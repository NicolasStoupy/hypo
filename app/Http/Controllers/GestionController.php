<?php

/**
 * Class GestionController
 *
 * Controller for managing events within the application.
 */

namespace App\Http\Controllers {

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
            $date=$request->get('date')??date('Y-m-d');
            $evenements = $this->repos->evenement()->getEvenementsByDate($date);
            return view('gestion.index', compact('evenements', 'date'));
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
    }
}
