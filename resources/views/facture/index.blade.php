@extends('layouts.app')

@section('content')

    <div class="container mt-4">
        <h1 class="mb-4">Liste des Factures</h1>
        <a href="{{ route('facture.create') }}" class="btn btn-primary mb-3">Créer une nouvelle facture</a>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>id</th>

                <th>Montant</th>
                <th>Date d'émission</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $facture)
                <tr>
                    <td>{{$facture->id}}</td>
                    <td>{{ number_format($facture->total(), 2, ',', ' ') }} €</td> <!-- Format du montant -->
                    <td>{{ $facture->created_at->format('d-m-Y') }}</td> <!-- Format de la date -->

                    <td>
                        <a href="{{ route('facture.show', $facture->id) }}" class="btn btn-warning btn-sm">Voir</a>

                        <form action="{{ route('facture.destroy', $facture->id) }}" method="POST"
                              style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette facture ?')">
                                Supprimer
                            </button>
                        </form>
                        <button class="btn btn-info btn-sm" onclick="toggleEvents({{ $facture->id }})"
                                id="toggle-btn-{{ $facture->id }}">Afficher les événements
                        </button>
                    </td>




                <tr>
                    <td colspan="5">
                        <div id="events-table-{{ $facture->id }}" style="display:none; margin-top: 0px;">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Prix</th>
                                    <th>Participants</th>
                                    <th>Date de début</th>
                                    <th>Date de fin</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($facture->evenements as $evenement)
                                    <tr>
                                        <td>{{ $evenement->id  }}</td>
                                        <td>{{ number_format($evenement->prix, 2, ',', ' ') }} €</td>
                                        <td>{{ $evenement->nombre_participant }}</td>
                                        <td>{{ $evenement->date_debut }}</td>
                                        <td>{{ $evenement->date_fin }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>

            @endforeach
            </tbody>
        </table>
    </div>

@endsection
<script>
    // Fonction pour afficher/masquer le tableau des événements
    function toggleEvents(factureId) {
        var eventsTable = document.getElementById('events-table-' + factureId);
        var toggleButton = document.getElementById('toggle-btn-' + factureId);

        // Vérifier si le tableau est visible ou non
        if (eventsTable.style.display === "none") {
            eventsTable.style.display = "block";
            toggleButton.innerHTML = "Masquer les événements"; // Changer le texte du bouton
        } else {
            eventsTable.style.display = "none";
            toggleButton.innerHTML = "Afficher les événements"; // Réinitialiser le texte du bouton
        }
    }
</script>
