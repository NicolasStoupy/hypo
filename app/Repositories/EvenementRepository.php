<?php
namespace App\Repositories;
use App\Http\Requests\EvenementRequest;
use App\Models\Evenement;
use App\Repositories\Interfaces\IEvenement;
use App\Repositories\BaseRepository;
class EvenementRepository extends BaseRepository implements IEvenement
{
    public function __construct()
    {
        parent::__construct(new Evenement());
    }
    public function create(EvenementRequest $EvenementRequest): void
    {
        Evenement::Create($EvenementRequest->validated());
    }

    function update(EvenementRequest $EvenementRequest, $id): void
    {
        $evenement = $this->getById($id);
        $evenement->update($EvenementRequest->validated());
    }
}
