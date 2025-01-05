@php use Carbon\Carbon; @endphp
@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
            <h1 class="h4 text-primary">Gestion des factures 🐴</h1>
            <p class="mb-0 text-muted">
                <i class="bi bi-calendar-event me-1"></i>
                {{ Carbon::now()->translatedFormat('l j F Y') }}
            </p>
        </div>
        <!-- Main content -->
        <div class="row">
            <!-- Historique -->
            <div class="col-md-4">
                <h2 class="h6 text-secondary mb-3">Historique des revenus :</h2>
                <div class="btn-group mb-4" role="group" aria-label="Navigation">
                    <!-- Bouton pour aller à l'année précédente -->
                    <form action="{{ route('facturier') }}" method="GET" class="d-inline">
                        <input type="hidden" name="year" value="{{ $selectedYear - 1 }}">
                        <button type="submit" class="btn btn-outline-primary rounded-0">{{ $selectedYear - 1 }}</button>
                    </form>
                    <!-- Bouton pour aller à l'année suivante -->
                    <form action="{{ route('facturier') }}" method="GET" class="d-inline">
                        <input type="hidden" name="year" value="{{ $selectedYear + 1 }}">
                        <button type="submit" class="btn btn-outline-primary rounded-0">{{ $selectedYear + 1 }}</button>
                    </form>
                </div>
            @foreach($facturiers as $facturier)
                    <div class="card">
                        <div class="card-header">
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="fw-bold">{{ $facturier->getYearMonth() }}</span>
                                <span class="badge bg-success rounded-pill px-3 py-2">{{ $facturier->revenu }}€</span>
                            </div>
                        </div>
                        <div class="card-body" style="display: {{ $facturier->hasCurrentYearMonth()? 'block' : 'none' }};">
                            <!-- Liste imbriquée des clients associés au facturier -->
                            <div class="list-group mt-2">
                                @foreach($facturier->facturier_clients() as $facture_client)
                                    <!-- Accès à la relation comme propriété -->
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="mt-2">
                                            <span class="fw-bold">{{ $facture_client->nom }}</span>
                                            <span class="text-muted"> - {{ $facture_client->revenu }}€</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-md-8">
                <h2 class="h6 text-secondary mb-3">Revenus du mois en cours :</h2>
                <table class="table table-striped shadow-sm">
                    <thead class="table-primary">
                    <tr>
                        <th>Nom du client</th>
                        <th>Qty evenement</th>
                        <th>Montant à payer</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($facturier_current as $facturier)
                        <tr>
                            <td data-bs-toggle="tooltip" title="Cliquez pour plus d'infos">{{ $facturier->nom }}</td>
                            <td>{{ $facturier->totalevenement }}</td>
                            <td class="text-end">{{ $facturier->revenu  }} €</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot class="table-light">
                    <tr>
                        <td colspan="2" class="text-end fw-bold">Total :</td>
                        <td class="text-end text-primary fw-bold">{{$facturier_current->sum('revenu')}} €</td>
                    </tr>
                    </tfoot>
                </table>
                <div class="text-end">
                    <button class="btn btn-lg btn-primary shadow-sm">
                        <i class="bi bi-envelope-paper me-2"></i> Envoyer toutes les factures
                    </button>
                </div>
            </div>
        </div>
        <!-- Mois en cours -->

    </div>
    </div>
@endsection
<!-- jQuery (assurez-vous que jQuery est chargé dans votre page) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Lorsque le header est cliqué, basculer le display du body
        $('.card-header').click(function() {
            $(this).next('.card-body').toggle();
        });
    });
</script>
