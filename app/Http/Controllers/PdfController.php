<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\IApplicationContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PdfController extends Controller
{
    //

    public function __construct(protected IApplicationContext $repos)
    {

    }

    public function facture()
    {
        $pdf = App::make('dompdf.wrapper');
        $facture= $this->repos->facture()->getById(1);

        return view('templates_factures.t_facture_1', compact('facture'));

        $html = view('templates_factures.t_facture_1', compact('facture'))->render();

        // Charger le HTML dans DomPDF
        $pdf->loadHTML($html);

        // Retourner le PDF généré
        return $pdf->stream('facture.pdf');
    }

}
