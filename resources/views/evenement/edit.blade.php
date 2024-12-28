@extends('layouts.app')

@section('content')
    <h1>Modifier l'événement : {{ $data->id }}</h1>
    <form action="{{ route('evenement.update', $data->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('evenement._form') <!-- Inclusion du formulaire partagé -->
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
@endsection
