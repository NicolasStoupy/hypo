@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Liste des Événements</h1>
        <a href="{{ route('evenement.create') }}" class="btn btn-primary mb-3">Créer un nouvel événement</a>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Id</th>
                <th>Prix</th>
                <th>Nombre de participants</th>
                <th>Date de début</th>
                <th>Date de fin</th>
                <th>Client</th>
                <th>Facture</th>
                <th>Créé par</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $evenement)
                <tr>
                    <td>{{ $evenement->id}} </td>
                    <td>{{ number_format($evenement->prix, 2) }} €</td>
                    <td>{{ $evenement->nombre_participant }}</td>
                    <td>{{ $evenement->date_debut }}</td>
                    <td>{{ $evenement->date_fin}}</td>
                    <td>{{ $evenement->client->nom }}</td> <!-- Assurez-vous que la relation 'client' est définie sur le modèle Evenement -->
                    <td>{{ $evenement->facture->id ?? 'Non attribuée' }}</td>
                    <td>{{ $evenement->user->name }}</td> <!-- Assurez-vous que la relation 'user' est définie sur le modèle Evenement -->
                    <td>
                        <a href="{{ route('evenement.show', $evenement->id) }}" class="btn btn-warning btn-sm">Modifier</a>

                        <form action="{{ route('evenement.destroy', $evenement->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
