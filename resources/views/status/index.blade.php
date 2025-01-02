@extends('layouts.app')

@section('content')

    <div class="container mt-4">
        <h1 class="mb-4">Liste des Statuts</h1>
        <a href="{{ route('status.create') }}" class="btn btn-primary mb-3">Créer un nouveau statut</a>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $status)
                <tr>
                    <td>{{ $status->id }}</td>
                    <td>{{ $status->description }}</td>
                    <td>
                        <a href="{{ route('status.show', $status->id) }}" class="btn btn-warning btn-sm">Voir</a>
                        <a href="{{ route('status.edit', $status->id) }}" class="btn btn-primary btn-sm">Modifier</a>

                        <form action="{{ route('status.destroy', $status->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce statut ?')">
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
