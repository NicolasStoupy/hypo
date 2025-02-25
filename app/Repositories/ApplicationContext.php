<?php

namespace App\Repositories;

use App\Repositories\Interfaces\IApplicationContext;
use App\Repositories\Interfaces\ICleanning;
use App\Repositories\Interfaces\IClient;
use App\Repositories\Interfaces\IEvenement;
use App\Repositories\Interfaces\IFacture;
use App\Repositories\Interfaces\IOpenHours;
use App\Repositories\Interfaces\IPoney;
use App\Repositories\Interfaces\IStatus;
use Illuminate\Support\Facades\DB;

class ApplicationContext implements IApplicationContext
{
    public function __construct(protected IPoney     $poneyRepository,
                                protected IClient    $clientRepository,
                                protected IEvenement $evenementRepository,
                                protected IFacture   $factureRepository,
                                protected IStatus    $statusRepository,
                                protected IOpenHours $openHoursRepository,
                                protected ICleanning $cleanning
    )
    {

    }

    public function poney(): IPoney
    {
        return $this->poneyRepository;
    }


    public function client(): IClient
    {
        return $this->clientRepository;
    }

    public function evenement(): IEvenement
    {
        return $this->evenementRepository;
    }

    public function facture(): IFacture
    {
        return $this->factureRepository;
    }

    public function status(): IStatus
    {
        return $this->statusRepository;
    }

    public function openHours(): IOpenHours
    {
        return $this->openHoursRepository;
    }

    public function cleaning(): ICleanning
    {
       return $this->cleanning;
    }
}
