<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Imagen;
use App\Models\Producto;
use App\Models\SubCategoria;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Str;


class ProductoController extends Controller
{
    public function indexWelcome()
    {
        $categorias = Categoria::with('subcategorias')->get();

        // Todos los productos paginados (opcional, si deseas mantenerlo)
        $productos = Producto::with('categoria', 'imagenes')
            ->whereNull('precio_oferta') // para evitar duplicados con promociones
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Productos nuevos (los últimos 8 creados)
        $nuevos = Producto::with('categoria', 'imagenes')
            ->whereBetween('created_at', [now()->subDays(7), now()])
            ->get();

        // Promociones (donde hay precio_oferta)
        $promociones = Producto::with('categoria', 'imagenes')
            ->whereNotNull('precio_oferta')
            ->take(8)
            ->get();

        return view('welcome', compact('categorias', 'productos', 'nuevos', 'promociones'));
    }
    public function productoInicio()
    {
        return view('Producto.ProductoInicio');
    }
    public function index(Request $request)
    {
        $categoriasFiltradas = $request->input('categorias', []);
        $todasLasCategorias = Categoria::all();

        // Obtener productos filtrados por categoría si se seleccionaron
        $query = Producto::with('categoria', 'categoria.subcategorias')
            ->latest();  // Ordena por fecha de creación descendente

        if (!empty($categoriasFiltradas)) {
            $query->whereIn('id_categoria', $categoriasFiltradas);
        }

        $productos = $query->paginate(10);

        return view('Producto.producto', [
            'productos' => $productos,
            'todasLasCategorias' => $todasLasCategorias,
            'categoriasSeleccionadas' => $categoriasFiltradas
        ]);
    }
    public function store(Request $request)
    {
        //dd($request->all());
        // 1. Crear el producto
        $producto = Producto::create(attributes: [
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'descripcion' => $request->descripcion,
            'cantidad' => $request->cantidad,
            'id_categoria' => $request->categoria_id,
            'id_subcategoria' => $request->subcategoria_id,
            'precio_oferta'     => $request->precio_oferta,
            'estado' => "activo",
        ]);

        // 2. Procesar imágenes y videos
        if ($request->hasFile('archivos')) {
            foreach ($request->file('archivos') as $archivo) {

                $mime = $archivo->getMimeType();
                $extension = $archivo->getClientOriginalExtension();

                // Almacena en diferentes carpetas según el tipo
                if (Str::startsWith($mime, 'image/')) {
                    $ruta = $archivo->store('productos/imagenes', 'public');
                } elseif (Str::startsWith($mime, 'video/')) {
                    $ruta = $archivo->store('productos/videos', 'public');
                } else {
                    continue; // ignorar archivos no válidos
                }

                // Registrar en la base de datos (solo la ruta por ahora)
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
        $producto->precio_oferta = $request->precio_oferta;
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
    public function exportar(Request $request)
    {
        $categoriasIds = $request->input('categorias', []);

        if (!empty($categoriasIds)) {
            $categorias = Categoria::whereIn('id', $categoriasIds)->get();
        } else {
            $categorias = Categoria::all();
        }

        foreach ($categorias as $categoria) {
            $categoria->productos = Producto::where('id_categoria', $categoria->id)->get();
        }

        $pdf = Pdf::loadView('producto.exportarPdf', compact('categorias'));

        // Mostrar en navegador directamente
        return $pdf->stream('productos_filtrados.pdf', ['Attachment' => false]);
    }

    public function obtenerSubcategoriasPorCategoria($categoriaId)
    {
        $subcategorias = SubCategoria::where('id_categoria', $categoriaId)->get();

        return response()->json($subcategorias);
    }
    public function eliminarImagen($id)
    {
        $imagen = Imagen::findOrFail($id);

        // Opcional: eliminar del disco si es local
        if (\Storage::exists($imagen->ruta)) {
            \Storage::delete($imagen->ruta);
        }

        $imagen->delete();

        return response()->json(['mensaje' => 'Imagen eliminada']);
    }
}
