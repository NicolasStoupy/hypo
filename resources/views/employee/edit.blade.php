@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Modifier l'employé</h1>

        <!-- Formulaire pour modifier l'employé -->
        <form action="{{ route('employees.update', $employee->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="first_name">Prénom</label>
                <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name', $employee->first_name) }}" >
                @error('first_name')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="last_name">Nom</label>
                <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name', $employee->last_name) }}" >
                @error('last_name')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-3">Mettre à jour</button>
        </form>
    </div>
@endsection
