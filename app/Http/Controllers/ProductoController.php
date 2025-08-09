<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Empresa;
use App\Models\Imagen;
use App\Models\Producto;
use App\Models\SubCategoria;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Str;


class ProductoController extends Controller
{
    public function productoInicio($slug)
    {
        // Buscar la empresa por slug
        $empresa = Empresa::where('slug', $slug)->firstOrFail();
        $empresaId = $empresa->id;

        // Categorías con productos activos
        $categorias = Categoria::with('subcategorias')
            ->where('id_empresa', $empresaId)
            ->whereHas('productos', function ($query) use ($empresaId) {
                $query->where('id_empresa', $empresaId)
                    ->where('estado', 'activo');
            })
            ->get();

        // Productos en promoción (todos)
        $promociones = Producto::with('categoria', 'imagenes')
            ->whereNotNull('precio_oferta')
            ->where('id_empresa', $empresaId)
            ->where('estado', 'activo')
            ->orderBy('created_at', 'desc')
            ->get();

        // Productos nuevos (todos)
        $nuevos = Producto::with('categoria', 'imagenes')
            ->whereBetween('created_at', [now()->subDays(7), now()])
            ->where('id_empresa', $empresaId)
            ->where('estado', 'activo')
            ->orderBy('created_at', 'desc')
            ->get();

        // Productos normales (todos)
        $productos = Producto::with('categoria', 'imagenes')
            ->whereNull('precio_oferta')
            ->where('id_empresa', $empresaId)
            ->where('estado', 'activo')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('Producto.ProductoInicio', compact('empresa', 'categorias', 'productos', 'nuevos', 'promociones'));
    }


    //cargar mas  8
    public function loadMorePromociones(Request $request)
    {
        $offset = $request->input('offset', 0);
        $empresaId = $request->input('empresa_id');

        $promociones = Producto::with('categoria', 'imagenes')
            ->whereNotNull('precio_oferta')
            ->where('id_empresa', $empresaId)
            ->where('estado', 'activo')
            ->orderBy('created_at', 'desc')
            ->skip($offset)
            ->take(8)
            ->get();

        $html = '';
        if ($promociones->count()) {
            $html = View::make('catalogo.catalogoNuevos', ['productos' => $promociones])->render();
        }

        return response()->json([
            'html' => $html,
            'total' => $promociones->count()
        ]);
    }

    public function loadMoreNuevos(Request $request)
    {
        $offset = $request->input('offset', 0);
        $empresaId = $request->input('empresa_id');

        $nuevos = Producto::with('categoria', 'imagenes')
            ->whereBetween('created_at', [now()->subDays(7), now()])
            ->where('id_empresa', $empresaId)
            ->where('estado', 'activo')
            ->orderBy('created_at', 'desc')
            ->skip($offset)
            ->take(8)
            ->get();

        $html = '';
        if ($nuevos->count()) {
            $html = View::make('catalogo.catalogoNuevos', ['productos' => $nuevos])->render();
        }

        return response()->json([
            'html' => $html,
            'total' => $nuevos->count()
        ]);
    }
    //pructos normales
    public function loadMoreProductos(Request $request)
    {
        $offset = $request->input('offset', 0);
        $empresaId = $request->input('empresa_id');

        $productos = Producto::with('categoria', 'imagenes')
            ->whereNull('precio_oferta')
            ->where('id_empresa', $empresaId)
            ->where('estado', 'activo')
            ->orderBy('created_at', 'desc')
            ->skip($offset)
            ->take(8)
            ->get();

        $html = '';
        if ($productos->count()) {
            $html = View::make('catalogo.catalogoNuevos', ['productos' => $productos])->render();
        }

        return response()->json([
            'html' => $html,
            'total' => $productos->count()
        ]);
    }

    public function index(Request $request)
    {
        $empresaId = Auth::user()->empresa->id;

        // Categorías solo de la empresa
        $todasLasCategorias = Categoria::where('id_empresa', $empresaId)->get();

        // Categorías filtradas por el request, pero que pertenezcan a la empresa
        $categoriasFiltradas = $request->input('categorias', []);

        // Query para productos de la empresa, filtrados si hay categorías seleccionadas
        $query = Producto::with('categoria', 'categoria.subcategorias')
            ->where('id_empresa', $empresaId)
            ->latest();

        if (!empty($categoriasFiltradas)) {
            // Aseguramos que solo filtre categorías que sean de esta empresa
            $categoriasFiltradas = array_filter($categoriasFiltradas, function ($catId) use ($todasLasCategorias) {
                return $todasLasCategorias->pluck('id')->contains($catId);
            });

            if (!empty($categoriasFiltradas)) {
                $query->whereIn('id_categoria', $categoriasFiltradas);
            }
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
        $empresa = Auth::user()->empresa;
        $producto = Producto::create(attributes: [
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'descripcion' => $request->descripcion,
            'cantidad' => $request->cantidad,
            'id_categoria' => $request->categoria_id,
            'id_subcategoria' => $request->subcategoria_id,
            'precio_oferta'     => $request->precio_oferta,
            'estado' => "activo",
            'id_empresa' => $empresa->id
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
            'precio_oferta' => $producto->precio_oferta,
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

        // Actualizar campos
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

        // Procesar imágenes y videos nuevos (igual que en store)
        if ($request->hasFile('archivos')) {
            foreach ($request->file('archivos') as $archivo) {

                $mime = $archivo->getMimeType();

                if (Str::startsWith($mime, 'image/')) {
                    $ruta = $archivo->store('productos/imagenes', 'public');
                } elseif (Str::startsWith($mime, 'video/')) {
                    $ruta = $archivo->store('productos/videos', 'public');
                } else {
                    continue; // ignorar archivos no válidos
                }

                // Registrar en la base de datos
                Imagen::create([
                    'id_producto' => $producto->id,
                    'ruta' => $ruta,
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
