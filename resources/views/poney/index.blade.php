@extends('layouts.app')

@section('content')

    <div class="container mt-4">
        <h1 class="mb-4">Liste des Poneys</h1>
        <a href="{{ route('poney.create') }}" class="btn btn-primary mb-3">Créer un nouveau poney</a>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Heures maximales par jour</th>
                <th>Créé par</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $poney)
                <tr>
                    <td>{{ $poney->nom }}</td>
                    <td>{{ $poney->max_hour_by_day }}</td>
                    <td>{{ $poney->user->name }}</td>
                    <td>{{ $poney->evenements->count() }}</td>
                    <td>
                        <a href="{{ route('poney.show', $poney->id) }}" class="btn btn-warning btn-sm">Modifier</a>

                        <form action="{{ route('poney.destroy', $poney->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce poney ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
