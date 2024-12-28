@extends('layouts.app')

@section('content')
    <h1>Créer un nouveau poney</h1>
    <form action="{{ route('poney.store') }}" method="POST">
        @csrf
        @include('poney._form')
        <button type="submit">Enregistrer</button>
    </form>



@endsection
