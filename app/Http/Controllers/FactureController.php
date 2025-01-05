<?php

namespace App\Http\Controllers {

    use App\Repositories\Interfaces\IApplicationContext;
    use Carbon\Carbon;
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
            $selectedYear = (int) $selectedYear;

            // Récupérer les facturiers pour l'année spécifiée
            $facturiers = $this->repos->facture()->getFacturier($selectedYear);

            // Récupérer les événements des clients associés aux facturiers pour l'année spécifiée
            $evenements = $this->repos->facture()->getFacturierClient($selectedYear);

            $facturier_current= $this->repos->facture()->getCurrentMonthFacturierClient();


            // Retourner la vue avec les données de facturiers, événements et l'année sélectionnée
            return view('facture.gestion_facture', compact('facturiers', 'evenements', 'selectedYear','facturier_current'));
        }


    }
}
