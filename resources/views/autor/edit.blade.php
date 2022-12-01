@extends('layout')

@section('title', 'Editar autors')

@section('stylesheets')
    @parent
@endsection

@section('content')
    <h1>Editar autors</h1>
    <a href="{{ route('autor_list') }}">&laquo; Torna</a>
	<div style="margin-top: 20px">
        <form method="POST" action="{{ route('autor_edit', ['id' => $autor->id]) }}" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="nom">Nom</label>
                <input type="text" name="nom" value = "{{ $autor->nom }}"/>
            </div>
            <div>            
                <label for="cognoms">Cognoms</label>
                <input type="text" name="cognoms" value = "{{ $autor->cognoms }}"/>
            </div>
            
            @if (!empty($autor->imatge))
            <div>            
                <label for="cognoms">Imatge actual: </label>
                <label for="imatge"><b>{{ $autor->imatge }}</b></label>
            </div>
            <div>
                <label for="checkbox">Esborrar Imatge?</label>
            <input type="checkbox" name="esborrarImg"/>
            </div>
            @endif
            <div>            
                <label for="img">Carrega una nova imatge: </label>
                <input type="file" name="imatge">
            </div>
            <button type="submit">Editar Autors</button>
        </form>
	</div>
    @if ($errors->any())
    <div class="alert alert-danger" style="color:red">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@endsection