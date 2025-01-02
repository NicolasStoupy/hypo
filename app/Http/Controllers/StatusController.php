<?php

namespace App\Http\Controllers {

    use App\Http\Requests\StatusRequest;
    use App\Repositories\Interfaces\IApplicationContext;


    class StatusController extends Controller
    {
        public function __construct(protected IApplicationContext $repository)
        {


        }

        /**
         * Display a listing of the resource.
         */
        public function index()
        {
            //
            $data = $this->repository->status()->getAll();
            return view('status.index', compact('data'));
        }

        /**
         * Show the form for creating a new resource.
         */
        public function create()
        {
            //

            return view('create');
        }

        /**
         * Store a newly created resource in storage.
         */
        public function store(StatusRequest $request)
        {
            //
            $this->repository->status()->create($request);
            return redirect()->route('status.index');
        }

        /**
         * Display the specified resource.
         */
        public function show(string $id)
        {
            //
            $data = $this->repository->status()->getById($id);
            return view('status.edit', compact('data'));
        }

        /**
         * Show the form for editing the specified resource.
         */
        public function edit(string $id)
        {
            $data = $this->repository->status()->getById($id);
            return view('status.edit', compact('data'));
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(StatusRequest $request, string $id)
        {
            //

            $this->repository->status()->update($request, $id);
            return redirect()->route('status.index')->with('success', 'Le status a été mis à jour avec succès.');
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(string $id)
        {
            $this->repository->status()->deleteById($id);
            return redirect()->route('status.index')->with('success', 'Le status a été supprimé avec succès.');
        }
    }
}
