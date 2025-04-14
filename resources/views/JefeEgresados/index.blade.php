@extends('layouts.app')

@section('title', 'Egresados - Universidad Los Libertadores')

@section('content')
    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <h1 class="text-3xl font-bold text-libertadores-green mb-6">Directorio de Egresados</h1>
            
            @if(isset($egresados) && $egresados->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($egresados as $egresado)
                        <div class="bg-gray-50 rounded-lg shadow p-4 hover:shadow-md transition duration-300">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <img class="h-12 w-12 rounded-full" src="{{ $egresado->foto_url ?? asset('images/default-avatar.png') }}" alt="{{ $egresado->nombre }}">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        {{ $egresado->nombre }} {{ $egresado->apellido }}
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        {{ $egresado->programa }}
                                    </p>
                                </div>
                                <div class="inline-flex items-center text-base font-semibold text-libertadores-green">
                                    <a href="{{ route('egresados.show', $egresado->id) }}" class="hover:text-libertadores-gold transition duration-300">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">
                    {{ $egresados->links() }}
                </div>
            @else
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                No hay egresados registrados en este momento.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="mt-8">
        <h2 class="text-2xl font-bold text-libertadores-green mb-4">Acciones Rápidas</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('jefe_egresados.create') }}" class="bg-libertadores-green hover:bg-libertadores-gold text-white hover:text-libertadores-green font-bold py-2 px-4 rounded transition duration-300 text-center">
                <i class="fas fa-user-plus mr-2"></i>Registrar Nuevo Egresado
            </a>
            <a href="{{ route('jefe_egresados.dashboard') }}" class="bg-libertadores-green hover:bg-libertadores-gold text-white hover:text-libertadores-green font-bold py-2 px-4 rounded transition duration-300 text-center">
                <i class="fas fa-tachometer-alt mr-2"></i>Ir al Dashboard
            </a>
            <a href="{{ route('jefe_egresados.busquedaAvanzada') }}" class="bg-libertadores-green hover:bg-libertadores-gold text-white hover:text-libertadores-green font-bold py-2 px-4 rounded transition duration-300 text-center">
                <i class="fas fa-search mr-2"></i>Búsqueda Avanzada
            </a>
            <a href="{{ route('jefe_egresados.alertas.index') }}" 
               class="bg-libertadores-green hover:bg-libertadores-gold text-white hover:text-libertadores-green font-bold py-2 px-4 rounded transition duration-300 text-center">
                <i class="fas fa-bell mr-2"></i>Ver Alertas Enviadas
            </a>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition duration-300">
                    <i class="fas fa-sign-out-alt mr-2"></i>Cerrar Sesión
                </button>
            </form>
        </div>
    </div>

    
@endsection



