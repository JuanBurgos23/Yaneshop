<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Empresa;
use App\Models\Imagen;
use App\Models\Producto;
use App\Models\SubCategoria;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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

        // Verificar suscripción
        $fechaFin = $empresa->fecha_fin_suscripcion ? \Carbon\Carbon::parse($empresa->fecha_fin_suscripcion) : null;
        $hoy = \Carbon\Carbon::now();

        if (!$fechaFin || $fechaFin->lt($hoy)) {
            // Suscripción expirada -> redirigir a inicio
            return redirect('/');
        }

        $empresaId = $empresa->id;

        // Categorías con productos activos
        $categorias = Categoria::with('subcategorias')
            ->where('id_empresa', $empresaId)
            ->whereHas('productos', function ($query) use ($empresaId) {
                $query->where('id_empresa', $empresaId)
                    ->where('estado', 'activo');
            })
            ->get();

        // 🏷️ Productos en promoción
        $promociones = Producto::with('categoria', 'imagenes')
            ->whereNotNull('precio_oferta')
            ->where('id_empresa', $empresaId)
            ->where('estado', 'activo')
            ->orderBy('created_at', 'desc')
            ->get();

        // 🆕 Productos nuevos (últimos 7 días)
        $nuevos = Producto::with('categoria', 'imagenes')
            ->whereBetween('created_at', [now()->subDays(7), now()])
            ->where('id_empresa', $empresaId)
            ->where('estado', 'activo')
            ->orderBy('created_at', 'desc')
            ->get();

        // ❌ IDs de productos ya mostrados
        $excluirIds = $promociones->pluck('id')
            ->merge($nuevos->pluck('id'))
            ->unique();

        // 📦 Productos normales (sin repetir)
        $productos = Producto::with('categoria', 'imagenes')
            ->whereNull('precio_oferta')
            ->where('id_empresa', $empresaId)
            ->where('estado', 'activo')
            ->whereNotIn('id', $excluirIds)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('Producto.ProductoInicio', compact('empresa', 'categorias', 'productos', 'nuevos', 'promociones'));
    }

    public function empresaJson($slug)
    {
        $empresa = Empresa::where('slug', $slug)->firstOrFail();

        // Verificar suscripción
        $fechaFin = $empresa->fecha_fin_suscripcion ? \Carbon\Carbon::parse($empresa->fecha_fin_suscripcion) : null;
        $hoy = \Carbon\Carbon::now();

        if (!$fechaFin || $fechaFin->lt($hoy)) {
            return response()->json(['error' => 'Suscripción expirada'], 403);
        }

        $empresaId = $empresa->id;

        // ✅ Categorías con subcategorías que tengan productos activos
        $categorias = Categoria::with(['subCategorias' => function ($q) use ($empresaId) {
            $q->whereHas('productos', function ($q2) use ($empresaId) {
                $q2->where('id_empresa', $empresaId)
                    ->where('estado', 'activo');
            });
        }])
            ->where('id_empresa', $empresaId)
            ->whereHas('productos', function ($q) use ($empresaId) {
                $q->where('id_empresa', $empresaId)
                    ->where('estado', 'activo');
            })
            ->get()
            ->map(function ($categoria) {
                return [
                    'id' => $categoria->id,
                    'nombre' => $categoria->nombre,
                    'subcategorias' => $categoria->subCategorias->map(function ($sub) {
                        return [
                            'id' => $sub->id,
                            'nombre' => $sub->nombre
                        ];
                    }),
                ];
            });

        // 🏷️ Productos en promoción
        $promociones = Producto::with(['categoria', 'subcategoria', 'imagenes'])
            ->whereNotNull('precio_oferta')
            ->where('id_empresa', $empresaId)
            ->where('estado', 'activo')
            ->orderBy('created_at', 'desc')
            ->get();

        // 🆕 Productos nuevos (últimos 7 días)
        $nuevos = Producto::with(['categoria', 'subcategoria', 'imagenes'])
            ->whereBetween('created_at', [now()->subDays(7), now()])
            ->where('id_empresa', $empresaId)
            ->where('estado', 'activo')
            ->orderBy('created_at', 'desc')
            ->get();

        // ❌ Excluir IDs ya mostrados
        $excluirIds = $promociones->pluck('id')
            ->merge($nuevos->pluck('id'))
            ->unique();

        // 📦 Productos normales (sin repetir)
        $productos = Producto::with(['categoria', 'subcategoria', 'imagenes'])
            ->whereNull('precio_oferta')
            ->where('id_empresa', $empresaId)
            ->where('estado', 'activo')
            ->whereNotIn('id', $excluirIds)
            ->orderBy('created_at', 'desc')
            ->get();

        // ✅ Formato común para todos los productos
        $formatear = fn($lista, $tipo = null) => $lista->map(function ($p) use ($tipo) {
            return [
                'id' => $p->id,
                'nombre' => $p->nombre,
                'descripcion' => $p->descripcion,
                'precio' => (float)$p->precio,
                'precio_oferta' => $p->precio_oferta ? (float)$p->precio_oferta : null,
                'oferta_tipo' => $p->oferta_tipo,
                'precio_oferta_tipo' => $p->precio_oferta_tipo,
                'categoria' => $p->categoria?->nombre ?? 'Sin categoría',
                'subcategoria' => $p->subcategoria?->nombre ?? 'Sin subcategoría',
                'imagenes' => $p->imagenes->map(function ($img) {
                    if (Str::startsWith($img->ruta, ['http://', 'https://'])) {
                        return $img->ruta;
                    }
                    return asset('storage/' . $img->ruta);
                }),
                'nuevo' => $tipo === 'nuevo',
                'promocion' => $tipo === 'promocion' || !is_null($p->precio_oferta),
            ];
        });

        $todosLosProductos = collect()
            ->merge($formatear($promociones, 'promocion'))
            ->merge($formatear($nuevos, 'nuevo'))
            ->merge($formatear($productos, 'normal'))
            ->values();

        return response()->json([
            'empresa' => [
                'nombre' => $empresa->nombre,
                'logo' => asset('storage/' . $empresa->logo),
                'telefono_whatsapp' => $empresa->telefono_whatsapp,
            ],
            'categorias' => $categorias,
            'productos' => $todosLosProductos,
        ]);
    }

    public function productoDetalles($id)
    {
        $producto = Producto::with([
            'categoria:id,nombre',
            'subcategoria:id,nombre',
            'imagenes:id,id_producto,ruta'
        ])
            ->where('id', $id)
            ->where('estado', 'activo')
            ->first();

        if (!$producto) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        // Formatear correctamente las imágenes
        $imagenes = $producto->imagenes->map(function ($img) {
            if (Str::startsWith($img->ruta, ['http://', 'https://'])) {
                return $img->ruta;
            }
            return asset('storage/' . $img->ruta);
        })->toArray();

        // Imagen principal
        $imagenPrincipal = $imagenes[0] ?? asset('images/no-image.png');

        $data = [
            'id' => $producto->id,
            'nombre' => $producto->nombre,
            'descripcion' => $producto->descripcion,
            'precio' => (float) $producto->precio,
            'precio_oferta' => $producto->precio_oferta ? (float) $producto->precio_oferta : null,
            'oferta_tipo' => $producto->oferta_tipo,             // <--- agregar
            'precio_oferta_tipo' => $producto->precio_oferta_tipo ? (float) $producto->precio_oferta_tipo : null, // <--- agregar
            'categoria' => $producto->categoria?->nombre ?? 'Sin categoría',
            'subcategoria' => $producto->subcategoria?->nombre ?? '',
            'imagenes' => $imagenes,
            'imagen_principal' => $imagenPrincipal,
            'video' => $producto->video
                ? (Str::startsWith($producto->video, ['http://', 'https://'])
                    ? $producto->video
                    : asset('storage/' . $producto->video))
                : null,
            'cantidad' => $producto->cantidad,
        ];

        return response()->json(['producto' => $data]);
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
        $user = Auth::user();

        // Solo aplicar restricción a clientes
        if ($user->hasRole('cliente')) {
            $empresa = $user->empresa;

            if (!$empresa || !$empresa->fecha_fin_suscripcion || \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($empresa->fecha_fin_suscripcion))) {
                // Suscripción vencida o no definida → redirigir a la vista de aviso
                return view('empresa.suscripcion_vencida');
            }
        }

        // Si es admin o cliente con suscripción vigente
        $empresaId = $user->empresa->id;

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
            'oferta_tipo' => $request->oferta_tipo,
            'precio_oferta_tipo' => $request->precio_oferta_tipo,
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
        $empresaId = Auth::user()->empresa->id; // O la empresa que corresponda según tu lógica

        // Buscar producto solo si pertenece a la empresa
        $producto = Producto::with(['categoria', 'subcategoria', 'imagenes'])
            ->where('id', $id)
            ->where('id_empresa', $empresaId)
            ->firstOrFail();

        return response()->json([
            'id' => $producto->id,
            'nombre' => $producto->nombre,
            'precio' => $producto->precio,
            'precio_oferta' => $producto->precio_oferta,
            'oferta_tipo' => $producto->oferta_tipo,
            'precio_oferta_tipo' => $producto->precio_oferta_tipo,
            'descripcion' => $producto->descripcion,
            'cantidad' => $producto->cantidad,
            'estado' => $producto->estado,
            'codigo_barras' => $producto->codigo_barras,
            'categoria_id' => $producto->categoria->id ?? null,
            'categoria_nombre' => $producto->categoria->nombre ?? '',
            'subcategoria_id' => $producto->subcategoria->id ?? null,
            'subcategoria_nombre' => $producto->subcategoria->nombre ?? '',
            'imagenes' => $producto->imagenes->map(function ($img) {
                $url = preg_match('/^https?:\/\//', $img->ruta) ? $img->ruta : asset('storage/' . $img->ruta);
                return [
                    'id' => $img->id,
                    'url' => $url
                ];
            })
        ]);
    }

    public function update(Request $request, $id)
    {
        $empresaId = Auth::user()->empresa->id;

        // Buscar producto solo si pertenece a la empresa
        $producto = Producto::where('id', $id)
            ->where('id_empresa', $empresaId)
            ->firstOrFail();

        // Actualizar campos
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->descripcion = $request->descripcion;
        $producto->cantidad = $request->cantidad;
        $producto->precio_oferta = $request->precio_oferta;
        $producto->oferta_tipo = $request->oferta_tipo;
        $producto->precio_oferta_tipo = $request->precio_oferta_tipo;
        $producto->codigo_barras = $request->codigo_barras ?? $producto->codigo_barras;
        $producto->estado = $request->estado;
        $producto->id_categoria = $request->categoria_id;
        $producto->id_subcategoria = $request->subcategoria_id;

        $producto->save();

        // Procesar archivos nuevos (imágenes/videos)
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $archivo) {
                $mime = $archivo->getMimeType();

                if (Str::startsWith($mime, 'image/')) {
                    $ruta = $archivo->store('productos/imagenes', 'public');
                } elseif (Str::startsWith($mime, 'video/')) {
                    $ruta = $archivo->store('productos/videos', 'public');
                } else {
                    continue;
                }

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

        $pdf = Pdf::loadView('Producto.exportarPdf', compact('categorias'));

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
    public function indexMasivo()
    {
        $todasLasCategorias = Categoria::all();
        return view('producto.productoMasivo', compact('todasLasCategorias'));
    }
    public function plantillaExcelProductos()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Encabezados
        $sheet->setCellValue('A1', 'nombre');
        $sheet->setCellValue('B1', 'precio');
        $sheet->setCellValue('C1', 'descripcion');
        $sheet->setCellValue('D1', 'codigo_barras');
        $sheet->setCellValue('E1', 'cantidad');
        $sheet->setCellValue('F1', 'precio_oferta');
        $sheet->setCellValue('G1', 'imagen_url'); // 👈 Nueva columna

        // Generar el archivo y devolverlo
        $writer = new Xlsx($spreadsheet);
        $filename = 'plantilla_productos.xlsx';
        $tempPath = storage_path('app/public/' . $filename);
        $writer->save($tempPath);

        return response()->download($tempPath)->deleteFileAfterSend(true);
    }
    public function previsualizarExcel(Request $request)
    {
        $request->validate([
            'archivo_excel' => 'required|file|mimes:xlsx,xls',
        ]);

        $data = Excel::toArray([], $request->file('archivo_excel'));
        $hoja = $data[0];

        if (!isset($hoja[1])) {
            return response()->json(['success' => false, 'message' => 'El archivo no contiene datos.']);
        }

        $encabezados = array_map('strtolower', $hoja[0]);
        unset($hoja[0]);

        $productos = [];
        $codigosBarrasVistos = [];

        foreach ($hoja as $fila) {
            $producto = [];
            foreach ($encabezados as $index => $campo) {
                $producto[$campo] = $fila[$index] ?? null;
            }

            $errores = [];

            if (empty($producto['nombre'])) {
                $errores[] = 'Nombre requerido';
            }

            if (!isset($producto['precio']) || !is_numeric($producto['precio'])) {
                $errores[] = 'Precio inválido';
            }

            if (!empty($producto['codigo_barras'])) {
                $codigo = (string) $producto['codigo_barras'];

                // Verifica duplicado en el archivo
                if (in_array($codigo, $codigosBarrasVistos)) {
                    $errores[] = 'Código de barras duplicado en el archivo';
                } else {
                    $codigosBarrasVistos[] = $codigo;

                    // Verifica duplicado en la base de datos
                    if (Producto::where('codigo_barras', $codigo)->exists()) {
                        $errores[] = 'Código de barras ya existe en la base de datos';
                    }
                }
            }

            // Guardar errores aparte para no sobrescribir columnas como 'estado'
            $producto['errores'] = $errores;
            $productos[] = $producto;
        }

        return response()->json(['success' => true, 'productos' => $productos]);
    }


    // ProductoController.php
    public function guardarMasivo(Request $request)
    {
        try {
            $productos = $request->input('productos', []);
            $categoriaId = $request->input('categoria_id');
            $subcategoriaId = $request->input('subcategoria_id');

            // Buscar empresa del usuario autenticado
            $idEmpresa = Empresa::where('id_user', auth()->id())->value('id');
            if (!$idEmpresa) {
                return response()->json(['success' => false, 'message' => 'El usuario no tiene una empresa asociada.'], 400);
            }

            // Validar existencia de categoría y subcategoría
            if (!Categoria::find($categoriaId)) {
                return response()->json(['success' => false, 'message' => 'Categoría no válida.'], 400);
            }
            if (!SubCategoria::find($subcategoriaId)) {
                return response()->json(['success' => false, 'message' => 'Subcategoría no válida.'], 400);
            }

            $errores = [];
            foreach ($productos as $index => $producto) {
                $productoErrores = [];

                if (empty($producto['nombre'])) $productoErrores[] = 'Nombre requerido';
                if (!isset($producto['precio']) || !is_numeric($producto['precio'])) $productoErrores[] = 'Precio inválido';
                if (!empty($producto['codigo_barras'])) {
                    if (!is_string($producto['codigo_barras']) && !is_numeric($producto['codigo_barras'])) {
                        $productoErrores[] = 'Código de barras debe ser texto o número';
                    } elseif (Producto::where('codigo_barras', $producto['codigo_barras'])->exists()) {
                        $productoErrores[] = 'Código de barras duplicado';
                    }
                }

                if (!empty($productoErrores)) $errores[$index] = $productoErrores;
            }

            if (!empty($errores)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hay errores en algunos productos',
                    'errores' => $errores,
                ], 422);
            }

            // Guardar productos válidos
            foreach ($productos as $producto) {
                $nuevoProducto = Producto::create([
                    'nombre' => $producto['nombre'],
                    'precio' => $producto['precio'],
                    'descripcion' => $producto['descripcion'] ?? null,
                    'codigo_barras' => $producto['codigo_barras'] ?? null,
                    'id_categoria' => $categoriaId,
                    'id_subcategoria' => $subcategoriaId,
                    'estado' => 'activo',
                    'id_empresa' => $idEmpresa,
                ]);

                // Log temporal para depuración
                /*Log::info('Producto procesado', [
                    'id' => $nuevoProducto->id,
                    'nombre' => $producto['nombre'],
                    'imagen_url' => $producto['imagen_url'] ?? null
                ]);*/

                // Si el producto trae una URL de imagen, la guardamos
                if (!empty($producto['imagen_url'])) {
                    Imagen::create([
                        'id_producto' => $nuevoProducto->id,
                        'ruta' => $producto['imagen_url'],
                    ]);
                    //Log::info("Imagen registrada para producto {$nuevoProducto->id}: {$producto['imagen_url']}");
                } else {
                    //Log::info("No hay imagen para producto {$nuevoProducto->id}");
                }
            }

            return response()->json(['success' => true, 'message' => 'Productos registrados correctamente']);
        } catch (\Throwable $e) {
            //Log::error('Error guardarMasivo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error interno: ' . $e->getMessage(),
            ], 500);
        }
    }
}
