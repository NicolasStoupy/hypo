@php use Carbon\Carbon; @endphp
@extends('layouts.app')

@section('content')

    <div class="col-12 col-md-6 mb-3">
        <div class="card h-100">
            <div class="card-header">
                <h5>Rendez-vous prévus :</h5>
            </div>
            <div class="card-body">

                <div class="btn-group mb-3 border " role="group" aria-label="Navigation">
                    <!-- Formulaire pour le Jour Précédent -->
                    <form action="{{ route('gestion.index') }}" method="GET" class="d-inline">
                        <input type="hidden" name="date"
                               value="{{ Carbon::parse($date)->subDay()->format('Y-m-d') }}">
                        <button type="submit" class="btn btn-secondary rounded-0">Jour Précédent</button>
                    </form>

                    <!-- Picker de Date -->
                    <form action="{{ route('gestion.index') }}" method="GET" class="d-inline">
                        <input type="date" name="date" value="{{ Carbon::parse($date)->format('Y-m-d') }}"
                               class="form-control border-0" onchange="this.form.submit()"/>
                    </form>

                    <!-- Formulaire pour le Jour Suivant -->
                    <form action="{{ route('gestion.index') }}" method="GET" class="d-inline">
                        <input type="hidden" name="date"
                               value="{{ Carbon::parse($date)->addDay()->format('Y-m-d') }}">
                        <button type="submit" class="btn btn-secondary rounded-0">Jour Suivant</button>
                    </form>
                </div>


                <ul class="list-group">
                    @foreach($evenements as $evenement)
                        <li onclick="toggleAssignment('assignmentContent_{{$evenement->id}}')"
                            class="clickable list-group-item d-flex justify-content-between align-items-center  ">
                            {{ $evenement->nom  }}
                            <span>{{$evenement->getTimeRange()}}</span>
                            <span>{{$evenement->isNow()}}</span>
                            <span>{{$evenement->isToday()}}</span>

                        </li>
                        <div class="container">
                            <!-- Contenu à afficher/masquer -->
                            <div id="assignmentContent_{{$evenement->id}}" style="display:none"
                                 class="toggle-content m-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <h6>Assigner {{$evenement->nombre_participant}} poneys :</h6>
                                            <span>{{$evenement->nombre_participant}} Personnes attendues</span>
                                        </div>
                                        <div class="row my-3">
                                            @for($i = 0; $i < $evenement->nombre_participant; $i++)
                                                <div class="col-6 mb-3">
                                                    <select class="form-select">
                                                        <option>Poney {{$i+1}}</option>
                                                        <option>Mercenaire</option>
                                                        <option>Bébert le gros</option>
                                                        <option>Anastallion</option>
                                                    </select>
                                                </div>
                                            @endfor
                                        </div>
                                        <!-- Bouton de confirmation -->
                                        <button class="btn btn-success w-100">Confirmer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
