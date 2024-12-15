<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Product;

class productController extends Controller
{   
    
    public function crearProducto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:products',
            'descripcion' => 'required',
            'valor' => 'required|numeric',
        ], [
            'required' => 'El campo nombre es obligatorio.',
            'unique' => 'El nombre del producto ya ha sido registrado.',
            'numeric' => 'El campo valor debe ser un número.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
            ], 400);
        }

        $product = Product::create([
            'name' => $request->name,
            'descripcion' => $request->descripcion,
            'valor' => $request->valor,
        ]);

        if (!$product) {
            return response()->json([
                'message' => 'Error al crear el producto',
            ], 500);
        }

        return response()->json([
            'message' => 'Producto creado exitosamente',
            'product' => $product,
        ], 201);

        return view('index')->with('products', $products);
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
        //return response()->json($products, 200);
        return view('index')->with('products', $products);
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
            'valor' => 'required',
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


public function eliminarProducto($id)
{
    $product = Product::find($id);

    if (!$product) {
        return response()->json([
            'message' => 'Producto no encontrado',
            'status' => 404,
        ], 404);
    }

    $product->delete();

    return response()->json([
        'message' => 'Producto eliminado exitosamente',
        'status' => 200,
    ], 200);
}

}
