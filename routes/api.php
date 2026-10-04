<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderItemController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('categories', CategoryController::class);
// La administración de productos se realiza exclusivamente desde /admin/catalogo.
// La API conserva las consultas de compatibilidad, pero no permite escrituras paralelas.
Route::apiResource('products', ProductController::class)->only(['index', 'show']);
Route::apiResource('orders', OrderController::class);
Route::apiResource('order-items', OrderItemController::class);

Route::get('/products/by-category/{category}', [ProductController::class, 'byCategory']);
Route::post('/orders/bulk-update-status', [OrderController::class, 'bulkUpdateStatus']);
