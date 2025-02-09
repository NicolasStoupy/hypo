@php use Carbon\Carbon; @endphp
@extends('layouts.app')

@section('content')
    @vite('resources/js/app_function.js') <!-- Chargement des fonctions JavaScript spécifiques -->
    <script src="/gestion.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/css/gestionjournalier.css" rel="stylesheet">
    <style>
        .agenda {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            width: 100px; /* Ajuster selon la largeur voulue */
            border-left: 2px solid #000; /* Ajouter une bordure pour délimiter l'agenda */
        }

        .hour {
            width: 100%; /* S'assurer que chaque élément prend toute la largeur de la colonne */
            padding: 10px;
            text-align: left;
            font-size: 1.2em;
            border-bottom: 1px solid #ddd; /* Séparer les heures avec des lignes */
            background-color: #f9f9f9; /* Couleur de fond pour les éléments */
            cursor: pointer; /* Ajouter un curseur pointer si tu veux rendre l'élément cliquable */
        }

        .hour:hover {
            background-color: #e2e6ea; /* Effet au survol */
        }


    </style>

    <!-- Identifiant de l'événement à afficher par défaut -->
    <input type="hidden" name="evenement_id_show" value="{{$last_modified_event_id}}">
    <div class="row">
        <!-- Left Content-->
        <div class="col-12 col-md-6 ms-12">
            <div class="card hovmagic shadow-sm h-100">
                <!-- En-tête de la carte -->
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Rendez-vous prévus :</h5>
                </div>
                <div class="card-body">
                    <!-- Navigation des jours -->
                    <div class="btn-group mb-1 d-flex flex-nowrap" role="group" aria-label="Navigation">
                        <!-- Bouton pour aller au jour précédent -->
                        <form action="{{ route('gestion.index') }}" method="GET" class="d-inline">
                            <input type="hidden" name="date"
                                   value="{{ Carbon::parse($selected_date)->subDay()->format('Y-m-d') }}">
                            <input type="hidden" name="evenement_type_id" value="{{$selected_event_type_id}}">
                            <button type="submit" class="btn btn-outline-primary rounded-0">Jour Précédent</button>
                        </form>

                        <!-- Sélecteur de date -->
                        <form action="{{ route('gestion.index') }}" method="GET" class="d-inline">
                            <input type="date" name="date" value="{{ Carbon::parse($selected_date)->format('Y-m-d') }}"
                                   class="form-control form-control-sm btn btn-outline-primary rounded-0 border"
                                   onchange="this.form.submit()"/><input type="hidden" name="evenement_type_id"
                                                                         value="{{$selected_event_type_id}}">
                        </form>

                        <!-- Bouton pour aller au jour suivant -->
                        <form action="{{ route('gestion.index') }}" method="GET" class="d-inline">
                            <input type="hidden" name="date"
                                   value="{{ Carbon::parse($selected_date)->addDay()->format('Y-m-d') }}">
                            <button type="submit" class="btn btn-outline-primary rounded-0">Jour Suivant</button>
                            <input type="hidden" name="evenement_type_id" value="{{$selected_event_type_id}}">
                        </form>
                    </div>

                    <!-- Liste des événements -->
                    <div class="list-group m-0">
                        @foreach($events as $evenement)
                            <!-- Événement cliquable -->
                            <div onclick="toggleAssignment('assignmentContent_{{$evenement->id}}')"
                                 class="clickable list-group-item list-group-item-action d-flex justify-content-between">
                                <!-- Nom de l'événement -->
                                <span>{{date('H:i', strtotime($evenement->date_debut)).' à '.date('H:i', strtotime($evenement->date_fin)).' | '.$evenement->nom . ' | ' . $evenement->client->nom }}</span>

                                <!-- Badges avec des informations sur l'événement -->

                                <div class="d-flex">
                                <span class="badge flex-grow-1 t text-black mr-3">
                                    {{ $evenement->getDuration() }}
                                </span>
                                    <span class="badge flex-grow-1  text-black">
                                    {{ $evenement->evenement_type->nom }}
                                </span>


                                    <div class="d-flex gap-2">
                                        <form action="{{ route('facture.facturer_evenement', $evenement->id) }}"
                                              method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="bi bi-file-earmark"></i>
                                            </button>
                                        </form>

                                        <form action="{{ route('gestion.delete_evenement')}}" method="POST"
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?');">
                                            @csrf
                                            @method('POST')
                                            <input type="hidden" name="selected_date" value="{{$selected_date}}">
                                            <input type="hidden" name="id" value="{{$evenement->id}}">
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Contenu détaillé de l'événement (affiché/masqué) -->
                            <div class="">
                                <div id="assignmentContent_{{$evenement->id}}" class="toggle-content m-0 p-0"
                                     style="display:none;">
                                    <div class="card shadow-sm">
                                        <div class="card-body" style="background-color: #ced4da">
                                            <!-- Nombre de participants -->
                                            <div class="d-flex justify-content-between">
                                                <span>{{$evenement->nombre_participant}} Poney(s) à assigner:</span>
                                            </div>
                                            <div class="row my-0">
                                                <!-- Poneys assignés -->
                                                @foreach($evenement->poneys as $poney_evenement)
                                                    <form action="{{ route('update_poney') }}" method="post"
                                                          class="col-12 col-md-6 mb-3 d-flex flex-column">
                                                        @csrf
                                                        <input type="hidden" name="previous_poney_id"
                                                               value="{{$poney_evenement->id}}">
                                                        <input type="hidden" name="evenement_id"
                                                               value="{{$evenement->id}}">
                                                        <input type="hidden" name="date" value="{{$selected_date}}">

                                                        <!-- Sélecteur de poneys -->
                                                        <div class="form-group m-0">
                                                            <select name="poney_id" class="form-select form-select-sm"
                                                                    onchange="this.form.submit()">
                                                                <option
                                                                    value="{{$poney_evenement->id}}">{{$poney_evenement->nom}}</option>
                                                                @foreach($evenement->get_poneys_availaible() as $poney)
                                                                    <option
                                                                        value="{{ $poney->id }}" {{ old('poney_id', $poney_evenement->id ?? '') == $poney->id ? 'selected' : '' }}>
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
                                                          class="col-12 col-md-6 mb-3 d-flex flex-column">
                                                        @csrf
                                                        <input type="hidden" name="evenement_id"
                                                               value="{{$evenement->id}}">
                                                        <input type="hidden" name="date" value="{{$selected_date}}">

                                                        <!-- Sélecteur pour les poneys non assignés -->
                                                        <div class="form-group m-0">
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
                                                    </form>
                                                @endfor
                                            </div>
                                            <!-- Les cavaliers -->
                                            <hr class="m-0">
                                            <div class="d-flex justify-content-between">
                                                <span>{{$evenement->nombre_participant}} Cavalier(s) attendu(s):</span>
                                            </div>
                                            @include('gestion._form_cavalier_event')

                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- Right Content-->
        <div class="col-12 col-md-6 ms-12">
            <div class="card shadow-sm h-100">
                <!-- En-tête de la carte -->
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Encoder un nouvel évenement :</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="{{ route('gestion.event_type') }}" method="post">
                            @csrf
                            <input type="hidden" name="evenement_id"
                                   value="{{ old('last_modified_event_id',$last_modified_event_id)}}">
                            <input type="hidden" name="date" value="{{ old('date', $selected_date) }}">
                            <div class="col-12">
                                <x-select_input name="evenement_type_id" label="Evenement Type"
                                                :options="$event_types->pluck('nom','id')->toArray()"
                                                :selected="$selected_event_type_id ?? ''"
                                                :autopost="false"
                                                placeholder="Sélectionnez un type d'évenement"
                                />
                            </div>
                            <div class="mb-3">
                                <label for="nombre_participant" class="form-label">Nombre de participants:</label>
                                <input type="number" id="nombre_participant" name="nombre_participant"
                                       value="{{ old('nombre_participant', $nombre_participant) }}"
                                       class="form-control" required>
                                @error('nombre_participant')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-outline-primary rounded-0 mt-1 form-control">Valider
                            </button>
                        </form>
                        @if($event_enable || ($errors->any() && !$errors->has('nombre_participant')) )

                            <form action="{{route('new_event')}}" method="post">
                                @csrf
                                <input type="hidden" name="nombre_participant"
                                       value="{{ old('nombre_participant', $nombre_participant) }}">
                                <input type="hidden" name="evenement_type_id"
                                       value="{{ old('evenement_type_id', $selected_event_type_id) }}">
                                <input type="hidden" name="selected_date"
                                       value="{{ old('selected_date',$selected_date)}}">
                                @include('gestion._form_association')
                                @if($selected_event_type_id == 2)
                                    @include('gestion._form_cavalier')
                                @endif
                                <button type="submit" class="btn btn-outline-primary rounded-0 mt-1 form-control">
                                    Valider
                                </button>
                            </form>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
