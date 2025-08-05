<?php

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/producto/{id}/detalles', function($id) {
    $producto = Producto::with('imagenes')->findOrFail($id);

    return response()->json([
        'nombre' => $producto->nombre,
        'precio' => number_format($producto->precio, 2),
        'descripcion' => $producto->descripcion,
        'imagenes' => $producto->imagenes->map(function($img){
            return [
                'tipo' => $img->tipo, // ej: 'imagen' o 'video'
                'ruta' => asset('storage/' . $img->ruta),
            ];
        }),
    ]);
});