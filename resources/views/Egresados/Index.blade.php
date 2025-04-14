@extends('layouts.app')

@section('title', 'Portal de Egresados - Universidad Los Libertadores')

@section('content')
<div class="flex bg-gray-100 min-h-screen">
    <!-- Menú lateral -->
    <div x-data="{ open: false }" class="flex flex-col w-64 bg-white shadow-md">
        <div class="flex items-center justify-between p-4 bg-libertadores-green text-white">
            <h2 class="text-lg font-bold">Menú</h2>
            @auth('web')
            <a href="{{ route('egresados.notifications.index') }}" class="relative">
                <i class="fas fa-bell text-xl"></i>
                @if(auth()->user()->notifications()->where('read', false)->count() > 0)
                <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                    {{ auth()->user()->notifications()->where('read', false)->count() }}
                </span>
                @endif
            </a>
            @endauth
            <button @click="open = !open" class="md:hidden focus:outline-none">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <div x-show="open" @click.away="open = false" class="md:block md:static md:bg-white md:shadow-none" x-transition>

            <ul class="py-2">
                
                <li>
                    
                        @if(auth()->guard('web')->check())
                        <center><div class="bg-white rounded-lg shadow-md p-4 mb-6">
                            <h2 class="text-lg font-semibold text-libertadores-green">Información de Egresado</h2>
                            <p class="text-sm text-gray-600">Estado: Autenticado como Egresado</p>
                            <p class="text-sm text-gray-600">Documento: {{ auth()->user()->documento }}</p>
                            <p class="text-sm text-gray-600">Nombre: {{ auth()->user()->nombre }}</p>
                        </div>  </center>
                        <a href="{{ route('egresados.show', auth()->guard('web')->user()->id) }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Perfil</a>
                        <a href="{{ route('egresados.notifications.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 flex items-center justify-between">
                            <span>Notificaciones</span>
                            @if(auth()->user()->notifications()->where('read', false)->count() > 0)
                            <span class="bg-red-500 text-white text-xs rounded-full px-2 py-1">
                                {{ auth()->user()->notifications()->where('read', false)->count() }}
                            </span>
                            @endif
                        </a>
                        @else
                        <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                            <h2 class="text-lg font-semibold text-libertadores-green">Información de Egresado</h2>
                            <p class="text-sm text-gray-600">Estado: No autenticado</p>
                        </div>
                        @endif
                    
                </li>
                <li>
                    <a href="{{ route('events.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Eventos</a>
                </li>
                <li>
                    <a href="{{ route('noticias.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Noticias</a>
                </li>
                <li>
                    <a href="https://co.computrabajo.com/" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Ofertas de Trabajo</a>
                </li>
          
            </ul>

        </div>

    </div>

    <div class="flex-1 container mx-auto px-4 md:px-6 py-8">
        <header class="mb-12 text-center">
            <h1 class="text-5xl font-bold text-libertadores-green mb-4">
                Bienvenido al Portal de Egresados
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Conectando el éxito de nuestros graduados y forjando un futuro brillante juntos.
            </p>
        </header>


        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <section class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300">
                <h2 class="text-2xl font-semibold mb-4 text-libertadores-green flex items-center">
                    <i class="fas fa-calendar-alt mr-2"></i>Próximos eventos
                </h2>
                @if(isset($eventos) && count($eventos) > 0)
                <ul class="space-y-4">
                    @foreach($eventos as $evento)
                    <li class="flex justify-between items-center border-b pb-2 hover:bg-gray-50 transition duration-150 ease-in-out rounded-md p-2">
                        <span class="font-medium text-gray-700">{{ $evento->titulo }}</span>
                        <span class="text-sm text-gray-500">{{ $evento->fecha->format('d M, Y') }}</span>
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="text-gray-600">No hay eventos próximos en este momento.</p>
                @endif
                <a href="{{ route('events.index') }}" class="mt-4 inline-block text-libertadores-green hover:text-libertadores-gold font-semibold transition duration-300">Ver todos los eventos →</a>
            </section>

            <section class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300">
                <h2 class="text-2xl font-semibold mb-4 text-libertadores-green flex items-center">
                    <i class="fas fa-newspaper mr-2"></i>Noticias recientes
                </h2>
                @if(isset($noticias) && count($noticias) > 0)
                <ul class="space-y-4">
                    @foreach($noticias as $noticia)
                    <li>
                        <a href="{{ route('noticias.show', $noticia) }}" class="block hover:bg-gray-50 transition duration-150 ease-in-out rounded-md p-2">
                            <h3 class="font-medium text-gray-700">{{ $noticia->titulo }}</h3>
                            <p class="text-sm text-gray-500">{{ Str::limit($noticia->resumen, 100) }}</p>
                        </a>
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="text-gray-600">No hay noticias recientes en este momento.</p>
                @endif
                <a href="{{ route('noticias.index') }}" class="mt-4 inline-block text-libertadores-green hover:text-libertadores-gold font-semibold transition duration-300">Ver todas las noticias →</a>
            </section>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('job_offers.index') }}" class="bg-white text-libertadores-green font-semibold px-6 py-8 rounded-lg shadow-md hover:bg-libertadores-green hover:text-white transition duration-300 ease-in-out text-center group">
                <i class="fas fa-briefcase mb-4 text-4xl group-hover:scale-110 transition-transform duration-300"></i>
                <div class="text-xl">Ver ofertas de trabajo</div>
            </a>
            <a href="{{ route('programs.index') }}" class="bg-white text-libertadores-green font-semibold px-6 py-8 rounded-lg shadow-md hover:bg-libertadores-green hover:text-white transition duration-300 ease-in-out text-center group">
                <i class="fas fa-graduation-cap mb-4 text-4xl group-hover:scale-110 transition-transform duration-300"></i>
                <div class="text-xl">Explorar programas</div>
            </a>
            <a href="#" class="bg-white text-libertadores-green font-semibold px-6 py-8 rounded-lg shadow-md hover:bg-libertadores-green hover:text-white transition duration-300 ease-in-out text-center group">
                <i class="fas fa-users mb-4 text-4xl group-hover:scale-110 transition-transform duration-300"></i>
                <div class="text-xl">Comunidad de egresados</div>
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@2.x.x/dist/alpine.min.js" defer></script>
@endpush