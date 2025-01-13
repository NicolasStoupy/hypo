<?php

/**
 * Class GestionController
 *
 * Controller for managing events within the application.
 */

namespace App\Http\Controllers {

    use App\Http\Requests\EvenementPoneyRequest;
    use App\Models\EvenementPoney;
    use App\Repositories\Interfaces\IApplicationContext;
    use Illuminate\Http\Request;

    class GestionController extends Controller
    {

        public function __construct(protected IApplicationContext $repos)
        {
        }

        /**
         * Display a listing of the resource.
         */
        public function index(Request $request)
        {
            $date = $request->get('date') ?? date('Y-m-d');
            $evenement_id = $request->get('evenement_id');
            $evenements = $this->repos->evenement()->getEvenementsByDate($date);
            $poneys = $this->repos->poney()->getAll();
            $evenement_types = $this->repos->evenement()->getEvenementTypes();
            return view('gestion.index', compact('evenements', 'date', 'poneys','evenement_id','evenement_types'));
        }

        /**
         * Show the form for creating a new resource.
         */
        public function create()
        {
            //
        }

        /**
         * Store a newly created resource in storage.
         */
        public function store(Request $request)
        {
            //
        }

        /**
         * Display the specified resource.
         */
        public function show(string $id)
        {
            //
        }

        /**
         * Show the form for editing the specified resource.
         */
        public function edit(string $id)
        {
            //
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, string $id)
        {
            //
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(string $id)
        {
            //
        }
        public function updatePoney(EvenementPoneyRequest $evenement_poney_request)
        {
            // Ajouter le poney à l'événement à l'aide du repository
            $this->repos->evenement()->addPoney($evenement_poney_request, request()->get('previous_poney_id'));

            // Récupérer les paramètres nécessaires pour la redirection
            $date = request()->get('date');
            $evenement_id = request()->get('evenement_id');

            // Vérifier si le paramètre 'date' est présent et rediriger en conséquence
            if ($date) {
                return redirect()->route('gestion.index', [
                    'date' => $date,
                    'evenement_id' => $evenement_id
                ]);
            }

            // Si aucun paramètre 'date', rediriger simplement vers la route
            return redirect()->route('gestion.index');
        }

    }
}
