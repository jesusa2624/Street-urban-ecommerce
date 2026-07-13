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
Route::apiResource('products', ProductController::class);
Route::apiResource('orders', OrderController::class);
Route::apiResource('order-items', OrderItemController::class);

Route::get('/products/by-category/{category}', [ProductController::class, 'byCategory']);
Route::post('/orders/bulk-update-status', [OrderController::class, 'bulkUpdateStatus']);
Route::post('/products/bulk-update-stock', [ProductController::class, 'bulkUpdateStock']);
