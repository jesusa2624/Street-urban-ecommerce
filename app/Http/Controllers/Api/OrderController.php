<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with('items.product');

        if ($request->has('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->has('order_number')) {
            $query->where('order_number', 'like', '%' . $request->input('order_number') . '%');
        }

        if ($request->has('min_total')) {
            $query->where('total', '>=', $request->input('min_total'));
        }

        if ($request->has('max_total')) {
            $query->where('total', '<=', $request->input('max_total'));
        }

        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->input('date_from'));
        }

        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->input('date_to'));
        }

        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $perPage = $request->input('per_page', 15);
        $orders = $query->paginate($perPage);

        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'order_number' => 'required|string|unique:orders',
            'status' => 'in:pending,confirmed,shipped,delivered,cancelled',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'tax' => 'numeric|min:0',
            'shipping' => 'numeric|min:0',
            'shipping_address' => 'nullable|string',
            'billing_address' => 'nullable|string',
            'payment_method' => 'nullable|string',
        ]);

        return DB::transaction(function () use ($validated) {
            $total = 0;
            $orderItems = [];

            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);

                if ($product->stock < $item['quantity']) {
                    return response()->json([
                        'error' => "Insufficient stock for product: {$product->name}",
                    ], 400);
                }

                $subtotal = $product->price * $item['quantity'];
                $total += $subtotal;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'subtotal' => $subtotal,
                ];

                $product->decrement('stock', $item['quantity']);
            }

            $total += $validated['tax'] ?? 0;
            $total += $validated['shipping'] ?? 0;

            $order = Order::create([
                'user_id' => $validated['user_id'],
                'order_number' => $validated['order_number'],
                'status' => $validated['status'] ?? 'pending',
                'total' => $total,
                'tax' => $validated['tax'] ?? 0,
                'shipping' => $validated['shipping'] ?? 0,
                'shipping_address' => $validated['shipping_address'],
                'billing_address' => $validated['billing_address'],
                'payment_method' => $validated['payment_method'],
            ]);

            foreach ($orderItems as $item) {
                $order->items()->create($item);
            }

            return response()->json($order->load('items.product'), 201);
        });
    }

    public function show(Order $order)
    {
        return response()->json($order->load('items.product', 'user'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'in:pending,confirmed,shipped,delivered,cancelled',
            'shipping_address' => 'nullable|string',
            'billing_address' => 'nullable|string',
            'payment_method' => 'nullable|string',
        ]);

        $order->update($validated);
        return response()->json($order);
    }

    public function destroy(Order $order)
    {
        return DB::transaction(function () use ($order) {
            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }

            $order->items()->delete();
            $order->delete();

            return response()->json(null, 204);
        });
    }

    public function bulkUpdateStatus(Request $request)
    {
        $validated = $request->validate([
            'updates' => 'required|array|min:1',
            'updates.*.order_id' => 'required|exists:orders,id',
            'updates.*.status' => 'required|in:pending,confirmed,shipped,delivered,cancelled',
        ]);

        return DB::transaction(function () use ($validated) {
            $updated = [];
            foreach ($validated['updates'] as $update) {
                $order = Order::find($update['order_id']);
                $order->update(['status' => $update['status']]);
                $updated[] = $order;
            }
            return response()->json(['message' => 'Estados actualizados', 'orders' => $updated]);
        });
    }
}
