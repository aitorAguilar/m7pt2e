@extends('layout')

@section('title', 'Nou autor')

@section('stylesheets')
    @parent
@endsection

@section('content')
    <h1>Nou autor</h1>
    <a href="{{ route('autor_list') }}">&laquo; Torna</a>
	<div style="margin-top: 20px">
        <form method="POST" action="{{ route('autor_new') }}" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="nom">Nom</label>
                <input type="text" name="nom"/>
            </div>
            <div>            
                <label for="cognoms">Cognoms</label>
                <input type="text" name="cognoms"/>
            </div>
            <div>            
                <label for="img">Carrega una imatge: </label>
                <input type="file" name="imatge">
            </div>
            <button type="submit">Crear autor</button>
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