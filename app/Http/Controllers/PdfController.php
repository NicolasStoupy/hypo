<?php

namespace App\Http\Controllers;

use App\Helpers\ConfigHelper;
use App\Models\Cavalier;
use App\Repositories\Interfaces\IApplicationContext;
use Barryvdh\DomPDF\Facade\Pdf;
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
        // Récupération de la configuration
        $invoiceFormat = ConfigHelper::get('INVOICE_FORMAT');
        $invoicePrefix = ConfigHelper::get('INVOICE_NUMBER_PREFIX');
        $factureName= $invoicePrefix.$id.'.pdf';
        $logoPath = ConfigHelper::get('INVOICE_LOGO_PATH');


        // Création de l'objet PDF
        $pdf = App::make('dompdf.wrapper');

        // Chargement du logo uniquement si le chemin est défini
        $logo = $logoPath ? base64_encode(file_get_contents(public_path($logoPath))) : null;

        // Récupération des données
        $facture = $this->repos->facture()->getById($id);
        $cavalier = Cavalier::where('facture_id', $id)->first();

        // Sélection du template en fonction de la présence d'un cavalier
        $template = $cavalier ? 'templates_factures.t_facture_1' : 'templates_factures.t_facture_2';
        $html = view($template, compact('facture', 'cavalier', 'logo'))->render();

        // Chargement du HTML dans DomPDF
        $pdf->loadHTML($html);

        // Gestion du format de sortie
        return match ($invoiceFormat) {
            'PDF' => $pdf->download($factureName),
            'STREAM' => $pdf->stream($factureName),
        };
    }

    public function facture_by_id($id)
    {

    }

    public function facture_by_evenement($id)
    {

        $evenement = $this->repos->evenement()->getById($id);

    }

}
