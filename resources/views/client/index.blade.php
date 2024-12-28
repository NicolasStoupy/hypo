@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Liste des clients</h1>
        <a href="{{ route('client.create') }}" class="btn btn-primary mb-3">Créer un client</a>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Créé par</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $client)
                <tr>
                    <td>{{ $client->id }}</td>
                    <td>{{ $client->nom }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->created_by }}</td>
                    <td>
                        <a href="{{ route('client.edit', $client->id) }}" class="btn btn-sm btn-warning">Modifier</a>
                        <form action="{{ route('client.destroy', $client->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
