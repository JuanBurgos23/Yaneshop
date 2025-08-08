<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        // Filtrado
        $query = Cliente::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('ci', 'like', '%' . $request->search . '%')
                ->orWhere('paterno', 'like', '%' . $request->search . '%');
        }

        // Paginación (10 clientes por página) y orden por fecha de creación (último agregado primero)
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


    //formulario del carrito
    public function buscarPorTelefono($telefono)
    {
        $cliente = Cliente::where('telefono', $telefono)->first();
        if ($cliente) {
            return response()->json([
                'encontrado' => true,
                'cliente' => $cliente
            ]);
        }
        return response()->json(['encontrado' => false]);
    }

    public function registrar(Request $request)
    {
        $request->validate([
            'telefono' => 'required|string',
            'nombre'   => 'required|string',
            'direccion' => 'required|string',
            'ciudad'   => 'required|string',
            'ci'       => 'nullable|string'
        ]);

        // Buscar cliente existente por teléfono
        $cliente = Cliente::where('telefono', $request->telefono)->first();

        if ($cliente) {
            // Cliente ya existe
            return response()->json([
                'success' => true,
                'cliente' => $cliente
            ]);
        }

        // Crear nuevo cliente
        $cliente = Cliente::create($request->only(['telefono', 'nombre', 'direccion', 'ciudad', 'ci']));

        return response()->json([
            'success' => true,
            'cliente' => $cliente
        ]);
    }
}
