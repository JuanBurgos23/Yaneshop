<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PerfilController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('perfil.perfil', compact('user'));
    }

    public function perfilUpdate(Request $request)
    {

        $user = auth()->user();

        // Validar datos
        $request->validate([
            'name' => 'required|string|max:255',
            'paterno' => 'nullable|string|max:255',
            'materno' => 'nullable|string|max:255',
            'ci' => 'nullable|string|max:50',
            'telefono' => 'nullable|string|max:50',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|',
        ]);

        // Asignar datos
        $user->name = $request->name;
        $user->paterno = $request->paterno;
        $user->materno = $request->materno;
        $user->ci = $request->ci;
        $user->telefono = $request->telefono;
        $user->email = $request->email;

        // Actualizar contraseña solo si se proporcionó
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Perfil actualizado correctamente.');
    }

    public function updateAvatar(Request $request, $id)
    {
        // Validación de la imagen
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg', // Puedes ajustar los tamaños y formatos permitidos
        ]);

        $user = User::find($id);

        // Si el usuario no existe, redirigir con un error
        if (!$user) {
            return redirect()->back()->with('error', 'Usuario no encontrado.');
        }

        // Procesar la imagen si fue subida
        if ($request->hasFile('avatar')) {
            // Eliminar la imagen anterior si existe
            if ($user->imagen && Storage::exists('public/' . $user->imagen)) {
                Storage::delete('public/' . $user->imagen);
            }

            // Subir la nueva imagen
            $path = $request->file('avatar')->store('avatars', 'public');

            // Actualizar el campo avatar en la base de datos
            $user->imagen = $path;
            $user->save();
        }

        return redirect()->back()->with('success', 'Foto de perfil actualizada correctamente.');
    }
    public function deleteAvatar($id)
    {
        // Obtén el usuario por ID
        $user = User::findOrFail($id);

        // Verifica si el usuario tiene una imagen
        if ($user->imagen && Storage::exists('public/' . $user->imagen)) {
            // Elimina la imagen del almacenamiento
            Storage::delete('public/' . $user->imagen);
        }

        // Restablece el campo imagen a null
        $user->imagen = null;
        $user->save();

        // Redirige de nuevo a la página del perfil del usuario
        return redirect()->back()->with('success', 'Foto de perfil eliminada correctamente.');
    }
}
