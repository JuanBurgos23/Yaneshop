<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\SubCategoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriaController extends Controller
{

    public function index()
    {
        // Si el usuario está autenticado y su empresa es la que queremos filtrar
        $empresaId = Auth::user()->empresa->id;

        // Traer solo categorías de esa empresa
        $categorias = Categoria::where('id_empresa', $empresaId)->get();

        // Subcategorías solo de esas categorías
        $subcategorias = SubCategoria::whereIn('id_categoria', $categorias->pluck('id'))->get();

        // Cargar productos paginados por categoría
        $categoriasConProductos = $categorias->map(function ($categoria) {
            $productosPaginados = Producto::where('id_categoria', $categoria->id)
                ->paginate(10, ['*'], "pagina_categoria_{$categoria->id}");
            $categoria->productosPaginados = $productosPaginados;
            return $categoria;
        });

        return view('categoria.categoria', [
            'categorias' => $categoriasConProductos,
            'subcategorias' => $subcategorias
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        Categoria::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'id_empresa' => Auth::user()->empresa->id, // <- asignar empresa
        ]);

        return redirect()->back()->with('success', 'Categoría registrada correctamente');
    }

    public function porCategoria(Request $request)
    {
        try {
            // Solo subcategorías de la empresa logueada o la empresa correspondiente
            $subcategorias = Subcategoria::where('id_categoria', $request->categoria_id)
                ->where('id_empresa', Auth::user()->empresa->id)
                ->get();

            return response()->json(
                $subcategorias->map(function ($sub) {
                    return [
                        'id' => $sub->id,
                        'text' => $sub->nombre
                    ];
                })
            );
        } catch (\Throwable $th) {
            \Log::error('Error cargando subcategorías: ' . $th->getMessage());
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }

    public function buscar(Request $request)
    {
        $query = $request->input('q');
        $empresaId = Auth::user()->empresa->id;

        $categorias = Categoria::where('id_empresa', $empresaId)
            ->where(function ($q) use ($query) {
                $q->where('nombre', 'like', '%' . $query . '%')
                    ->orWhere('descripcion', 'like', '%' . $query . '%');
            })
            ->limit(10)
            ->get();

        return response()->json($categorias);
    }

    public function edit($id)
    {
        $empresaId = Auth::user()->empresa->id;

        // Buscar solo en la empresa del usuario autenticado
        $categoria = Categoria::where('id_empresa', $empresaId)->findOrFail($id);

        return response()->json($categoria);
    }

    public function update(Request $request, $id)
    {
        $empresaId = Auth::user()->empresa->id;

        $categoria = Categoria::where('id_empresa', $empresaId)->findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $categoria->update($request->only('nombre', 'descripcion'));

        return redirect()->back()->with('success', 'Categoría actualizada correctamente');
    }

    //sub categoria
    public function storeSubCategoria(Request $request)
    {
        $empresaId = Auth::user()->empresa->id;

        $request->validate([
            'nombre' => 'required|string|max:255',
            'id_categoria' => 'required|exists:categoria,id',
        ]);

        SubCategoria::create([
            'nombre' => $request->nombre,
            'id_categoria' => $request->id_categoria,
            'id_empresa' => $empresaId,
        ]);

        return redirect()->back()->with('success', 'Subcategoría registrada correctamente');
    }

    public function editSubCategoria($id)
    {
        $empresaId = Auth::user()->empresa->id;

        $subcategoria = SubCategoria::where('id_empresa', $empresaId)->findOrFail($id);

        return response()->json($subcategoria);
    }

    public function updateSubCategoria(Request $request, $id)
    {
        $empresaId = Auth::user()->empresa->id;

        $subcategoria = SubCategoria::where('id_empresa', $empresaId)->findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'id_categoria' => 'required|exists:categoria,id',
        ]);

        $subcategoria->update($request->only('nombre', 'id_categoria'));

        return redirect()->back()->with('success', 'Subcategoría actualizada correctamente');
    }

    public function subcategoriasPorCategoria($id)
    {
        $empresaId = Auth::user()->empresa->id;

        $subcategorias = SubCategoria::where('id_categoria', $id)
            ->where('id_empresa', $empresaId)
            ->get();

        return response()->json($subcategorias);
    }
}
