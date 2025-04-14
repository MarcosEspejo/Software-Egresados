<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Egresado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EgresadoSessionController extends Controller
{
    public function create()
    {
        return view('Egresados.login'); // Asegúrate de que la vista exista
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'documento' => 'required|string',
        ]);

        $egresado = Egresado::where('email', $request->email)
            ->where('documento', $request->documento)
            ->first();

        if ($egresado) {
            Auth::login($egresado);
            return redirect()->route('egresados.index')->with('success', '¡Inicio de sesión exitoso!');
        }

        return back()->withErrors(['error' => 'Credenciales incorrectas.']);
    }

    public function destroy()
    {
        Auth::logout();
        return redirect()->route('egresados.login')->with('success', 'Has cerrado sesión.');
    }
} 