@extends('layouts.app')

@section('content')

<form method="post" action="{{route('config.update')}}" >
    @csrf
    <table class="table">
        <thead>
        <tr>
            <th>Clé</th>
            <th>Valeur</th>
            <th>Type</th>
            <th>Documentation</th>
        </tr>
        </thead>
        <tbody>
        @foreach($config as $key => $data)
            <tr>
                <td>{{ $key }}</td>
                <td>
                    <input name="{{ $key }}" type="text" class="form-control config-input"
                           value="{{ $data['value'] }}">
                </td>
                <td>
                    <select disabled class="form-select config-type" name="{{ $key }}">
                        <option value="string" {{ $data['type'] == 'string' ? 'selected' : '' }}>String</option>
                        <option value="integer" {{ $data['type'] == 'integer' ? 'selected' : '' }}>Integer</option>
                        <option value="boolean" {{ $data['type'] == 'boolean' ? 'selected' : '' }}>Boolean</option>
                    </select>
                </td>
                <td>
                    <label>{{$data['documentation']}}</label>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <button id="saveConfig" class="btn btn-primary">Sauvegarder</button>
</form>


@endsection
