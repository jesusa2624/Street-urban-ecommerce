<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;

class PurchaseController extends Controller
{
    public function index()
    {
        $variants = ProductVariant::with('product.category')
            ->orderByDesc('updated_at')
            ->get()
            ->map(fn ($variant) => [
                'id' => $variant->id,
                'productId' => $variant->product_id,
                'producto' => $variant->product->name,
                'marca' => $variant->product->brand,
                'categoria' => $variant->product->category->name ?? '-',
                'talla' => $variant->size,
                'color' => $variant->color,
                'colorHex' => $variant->color_hex,
                'stock' => $variant->stock,
                'precioCompra' => (float) $variant->cost,
                'precioVenta' => (float) $variant->product->price,
            ]);

        // Valor real de inventario: suma de lo que queda de cada lote a su costo real (FIFO),
        // no cantidad total x último costo, ya que un mismo producto puede tener lotes a precios distintos.
        $valorInventario = PurchaseItem::where('quantity_remaining', '>', 0)
            ->get()
            ->sum(fn ($item) => $item->quantity_remaining * $item->unit_cost);

        $marcasPorCategoria = Product::with('category')
            ->whereNotNull('brand')->where('brand', '!=', '')
            ->get()
            ->groupBy(fn ($p) => $p->category->name ?? 'Sin categoría')
            ->map(fn ($group) => $group->pluck('brand')->unique()->sort()->values());

        return Inertia::render('Admin/Compras/Index', [
            'variants' => $variants,
            'categorias' => Category::orderBy('name')->pluck('name'),
            'marcasPorCategoria' => $marcasPorCategoria,
            'stats' => [
                'totalProductos' => Product::count(),
                'totalVariantes' => $variants->count(),
                'sinStock' => $variants->where('stock', 0)->count(),
                'valorInventario' => $valorInventario,
            ],
        ]);
    }

    public function historial()
    {
        $compras = Purchase::with(['items.variant.product', 'user'])
            ->orderByDesc('purchase_date')
            ->orderByDesc('id')
            ->get()
            ->map(fn ($p) => [
                'id' => $p->id,
                'numero' => 'C-' . str_pad($p->id, 5, '0', STR_PAD_LEFT),
                'fecha' => $p->purchase_date->format('d/m/Y'),
                'proveedor' => $p->supplier,
                'factura' => $p->invoice_number,
                'notas' => $p->notes,
                'total' => (float) $p->total,
                'registradoPor' => $p->user->name ?? null,
                'totalPrendas' => $p->items->sum('quantity'),
                'items' => $p->items->map(fn ($item) => [
                    'producto' => $item->variant->product->name,
                    'marca' => $item->variant->product->brand,
                    'talla' => $item->variant->size,
                    'color' => $item->variant->color,
                    'colorHex' => $item->variant->color_hex,
                    'cantidad' => $item->quantity,
                    'costoUnitario' => (float) $item->unit_cost,
                    'subtotal' => (float) $item->subtotal,
                ]),
            ]);

        return Inertia::render('Admin/Compras/Historial', [
            'compras' => $compras,
            'stats' => [
                'totalCompras' => $compras->count(),
                'totalGastado' => $compras->sum('total'),
                'promedioCompra' => $compras->count() > 0 ? $compras->sum('total') / $compras->count() : 0,
            ],
        ]);
    }

