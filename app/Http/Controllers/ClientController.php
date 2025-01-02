<?php

namespace App\Http\Controllers {

    use App\Http\Requests\ClientRequest;
    use App\Repositories\Interfaces\IApplicationContext;

    class ClientController extends Controller
    {
        /**
         * Construct the ClientController.
         */
        public function __construct(protected IApplicationContext $repos)
        {
            //
        }

        /**
         * Display a listing of the resource.
         */
        public function index()
        {
            $data = $this->repos->client()->getAll();
            return view('Client.index', compact('data'));
        }

        /**
         * Show the form for creating a new resource.
         */
        public function create()
        {
            return view('Client.create');
        }

        /**
         * Store a newly created resource in storage.
         */
        public function store(ClientRequest $request)
        {

            $this->repos->client()->create($request);

            // Redirection vers la page d'index avec un message de succès
            return redirect()->route('client.index')->with('success', 'Le client a été ajouté avec succès.');
        }

        /**
         * Display the specified resource.
         */
        public function show(string $id)
        {
            $data = $this->repos->client()->getById($id);
            return view('Client.show', compact('data'));
        }

        /**
         * Show the form for editing the specified resource.
         */
        public function edit(string $id)
        {
            $data = $this->repos->client()->getById($id);

            return view('Client.edit', compact('data'));
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(ClientRequest $request, $id)
        {
            $this->repos->client()->update($request, $id);

            // Redirection vers la page d'index avec un message de succès
            return redirect()->route('client.index')->with('success', 'Le client a été mis à jour avec succès.');
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy($id)
        {
            $this->repos
                ->client()
                ->deleteById($id);

            // Redirection vers la page d'index avec un message de succès
            return redirect()
                ->route('client.index')
                ->with('success', 'Le client a été supprimé avec succès.');
        }
    }
}
