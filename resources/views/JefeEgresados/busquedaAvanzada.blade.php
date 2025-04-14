@extends('layouts.app')

@section('title', 'Búsqueda Avanzada - Egresados')

@section('content')
<div class="container mx-auto py-6">
<a href="{{ route('jefe_egresados.index') }}">  
    <img src="{{ asset('imagenes/regresar.jpg') }}" class="w-8 h-8 text-sm text-yellow-700" />  
</a>
 
    <h1 class="text-3xl font-bold mb-4">Búsqueda Avanzada de Egresados</h1>

    <form action="{{ route('jefe_egresados.busquedaAvanzada') }}" method="GET" class="mb-4">
        <div class="flex flex-col space-y-4">
            <input type="text" name="query" placeholder="Buscar por nombre, apellido o documento" class="border border-gray-300 rounded-lg p-2">
            <input type="text" name="programa" placeholder="Buscar por programa" class="border border-gray-300 rounded-lg p-2">
            <button type="submit" class="bg-libertadores-green text-white rounded-lg px-4 py-2 hover:bg-libertadores-gold transition duration-300">
                <i class="fas fa-search"></i> Buscar
            </button>
        </div>
    </form>

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
                                <a href="{{ route('egresados.show', $egresado->id) }}" class="hover:text-libertadores-gold transition duration-300">
                                    {{ $egresado->nombre }} {{ $egresado->apellido }}
                                </a>
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
                        No se encontraron egresados que coincidan con los criterios de búsqueda.
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection 