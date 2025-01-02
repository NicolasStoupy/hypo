@extends('layouts.app')

@section('content')

    <div class="container mt-1">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mb-1">Liste des Poneys</h1>
            <a href="{{ route('poney.create') }}" class="btn btn-primary mb-1">Créer un nouveau poney</a>
        </div>
        <form method="GET" action="{{ route('poney.index') }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Rechercher un poney..."
                       value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Rechercher</button>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>id</th>
                <th>Nom</th>
                <th>Heures maximales par jour</th>
                <th>Créé par</th>
                <th>Nbr Evenement</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $poney)
                <tr>
                    <td>{{ $poney->id }}</td>
                    <td>{{ $poney->nom }}</td>
                    <td>{{ $poney->max_hour_by_day }}</td>
                    <td>{{ $poney->user->name }}</td>
                    <td>{{ $poney->evenements->count() }}</td>
                    <td>
                        <a href="{{ route('poney.show', $poney->id) }}" class="btn btn-warning btn-sm">Modifier</a>

                        <form action="{{ route('poney.destroy', $poney->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce poney ?')">Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-4">
            {{ $data->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
