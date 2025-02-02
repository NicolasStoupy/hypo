@php use Carbon\Carbon; @endphp
@extends('layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <div class="container mt-1">
        <h2 class="mb-1">Facturer un Événement :</h2>

        <div class="card">
            <div class="card-header bg-primary text-white"> Événement</div>
            <div class="card-body">
                <h3 class="card-title">Nom de l'événement : {{ $evenement->nom }}</h3>

                <div class="row">
                    <!-- Colonne gauche avec les informations de l'événement -->
                    <div class="col-md-6">
                        <p><strong>ID:</strong> {{ $evenement->id }}</p>
                        <p><strong>Prix:</strong> {{ number_format($evenement->prix, 2, ',', ' ') }}€</p>
                        <p><strong>Date de
                                l'Événement:</strong> {{ Carbon::parse($evenement->date_evenement)->format('d M Y') }}
                        </p>
                        <p><strong>Nombre de Participants
                                (présent/planifié):</strong> {{$evenement->cavaliers->count() .'/'. $evenement->nombre_participant }}
                        </p>
                        <p><strong>Type d'Événement:</strong> {{$evenement->evenement_type->nom }}</p>
                    </div>

                    <!-- Colonne droite avec les informations supplémentaires -->
                    <div class="col-md-6">
                        <p><strong>Date
                                Début:</strong> {{ Carbon::parse($evenement->date_debut)->format('d M Y, H:i') }}
                        </p>
                        <p><strong>Date
                                Fin:</strong> {{ Carbon::parse($evenement->date_fin)->format('d M Y, H:i') }}
                        </p>
                        <p><strong>Durée:</strong> {{ $evenement->getDuration() }}</p>
                        <p><strong>Client:</strong> {{ $evenement->client->nom }}</p>
                        <p><strong>Créé Par:</strong> {{ $evenement->user->name }}</p>
                        <p><strong>Status:</strong> {{ $evenement->status->description }}</p>
                        @if($evenement->remaining_to_bill()>0)
                            <form method="post" action="{{route('facture.facturation_evenement')}}">
                                @csrf
                                <input type="hidden" name="evenement_id" value="{{$evenement->id}}">
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="bi bi-file-earmark-pdf"></i> {{$evenement->remaining_to_bill()}} € -
                                    Facture
                                    Evenement PDF
                                </button>
                            </form>
                        @else
                            @if(isset($evenement->facture_id))
                                <a type="submit" class="btn btn-success btn-sm me-2"
                                   href="{{ route('facture.id', ['id' => $evenement->facture_id]) }}" target="_blank">
                                    <i class="bi bi-file-earmark-pdf"></i> Télécharger Facture
                                </a>
                                <a class="btn btn-danger btn-sm me-2"
                                        href="{{ route('facture.event_reverse', ['evenement_id'=>$evenement->id]) }}">
                                    <i class="bi bi-arrow-counterclockwise"></i> Reverse
                                </a>
                            @endif


                        @endif
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <!-- Table des cavaliers -->
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="card-title">Cavaliers Associés</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Cavalier</th>
                        <th>Montant Facturé</th>
                        <th>Montant Restant Du</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($evenement->cavaliers as $cavalier)
                        <tr>
                            @php
                                $facturer =  $cavalier->facture->amount??0;
                                $difference = $evenement->get_separed_price()-$facturer;
                            @endphp
                            <td>{{ $cavalier->nom }}                 </td>
                            <td>{{$cavalier->facture->amount??0 }} €</td>
                            <td>{{$difference}} €</td>
                            <td>
                                <div class="d-flex justify-content-start">

                                    @if($difference==0)
                                        <!-- Formulaire pour générer la facture -->

                                        <a type="submit" class="btn btn-success btn-sm me-2"
                                           href="{{ route('facture.id', ['id' => $cavalier->facture_id]) }}"  target="_blank">
                                            <i class="bi bi-file-earmark-pdf"></i> Télécharger Facture
                                        </a>
                                        <a class="btn btn-danger btn-sm me-2"
                                           href="{{ route('facture.reverse', ['id' => $cavalier->id,'evenement_id'=>$evenement->id]) }}">
                                            <i class="bi bi-arrow-counterclockwise"></i> Reverse
                                        </a>

                                    @else

                                        @if($evenement->remaining_to_bill()>=$evenement->get_separed_price())
                                            <!-- Formulaire pour encoder le paiement -->
                                            <form method="post"
                                                  action="{{ route('facture.facturer_cavalier') }}">
                                                <input type="hidden" name="cavalier_id" value="{{$cavalier->id}}">
                                                <input type="hidden" name="evenement_id" value="{{$evenement->id}}">
                                                <input type="hidden" name="amount" value="{{$difference}}">

                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm me-2">
                                                    <i class="bi bi-currency-dollar"></i> Créer Facture
                                                </button>
                                            </form>

                                        @else
                                           Facturé sur l'évenement
                                        @endif

                                    @endif


                                    <!-- Lien pour la note de crédit si la condition est remplie -->
                                    @if($difference < 0)
                                        <a href="" class="btn btn-danger btn-sm">
                                            <i class="bi bi-file-earmark-pdf"></i> Note Crédit
                                        </a>
                                    @endif
                                </div>
                            </td>


                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
