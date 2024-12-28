@extends('layouts.app')

@section('content')
    <h1>Modifier le poney: {{ $data->nom }}</h1>
    <form action="{{ route('poney.update', $data->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('poney._form')
        <button type="submit">Mettre à jour</button>
    </form>
@endsection
