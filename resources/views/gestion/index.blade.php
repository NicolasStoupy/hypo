@php use Carbon\Carbon; @endphp
@extends('layouts.app')

@section('content')
    @vite('resources/js/app_function.js') <!-- Chargement des fonctions JavaScript spécifiques -->

    <!-- Identifiant de l'événement à afficher par défaut -->
    <input type="hidden" name="evenement_id_show" value="{{$evenement_id}}">

    <div class="col-12 col-md-8 mb-4">
        <div class="card shadow-sm h-100">
            <!-- En-tête de la carte -->
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Rendez-vous prévus :</h5>
            </div>

            <div class="card-body">
                <!-- Navigation des jours -->
                <div class="btn-group mb-4" role="group" aria-label="Navigation">
                    <!-- Bouton pour aller au jour précédent -->
                    <form action="{{ route('gestion.index') }}" method="GET" class="d-inline">
                        <input type="hidden" name="date" value="{{ Carbon::parse($date)->subDay()->format('Y-m-d') }}">
                        <button type="submit" class="btn btn-outline-primary rounded-0">Jour Précédent</button>
                    </form>

                    <!-- Sélecteur de date -->
                    <form action="{{ route('gestion.index') }}" method="GET" class="d-inline">
                        <input type="date" name="date" value="{{ Carbon::parse($date)->format('Y-m-d') }}"
                               class="form-control form-control-sm btn btn-outline-primary rounded-0 border"
                               onchange="this.form.submit()"/>
                    </form>

                    <!-- Bouton pour aller au jour suivant -->
                    <form action="{{ route('gestion.index') }}" method="GET" class="d-inline">
                        <input type="hidden" name="date" value="{{ Carbon::parse($date)->addDay()->format('Y-m-d') }}">
                        <button type="submit" class="btn btn-outline-primary rounded-0">Jour Suivant</button>
                    </form>
                </div>
                <!-- Liste des événements -->
                <div class="list-group list-group-flush">
                    @foreach($evenements as $evenement)
                        <!-- Événement cliquable -->
                        <div onclick="toggleAssignment('assignmentContent_{{$evenement->id}}')"
                             class="clickable list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <!-- Nom de l'événement -->
                            <span>{{ $evenement->nom }}</span>

                            <!-- Badges avec des informations sur l'événement -->
                            <div class="d-flex align-items-center justify-content-between" style="min-width: 250px;">
                                <span class="badge bg-info flex-grow-1 text-center" style="width: 80px;">
                                    {{ $evenement->getTimeRange() }}
                                </span>
                                <span class="badge bg-secondary flex-grow-1 text-center" style="width: 80px;">
                                 {{ $evenement->getTimeRange() }}
                                </span>
                                <span class="badge bg-success flex-grow-1 text-center" style="width: 80px;">
                                    {{ $evenement->status->description }}
                                </span>
                            </div>
                        </div>

                        <!-- Contenu détaillé de l'événement (affiché/masqué) -->
                        <div class="container-fluid">
                            <div id="assignmentContent_{{$evenement->id}}" class="toggle-content m-3"
                                 style="display:none;">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <!-- Nombre de participants -->
                                        <div class="d-flex justify-content-between">
                                            <span>{{$evenement->nombre_participant}} Personnes attendues</span>
                                        </div>

                                        <div class="row my-3">
                                            <!-- Poneys assignés -->
                                            @foreach($evenement->poneys as $poney_evenement)
                                                <form action="{{ route('updatePoney') }}" method="post"
                                                      class="col-12 col-md-6 mb-3">
                                                    @csrf
                                                    <input type="hidden" name="previous_poney_id"
                                                           value="{{$poney_evenement->id}}">
                                                    <input type="hidden" name="evenement_id" value="{{$evenement->id}}">
                                                    <input type="hidden" name="date" value="{{$date}}">

                                                    <!-- Sélecteur de poneys -->
                                                    <div class="form-group">
                                                        <select name="poney_id" class="form-select form-select-sm"
                                                                onchange="this.form.submit()">
                                                            <option value="{{$poney_evenement->id}}">
                                                                {{$poney_evenement->nom}}
                                                            </option>
                                                            @foreach($evenement->getPoneysAvailaible() as $poney)
                                                                <option value="{{ $poney->id }}"
                                                                    {{ old('poney_id', $poney_evenement->id ?? '') == $poney->id ? 'selected' : '' }}>
                                                                    {{ $poney->nom }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </form>
                                            @endforeach

                                            <!-- Poneys disponibles pour les participants supplémentaires -->
                                            @for($i = $evenement->qtyOfPoneysSelected(); $i < $evenement->nombre_participant; $i++)
                                                <form action="{{ route('updatePoney') }}" method="post"
                                                      class="col-12 col-md-6 mb-3">
                                                    @csrf
                                                    <input type="hidden" name="evenement_id" value="{{$evenement->id}}">
                                                    <input type="hidden" name="date" value="{{$date}}">

                                                    <!-- Sélecteur pour les poneys non assignés -->
                                                    <div class="form-group">
                                                        <select name="poney_id" class="form-select form-select-sm"
                                                                onchange="this.form.submit()">
                                                            <option value="" selected>Poney {{$i+1}}</option>
                                                            @foreach($evenement->getPoneysAvailaible() as $poney)
                                                                <option value="{{ $poney->id }}">
                                                                    {{ $poney->nom }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </form>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fonction pour afficher/masquer le contenu d'un événement
        function toggleAssignment(contentId) {
            var content = document.getElementById(contentId);
            content.style.display = (content.style.display === "none") ? "block" : "none";
        }

        // Afficher le contenu du premier événement au chargement de la page
        window.onload = function () {
            var evenementId = document.querySelector('[name="evenement_id_show"]').value;
            var contentId = "assignmentContent_" + evenementId;
            var content = document.getElementById(contentId);
            if (content) {
                content.style.display = "block";
            }
        };
    </script>
@endsection
