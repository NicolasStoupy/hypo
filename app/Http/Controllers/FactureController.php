<?php

namespace App\Http\Controllers {

    use App\Http\Requests\FactureCavalierRequest;
    use App\Http\Requests\FactureEvenementRequest;
    use App\Repositories\Interfaces\IApplicationContext;
    use Carbon\Carbon;
    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Http\Request;

    class FactureController extends Controller
    {


        public function __construct(protected IApplicationContext $repos)
        {

        }

        /**
         * Display a listing of the resource.
         */
        public function index()
        {
            $data = $this->repos->facture()->getAll();

            return view('facture.index', compact('data'));
        }

        /**
         * Show the form for creating a new resource.
         */
        public function create()
        {
            return view('facture.create');
        }

        /**
         * Gère la logique de l'affichage de la page de gestion des factures, en fonction de l'année sélectionnée.
         * Si aucune année n'est spécifiée dans la requête, l'année en cours est utilisée par défaut.
         *
         * @return \Illuminate\View\View
         */
        public function gestion()
        {
            // Récupérer l'année sélectionnée dans la requête, ou utiliser l'année en cours si aucune année n'est spécifiée
            $selectedYear = request()->get('year', Carbon::now()->year);

            // S'assurer que l'année est bien un entier, sinon utiliser l'année actuelle
            $selectedYear = (int)$selectedYear;

            // Récupérer les facturiers pour l'année spécifiée
            $facturiers = $this->repos->facture()->getFacturier($selectedYear);

            // Récupérer les événements des clients associés aux facturiers pour l'année spécifiée
            $evenements = $this->repos->facture()->getFacturierClient($selectedYear);

            $facturier_current = $this->repos->facture()->getCurrentMonthFacturierClient();


            // Retourner la vue avec les données de facturiers, événements et l'année sélectionnée
            return view('facture.gestion_facture', compact('facturiers', 'evenements', 'selectedYear', 'facturier_current'));
        }

        /**
         * Affiche le formulaire de création de facture pour un événement.
         *
         * Cette méthode récupère un événement spécifique à partir de son identifiant `$id` en
         * utilisant la méthode `getById()` du repository `evenement`. L'événement récupéré est
         * ensuite passé à la vue `facture.create` pour permettre la création de la facture.
         *
         * @param int $id L'identifiant de l'événement pour lequel la facture est créée.
         *
         * @return \Illuminate\View\View La vue `facture.create` avec les données de l'événement.
         */
        public function facturer_evenement($id)
        {
            // Récupérer l'événement par son identifiant
            $evenement = $this->repos->evenement()->getById($id);

            // Retourner la vue pour créer la facture
            return view('facture.create', compact('evenement'));
        }

        /**
         * Crée une facture pour un cavalier à partir de la requête.
         *
         * Cette méthode utilise les données fournies dans la requête (via `FactureCavalierRequest`)
         * pour créer une facture pour un cavalier en appelant la méthode `creationFactureCavalier()`
         * du repository `facture`. Ensuite, elle redirige vers la page de facturation de l'événement
         * associé, avec un message de confirmation.
         *
         * @param \App\Http\Requests\FactureCavalierRequest $request La requête contenant les informations nécessaires pour créer la facture.
         *
         * @return \Illuminate\View\View La redirection vers la page de création de facture avec les données de l'événement.
         */
        public function facturer_cavalier(FactureCavalierRequest $request)
        {

            $this->repos->facture()->creationFactureCavalier($request);
            // Rediriger vers la page de création avec un message de confirmation
            return $this->facturer_evenement($request->get('evenement_id'));
        }

        /**
         * Annule la facture pour un cavalier et redirige vers la page de facturation de l'événement.
         *
         * Cette méthode supprime la facture associée au cavalier spécifié par l'ID `$id` en
         * appelant la méthode `delete_by_cavalier()` du repository `facture`. Ensuite, elle
         * redirige vers la page de facturation de l'événement identifié par `$evenement_id`.
         *
         * @param int $id L'identifiant du cavalier dont la facture doit être annulée.
         * @param int $evenement_id L'identifiant de l'événement vers lequel la redirection doit avoir lieu après la suppression de la facture.
         *
         * @return \Illuminate\View\View La redirection vers la page de facturation de l'événement.
         */
        public function reverse($id, $evenement_id)
        {

            $this->repos->facture()->delete_by_cavalier($id);
            return $this->facturer_evenement($evenement_id);
        }

        /**
         * Annule la facturation d'un événement et redirige vers la page de création de facture pour cet événement.
         *
         * Cette méthode supprime toutes les factures associées à l'événement spécifié par l'ID `$evenement_id`
         * en appelant la méthode `delete_by_evenement()` du repository `facture`. Ensuite, elle redirige vers la
         * page de facturation de l'événement pour permettre de recréer une facture.
         *
         * @param int $evenement_id L'identifiant de l'événement dont la facturation doit être annulée.
         *
         * @return \Illuminate\View\View La redirection vers la page de facturation de l'événement.
         */
        public function reverse_event_facturation($evenement_id)
        {

            $this->repos->facture()->delete_by_evenement($evenement_id);
            return $this->facturer_evenement($evenement_id);

        }

        /**
         * Crée une facture pour un événement et redirige vers la page de facturation de cet événement.
         *
         * Cette méthode récupère l'identifiant de l'événement à partir de la requête `$request` et appelle
         * la méthode `creationFactureEvnement()` du repository `facture` pour créer une facture pour cet événement.
         * Ensuite, elle redirige vers la page de facturation de l'événement.
         *
         * @param \Illuminate\Http\Request $request La requête contenant l'identifiant de l'événement pour lequel la facture doit être créée.
         *
         * @return \Illuminate\View\View La redirection vers la page de facturation de l'événement.
         */
        public function facturation_evenement(Request $request)
        {
            $evenement_id = $request->get('evenement_id');

            $this->repos->facture()->creationFactureEvnement($evenement_id);
            return $this->facturer_evenement($evenement_id);
        }


    }
}
