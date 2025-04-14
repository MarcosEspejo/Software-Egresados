<?php

namespace App\Http\Controllers;

use App\Models\Egresado;
use App\Models\Noticia;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Notification;

class EgresadoController extends Controller
{
    public function create()
    {
        return view('egresados.create');
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

        return redirect()->route('egresados.index')
            ->with('success', 'Egresado registrado exitosamente.');
    }

    public function index()
    {
        $egresados = Egresado::paginate(15); 
        return view('egresados.index', compact('egresados'));
    }

    public function show($id)
    {
        $egresado = Egresado::findOrFail($id);
        return view('egresados.show', compact('egresado'));
    }

    public function edit(Egresado $egresado)
    {
        return view('egresados.edit', compact('egresado'));
    }

    public function update(Request $request, Egresado $egresado)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'email' => 'required|email|unique:egresados,email,' . $egresado->id,
                'programa' => 'required|string|max:255',
                'ano_graduacion' => 'required|integer|min:1900|max:' . date('Y'),
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            \Log::info('Actualizando egresado', [
                'id' => $egresado->id,
                'datos' => $request->all()
            ]);

            $egresado->nombre = $request->nombre;
            $egresado->apellido = $request->apellido;
            $egresado->email = $request->email;
            $egresado->programa = $request->programa;
            $egresado->ano_graduacion = $request->ano_graduacion;

            if ($request->hasFile('foto')) {
                // Eliminar la foto anterior si existe
                if ($egresado->foto_url) {
                    Storage::delete(str_replace('/storage', 'public', $egresado->foto_url));
                }
                
                $path = $request->file('foto')->store('public/egresados');
                $egresado->foto_url = Storage::url($path);
            }

            if ($egresado->save()) {
                \Log::info('Egresado actualizado exitosamente', ['id' => $egresado->id]);
                return redirect()->route('egresados.show', $egresado)
                    ->with('success', 'Egresado actualizado exitosamente.');
            } else {
                \Log::error('Error al guardar el egresado', ['id' => $egresado->id]);
                return back()->withInput()->withErrors(['error' => 'Error al actualizar el egresado.']);
            }

        } catch (\Exception $e) {
            \Log::error('Error en actualización de egresado', [
                'error' => $e->getMessage(),
                'id' => $egresado->id
            ]);
            return back()->withInput()->withErrors(['error' => 'Error al actualizar el egresado: ' . $e->getMessage()]);
        }
    }

    public function dashboard()
    {
        $egresado = Auth::user(); //  suponiendo que sea egresado
        $eventos = Evento::upcoming()->take(3)->get();
        $noticias = Noticia::latest()->take(3)->get();

        return view('Egresados.PrincipalEgresados', compact('egresado', 'eventos', 'noticias'));
    }

    public function PrincipalEgresados()
    {
        $eventos = Evento::upcoming()->take(3)->get();
        $noticias = Noticia::latest()->take(3)->get();
        
        return view('Egresados.Index', compact('eventos', 'noticias'));
    }

    public function indexFormLogin()
    {
        return view('Egresados.login');
    }


    public function iniciarSesion(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'documento' => 'required|string',
        ]);

        \Log::info('Intento de inicio de sesión de egresado', [
            'email' => $request->email,
            'documento' => $request->documento
        ]);

        $egresado = Egresado::where('email', $request->email)
            ->where('documento', $request->documento)
            ->first();

        if ($egresado) {
            \Log::info('Egresado encontrado', ['id' => $egresado->id]);
            
            Auth::guard('web')->login($egresado);
            
            if (Auth::guard('web')->check()) {
                \Log::info('Autenticación exitosa como egresado');
                return redirect()->route('egresados.index')
                    ->with('success', '¡Inicio de sesión exitoso!');
            }
        }

        \Log::warning('Credenciales incorrectas para egresado');
        return back()->withErrors(['error' => 'Credenciales incorrectas.']);
    }

    public function buscar(Request $request)
    {
        $request->validate([
            'query' => 'required|string|max:255',
        ]);

        $query = $request->input('query');

        // Buscar en la base de datos
        $egresados = Egresado::where('nombre', 'LIKE', "%{$query}%")
            ->orWhere('apellido', 'LIKE', "%{$query}%")
            ->orWhere('programa', 'LIKE', "%{$query}%")
            ->paginate(15);

        return view('JefeEgresados.index', compact('egresados'));
    }

    public function busquedaAvanzada(Request $request)
    {
        // Validar los parámetros de búsqueda
        $request->validate([
            'query' => 'nullable|string|max:255',
            'programa' => 'nullable|string|max:255',
        ]);

        // Obtener los parámetros de búsqueda
        $query = $request->input('query');
        $programa = $request->input('programa');

        // Realizar la búsqueda en la base de datos
        $egresados = Egresado::when($query, function ($queryBuilder) use ($query) {
            return $queryBuilder->where('nombre', 'LIKE', "%{$query}%")
                ->orWhere('apellido', 'LIKE', "%{$query}%");
        })
        ->when($programa, function ($queryBuilder) use ($programa) {
            return $queryBuilder->where('programa', 'LIKE', "%{$programa}%");
        })
        ->paginate(15);

        // Devolver la vista con los resultados
        return view('JefeEgresados.busquedaAvanzada', compact('egresados'));
    }

    public function showRegistrationForm()
    {
        return view('Egresados.register');
    }

    public function register(Request $request)
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

        // Redirigir al login con un mensaje de éxito
        return redirect()->route('egresados.login')->with('success', 'Registro exitoso. Ahora puedes iniciar sesión.');
    }

    public function notifications()
    {
        $notifications = auth()->user()->notifications()->orderBy('created_at', 'desc')->get();
        return view('Egresados.notifications', compact('notifications'));
    }

    public function markNotificationAsRead(Notification $notification)
    {
        if ($notification->egresado_id === auth()->id()) {
            $notification->update(['read' => true]);
            return back()->with('success', 'Notificación marcada como leída.');
        }
        return back()->with('error', 'No tienes permiso para modificar esta notificación.');
    }

    public function destroyNotification(Notification $notification)
    {
        if ($notification->egresado_id === auth()->id()) {
            $notification->delete();
            return back()->with('success', 'Notificación eliminada correctamente.');
        }
        return back()->with('error', 'No tienes permiso para eliminar esta notificación.');
    }
}
