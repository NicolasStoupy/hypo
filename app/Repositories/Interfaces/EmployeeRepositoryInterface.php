<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use App\Models\User;

interface EmployeeRepositoryInterface
{
    public function getAll();

    public function store(EmployeeRequest $request);

    public function getEmployeeById($id);

    public function updateEmployee(EmployeeRequest $request,$id);

    public function destroyEmployee(string $id);
}
