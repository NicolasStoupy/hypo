<?php

namespace App\Http\Controllers;

use App\Models\Cavalier;
use App\Repositories\Interfaces\IApplicationContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PdfController extends Controller
{
    //

    public function __construct(protected IApplicationContext $repos)
    {

    }

    public function facture($id)
    {

        $pdf = App::make('dompdf.wrapper');
        $facture = $this->repos->facture()->getById($id);
        $cavalier = Cavalier::where('facture_id', $id)->first();
        if(isset($cavalier)){
            //Facturation cavalier
            return view('templates_factures.t_facture_1', compact('facture','cavalier'));
        }else{

            return view('templates_factures.t_facture_2', compact('facture'));
        }




        $html = view('templates_factures.t_facture_1', compact('facture'))->render();

        // Charger le HTML dans DomPDF
        $pdf->loadHTML($html);

        // Retourner le PDF généré
        return $pdf->stream('facture.pdf');
    }

    public function facture_by_id($id)
    {

    }

    public function facture_by_evenement($id)
    {

        $evenement = $this->repos->evenement()->getById($id);

    }

}
