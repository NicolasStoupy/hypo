<?php

namespace App\Http\Controllers;

use App\Http\Requests\PoneyRequest;
use App\Repositories\Interfaces\IApplicationContext;
use App\Repositories\Interfaces\IPoney;
use Illuminate\Http\Request;
use Masmerise\Toaster\Toaster;

class PoneyController extends Controller
{

    /**
     * Construct the PoneyController.
     */
    public function __construct(protected IApplicationContext $repos)
    {
        //
    }


    public function index(Request $request)
    {
        $search = $request->get('search');
        $this->repos->facture()->getAll();
        $data = $this->repos->poney()->paginate(5,$search);
        return view('poney.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $boxs = $this->repos->cleaning()->getAll();
        return view('poney.create',compact("boxs"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PoneyRequest $request)
    {

        $this->repos->poney()->create($request);

        // Redirection vers la page d'index avec un message de succès
        return redirect()->route('poney.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->repos->poney()->getById($id);
        $boxs = $this->repos->cleaning()->getAll();
        return view('poney.edit', compact('data','boxs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = $this->repos->poney()->getById($id);
        return view('poney.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PoneyRequest $request, $id)
    {

        $this->repos->poney()->update($request, $id);

        // Redirection vers la page d'index avec un message de succès
        return redirect()->route('poney.index')->with('success', 'Le poney a été mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->repos->poney()->deleteById($id);

        // Redirection vers la page d'index avec un message de succès
        return redirect()->route('poney.index')->with('success', 'Le poney a été supprimé avec succès.');
    }
}
