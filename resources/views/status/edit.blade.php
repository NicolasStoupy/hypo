@extends('layouts.app')

@section('content')

    <div class="container mt-4">
        <h1 class="mb-4">Modifier le Statut</h1>
        <form action="{{ route('status.update', $data->id) }}" method="POST">
            @csrf
            @method('PUT')

            @include('status._form')

            <button type="submit" class="btn btn-success">Mettre à jour</button>
            <a href="{{ route('status.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>

@endsection
