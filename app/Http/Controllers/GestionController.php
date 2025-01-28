<?php

namespace App\Http\Controllers {

    use App\Http\Requests\EvenementPoneyRequest;
    use App\Http\Requests\EvenementRequest;
    use App\Models\Cavalier;
    use App\Models\Evenement;
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
            // Validation des données de la requête
            $validated = $request->validate([
                'nombre_participant' => 'nullable|integer|min:1',
                'date' => 'nullable|date',
                'evenement_id' => 'nullable|integer',
                'evenement_type_id' => 'nullable|integer'

            ]);
            // Récupérer le nombre de participants
            $nombre_participant = $validated['nombre_participant'] ?? null;

            // Récupérer la date sélectionnée
            $selected_date = $validated['date'] ?? date('Y-m-d');
            // Récupérer l'identifiant de l'événement modifié
            $last_modified_event_id = $validated['evenement_id'] ?? null;

            // Récupérer l'identifiant du type d'événement sélectionné
            $selected_event_type_id = $validated['evenement_type_id'] ?? null;
            // Récupérer les événements pour la date sélectionnée
            $events = $this->repos->evenement()->getEvenementsByDate($selected_date);
            // Récupérer tous les poneys et les clients
            $poneys = $this->repos->poney()->getAll();
            $clients = $this->repos->client()->getAll();

            // Récupérer les types d'événements disponibles
            $event_types = $this->repos->evenement()->getEvenementTypes();
            $event_enable = isset($nombre_participant);

            // Retourner un tableau compacté avec les données nécessaires à la vue
            return compact(
                'events',
                'selected_date',
                'poneys',
                'last_modified_event_id',
                'event_types',
                'selected_event_type_id',
                'clients', 'nombre_participant', 'event_enable'
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

            // Sinon, effectuer une redirection simple vers la vue de gestion
            return redirect()
                ->route('gestion.index',
                    ['evenement_id' => $evenement_poney_request->get('evenement_id'),
                        'date' => $evenement_poney_request->get('date')]
                )->with('success', 'Poney mise a jour ');
        }

        /**
         * Créer un nouvel événement.
         */
        public function new_event(EvenementRequest $request)
        {

            if ($request->get('evenement_type_id') === '2') {

                $evenement = $this->repos->evenement()->create($request);
                $cavaliers = $request->get('cavaliers');
                $this->repos->evenement()->addCavaliers($cavaliers, $evenement->id);


            } else {

                // Création de l'événement via le repository
                $this->repos->evenement()->create($request);
            }


            // Rediriger vers la vue de gestion avec la date de l'événement
            return redirect()->route('gestion.index', ['date' => $request->get('date_evenement')])->with('success', 'Créé avec success');
        }


        public function update_cavaliers(FormRequest $request)
        {
            $evenement_id = $request->get('evenement_id');
            $cavaliers = $request->get('cavaliers');

            // Mise à jour des cavaliers existants
            if (!empty($cavaliers)) {
                $this->repos->evenement()->updateCavaliers($cavaliers);
            }
            return redirect()->route('gestion.index', [
                'evenement_id' => $evenement_id,
                'date' => $request->get('date')
            ])->with('success', 'Validé avec succès');

        }
        public function add_cavaliers(FormRequest $request)
        {

            // Récupération des données de la requête
            $evenement_id = $request->get('evenement_id');
            $nouveau_cavaliers = $request->get('new_cavalier');

            // Ajout de nouveaux cavaliers si nécessaire
            if (!empty($nouveau_cavaliers)) {
                $this->repos->evenement()->addCavaliers($nouveau_cavaliers, $evenement_id);
            }
            // Redirection avec message de succès
            return redirect()->route('gestion.index', [
                'evenement_id' => $evenement_id,
                'date' => $request->get('date')
            ])->with('success', 'Validé avec succès');
        }


        /**
         * Handles the deletion of an event and prepares the updated view.
         *
         * @param Request $request The HTTP request containing the event ID to delete.
         * @return \Illuminate\Http\RedirectResponse The updated view with a success message.
         */
        public function delete_evenement(Request $request)
        {

            // Retrieve the event ID from the request
            $evenement_id = $request->get('id');
            // Delete the event using the repository
            $this->repos->evenement()->deleteById($evenement_id);
            return redirect()->route('gestion.index', [
                    'evenement_id' => $evenement_id,
                    'date' => $request->get('selected_date')
                ]
            )->with('success', 'Événement supprimé avec succès');

        }

    }
}
