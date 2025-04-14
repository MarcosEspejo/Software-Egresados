@extends('layouts.app')

@section('title', 'Detalles del Egresado - Universidad Los Libertadores')

@section('content')
<div class="bg-white shadow-lg rounded-lg overflow-hidden max-w-4xl mx-auto">
    <div class="bg-libertadores-green p-6">
        <h1 class="text-3xl font-bold text-white mb-2">Detalles del Egresado</h1>
    </div>
    <div class="p-6">
        <div class="flex items-center space-x-4 mb-6">
            <img class="h-24 w-24 rounded-full" src="{{ $egresado->foto_url ?? asset('images/default-avatar.png') }}" alt="{{ $egresado->nombre }}">
            <div>
                <h2 class="text-2xl font-bold text-libertadores-green">{{ $egresado->nombre }} {{ $egresado->apellido }}</h2>
                <p class="text-gray-600">{{ $egresado->programa }}</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm font-medium text-gray-500">Correo Electrónico</p>
                <p class="text-lg">{{ $egresado->email }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Año de Graduación</p>
                <p class="text-lg">{{ $egresado->ano_graduacion }}</p>
            </div>
        </div>
        
        <div class="mt-8 flex space-x-4">
            <a href="{{ route('jefe_egresados.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded transition duration-300">
                Volver al Listado
            </a>
            <a href="{{ route('egresados.edit',  $egresado->id) }}" class="bg-libertadores-green hover:bg-libertadores-gold text-white font-bold py-2 px-4 rounded transition duration-300">
                Editar Egresado
            </a>
        </div>
    </div>
</div>
@endsection
