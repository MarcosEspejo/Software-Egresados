@extends('layouts.app')

@section('title', 'Editar Egresado - Universidad Los Libertadores')

@section('content')
<div class="bg-white shadow-lg rounded-lg overflow-hidden max-w-4xl mx-auto">
    <div class="bg-libertadores-green p-6">
        <h1 class="text-3xl font-bold text-white mb-2">Editar Egresado</h1>
        <p class="text-libertadores-gold">Actualiza la información del egresado.</p>
    </div>
    <div class="p-6">
        <form action="{{ route('jefe_egresados.update', $egresado) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $egresado->nombre) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-libertadores-green focus:border-transparent" required>
                </div>
                
                <div>
                    <label for="apellido" class="block text-sm font-medium text-gray-700 mb-1">Apellido</label>
                    <input type="text" name="apellido" id="apellido" value="{{ old('apellido', $egresado->apellido) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-libertadores-green focus:border-transparent" required>
                </div>
            </div>
            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                <input type="email" name="email" id="email" value="{{ old('email', $egresado->email) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-libertadores-green focus:border-transparent" required>
            </div>
            
            <div>
                <label for="programa" class="block text-sm font-medium text-gray-700 mb-1">Programa Académico</label>
                <select name="programa" id="programa" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-libertadores-green focus:border-transparent" required>
                    <option value="">Seleccione un programa</option>
                    <option value="Ingeniería de Sistemas" {{ old('programa', $egresado->programa) == 'Ingeniería de Sistemas' ? 'selected' : '' }}>Ingeniería de Sistemas</option>
                    <option value="Administración de Empresas" {{ old('programa', $egresado->programa) == 'Administración de Empresas' ? 'selected' : '' }}>Administración de Empresas</option>
                    <option value="Gastronomia" {{ old('programa', $egresado->programa) == 'Gastronomia' ? 'selected' : '' }}>Gastronomia</option> 
                    <option value="Ingenieria Civil" {{ old('programa', $egresado->programa) == 'Ingeniería Civil' ? 'selected' : '' }}>Ingenieria Civil</option>
                    <option value="Desarrollo de Software" {{ old('programa', $egresado->programa) == 'Desarrollo de Software' ? 'selected' : '' }}>Desarrollo de Software</option>
                    <option value="Derecho" {{ old('programa', $egresado->programa) == 'Derecho' ? 'selected' : '' }}>Derecho</option>
                </select>
            </div>
            
            <div>
                <label for="ano_graduacion" class="block text-sm font-medium text-gray-700 mb-1">Año de Graduación</label>
                <input type="number" name="ano_graduacion" id="ano_graduacion" value="{{ old('ano_graduacion', $egresado->ano_graduacion) }}" min="1900" max="{{ date('Y') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-libertadores-green focus:border-transparent" required>
            </div>
            
            <div class="flex items-center justify-end mt-6">
                <a href="{{ route('egresados.show', $egresado) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-l transition duration-300 mr-2">
                    Cancelar
                </a>
                <button type="submit" class="bg-libertadores-green hover:bg-libertadores-gold text-white font-bold py-2 px-4 rounded-r transition duration-300">
                    Actualizar Egresado
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