    public function reportes(Request $request)
    {
        $desde = $request->query('desde');
        $hasta = $request->query('hasta');
        $proveedor = $request->query('proveedor');
        $categoria = $request->query('categoria');

        $itemsQuery = PurchaseItem::with(['purchase', 'variant.product.category'])
            ->whereHas('purchase', function ($q) use ($desde, $hasta, $proveedor) {
                if ($desde) $q->whereDate('purchase_date', '>=', $desde);
                if ($hasta) $q->whereDate('purchase_date', '<=', $hasta);
                if ($proveedor) $q->where('supplier', $proveedor);
            });

        if ($categoria) {
            $itemsQuery->whereHas('variant.product.category', fn ($q) => $q->where('name', $categoria));
        }

        $items = $itemsQuery->get();

        $numeroCompras = $items->pluck('purchase_id')->unique()->count();
        $totalInvertido = $items->sum('subtotal');

        $porCategoria = $items->groupBy(fn ($i) => $i->variant->product->category->name ?? 'Sin categoría')
            ->map(fn ($group, $nombre) => [
                'label' => $nombre,
                'total' => $group->sum('subtotal'),
                'unidades' => $group->sum('quantity'),
                'compras' => $group->pluck('purchase_id')->unique()->count(),
            ])
            ->sortByDesc('total')->values();

        $porProveedor = $items->groupBy(fn ($i) => $i->purchase->supplier ?: 'Sin proveedor')
            ->map(fn ($group, $nombre) => [
                'label' => $nombre,
                'total' => $group->sum('subtotal'),
                'unidades' => $group->sum('quantity'),
                'compras' => $group->pluck('purchase_id')->unique()->count(),
            ])
            ->sortByDesc('total')->values();

        $porMarca = $items->groupBy(fn ($i) => $i->variant->product->brand ?: 'Sin marca')
            ->map(fn ($group, $nombre) => [
                'label' => $nombre,
                'total' => $group->sum('subtotal'),
                'unidades' => $group->sum('quantity'),
                'compras' => $group->pluck('purchase_id')->unique()->count(),
            ])
            ->sortByDesc('total')->values();

        $topProductos = $items->groupBy(fn ($i) => $i->variant->product->name)
            ->map(function ($group, $nombre) {
                $unidades = $group->sum('quantity');
                $total = $group->sum('subtotal');

                return [
                    'label' => $nombre,
                    'marca' => $group->first()->variant->product->brand,
                    'categoria' => $group->first()->variant->product->category->name ?? 'Sin categoría',
                    'unidades' => $unidades,
                    'numeroCompras' => $group->pluck('purchase_id')->unique()->count(),
                    'costoPromedio' => $unidades > 0 ? $total / $unidades : 0,
                    'total' => $total,
                ];
            })
            ->sortByDesc('unidades')->values()->take(10);

        return Inertia::render('Admin/Compras/Reportes', [
            'filtros' => compact('desde', 'hasta', 'proveedor', 'categoria'),
            'proveedores' => Purchase::whereNotNull('supplier')->where('supplier', '!=', '')->distinct()->orderBy('supplier')->pluck('supplier'),
            'categorias' => Category::orderBy('name')->pluck('name'),
            'stats' => [
                'totalInvertido' => $totalInvertido,
                'numeroCompras' => $numeroCompras,
                'totalUnidades' => $items->sum('quantity'),
                'promedioPorCompra' => $numeroCompras > 0 ? $totalInvertido / $numeroCompras : 0,
            ],
            'porCategoria' => $porCategoria,
            'porProveedor' => $porProveedor,
            'porMarca' => $porMarca,
            'topProductos' => $topProductos,
        ]);
    }

    public function lotes(ProductVariant $variant)
    {
        $lotes = PurchaseItem::with('purchase')
            ->where('product_variant_id', $variant->id)
            ->orderBy('created_at')
            ->get()
            ->map(fn ($item) => [
                'id' => $item->id,
                'numeroCompra' => 'C-' . str_pad($item->purchase_id, 5, '0', STR_PAD_LEFT),
                'fecha' => $item->purchase->purchase_date->format('d/m/Y'),
                'proveedor' => $item->purchase->supplier,
                'cantidad' => $item->quantity,
                'cantidadRestante' => $item->quantity_remaining,
                'costoUnitario' => (float) $item->unit_cost,
            ]);

        return response()->json($lotes);
    }

