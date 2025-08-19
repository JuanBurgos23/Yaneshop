<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class ClienteController extends Controller
{


    public function index(Request $request)
    {
        $usuario = Auth::user();

        // Verificar si tiene empresa
        if (!$usuario->empresa) {
            // Paginador vacío para evitar error con links()
            $clientes = new LengthAwarePaginator([], 0, 10);
            $noEmpresa = true; // flag para el modal
            return view('cliente.cliente', compact('clientes', 'noEmpresa'));
        }

        $empresaId = $usuario->empresa->id;

        // Query base: solo clientes de esta empresa
        $query = Cliente::where('id_empresa', $empresaId);

        // Filtro de búsqueda
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ci', 'like', '%' . $search . '%')
                    ->orWhere('paterno', 'like', '%' . $search . '%')
                    ->orWhere('nombre', 'like', '%' . $search . '%');
            });
        }

        // Paginación y orden
        $clientes = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('cliente.cliente', compact('clientes'));
    }

    public function store(Request $request)
    {
        $cliente = new Cliente();
        $cliente->nombre = $request->nombre;
        $cliente->paterno = $request->paterno;
        $cliente->materno = $request->materno;
        $cliente->ci = $request->ci;
        $cliente->telefono = $request->telefono;
        $cliente->correo = $request->correo;

        $cliente->save();

        return redirect()->route('mostrar_cliente')->with('success', 'Cliente Registrado correctamente');
    }

    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return response()->json($cliente); // Devolvemos el cliente como JSON
    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::find($id);
        $cliente->nombre = $request->nombre;
        $cliente->paterno = $request->paterno;
        $cliente->materno = $request->materno;
        $cliente->ci = $request->ci;
        $cliente->telefono = $request->telefono;
        $cliente->correo = $request->correo;

        $cliente->update();
        return redirect()->route('mostrar_cliente')->with('success', 'Cliente actualizado correctamente');
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        $clientes = Cliente::where('nombre_completo', 'like', "%{$query}%")
            ->orWhere('ci', 'like', "%{$query}%")
            ->orWhere('paterno', 'like', "%{$query}%")
            ->get();

        return response()->json($clientes);
    }

    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);

        try {
            $cliente->delete();
            return redirect()->route('mostrar_cliente')->with('success', 'Cliente eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('mostrar_cliente')->with('error', 'No se pudo eliminar el cliente. Error: Esta registrado en una inscripcion.');
        }
    }


    // Buscar cliente por teléfono para la empresa actual
    public function buscarPorTelefono($telefono, Request $request)
    {
        // Espera que envíes la empresa_id en query (desde fetch)
        $empresaId = $request->query('empresa_id');
        if (!$empresaId) {
            return response()->json(['error' => 'Empresa no definida'], 400);
        }

        $cliente = Cliente::where('telefono', $telefono)
            ->where('id_empresa', $empresaId)
            ->first();

        if ($cliente) {
            return response()->json([
                'encontrado' => true,
                'cliente' => $cliente
            ]);
        }

        return response()->json(['encontrado' => false]);
    }

    // Registrar cliente para la empresa actual
    public function registrar(Request $request)
    {
        // Obtenemos la empresa correctamente
        $empresaId = $request->id_empresa;

        $cliente = Cliente::where('telefono', $request->telefono)
            ->where('id_empresa', $empresaId)
            ->first();

        if ($cliente) {
            return response()->json([
                'success' => true,
                'cliente' => $cliente
            ]);
        }

        $cliente = Cliente::create(array_merge(
            $request->only(['telefono', 'nombre', 'direccion', 'ciudad', 'ci']),
            ['id_empresa' => $empresaId]
        ));

        return response()->json([
            'success' => true,
            'cliente' => $cliente
        ]);
    }
}
