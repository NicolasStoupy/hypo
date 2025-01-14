@php use Carbon\Carbon; @endphp
@extends('layouts.app')

@section('content')
    @vite('resources/js/app_function.js') <!-- Chargement des fonctions JavaScript spécifiques -->

    <!-- Identifiant de l'événement à afficher par défaut -->
    <input type="hidden" name="evenement_id_show" value="{{$last_modified_event_id}}">

    <div class="row">
        <div class="col-6 col-md-6 ms-12">
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
                            <input type="hidden" name="date" value="{{ Carbon::parse($selected_date)->subDay()->format('Y-m-d') }}">
                            <input type="hidden" name="evenement_type_id" value="{{$selected_event_type_id}}">
                            <button type="submit" class="btn btn-outline-primary rounded-0">Jour Précédent</button>
                        </form>

                        <!-- Sélecteur de date -->
                        <form action="{{ route('gestion.index') }}" method="GET" class="d-inline">
                            <input type="date" name="date" value="{{ Carbon::parse($selected_date)->format('Y-m-d') }}"
                                   class="form-control form-control-sm btn btn-outline-primary rounded-0 border"
                                   onchange="this.form.submit()"/><input type="hidden" name="evenement_type_id" value="{{$selected_event_type_id}}">
                        </form>
                        <!-- Bouton pour aller au jour suivant -->
                        <form action="{{ route('gestion.index') }}" method="GET" class="d-inline">
                            <input type="hidden" name="date" value="{{ Carbon::parse($selected_date)->addDay()->format('Y-m-d') }}">
                            <button type="submit" class="btn btn-outline-primary rounded-0">Jour Suivant</button><input type="hidden" name="evenement_type_id" value="{{$selected_event_type_id}}">
                        </form>
                    </div>
                    <!-- Liste des événements -->
                    <div class="list-group list-group-flush">
                        @foreach($events as $evenement)
                            <!-- Événement cliquable -->
                            <div onclick="toggleAssignment('assignmentContent_{{$evenement->id}}')"
                                 class="clickable list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <!-- Nom de l'événement -->
                                <span>{{ $evenement->nom . ' | ' . $evenement->client->nom }}</span>

                                <!-- Badges avec des informations sur l'événement -->
                                <div class="d-flex align-items-center justify-content-between" style="min-width: 250px;">
                                <span class="badge bg-info flex-grow-1 text-center" style="width: 80px;">
                                    {{ $evenement->getDuration() }}
                                </span>
                                    <span class="badge bg-secondary flex-grow-1 text-center" style="width: 80px;">
                                 {{ $evenement->getTimeRange() }}
                                </span>
                                    <span class="badge bg-success flex-grow-1 text-center" style="width: 80px;">
                                    {{ $evenement->status->description }}
                                </span>
                                    <span class="badge flex-grow-1 text-center text-black" style="width: 80px;">
                                    {{ $evenement->evenement_type->nom }}
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
                                                    <form action="{{ route('update_poney') }}" method="post"
                                                          class="col-12 col-md-6 mb-3">
                                                        @csrf
                                                        <input type="hidden" name="previous_poney_id"
                                                               value="{{$poney_evenement->id}}">
                                                        <input type="hidden" name="evenement_id" value="{{$evenement->id}}">
                                                        <input type="hidden" name="date" value="{{$selected_date}}">

                                                        <!-- Sélecteur de poneys -->
                                                        <div class="form-group">
                                                            <select name="poney_id" class="form-select form-select-sm"
                                                                    onchange="this.form.submit()">
                                                                <option value="{{$poney_evenement->id}}">
                                                                    {{$poney_evenement->nom}}
                                                                </option>
                                                                @foreach($evenement->get_poneys_availaible() as $poney)
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
                                                    <form action="{{ route('update_poney') }}" method="post"
                                                          class="col-12 col-md-6 mb-3">
                                                        @csrf
                                                        <input type="hidden" name="evenement_id" value="{{$evenement->id}}">
                                                        <input type="hidden" name="date" value="{{$selected_date}}">

                                                        <!-- Sélecteur pour les poneys non assignés -->
                                                        <div class="form-group">
                                                            <select name="poney_id" class="form-select form-select-sm"
                                                                    onchange="this.form.submit()">
                                                                <option value="" selected>Poney {{$i+1}}</option>
                                                                @foreach($evenement->get_poneys_availaible() as $poney)
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
        <div class="col-6 col-md-6 ms-12">
            <div class="card shadow-sm h-100">
                <!-- En-tête de la carte -->
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Encoder un nouvel évenement :</h5>
                </div>
                <div class="card-body">

                    <div class="row">
                        <form action="{{ route('gestion.index') }}" method="get">
                            @csrf
                            <input type="hidden" name="evenement_id" value="{{$last_modified_event_id}}">
                            <input type="hidden" name="date" value="{{$selected_date}}">
                            <div class="col-12">
                                <x-select_input  name="evenement_type_id" label="Evenement Type"
                                                :options="$event_types->pluck('nom','id')->toArray()"
                                                :selected="$selected_event_type_id ?? ''"
                                                :autopost="true"
                                                 placeholder="Sélectionnez un type d'évenement"
                                />
                            </div>
                        </form>
                        <form action="{{route('new_event')}}" method="post">
                            @csrf
                            <input type="hidden" name="evenement_type_id" value="{{$selected_event_type_id}}">
                            @if($selected_event_type_id == 1)
                                @include('gestion._form_association')
                            @endif
                            @if($selected_event_type_id == 2)
                                @include('gestion._form_poney_club')
                            @endif
                            @if($selected_event_type_id == 3)
                                @include('gestion._form_association')
                            @endif
                            <button type="submit">Ajouter</button>
                        </form>



                    </div>
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
