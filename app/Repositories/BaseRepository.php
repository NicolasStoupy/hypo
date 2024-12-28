<?php

namespace App\Repositories;

use App\Repositories\Interfaces\IRepository;
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
}
