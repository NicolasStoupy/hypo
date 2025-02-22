@php use App\Helpers\ConfigHelper;use Carbon\Carbon; @endphp
@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Navigation entre les semaines -->
        <div class="mb-3">
            <a href="{{ route('weekly_hours.index', ['year' => $currentYear, 'week' => $currentWeek - 1]) }}"
               class="btn btn-primary">Semaine précédente</a>
            <a href="{{ route('weekly_hours.index', ['year' => $currentYear, 'week' => $currentWeek + 1]) }}"
               class="btn btn-primary">Semaine suivante</a>
        </div>

        <h2>Horaires d'ouverture - Semaine {{ $currentWeek }} / {{ $currentYear }}</h2>

        <div class="row">
            <div class="col-12 p-2 bg-light border">
                <!-- Formulaire de définition des heures globales -->
                <form action="{{ route('weekly_hours.apply_default_hours') }}" method="POST">
                    @csrf
                    <input type="hidden" name="week_number" value="{{ $currentWeek }}">
                    <input type="hidden" name="year" value="{{ $currentYear }}">

                    <div class="form-group">
                        <label for="default_open_time">Heure d'ouverture par défaut</label>
                        <input type="time" name="default_open_time"
                               value="{{ConfigHelper::get('WEEK_DEFAULT_START_HOUR')}}" id="default_open_time"
                               class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="default_close_time">Heure de fermeture par défaut</label>
                        <input type="time" name="default_close_time"
                               value="{{ConfigHelper::get('WEEK_DEFAULT_END_HOUR')}}" id="default_close_time"
                               class="form-control">
                    </div>

                    <button type="submit" class="btn btn-success mt-1 form-control">Appliquer à toute la semaine
                    </button>
                </form>
            </div>
            <div class="col-12 mt-1 border p-2">
                <form action="{{ route('weekly_hours.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="week_number" value="{{ $currentWeek }}">
                    <input type="hidden" name="year" value="{{ $currentYear }}">

                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Jour</th>
                            <th>Date</th>
                            <th>Ouverture</th>
                            <th>Fermeture</th>
                            <th>Fermé</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ([0 => 'Lundi', 1 => 'Mardi', 2 => 'Mercredi', 3 => 'Jeudi', 4 => 'Vendredi', 5 => 'Samedi', 6 => 'Dimanche'] as $day => $dayName)
                            @php
                                // Calcul de la date du jour en fonction de l'année et de la semaine
                                $date = Carbon::now()->setISODate($currentYear, $currentWeek,$day);
                                $data = $openingHours[$day] ?? null;
                            @endphp
                            <tr>
                                <td>{{ $dayName }}</td>
                                <td>{{ $date->format('d/m/Y') }}</td> <!-- Affiche la date -->
                                <td>
                                    <input type="time" name="hours[{{ $day }}][open_time]"
                                           value="{{ $data ? $data->open_time : '' }}"
                                           class="form-control"
                                        {{ $isPastWeek ? 'readonly' : '' }}
                                        {{ $data && $data->is_closed ? 'readonly' : '' }}>
                                </td>
                                <td>
                                    <input type="time" name="hours[{{ $day }}][close_time]"
                                           value="{{ $data ? $data->close_time : '' }}"
                                           class="form-control"
                                        {{ $isPastWeek ? 'readonly' : '' }}
                                        {{ $data && $data->is_closed ? 'readonly' : '' }}>
                                </td>
                                <td>
                                    <input type="checkbox" name="hours[{{ $day }}][is_closed]"
                                           value="1" {{ $data && $data->is_closed ? 'checked' : '' }}
                                        {{ $isPastWeek ? 'disabled' : '' }}>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    @if (!$isPastWeek)
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    @else
                        <p class="text-danger">Cette semaine est passée, modification impossible.</p>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection
