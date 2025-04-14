@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Noticias</h1>
    @foreach($noticias as $noticia)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $noticia->titulo }}</h5>
                <p class="card-text">{{ Str::limit($noticia->resumen, 100) }}</p>
                <a href="{{ route('noticias.show', $noticia) }}" class="btn btn-primary">Leer más</a>
            </div>
        </div>
    @endforeach
    
    {{ $noticias->links() }}
</div>
@endsection

