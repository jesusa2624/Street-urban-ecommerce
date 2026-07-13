<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = OrderItem::with('product', 'order');

        if ($request->has('order_id')) {
            $query->where('order_id', $request->input('order_id'));
        }

        if ($request->has('product_id')) {
            $query->where('product_id', $request->input('product_id'));
        }

        $perPage = $request->input('per_page', 15);
        $items = $query->paginate($perPage);

        return response()->json($items);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
        ]);

        $item = OrderItem::create($validated);
        return response()->json($item, 201);
    }

    public function show(OrderItem $orderItem)
    {
        return response()->json($orderItem->load('product', 'order'));
    }

    public function update(Request $request, OrderItem $orderItem)
    {
        $validated = $request->validate([
            'quantity' => 'integer|min:1',
            'unit_price' => 'numeric|min:0',
            'subtotal' => 'numeric|min:0',
        ]);

        $orderItem->update($validated);
        return response()->json($orderItem);
    }

    public function destroy(OrderItem $orderItem)
    {
        $orderItem->delete();
        return response()->json(null, 204);
    }
}