    public function searchProducts(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $categoria = $request->query('categoria');
        $marca = $request->query('marca');

        // Sin texto y sin categoría/marca elegidas: no hay nada útil que sugerir todavía.
        if (mb_strlen($q) < 2 && !$categoria && !$marca) {
            return response()->json([]);
        }

        $query = Product::with('category');

        if ($q) {
            $query->where(function ($qq) use ($q) {
                $qq->where('name', 'like', "%{$q}%")
                    ->orWhere('brand', 'like', "%{$q}%");
            });
        }

        if ($categoria) {
            $query->whereHas('category', fn ($qq) => $qq->where('name', $categoria));
        }

        if ($marca) {
            $query->where('brand', $marca);
        }

        $products = $query->orderBy('name')
            ->limit(20)
            ->get()
            ->map(fn ($p) => [
                'id' => $p->id,
                'nombre' => $p->name,
                'marca' => $p->brand,
                'categoria' => $p->category->name ?? null,
                'stock' => $p->stock,
            ]);

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fecha' => 'required|date',
            'tienda' => 'nullable|string|max:255',
            'factura' => 'nullable|string|max:255',
            'notas' => 'nullable|string',
            'prendas' => 'required|array|min:1',
            'prendas.*.productId' => 'nullable|integer|exists:products,id',
            'prendas.*.nombre' => 'required|string|max:255',
            'prendas.*.categoria' => 'required|string|max:255',
            'prendas.*.marca' => 'required|string|max:255',
            'prendas.*.talla' => 'required|string|max:20',
            'prendas.*.colorNombre' => 'required|string|max:50',
            'prendas.*.color' => 'nullable|string|max:7',
            'prendas.*.cantidad' => 'required|integer|min:1',
            'prendas.*.precioCompra' => 'required|numeric|min:0',
            'prendas.*.precioVenta' => 'required|numeric|min:0',
        ]);

        $purchase = DB::transaction(function () use ($validated) {
            $total = collect($validated['prendas'])->sum(fn ($p) => $p['cantidad'] * $p['precioCompra']);

            $purchase = Purchase::create([
                'user_id' => Auth::guard('web')->id(),
                'purchase_date' => $validated['fecha'],
                'supplier' => $validated['tienda'] ?? null,
                'invoice_number' => $validated['factura'] ?? null,
                'notes' => $validated['notas'] ?? null,
                'total' => $total,
            ]);

            foreach ($validated['prendas'] as $item) {
                // Si vino de una selección explícita del buscador, reutiliza ese producto tal cual.
                $product = !empty($item['productId'])
                    ? Product::find($item['productId'])
                    : null;

                // Red de seguridad: si escribieron el nombre a mano, buscar por coincidencia
                // normalizada (sin importar mayúsculas/espacios) antes de crear uno nuevo.
                if (!$product) {
                    $product = Product::whereRaw('LOWER(TRIM(name)) = ?', [mb_strtolower(trim($item['nombre']))])
                        ->whereRaw('LOWER(TRIM(brand)) = ?', [mb_strtolower(trim($item['marca']))])
                        ->first();
                }

                if (!$product) {
                    // Solo se crea/usa la categoría cuando realmente se está creando un producto nuevo.
                    $category = Category::firstOrCreate(
                        ['slug' => Str::slug($item['categoria'])],
                        ['name' => $item['categoria'], 'active' => true]
                    );

                    $product = Product::create([
                        'name' => trim($item['nombre']),
                        'brand' => trim($item['marca']),
                        'category_id' => $category->id,
                        'description' => '',
                        'sku' => strtoupper(Str::slug($item['nombre'] . '-' . $item['marca'])) . '-' . Str::random(4),
                        'price' => $item['precioVenta'],
                        'cost' => $item['precioCompra'],
                        'stock' => 0,
                        'image_url' => null,
                        'active' => true,
                    ]);
                } else {
                    // El producto ya existe: su categoría original no se toca aunque hayan
                    // escrito una distinta por error; solo se actualizan precio y costo.
                    $product->update([
                        'price' => $item['precioVenta'],
                        'cost' => $item['precioCompra'],
                    ]);
                }

                $variant = ProductVariant::firstOrCreate(
                    [
                        'product_id' => $product->id,
                        'size' => $item['talla'],
                        'color' => $item['colorNombre'],
                    ],
                    [
                        'color_hex' => $item['color'] ?? null,
                        'sku' => strtoupper($product->sku . '-' . $item['talla'] . '-' . $item['colorNombre']) . '-' . Str::random(3),
                        'stock' => 0,
                        'cost' => $item['precioCompra'],
                    ]
                );

                // El "costo" del variant es solo referencial (el del lote más reciente).
                // El valor real de inventario se calcula por lote en index().
                $variant->update(['cost' => $item['precioCompra']]);
                $variant->increment('stock', $item['cantidad']);
                $product->increment('stock', $item['cantidad']);

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_variant_id' => $variant->id,
                    'quantity' => $item['cantidad'],
                    'quantity_remaining' => $item['cantidad'],
                    'unit_cost' => $item['precioCompra'],
                    'unit_price' => $item['precioVenta'],
                    'subtotal' => $item['cantidad'] * $item['precioCompra'],
                ]);
            }

            return $purchase;
        });

        return redirect()->route('admin.purchases.index')->with('success', 'Compra registrada correctamente.');
    }
}
