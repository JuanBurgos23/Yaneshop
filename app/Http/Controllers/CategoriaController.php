<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\SubCategoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{

    public function index()
    {
        $categorias = Categoria::all();


        $subcategorias = SubCategoria::whereIn('id_categoria', $categorias->pluck('id'))->get();

        // Cargamos productos paginados por categoría
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
        Categoria::Create([
            'nombre' => $request->nombre, // Normalize
            'descripcion' => $request->descripcion,
        ]);
        return redirect()->back()->with('success', 'Categoria registrada correctamente');
    }
    public function porCategoria(Request $request)
    {
        try {
            $subcategorias = Subcategoria::where('id_categoria', $request->categoria_id)->get();

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

        $categorias = Categoria::where('nombre', 'like', '%' . $query . '%')
            ->orWhere('descripcion', 'like', '%' . $query . '%')
            ->limit(10)
            ->get();

        return response()->json($categorias);
    }

    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);
        return response()->json($categoria); // Devolvemos la categoría como JSON
    }
    public function update(Request $request, $id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->update($request->only('nombre', 'descripcion'));

        return redirect()->back()->with('success', 'Categoria actualizada correctamente');
    }

    //sub categoria
    public function storeSubCategoria(Request $request)
    {
        SubCategoria::Create([
            'nombre' => $request->nombre, // Normalize
            'id_categoria' => $request->id_categoria,
        ]);
        return redirect()->back()->with('success', 'Subcategoría registrada correctamente');
    }
    public function editSubCategoria($id)
    {
        $subcategoria = SubCategoria::findOrFail($id);
        return response()->json($subcategoria); // Devolvemos la subcategoría como JSON
    }
    public function updateSubCategoria(Request $request, $id)
    {
        $subcategoria = SubCategoria::findOrFail($id);
        $subcategoria->update($request->only('nombre', 'id_categoria'));
        return redirect()->back()->with('success', 'Subcategoría actualizada correctamente');
    }

    public function subcategoriasPorCategoria($id)
{
    $subcategorias = SubCategoria::where('id_categoria', $id)->get();
    return response()->json($subcategorias);
}
}
