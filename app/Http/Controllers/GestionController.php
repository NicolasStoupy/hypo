<?php

namespace App\Http\Controllers {

    use App\Http\Requests\EvenementPoneyRequest;
    use App\Http\Requests\EvenementRequest;
    use App\Models\EvenementPoney;
    use App\Repositories\Interfaces\IApplicationContext;
    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Http\Request;

    class GestionController extends Controller
    {
        // Injection de la dépendance IApplicationContext via le constructeur
        public function __construct(protected IApplicationContext $repos)
        {
        }

        /**
         * Prépare les données nécessaires pour la vue.
         *
         * @param Request $request La requête entrante contenant les paramètres.
         * @return array Un tableau contenant les données pour la vue.
         */
        private function prepareViewModel(Request $request): array
        {

            // Déterminer la date sélectionnée ou utiliser la date actuelle par défaut
            $selected_date = $request->get('date', date('Y-m-d'));

            // Identifiant de l'événement récemment modifié, s'il existe
            $last_modified_event_id = $request->get('evenement_id');

            // Récupérer les événements pour la date sélectionnée
            $events = $this->repos->evenement()->getEvenementsByDate($selected_date);

            // Récupérer tous les poneys et les clients
            $poneys = $this->repos->poney()->getAll();
            $clients = $this->repos->client()->getAll();

            // Récupérer les types d'événements disponibles
            $event_types = $this->repos->evenement()->getEvenementTypes();

            // Identifiant du type d'événement sélectionné, s'il existe
            $selected_event_type_id = $request->get('evenement_type_id');

            // Retourner un tableau compacté avec les données nécessaires à la vue
            return compact(
                'events',
                'selected_date',
                'poneys',
                'last_modified_event_id',
                'event_types',
                'selected_event_type_id',
                'clients'
            );
        }

        /**
         * Afficher la liste des événements.
         */
        public function index(Request $request)
        {
            return view('gestion.index', $this->prepareViewModel($request));
        }
        /**
         * Mettre à jour l'affectation d'un poney à un événement.
         */
        public function updatePoney(EvenementPoneyRequest $evenement_poney_request)
        {
            // Ajouter ou modifier l'affectation du poney
            $this->repos->evenement()->addPoney($evenement_poney_request, request()->get('previous_poney_id'));

            // Récupérer les paramètres nécessaires pour la redirection
            $date = request()->get('date');
            $evenement_id = request()->get('evenement_id');

            // Si un paramètre 'date' est passé, effectuer la redirection vers la vue correspondante
            if ($date) {
                return redirect()->route('gestion.index', [
                    'date' => $date,
                    'evenement_id' => $evenement_id
                ]);
            }

            session('success')[]=['success'=>'success'];
            // Sinon, effectuer une redirection simple vers la vue de gestion
            return redirect()->route('gestion.index');
        }

        /**
         * Créer un nouvel événement.
         */
        public function new_event(EvenementRequest $request)
        {
            // Création de l'événement via le repository
            $this->repos->evenement()->create($request);

            // Rediriger vers la vue de gestion avec la date de l'événement
            return redirect()->route('gestion.index', ['date' => $request->get('date_evenement')])->with('success', 'Créé avec success');
        }

        public function  add_cavaliers(FormRequest $request)
        {

            $cavaliers = $request->get('nom');
            $evenement_id= $request->get('evenement_id');

            $this->repos->evenement()->addCavaliers($cavaliers,$evenement_id);


            return redirect()->route('gestion.index', ['date' => $request->get('date'),'evenement_id'=>$evenement_id]);
        }
    }
}
