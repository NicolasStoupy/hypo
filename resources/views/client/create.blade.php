@extends('layouts.app')

@section('content')
    <h1>Créer un nouveau client</h1>
    <form action="{{ route('client.store') }}" method="POST">
        @csrf

        @include('client._form')
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
@endsection
