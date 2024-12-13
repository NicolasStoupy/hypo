<?php

namespace App\Repositories;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use App\Models\User;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ApplicationRepository implements EmployeeRepositoryInterface
{

    /**
     * Récupère tous les employés dont le prénom commence par la lettre 'A'.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Employee::all();
    }

    /**
     * Crée un nouvel employé en utilisant les données validées de la requête.
     *
     * @param EmployeeRequest $request La requête contenant les données de l'employé à créer.
     * @param Employee $employee Le modèle d'employé utilisé pour la création.
     * @return Employee
     */
    public function store(EmployeeRequest $request)
    {
        Employee::create($request->validated());
    }

    public function getEmployeeById($id)
    {
        return Employee::findOrFail($id);
    }

    public function updateEmployee(EmployeeRequest $request, $id)
    {
        $employee = Employee::findOrFail($id);  // Utilisez l'ID pour trouver l'employé

        // Mettez à jour l'employé avec les données validées
        $employee->update($request->validated());
    }

    public function destroyEmployee(string $id)
    {
        $employee = Employee::findOrFail($id);  // Utilisez l'ID pour trouver l'employé

        $employee->delete();


    }

}
