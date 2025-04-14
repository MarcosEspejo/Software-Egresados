@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-libertadores-green mb-6">Mis Notificaciones</h1>

    @if($notifications->count() > 0)
        <div class="space-y-4">
            @foreach($notifications as $notification)
                <div class="bg-white p-4 rounded-lg shadow {{ $notification->read ? 'opacity-75' : '' }}">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-xl font-semibold mb-2">{{ $notification->title }}</h3>
                            <p class="text-gray-600">{{ $notification->message }}</p>
                            <div class="mt-2 text-sm text-gray-500">
                                {{ $notification->created_at->diffForHumans() }}
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            @if(!$notification->read)
                                <form action="{{ route('egresados.notifications.mark-as-read', $notification->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-sm text-libertadores-green hover:text-libertadores-gold">
                                        <i class="fas fa-check mr-1"></i> Marcar como leída
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('egresados.notifications.destroy', $notification->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600 hover:text-red-800" 
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar esta notificación?')">
                                    <i class="fas fa-trash-alt mr-1"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-600">No tienes notificaciones.</p>
    @endif
</div>
@endsection 