@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Liste des employés</h1>

        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Prénom</th>
                <th>Nom</th>
            </tr>
            </thead>
            <tbody>
            @forelse($employees as $index => $employee)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $employee->first_name }}</td>
                    <td>{{ $employee->last_name }}</td>
                    <td>
                    <form method="get" action="{{ route('employees.edit', $employee->id) }}">
                        <button type="submit">Edit</button>
                    </form>
                    <form method="post" action="{{ route('employees.destroy', $employee->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit">delete</button>
                    </form></td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Aucun employé trouvé.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
