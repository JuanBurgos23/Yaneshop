<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Imagen;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function indexWelcome()
    {
        return view('Producto.ProductoInicio');
    }
    public function index(Request $request)
    {
        $categoriasFiltradas = $request->input('categorias', []);
        $todasLasCategorias = Categoria::all();

        // Obtener productos filtrados por categoría si se seleccionaron
        $query = Producto::with('categoria', 'categoria.subcategorias');

        if (!empty($categoriasFiltradas)) {
            $query->whereIn('id_categoria', $categoriasFiltradas);
        }

        $productos = $query->orderBy('nombre')->paginate(10);

        return view('Producto.producto', [
            'productos' => $productos,
            'todasLasCategorias' => $todasLasCategorias,
            'categoriasSeleccionadas' => $categoriasFiltradas
        ]);
    }
    public function store(Request $request)
    {

        // Determinar código de barras solo si no es 'ninguno'
        $codigoBarras = null;
        if ($request->modo_codigo_barras !== 'ninguno') {
            $codigoBarras = $request->codigo_barras;

            // Validación manual para evitar duplicados
            if ($codigoBarras && Producto::where('codigo_barras', $codigoBarras)->exists()) {
                return redirect()->back()
                    ->withErrors(['codigo_barras' => 'Este código de barras ya está registrado.'])
                    ->withInput();
            }
        }
        // 1. Crear el producto
        $producto = Producto::create([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'descripcion' => $request->descripcion,
            'cantidad' => $request->cantidad,
            'codigo_barras' => $codigoBarras,
            'id_categoria' => $request->categoria_id,
            'id_subcategoria' => $request->subcategoria_id,
            'estado' => "activo",
        ]);
        // 2. Procesar y guardar las imágenes
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $imagen) {
                $ruta = $imagen->store('productos', 'public'); // guarda en /storage/app/public/productos

                Imagen::create([
                    'id_producto' => $producto->id,
                    'ruta' => $ruta,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Producto registrado correctamente');
    }

    public function edit($id)
    {
        $producto = Producto::with(['categoria', 'subcategoria', 'imagenes'])->findOrFail($id);

        return response()->json([
            'id' => $producto->id,
            'nombre' => $producto->nombre,
            'precio' => $producto->precio,
            'descripcion' => $producto->descripcion,
            'cantidad' => $producto->cantidad,
            'estado' => $producto->estado,
            'codigo_barras' => $producto->codigo_barras,
            'categoria_id' => $producto->categoria->id ?? null,
            'categoria_nombre' => $producto->categoria->nombre ?? '',
            'subcategoria_id' => $producto->subcategoria->id ?? null,
            'subcategoria_nombre' => $producto->subcategoria->nombre ?? '',
            'imagenes' => $producto->imagenes->map(fn($img) => [
                'id' => $img->id,
                'url' => asset('storage/' . $img->ruta)
            ])
        ]);
    }

    public function update(Request $request, $id)
    {


        $producto = Producto::findOrFail($id);

        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->descripcion = $request->descripcion;
        $producto->cantidad = $request->cantidad;

        $producto->codigo_barras = $request->codigo_barras ?? $producto->codigo_barras;
        $producto->estado = $request->estado;
        $producto->id_categoria = $request->categoria_id;
        $producto->id_subcategoria = $request->subcategoria_id;

        $producto->save();

        // Guardar nuevas imágenes
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $imagen) {
                // Guardar archivo en storage (ejemplo: carpeta 'productos')
                $ruta = $imagen->store('productos', 'public');

                // Crear registro en tabla imágenes (ajusta según tu modelo)
                $producto->imagenes()->create([
                    'ruta' => $ruta,
                    'url' => asset('storage/' . $ruta)
                ]);
            }
        }

        return redirect()->route('productos')->with('success', 'Producto actualizado correctamente');
    }
}
