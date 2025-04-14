@extends('layouts.app')

@section('title', 'Enviar Alerta a Egresado')

@section('content')
    <h1 class="text-3xl font-bold text-libertadores-green mb-6">Enviar Alerta a Egresado</h1>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('send.alert') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
            <input type="email" name="email" id="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-libertadores-green focus:ring focus:ring-libertadores-green" required>
        </div>
        <div class="mb-4">
            <label for="message" class="block text-sm font-medium text-gray-700">Mensaje</label>
            <textarea name="message" id="message" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-libertadores-green focus:ring focus:ring-libertadores-green" required></textarea>
        </div>
        <button type="submit" class="bg-libertadores-green hover:bg-libertadores-gold text-white font-bold py-2 px-4 rounded transition duration-300">
            Enviar
        </button>
    </form>
@endsection 