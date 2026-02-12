<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function mostrar()
    {
        return view('login');
    }

    public function procesar(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Credenciales incorrectas');
        }

        session(['logueado' => true, 'user_id' => $user->id]);

        return redirect()->route('contacto');
    }
}
