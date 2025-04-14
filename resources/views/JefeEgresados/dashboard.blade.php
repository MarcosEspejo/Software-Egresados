@extends('layouts.app')

@section('title', 'Dashboard - Jefe de Egresados')

@section('content')
<div class="container mx-auto py-6">
<a href="{{ route('jefe_egresados.index') }}">  
    <img src="{{ asset('imagenes/regresar.jpg') }}" class="w-8 h-8 text-sm text-yellow-700" />  
</a>
 
    <h1 class="text-3xl font-bold mb-4">Dashboard - Jefe de Egresados</h1>

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Total de Egresados: {{ $totalEgresados }}</h2>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Egresados por Carrera</h2>
        <table class="min-w-full bg-white border border-gray-300">
            <thead class="bg-libertadores-green text-white">
                <tr>
                    <th class="border-b-2 border-gray-300 px-4 py-2 text-left">Carrera</th>
                    <th class="border-b-2 border-gray-300 px-4 py-2 text-left">Cantidad</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($conteoCarreras as $carrera => $cantidad)
                <tr class="hover:bg-gray-100 transition duration-300">
                    <td class="border-b border-gray-300 px-4 py-2">
                        <a href="{{ route('jefe_egresados.egresadosPorCarrera', ['carrera' => $carrera]) }}" class="text-blue-500 hover:underline">
                            {{ $carrera }}
                        </a>
                    </td>
                    <td class="border-b border-gray-300 px-4 py-2">{{ $cantidad }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
