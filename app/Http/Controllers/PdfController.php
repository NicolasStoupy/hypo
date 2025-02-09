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
    /**
     * Génère une facture au format PDF et la retourne en fonction de la configuration.
     *
     * Cette méthode récupère la configuration du format de facture, le préfixe du numéro de facture,
     * et le chemin du logo, puis génère un fichier PDF de la facture associée à l'identifiant `$id`.
     * Le contenu du PDF est basé sur un template différent en fonction de la présence d'un cavalier
     * associé à la facture. La facture est ensuite envoyée au client sous forme de téléchargement ou
     * de diffusion en streaming, selon la configuration définie dans les paramètres.
     *
     * @param int $id L'identifiant de la facture à générer.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Symfony\Component\HttpFoundation\Response Le fichier PDF généré, soit en téléchargement, soit en streaming.
     */
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

}
