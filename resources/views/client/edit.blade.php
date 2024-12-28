@extends('layouts.app')

@section('content')
    <h1>Modifier le client: {{ $data->nom }}</h1>
    <form action="{{ route('client.update', $data->id) }}" method="POST">
        @csrf
        @method('PUT')

        @include('client._form')

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
@endsection
