<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Carbon;
use Inertia\Inertia;

class DashboardController extends Controller
{
    private function cambioPorcentual(float $actual, float $anterior): ?float
    {
        if ($anterior == 0) {
            return null;
        }

        return round((($actual - $anterior) / $anterior) * 100, 1);
    }

    private function semanaVentas(): array
    {
        $hoy = Carbon::today();
        $inicioSemana = $hoy->copy()->subDays(6);
        $abrevs = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];

        $filas = Sale::selectRaw('sale_date, (cancelled_at is not null) as cancelada, count(*) as cantidad, sum(total) as monto')
            ->whereBetween('sale_date', [$inicioSemana->toDateString(), $hoy->toDateString()])
            ->groupBy('sale_date', 'cancelada')
            ->get();

        $porFecha = [];
        foreach ($filas as $fila) {
            $fecha = $fila->sale_date->toDateString();
            $porFecha[$fecha] ??= ['ventas' => 0, 'canceladas' => 0, 'monto' => 0.0];
            $porFecha[$fecha][$fila->cancelada ? 'canceladas' : 'ventas'] = (int) $fila->cantidad;

            // El monto de ingreso solo cuenta lo que sí se concretó (no lo cancelado).
            if (!$fila->cancelada) {
                $porFecha[$fecha]['monto'] = (float) $fila->monto;
            }
        }

        $semana = [];
        for ($i = 6; $i >= 0; $i--) {
            $fecha = $hoy->copy()->subDays($i);
            $clave = $fecha->toDateString();

            $semana[] = [
                'label' => $abrevs[$fecha->dayOfWeek],
                'ventas' => $porFecha[$clave]['ventas'] ?? 0,
                'canceladas' => $porFecha[$clave]['canceladas'] ?? 0,
                'monto' => $porFecha[$clave]['monto'] ?? 0.0,
            ];
        }

        return $semana;
    }

    private function topProductosVendidos()
    {
        $colores = ['bg-[#ff8c42]', 'bg-blue-400', 'bg-green-400'];

        $top = SaleItem::join('sales', 'sales.id', '=', 'sale_items.sale_id')
            ->join('product_variants', 'product_variants.id', '=', 'sale_items.product_variant_id')
            ->join('products', 'products.id', '=', 'product_variants.product_id')
            ->whereNull('sales.cancelled_at')
            ->selectRaw('products.name, sum(sale_items.quantity) as unidades')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('unidades')
            ->limit(3)
            ->get();

        $maxUnidades = $top->max('unidades') ?: 1;

        return $top->values()->map(fn ($p, $i) => [
            'name' => $p->name,
            'unidades' => (int) $p->unidades,
            'percent' => (int) round($p->unidades / $maxUnidades * 100),
            'color' => $colores[$i] ?? 'bg-gray-300',
        ]);
    }

    private function ventasRecientes()
    {
        $hoy = Carbon::today();
        $ayer = $hoy->copy()->subDay();

        // Se ordena por fecha/hora de REGISTRO (created_at), no por sale_date — esa la elige
        // el usuario y puede ser una fecha pasada, así que no refleja qué se registró último.
        return Sale::with('items.variant.product', 'items.variant.productColor')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get()
            ->map(function ($v) use ($hoy, $ayer) {
                $nombres = $v->items->pluck('variant.product.name')->unique()->values();
                $producto = $nombres->count() <= 1
                    ? ($nombres->first() ?? 'Sin prendas')
                    : "{$nombres->first()} + " . ($nombres->count() - 1) . ' más';

                $dia = match (true) {
                    $v->created_at->isSameDay($hoy) => 'Hoy',
                    $v->created_at->isSameDay($ayer) => 'Ayer',
                    default => $v->created_at->format('d/m/Y'),
                };

                return [
                    'id' => $v->id,
                    'numero' => 'V-' . str_pad($v->id, 5, '0', STR_PAD_LEFT),
                    'fecha' => "{$dia} · {$v->created_at->format('g:i a')}",
                    'customer' => $v->customer_name ?: 'Sin cliente registrado',
                    'product' => $producto,
                    'colorHex' => $v->items->first()?->variant?->productColor?->hex,
                    'amount' => (float) $v->total,
                    'cancelada' => $v->cancelled_at !== null,
                ];
            });
    }

    public function index()
    {
        $hoy = Carbon::today();
        $inicioMes = $hoy->copy()->startOfMonth();
        $inicioMesPasado = $hoy->copy()->subMonthNoOverflow()->startOfMonth();
        $finMesPasado = $inicioMes->copy()->subDay();

        $ventasEsteMesQuery = Sale::whereNull('cancelled_at')->whereBetween('sale_date', [$inicioMes, $hoy]);
        $ventasMesPasadoQuery = Sale::whereNull('cancelled_at')->whereBetween('sale_date', [$inicioMesPasado, $finMesPasado]);

        $totalVentasEsteMes = (float) $ventasEsteMesQuery->sum('total');
        $totalVentasMesPasado = (float) $ventasMesPasadoQuery->sum('total');
        $numVentasEsteMes = (clone $ventasEsteMesQuery)->count();
        $numVentasMesPasado = (clone $ventasMesPasadoQuery)->count();

        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'ventasMes' => $totalVentasEsteMes,
                'cambioVentas' => $this->cambioPorcentual($totalVentasEsteMes, $totalVentasMesPasado),
                'numVentasMes' => $numVentasEsteMes,
                'cambioNumVentas' => $this->cambioPorcentual($numVentasEsteMes, $numVentasMesPasado),
                'totalClientes' => Customer::count(),
                'nuevosClientesMes' => Customer::whereBetween('created_at', [$inicioMes, $hoy->copy()->endOfDay()])->count(),
                'totalProductos' => Product::count(),
                'nuevosProductosMes' => Product::whereBetween('created_at', [$inicioMes, $hoy->copy()->endOfDay()])->count(),
            ],
            'weeklySales' => $this->semanaVentas(),
            'topProductos' => $this->topProductosVendidos(),
            'ventasRecientes' => $this->ventasRecientes(),
        ]);
    }
}
