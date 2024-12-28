@extends('layouts.app')

@section('content')
    <h1>Créer un nouvel événement</h1>
    <form action="{{ route('evenement.store') }}" method="POST">
        @csrf
        @include('evenement._form') <!-- Inclusion du formulaire partagé -->
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
@endsection
