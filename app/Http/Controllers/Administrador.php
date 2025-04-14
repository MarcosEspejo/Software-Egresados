<?php

namespace App\Http\Controllers\Auth;

use App\Models\Administrador;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdministradorController extends Controller
{
    public function mostrarInicioSesion()
    {
        return view('Administrador.login');
    }

    public function iniciarSesion(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('administrador')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('administrador.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('administrador')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function mostrarRegistro()
    {
        return view('Administrador.register');
    }

    public function registrar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:administradores',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $administrador = new Administrador([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $administrador->save();

        return redirect()->route('administrador.login')
            ->with('success', 'Registro exitoso. Por favor, inicie sesión.');
    }

    public function dashboard()
    {
        // aqui estara la logica del panel de admin
        return view('Administrador.dashboard');
    }

    public function index()
    {
        // aqui se mostrara la lista de egresados o otros usuarios
        return view('Administrador.index');
    }

    public function gestionarEgresados()
    {
        // aqu se podra gestionar la informacion del egresado
    }
}
