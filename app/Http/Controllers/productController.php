<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Product;

class productController extends Controller
{
    public function crearProducto(Request $request){
        
        $validator=Validator::make($request->all(), [
            'name'=>'required|unique:products',
            'descripcion'=>'required',
            'valor'=>'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
            ];
            return response()->json($data, 400);
        }

        $product = Product::create([
            'name' => $request->name,
            'descripcion' => $request->descripcion,
            'valor' => $request->valor
        ]);

        if (!$product) {
            $data = [
                'message' => 'Error al crear el producto',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'product' => $product,
            'status' => 201
        ];

        return response()->json($data, 201); 
    }

    public function listarProducto(){

        $products = Product::all();
        if ($products->isEmpty()) {
            $data = [
                'message' => 'No se encontraron los productos',
                'status' => 200
            ];
            return response()->json($data, 404);
        }
        return response()->json($products, 200);
    }

    public function actualizarProducto(Request $request, $id)
{
    $product = Product::find($id);
    if (!$product) {
        $data = [
            'message' => 'No se encontró el producto',
            'status' => 404
        ];
        return response()->json($data, 404);
    }

    // Validar los datos de entrada, excluyendo el producto actual en la regla unique
    $validator = Validator::make($request->all(), [
        'name' => 'required|unique:products,name,' . $id,
        'descripcion' => 'required',
        'valor' => 'required|numeric|min:0.01',
    ]);

    if ($validator->fails()) {
        $data = [
            'message' => 'Error en la validación de los datos',
            'errors' => $validator->errors(),
            'status' => 400
        ];
        return response()->json($data, 400);
    }

    // Actualizar los datos del producto
    $product->name = $request->name;
    $product->descripcion = $request->descripcion;
    $product->valor = $request->valor;

    $product->save();

    $data = [
        'message' => 'Producto actualizado',
        'product' => $product,
        'status' => 200
    ];
    return response()->json($data, 200);
}


    public function eliminandoProducto($id){
        $product = Product::find($id);
        if (!$product) {
            $data = [
                'message' => 'No se encontro el producto',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $product->delete();

        $data = [
            'message' => 'Producto Eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
