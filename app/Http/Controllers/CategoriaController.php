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
        $empresaId = Auth::user()->empresa->id;

        // 🔹 Traer solo categorías activas de la empresa
        $categorias = Categoria::where('id_empresa', $empresaId)
            ->where('estado', 'activo')
            ->get();

        // 🔹 Subcategorías activas solo de esas categorías
        $subcategorias = SubCategoria::whereIn('id_categoria', $categorias->pluck('id'))
            ->where('estado', 'activo')
            ->get();

        // 🔹 Cargar productos paginados por categoría (si existen)
        $categoriasConProductos = $categorias->map(function ($categoria) {
            $productosPaginados = Producto::where('id_categoria', $categoria->id)
                ->paginate(10, ['*'], "pagina_categoria_{$categoria->id}");
            $categoria->productosPaginados = $productosPaginados;
            return $categoria;
        });

        return view('Categoria.categoria', [
            'categorias' => $categoriasConProductos,
            'subcategorias' => $subcategorias
        ]);
    }



    public function store(Request $request)
    {
        $empresaId = Auth::user()->empresa->id;
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        Categoria::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'id_empresa' => $empresaId, // <- asignar empresa
        ]);

        return redirect()->back()->with('success', 'Categoría registrada correctamente');
    }

    public function porCategoria(Request $request)
    {
        try {
            // Solo subcategorías de la empresa logueada o la empresa correspondiente
            $subcategorias = Subcategoria::where('id_categoria', $request->categoria_id)
                ->where('id_empresa', Auth::user()->empresa->id)
                ->where('estado', 'activo')
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
            ->where('estado', 'activo') // 🔹 Solo categorías activas
            ->where(function ($q2) use ($query) {
                $q2->where('nombre', 'like', '%' . $query . '%')
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
    public function eliminarCategoria($id)
    {
        $empresaId = Auth::user()->empresa->id;

        $categoria = Categoria::where('id_empresa', $empresaId)->findOrFail($id);

        // Cambiar estado a eliminado
        $categoria->update(['estado' => 'eliminado']);

        // También eliminar sus subcategorías relacionadas
        SubCategoria::where('id_categoria', $categoria->id)
            ->where('id_empresa', $empresaId)
            ->update(['estado' => 'eliminado']);

        return response()->json(['success' => true, 'message' => 'Categoría eliminada correctamente']);
    }

    public function eliminarSubCategoria($id)
    {
        $empresaId = Auth::user()->empresa->id;

        $subcategoria = SubCategoria::where('id_empresa', $empresaId)->findOrFail($id);

        $subcategoria->update(['estado' => 'eliminado']);

        return response()->json(['success' => true, 'message' => 'Subcategoría eliminada correctamente']);
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
