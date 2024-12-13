<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    // Injection du repository pour la gestion des employés
    public function __construct(protected EmployeeRepositoryInterface $employeeRepository)
    {
    }

    /**
     * Affiche la liste des employés.
     */
    public function index()
    {
        // Récupérer tous les employés à partir du repository
        $employees = $this->employeeRepository->getAll();

        // Retourner la vue avec les employés
        return view('employee.index', compact('employees'));
    }

    /**
     * Affiche le formulaire pour créer un nouvel employé.
     */
    public function create()
    {
        // Cette méthode peut être implémentée pour afficher le formulaire de création
    }

    /**
     * Stocke un nouvel employé dans la base de données.
     */
    public function store(Request $request)
    {
        // Cette méthode peut être implémentée pour stocker un employé
    }

    /**
     * Affiche les détails d'un employé spécifique.
     *
     * @param string $id L'identifiant de l'employé
     */
    public function show(string $id)
    {
        // Récupérer l'employé par ID
        $employee = $this->employeeRepository->getEmployeeById($id);

        // Retourner la vue avec l'employé
        return view('employee.edit', compact('employee'));
    }

    /**
     * Affiche le formulaire d'édition pour un employé spécifique.
     *
     * @param string $id L'identifiant de l'employé
     */
    public function edit(string $id)
    {
        // Récupérer l'employé par ID
        $employee = $this->employeeRepository->getEmployeeById($id);

        // Retourner la vue d'édition avec l'employé
        return view('employee.edit', compact('employee'));
    }

    /**
     * Met à jour un employé existant dans la base de données.
     *
     * @param EmployeeRequest $request Les données validées pour l'employé
     * @param string $id L'identifiant de l'employé à mettre à jour
     */
    public function update(EmployeeRequest $request, $id)
    {
        // Appeler le repository pour effectuer la mise à jour de l'employé
        $this->employeeRepository->updateEmployee($request, $id);

        // Rediriger vers la liste des employés après la mise à jour
        return redirect(route('employee'));
    }

    /**
     * Supprime un employé de la base de données.
     *
     * @param string $id L'identifiant de l'employé à supprimer
     */
    public function destroy($id)
    {

        $this->employeeRepository->destroyEmployee($id);

        return redirect(route('employee'));
    }
}
