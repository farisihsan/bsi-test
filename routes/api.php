<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StockController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\CategoryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('api_key')->group(function () {
    Route::apiResource('stock', StockController::class)
        ->scoped(['stock' => 'slug']);

    Route::apiResource('category', CategoryController::class)
        ->scoped(['category' => 'slug']);

    Route::apiResource('transaction', TransactionController::class);
});
