@extends('layouts.app')

@section('content')
    <h1>Modifier le client: {{ $data->nom }}</h1>

    <form action="{{ route('client.update', $data->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Include the form partial for client data -->
        @include('client._form')

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </div>
    </form>
@endsection
