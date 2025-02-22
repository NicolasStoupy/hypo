@php use Carbon\Carbon; @endphp
@extends('layouts.app')
<!-- Ajoutez cette ligne dans la section <head> de votre document HTML si vous souhaitez afficher des icônes -->


@section('content')
    <div class="container mt-0">
        <!-- Section des Box -->
        <div class="row">
            <h3>Gestion des Box</h3>
            <div class="d-flex justify-content-between mb-3">
                <a href="/box/assign" class="align-self-center btn btn-outline-primary btn-sm shadow-sm border-0 px-4 py-2 rounded-pill">
                    Configurer les box
                </a>
                <form method="POST" action="{{ route('new_box') }}">
                    @csrf
                    <button class="btn btn-outline-primary btn-sm shadow-sm border-0 px-4 py-2 rounded-pill" type="submit">
                        <i class="fas fa-plus-circle"></i> Nouveau Box
                    </button>
                </form>
            </div>



            <!-- Liste des Box -->
            <div class="col-12">
                <div class="row">
                    @foreach($boxs as $box)
                        <div class="col-xxl-2 col-lg-3 col-md-4 col-sm-6 mb-2">
                            <div
                                class="box p-2 @if($box->needCleaning()) bg-danger @else bg-success @endif border rounded shadow-sm">
                                <h6 class="text-center mb-1 bg-light">Box {{$box->id}}
                                </h6>
                                <!-- Formulaire pour supprimer le box -->
                                <form method="POST" action="{{ route('delete_box', ['id' => $box->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm w-100 mt-2" type="submit">
                                        <i class="fas fa-trash-alt"></i> Supprimer le Box
                                    </button>
                                </form>
                                <hr>
                                <p class="text-center small m-0 bg-light">{{ $box->remainingTime() }}</p>
                                <hr class="my-1">
                                <small class="text-center d-block bg-light">Dernier nettoyage:
                                    <span class="text-muted">
                                        {{ $box->last_cleaning ? Carbon::parse($box->last_cleaning)->format('d/m/Y H:i') : 'Jamais nettoyé' }}
                                    </span>
                                </small>
                                @if($box->Poneys->isNotEmpty())
                                    <p class="text-center small m-0">
                                        @foreach($box->Poneys as $index => $poney)
                                            @if($index > 0)
                                                ,
                                            @endif
                                            <strong>{{ $poney->nom }}</strong>
                                        @endforeach
                                    </p>
                                    @if($box->needCleaning())
                                        <!-- Formulaire pour nettoyer -->
                                        <form action="{{ route('clean_box', $box->id) }}" method="post"
                                              class="bg-light d-flex justify-content-center">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Nettoyer Box</button>
                                        </form>
                                    @endif

                                @else
                                    <p class="text-center text-muted small m-0">Aucun poney assigné</p>
                                @endif
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>


        </div>
    </div>

    <div class="row mt-5">
        <h3>Disponibilité pour le nettoyage des boxs</h3>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Box</th>
                <th>Date de Nettoyage</th>
                <th>Disponibilité</th>

            </tr>
            </thead>
            <tbody>
            @foreach($boxs as $box)

                    @php
                        $availablePeriods = $box->GetAvailablePeriod();
                        $rowSpan = count($availablePeriods); // Nombre de périodes disponibles pour ce box
                    @endphp

                    @foreach($availablePeriods as $index => $avail_period)
                        <tr>
                            <!-- Si c'est la première période, afficher la cellule Box avec rowspan -->
                            @if ($index == 0)
                                <td rowspan="{{ $rowSpan }}" class="align-middle">Box {{$box->id}}</td>
                            @endif
                            <td>{{ \Carbon\Carbon::parse($avail_period['start'])->format('d/m/Y') }}</td>
                            <td>Disponible de {{ \Carbon\Carbon::parse($avail_period['start'])->format('H:i') }}
                             à {{ \Carbon\Carbon::parse($avail_period['end'])->format('H:i') }}</td>
                        </tr>
                    @endforeach


            @endforeach
            </tbody>
        </table>
    </div>

@endsection
