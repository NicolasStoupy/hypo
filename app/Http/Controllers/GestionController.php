<?php

namespace App\Http\Controllers {

    use App\Http\Requests\EvenementPoneyRequest;
    use App\Http\Requests\EvenementRequest;
    use App\Models\Cavalier;
    use App\Models\Evenement;
    use App\Models\EvenementPoney;
    use App\Models\Poney;
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
                'nombre_participant' => 'nullable|integer|min:1|lte:' . Poney::count(),
                'date' => 'nullable|date',
                'evenement_id' => 'nullable|integer',
                'evenement_type_id' => 'nullable|integer'

            ], [
                'nombre_participant.lte' => 'Le nombre de participants ne peut pas dépasser le nombre de poneys (' . Poney::count() . ') disponibles.',
            ]);


            // Récupérer le nombre de participants
            $nombre_participant = $validated['nombre_participant'] ?? null;

            $selected_date = date('Y-m-d');


            if (isset($validated['date'])) {
                // Récupérer la date sélectionnée et la stocker en session
                $selected_date = $validated['date'];
                session(['selected_date' => $selected_date]);
            } elseif (session()->has('selected_date')) {
                // Récupérer la date depuis la session si elle existe
                $selected_date = session('selected_date');
            }
            $open_data = $this->repos->openHours()->IsOpenDay($selected_date);
            $open = $open_data['is_open'];
            $week =$open_data['week'];
            $year= $open_data['year'];
            $day= $open_data['day'];
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
                'clients', 'nombre_participant', 'event_enable','open','week','year'
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
         * Met à jour l'affectation d'un poney pour un événement.
         *
         * Cette méthode permet d'ajouter ou de modifier l'affectation d'un poney à un événement.
         * Si un poney a déjà été affecté à l'événement, son affectation est mise à jour.
         * Ensuite, une redirection est effectuée vers la page de gestion avec un message de succès.
         *
         * @param EvenementPoneyRequest $evenement_poney_request Les données de la requête envoyées pour la mise à jour de l'affectation du poney.
         * @return \Illuminate\Http\RedirectResponse La réponse redirigeant l'utilisateur vers la page de gestion avec un message de succès.
         */
        public function updatePoney(EvenementPoneyRequest $evenement_poney_request)
        {
            // Récupération de l'ID du poney précédent pour une mise à jour (si nécessaire)
            $previous_poney_id = request()->get('previous_poney_id');

            // Ajouter ou modifier l'affectation du poney à l'événement
            $this->repos->evenement()->addPoney($evenement_poney_request, $previous_poney_id);

            // Redirection vers la page de gestion avec un message de succès
            return redirect()->route('gestion.index', [
                'evenement_id' => $evenement_poney_request->get('evenement_id'),  // ID de l'événement
                'date' => $evenement_poney_request->get('date')  // Date de l'événement
            ])->with('success', 'Affectation du poney mise à jour avec succès');
        }


        /**
         * Crée un nouvel événement et associe des cavaliers si nécessaire.
         *
         * Cette méthode crée un événement en fonction du type d'événement spécifié dans la requête.
         * Si le type d'événement est "2", elle associe également des cavaliers à l'événement.
         * Après la création, une redirection vers la page de gestion est effectuée avec un message de succès.
         *
         * @param EvenementRequest $request Les données de la requête envoyée par le formulaire.
         * @return \Illuminate\Http\RedirectResponse La réponse redirigeant l'utilisateur vers la page de gestion.
         */
        public function new_event(EvenementRequest $request)
        {

            $evenement = new Evenement();
            // Vérification du type d'événement pour savoir s'il faut ajouter des cavaliers
            if ($request->get('evenement_type_id') === '2') {
                // Création de l'événement avec les données de la requête
                $evenement = $this->repos->evenement()->create($request);

                // Récupération des cavaliers à associer à l'événement
                $cavaliers = $request->get('cavaliers');

                // Ajout des cavaliers à l'événement créé
                $this->repos->evenement()->addCavaliers($cavaliers, $evenement->id);
            } else {
                // Création de l'événement sans association de cavaliers
                $evenement = $this->repos->evenement()->create($request);
            }

            // Redirection vers la page de gestion avec la date de l'événement et un message de succès
            return redirect()->route('gestion.index', ['date' => $request->get('date_evenement'), 'evenement_id' => $evenement->id])
                ->with('success', 'Événement créé avec succès');
        }


        /**
         * Met à jour les cavaliers d'un événement.
         *
         * Cette méthode récupère la liste des cavaliers à mettre à jour et effectue la mise à jour dans la base de données.
         * Si la mise à jour est réussie, l'utilisateur est redirigé vers la page de gestion avec un message de succès.
         *
         * @param FormRequest $request Les données de la requête envoyée par le formulaire.
         * @return \Illuminate\Http\RedirectResponse La réponse redirigeant l'utilisateur vers la page de gestion.
         */
        public function update_cavaliers(FormRequest $request)
        {
            // Récupération des données de la requête
            $evenement_id = $request->get('evenement_id');  // ID de l'événement dont on met à jour les cavaliers
            $cavaliers = $request->get('cavaliers');  // Liste des cavaliers à mettre à jour

            // Vérification si des cavaliers sont fournis dans la requête
            if (!empty($cavaliers)) {
                // Mise à jour des cavaliers via le repository
                $this->repos->evenement()->updateCavaliers($cavaliers);
            }

            // Redirection vers la page de gestion avec un message de succès
            return redirect()->route('gestion.index', [
                'evenement_id' => $evenement_id,  // ID de l'événement pour l'affichage
                'date' => $request->get('date')  // Date associée à l'événement
            ])->with('success', 'Cavaliers mis à jour avec succès');
        }

        /**
         * Ajoute de nouveaux cavaliers à un événement.
         *
         * Cette méthode récupère les informations des cavaliers à ajouter à partir de la requête,
         * puis les ajoute à l'événement correspondant. Si des cavaliers sont ajoutés avec succès,
         * une redirection est effectuée vers la page de gestion avec un message de succès.
         *
         * @param FormRequest $request Les données de la requête envoyée par le formulaire.
         * @return \Illuminate\Http\RedirectResponse La réponse redirigeant l'utilisateur vers la page de gestion.
         */
        public function add_cavaliers(FormRequest $request)
        {
            // Récupération des données de la requête
            $evenement_id = $request->get('evenement_id');  // ID de l'événement auquel ajouter les cavaliers
            $nouveau_cavaliers = $request->get('new_cavalier');  // Liste des nouveaux cavaliers à ajouter

            // Vérification si des cavaliers sont fournis dans la requête
            if (!empty($nouveau_cavaliers)) {
                // Ajout des cavaliers à l'événement via le repository
                $this->repos->evenement()->addCavaliers($nouveau_cavaliers, $evenement_id);
            }

            // Redirection vers la page de gestion avec un message de succès
            return redirect()->route('gestion.index', [
                'evenement_id' => $evenement_id,  // ID de l'événement pour l'affichage
                'date' => $request->get('date')  // Date associée à l'événement
            ])->with('success', 'Cavaliers ajoutés avec succès');
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
