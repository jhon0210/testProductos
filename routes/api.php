<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\productController;


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/products', [productController::class, 'listarProducto']);

Route::post('/products', [productController::class, 'crearProducto']);

Route::put('/products', [productController::class, 'actualizarProducto']);

Route::delete('/products/{id}', [productController::class, 'eliminandoProducto']);
