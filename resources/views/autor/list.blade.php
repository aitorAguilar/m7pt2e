@extends('layout')

@section('nom', 'Llistat de autors')

@section('stylesheets')
    @parent
@endsection

@section('content')
    <h1>Llistat de autors</h1>
    @if (Auth::check()) 
        <a href="{{ route('autor_new') }}">+ Nou autor</a>
    @endif
    

    @if (session('status'))
        <div>
            <strong>Success!</strong> {{ session('status') }}  
        </div>
    @endif

    <table style="margin-top: 20px;margin-bottom: 10px;">
        <thead>
            <tr>
                <th>Nom</th><th>Cognoms</th><th>Imatge</th><th>Eliminar</th><th>Editar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($autors as $autor)
                <tr>
                    <td>{{ $autor->nom }}</td><td>{{ $autor->cognoms }}</td>
                    <td>
                        <img src="{{ asset(env('RUTA_IMATGES') . $autor->imatge) }}" alt="" style="width:150px;">
                    </td>
                    <td>
                        @if (Auth::check()) 
                        <a href="{{ route('autor_delete', ['id' => $autor->id]) }}">Eliminar</a>
                        @endif
                    </td>
                    <td>
                        @if (Auth::check()) 
                        <a href="{{ route('autor_edit', ['id' => $autor->id]) }}">Editar</a>
                        @endif
                    </td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>

    <br>
@endsection