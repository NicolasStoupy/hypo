@extends('layouts.app')

@section('content')


    <table class="table">
        <thead>
        <tr>
            <th>Clé</th>
            <th>Valeur</th>
            <th>Type</th>
        </tr>
        </thead>
        <tbody>
        @foreach($config as $key => $data)
            <tr>
                <td>{{ $key }}</td>
                <td>
                    <input type="text" class="form-control config-input"
                           data-key="{{ $key }}" value="{{ $data['value'] }}">
                </td>
                <td>
                    <select class="form-select config-type" data-key="{{ $key }}">
                        <option value="string" {{ $data['type'] == 'string' ? 'selected' : '' }}>String</option>
                        <option value="integer" {{ $data['type'] == 'integer' ? 'selected' : '' }}>Integer</option>
                        <option value="boolean" {{ $data['type'] == 'boolean' ? 'selected' : '' }}>Boolean</option>
                    </select>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <button id="saveConfig" class="btn btn-primary">Sauvegarder</button>

@endsection
