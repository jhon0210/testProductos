<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\productController;

Route::get('/products/listar', [productController::class, 'listarProducto']);

Route::post('/products/crear', [productController::class, 'crearProducto']);

Route::put('/products/{id}', [productController::class, 'actualizarProducto']);

Route::delete('/products/{id}', [productController::class, 'eliminarProducto']);
