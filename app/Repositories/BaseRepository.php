<?php

namespace App\Repositories;

use App\Repositories\Interfaces\IRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements IRepository
{


    public function __construct(protected Model $model)
    {

    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function deleteById($id)
    {
        return $this->model->destroy($id);
    }

    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function paginate($perPage, $search = null): LengthAwarePaginator
    {
        $query = $this->model::query(); // Initialisation de la requête

        // Si un terme de recherche est fourni, appliquez le scope search
        if ($search) {
            $query->search($search);
        }

        // Retourne les résultats paginés, avec ou sans recherche
        return $query->paginate($perPage);
    }

}
