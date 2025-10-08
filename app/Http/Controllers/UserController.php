<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Solo retorna la vista base sin usuarios (se cargarán por fetch)
        return view('admin.usuarios.index');
    }

   public function buscar(Request $request)
    {
        $query = $request->get('query', '');
        $perPage = $request->get('per_page', 10); // cantidad por página (default 10)

        $usuarios = User::with('empresa')
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('paterno', 'like', "%{$query}%")
                    ->orWhere('materno', 'like', "%{$query}%")
                    ->orWhere('ci', 'like', "%{$query}%")
                    ->orWhereHas('empresa', function ($q2) use ($query) {
                        $q2->where('nombre', 'like', "%{$query}%");
                    });
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return response()->json($usuarios);
    }

    public function crearEmpresa(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo_suscripcion' => 'required|string',
            'cantidad_meses' => 'nullable|integer|min:1'
        ]);

        $user = User::findOrFail($id);

        $empresa = new Empresa();
        $empresa->id_user = $user->id;
        $empresa->nombre = $request->nombre;
        $empresa->fecha_inicio_suscripcion = now();

        switch ($request->tipo_suscripcion) {
            case 'mensual':
                $empresa->fecha_fin_suscripcion = now()->addMonth();
                break;
            case 'semestral':
                $empresa->fecha_fin_suscripcion = now()->addMonths(6);
                break;
            case 'anual':
                $empresa->fecha_fin_suscripcion = now()->addYear();
                break;
            case 'personalizado':
                $meses = $request->cantidad_meses ?? 1;
                $empresa->fecha_fin_suscripcion = now()->addMonths($meses);
                break;
        }

        $empresa->tipo_suscripcion = $request->tipo_suscripcion;
        $empresa->save();

        return response()->json([
            'success' => true,
            'message' => 'Empresa creada correctamente',
            'empresa' => $empresa
        ]);
    }

    public function crearUsuario(Request $request)
    {
        // Validación
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        // Crear usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // Laravel 12 con $casts en User -> hashed
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Usuario creado correctamente',
            'usuario' => $user
        ]);
    }
}
