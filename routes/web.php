<?php  

use Illuminate\Support\Facades\Route;  
use App\Http\Controllers\EgresadoController;  
use App\Http\Controllers\ProgramController;  
use App\Http\Controllers\JobOfferController;  
use App\Http\Controllers\EventController;  
use App\Http\Controllers\NoticiaController;  
use App\Http\Controllers\JefeEgresadoController;  
use App\Http\Middleware\CheckAnyAuth;  

// Ruta principal  
Route::get('/', function () {  
    return view('principal');  
})->name('home');  

// Rutas de Egresados  
Route::prefix('egresados')->name('egresados.')->group(function () {  
    // Rutas públicas  
    Route::get('/login', [EgresadoController::class, 'indexFormLogin'])->name('login');  
    Route::post('/login', [EgresadoController::class, 'iniciarSesion'])->name('login.post');  
    Route::get('/register', [EgresadoController::class, 'showRegistrationForm'])->name('register');  
    Route::post('/register', [EgresadoController::class, 'register'])->name('register.post');  

    // Rutas protegidas  
    Route::middleware([CheckAnyAuth::class])->group(function () {  
        Route::get('/', [EgresadoController::class, 'PrincipalEgresados'])->name('index');  
        Route::get('/create', [EgresadoController::class, 'create'])->name('create');  
        Route::get('/dashboard', [EgresadoController::class, 'dashboard'])->name('dashboard');  
        
        // Rutas de notificaciones
        Route::get('/notifications', [EgresadoController::class, 'notifications'])->name('notifications.index');
        Route::patch('/notifications/{notification}/mark-as-read', [EgresadoController::class, 'markNotificationAsRead'])
            ->name('notifications.mark-as-read');
        Route::delete('/notifications/{notification}', [EgresadoController::class, 'destroyNotification'])
            ->name('notifications.destroy');
        
        // Rutas con parámetros
        Route::get('/{egresado}', [EgresadoController::class, 'show'])->name('show');  
        Route::get('/{egresado}/edit', [EgresadoController::class, 'edit'])->name('edit');  
        Route::put('/{egresado}', [EgresadoController::class, 'update'])->name('update');  
    });  
});


// Rutas de Programas  
Route::get('/programs', [ProgramController::class, 'index'])->name('programs.index');  

// Rutas de Ofertas de Trabajo  
Route::get('/job-offers', [JobOfferController::class, 'index'])->name('job_offers.index');  

// Rutas de Eventos  
Route::get('/events', [EventController::class, 'index'])->name('events.index');  

// Rutas de Noticias  
Route::get('/noticias', [NoticiaController::class, 'index'])->name('noticias.index');  
Route::get('/noticias/{noticia}', [NoticiaController::class, 'show'])->name('noticias.show');  

// Rutas para Jefe de Egresados  
Route::prefix('jefe-egresados')->name('jefe_egresados.')->group(function () {  
    // Rutas públicas  
    Route::get('/login', [JefeEgresadoController::class, 'mostrarInicioSesion'])->name('login');  
    Route::post('/login', [JefeEgresadoController::class, 'iniciarSesion'])->name('login.post');  
    Route::get('/register', [JefeEgresadoController::class, 'mostrarRegistro'])->name('register');  
    Route::post('/register', [JefeEgresadoController::class, 'registrar'])->name('register.post');  

    // Rutas protegidas  
    Route::middleware([CheckAnyAuth::class])->group(function () {  
        Route::get('/', [JefeEgresadoController::class, 'index'])->name('index');  
        Route::get('/dashboard', [JefeEgresadoController::class, 'dashboard'])->name('dashboard');  
        Route::get('/busquedaAvanzada', [JefeEgresadoController::class, 'busquedaAvanzada'])->name('busquedaAvanzada');  
        
        // CRUD de egresados
        Route::get('/create', [JefeEgresadoController::class, 'create'])->name('create');  
        Route::post('/store', [JefeEgresadoController::class, 'store'])->name('store');  
        Route::get('/{egresado}/edit', [JefeEgresadoController::class, 'edit'])->name('edit');  
        Route::put('/{egresado}', [JefeEgresadoController::class, 'update'])->name('update');  
        Route::delete('/{egresado}', [JefeEgresadoController::class, 'destroy'])->name('destroy');  
        
        // Rutas de alertas
        Route::get('/alerta', [JefeEgresadoController::class, 'mostrarAlerta'])->name('alerta');
        Route::get('/enviar-alerta', [JefeEgresadoController::class, 'mostrarFormulario'])->name('enviar.alerta');
        Route::post('/send-alert', [JefeEgresadoController::class, 'sendAlert'])->name('send.alert');
        
        // Otras rutas protegidas
        Route::post('/logout', [JefeEgresadoController::class, 'logout'])->name('logout');  
        Route::get('/egresados/carrera/{carrera}', [JefeEgresadoController::class, 'egresadosPorCarrera'])->name('egresadosPorCarrera');  
        
        // Rutas de alertas
        Route::get('/alertas', [JefeEgresadoController::class, 'alertasEnviadas'])->name('alertas.index');
        Route::get('/alertas/{notification}/edit', [JefeEgresadoController::class, 'editAlerta'])->name('alertas.edit');
        Route::put('/alertas/{notification}', [JefeEgresadoController::class, 'updateAlerta'])->name('alertas.update');
        Route::delete('/alertas/{notification}', [JefeEgresadoController::class, 'destroyAlerta'])->name('alertas.destroy');
    });  
});


require __DIR__.'/auth.php';