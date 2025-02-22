@php use Carbon\Carbon; @endphp

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-1">Gestion des poneys dans les boxs</h2>
        <a href="/box"
           class="align-self-center btn btn-outline-primary btn-sm border shadow-sm border-0 px-4 py-2 rounded-pill mb-1">Retour aux
            box</a>
        <div class="row">
            @foreach($boxs as $box)
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-4">
                    <div class="box p-3 border rounded shadow-sm">
                        <h5 class="text-center mb-2">Box {{$box->id}}</h5>

                        {{-- Liste des poneys assignés au box --}}
                        <ul class="list-unstyled mb-3">
                            @forelse($box->Poneys as $poney)
                                <li class="d-flex justify-content-between align-items-center">
                                    <strong>{{ $poney->nom }}</strong>
                                    <form action="{{ route('box.removePoney', [$box->id, $poney->id]) }}" method="POST"
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Retirer ce poney du box ?');">
                                            ✖
                                        </button>
                                    </form>
                                </li>
                            @empty
                                <li class="text-muted">Aucun poney assigné</li>
                            @endforelse
                        </ul>

                        {{-- Formulaire d'ajout de poney --}}
                        <form method="POST" action="{{ route('box.addPoney', $box->id) }}">
                            @csrf
                            <div class="mb-3">
                                <label for="poney_id" class="form-label">Choisir un poney à ajouter</label>
                                <select name="poney_id" id="poney_id" class="form-select" required>
                                    <option value="">Sélectionner un poney</option>
                                    @foreach($poneys as $poney)
                                        <option value="{{ $poney->id }}">{{ $poney->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary w-100">Ajouter le poney</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
