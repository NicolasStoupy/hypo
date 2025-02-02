<?php

namespace App\Repositories;

use App\Http\Requests\FactureCavalierRequest;
use App\Http\Requests\FactureRequest;
use App\Models\Cavalier;
use App\Models\Evenement;
use App\Models\Facture;
use App\Models\Facturier;
use App\Models\Facturier_client;
use App\Models\Poney;
use App\Repositories\Interfaces\FactureEvenementRequest;
use App\Repositories\Interfaces\IFacture;
use Exception;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Double;
use PhpParser\Node\Scalar\Float_;
use Ramsey\Uuid\Type\Decimal;


class FactureRepository extends BaseRepository implements IFacture
{

    public function __construct()
    {
        parent::__construct(new Facture());
    }

    public function create(FactureRequest $factureRequest): void
    {
        Facture::Create($factureRequest->validated());
    }

    public function update(FactureRequest $factureRequest, $id): void
    {
        $facture = $this->getById($id);
        $facture->update($factureRequest->validated());

    }

    public function delete_by_cavalier($cavalier_id)
    {
       $cavalier = Cavalier::find($cavalier_id);
       $facture_id = $cavalier->facture_id;
       $cavalier->facture_id = null;
       $cavalier->save();
       if(isset($facture_id)){
           $evenements_count = Evenement::where('facture_id', $facture_id)->count();
           if($evenements_count==0){
               $this->deleteById($facture_id);
           }
       }

    }


    public function getFacturier($year)
    {


        return Facturier::where('year', $year)->get();

    }


    public function getFacturierClient(int $year)
    {
        return Facturier_client::where('year', $year)->get();
    }

    public function getCurrentMonthFacturierClient()
    {
        $currentYear = now()->year;
        $currentMonth = now()->month;

        return Facturier_client::where('year', $currentYear)->where('month', $currentMonth)->get();
    }

    public function creationFactureCavalier(FactureCavalierRequest $request)
    {

        DB::transaction(function () use ($request) {
            // Récupérer les paramètres du $request
            $cavalierId = $request->cavalier_id;
            $evenementId = $request->evenement_id;
            $amount = $request->amount;

            // Trouver le cavalier et l'événement
            $cavalier = Cavalier::findOrFail($cavalierId);
            $evenement = Evenement::findOrFail($evenementId);

            $facture = null;

            // Vérifie si une facture existe déjà pour le cavalier
            if ($cavalier->facture_id === null) {
                // Création d'une nouvelle facture
                $facture = new Facture();
                $facture->client_id = $evenement->client_id;
                $facture->status_id = 'EC';
                $facture->save();  // Sauvegarde la facture après la création
            } else {
                // Récupère la facture existante
                $facture = Facture::findOrFail($cavalier->facture_id);
            }

            // Mise à jour du montant de la facture
            $facture->amount += $amount;
            $facture->save();  // Sauvegarde la facture après mise à jour du montant

            // Mise à jour du cavalier avec la nouvelle facture
            $cavalier->facture_id = $facture->id;
            $cavalier->save();  // Sauvegarde les changements du cavalier
        });

    }

    public function creationFactureEvnement($evenement_id)
    {

        // Démarre la transaction
        DB::transaction(function () use ($evenement_id) {
            // Trouver l'événement
            $evenement = Evenement::findOrFail($evenement_id);

            // Récupérer les cavaliers associés à l'événement
            $cavaliers = $evenement->Cavaliers;

            // Calcul du total de l'événement et du montant payé par les cavaliers
            $total_event = $evenement->prix;

            $paid_by_cavaliers = $cavaliers->sum(function($cavalier) {
                return $cavalier->facture ? $cavalier->facture->amount : 0;
            });

            $facture= null;
            // Créer la facture si elle n'existe pas déjà
            if (!isset($evenement->facture_id)) {

                $facture = new Facture();
            } else {

                // Si la facture existe déjà, on récupère l'ID de la facture existante
                $facture = Facture::find($evenement->facture_id);

                if(!isset($facture)){
                    $facture = new Facture();
                }
            }

            $facture->client_id = $evenement->client_id;
            $facture->status_id = 'EC';
            $facture->amount = $total_event - $paid_by_cavaliers;
            $facture->save();  // Sauvegarde la facture après la création

            // Mise à jour de l'événement avec l'ID de la facture
            $evenement->facture_id = $facture->id;
            $evenement->save();  // Sauvegarde les modifications de l'événement
        });
    }
}
