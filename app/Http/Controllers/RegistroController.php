<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistroController extends Controller
{
    public function mostrar()
    {
        return view('registro');
    }

    public function procesar(Request $request)
    {
        //  Validación
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ], [
            'email.unique' => 'Este email ya está registrado.',
        ]);

        //  Crear usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Guardar sesión correctamente
        session([
            'logueado' => true,
            'user_id' => $user->id,
        ]);

        return redirect()->route('contacto');
    }
}
