<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Egresado;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\JefeEgresadoMiddleware;
use App\Mail\AlertaEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\Notification;

class JefeEgresadoController extends Controller
{
    public function __construct()
    {
        // Quitamos el middleware del constructor
    }

    public function index()
    {
        $egresados = Egresado::paginate(15);
        return view('JefeEgresados.index', compact('egresados'));
    }

    public function create()
    {
        return view('JefeEgresados.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'documento' => 'required|string|unique:egresados,documento',
            'email' => 'required|email|unique:egresados,email',
            'programa' => 'required|string|max:255',
            'ano_graduacion' => 'required|integer|min:1900|max:' . date('Y'),
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $egresado = new Egresado($request->except('foto'));

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('public/egresados');
            $egresado->foto_url = Storage::url($path);
        }

        $egresado->save();

        // Redirigir al login de jefe de egresados con mensaje de éxito
        return redirect()->route('jefe_egresados.login')
            ->with('success', 'Egresado registrado exitosamente. Por favor, inicie sesión nuevamente.');
    }

    public function edit(Egresado $egresado)
    {
        return view('JefeEgresados.edit', compact('egresado'));
    }

    public function update(Request $request, Egresado $egresado)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email|unique:egresados,email,' . $egresado->id,
            'programa' => 'required|string|max:255',
            'ano_graduacion' => 'required|integer|min:1900|max:' . date('Y'),
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $egresado->fill($request->except('foto'));

        if ($request->hasFile('foto')) {
            // Eliminar foto anterior si existe
            if ($egresado->foto_url) {
                Storage::delete(str_replace('/storage', 'public', $egresado->foto_url));
            }
            $path = $request->file('foto')->store('public/egresados');
            $egresado->foto_url = Storage::url($path);
        }

        $egresado->save();

        return redirect()->route('jefe_egresados.index')
            ->with('success', 'Egresado actualizado exitosamente.');
    }

    public function destroy(Egresado $egresado)
    {
        if ($egresado->foto_url) {
            Storage::delete(str_replace('/storage', 'public', $egresado->foto_url));
        }
        $egresado->delete();

        return redirect()->route('jefe_egresados.index')
            ->with('success', 'Egresado eliminado exitosamente.');
    }

    public function mostrarInicioSesion()
    {
        return view('JefeEgresados.login');
    }

    public function iniciarSesion(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('jefe_egresado')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('jefe_egresados.index'));
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('jefe_egresado')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function mostrarRegistro()
    {
        return view('JefeEgresados.register');
    }

    public function registrar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:jefe_egresados',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $jefeEgresado = new \App\Models\JefeEgresado([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $jefeEgresado->save();

        // Eliminar el login automático y redirigir al login
        return redirect()->route('jefe_egresados.login')
            ->with('success', 'Registro exitoso. Por favor, inicie sesión.');
    }

    public function dashboard()
    {
        // Obtener el total de egresados
        $totalEgresados = Egresado::count();

        // Obtener el conteo de egresados por carrera
        $conteoCarreras = Egresado::select('programa', \DB::raw('count(*) as cantidad'))
            ->groupBy('programa')
            ->pluck('cantidad', 'programa');

        // Pasar las variables a la vista
        return view('JefeEgresados.dashboard', compact('totalEgresados', 'conteoCarreras'));
    }

    public function busquedaAvanzada(Request $request)
    {
        $query = $request->input('query');
        $programa = $request->input('programa');

        $egresados = Egresado::when($query, function ($queryBuilder) use ($query) {
            return $queryBuilder->where('nombre', 'like', "%{$query}%")
                                 ->orWhere('apellido', 'like', "%{$query}%")
                                 ->orWhere('documento', 'like', "%{$query}%"); // Filtrar por documento
        })
        ->when($programa, function ($queryBuilder) use ($programa) {
            return $queryBuilder->where('programa', 'like', "%{$programa}%");
        })
        ->paginate(10);

        return view('JefeEgresados.busquedaAvanzada', compact('egresados'));
    }

    public function egresadosPorCarrera($carrera)
    {
        // Obtener los egresados de la carrera específica
        $egresados = Egresado::where('programa', $carrera)->get();

        // Pasar los egresados a la vista
        return view('JefeEgresados.egresadosPorCarrera', compact('egresados', 'carrera'));
    }

    public function sendAlert(Request $request)
    {
        $request->validate([
            'egresado_id' => 'required|exists:egresados,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Notification::create([
            'egresado_id' => $request->egresado_id,
            'title' => $request->title,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Alerta enviada exitosamente al egresado.');
    }

    public function mostrarAlerta()
    {
        $egresados = Egresado::all();
        return view('JefeEgresados.alerta', compact('egresados'));
    }

    public function mostrarFormulario()
    {
        return view('JefeEgresados.enviar_alerta');
    }

    public function alertasEnviadas()
    {
        $notifications = Notification::with('egresado')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('JefeEgresados.alertas_enviadas', compact('notifications'));
    }

    public function editAlerta(Notification $notification)
    {
        return view('JefeEgresados.edit_alerta', compact('notification'));
    }

    public function updateAlerta(Request $request, Notification $notification)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $notification->update([
            'title' => $request->title,
            'message' => $request->message,
        ]);

        return redirect()->route('jefe_egresados.alertas.index')
            ->with('success', 'Alerta actualizada correctamente.');
    }

    public function destroyAlerta(Notification $notification)
    {
        $notification->delete();
        return redirect()->route('jefe_egresados.alertas.index')
            ->with('success', 'Alerta eliminada correctamente.');
    }

}
