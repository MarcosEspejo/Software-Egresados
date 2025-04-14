@extends('layouts.app')

@section('title', 'Iniciar Sesión - Egresados')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-cover bg-center relative bg-fixed" 
     style="background-image: url('{{ asset('imagenes/cartagena.jpg') }}');">
    <!-- Overlay mejorado con gradiente -->
    <div class="absolute inset-0 bg-gradient-to-br from-black/70 to-libertadores-green/50"></div>

    <!-- Contenido del login -->
    <div class="z-10 max-w-md w-full space-y-6 p-8 backdrop-blur-sm bg-white/90 rounded-2xl shadow-2xl transform transition-all duration-300 hover:scale-[1.02]">
        <!-- Logo y título con animación -->
        <div class="fade-in">
            <img class="mx-auto h-16 w-auto drop-shadow-md transform transition-transform duration-300 hover:scale-110" 
                 src="{{ asset('imagenes/logo-full.png') }}" 
                 alt="Logo">
            <h2 class="mt-6 text-center text-3xl font-extrabold bg-gradient-to-r from-libertadores-green to-libertadores-gold bg-clip-text text-transparent">
                Bienvenido de Vuelta
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Portal de Egresados Los Libertadores
            </p>
        </div>

        <!-- Mensajes de éxito con animación -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg shadow-md transform animate-fade-in-down">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <!-- Mensajes de error con animación -->
        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded-lg shadow-md transform animate-fade-in-down">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Formulario de login mejorado -->
        <form class="mt-8 space-y-6" action="{{ route('egresados.login.post') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div class="group">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <input id="email" 
                               name="email" 
                               type="email" 
                               required 
                               class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-libertadores-green focus:border-libertadores-green transition-all duration-300 bg-white/50 backdrop-blur-sm"
                               placeholder="Correo electrónico">
                    </div>
                </div>

                <div class="group">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <input id="documento" 
                               name="documento" 
                               type="text" 
                               required 
                               class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-libertadores-green focus:border-libertadores-green transition-all duration-300 bg-white/50 backdrop-blur-sm"
                               placeholder="Documento">
                    </div>
                </div>
            </div>

            <div>
                <button type="submit" 
                        class="w-full flex justify-center items-center px-4 py-3 border border-transparent rounded-lg font-medium text-white bg-gradient-to-r from-libertadores-green to-green-600 hover:from-green-600 hover:to-libertadores-green transform transition-all duration-300 hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-libertadores-green shadow-lg hover:shadow-xl">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Iniciar Sesión
                </button>
            </div>
        </form>

        <!-- Enlaces adicionales -->
        <div class="mt-6 space-y-4">
            <p class="text-center text-sm text-gray-600">
                ¿No tienes una cuenta? 
                <a href="{{ route('egresados.register') }}" 
                   class="font-medium text-libertadores-green hover:text-green-600 transition-colors duration-300">
                    Regístrate aquí
                </a>
            </p>
            <div class="flex items-center justify-center space-x-4">
                <a href="#" class="text-gray-600 hover:text-libertadores-green transition-colors duration-300">
                    <i class="fas fa-question-circle"></i> Ayuda
                </a>
                <span class="text-gray-300">|</span>
                <a href="#" class="text-gray-600 hover:text-libertadores-green transition-colors duration-300">
                    <i class="fas fa-lock"></i> Política de privacidad
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Estilos adicionales -->
<style>
    .fade-in {
        animation: fadeIn 0.6s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fade-in-down {
        animation: fadeInDown 0.5s ease-out;
    }

    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection
