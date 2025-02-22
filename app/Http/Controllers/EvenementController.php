<?php

namespace App\Http\Controllers;

use App\Helpers\MemorisePathHelper;
use App\Http\Requests\AssociationRequest;
use App\Http\Requests\EvenementRequest;
use App\Repositories\Interfaces\IApplicationContext;
use Illuminate\Http\Request;
use function Termwind\parse;

class EvenementController extends Controller
{

    public function __construct(protected IApplicationContext $repos)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $data = $this->repos->evenement()->paginate(5, $search);

        return view('evenement.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $factures = $this->repos->facture()->getAll();
        $clients = $this->repos->client()->getAll();
        $status = $this->repos->status()->getAll();
        $evenement_types = $this->repos->evenement()->getEvenementTypes();


        return view('evenement.create', compact('factures', 'clients', 'status', 'evenement_types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EvenementRequest $evenementRequest)
    {

        $this->repos->evenement()->create($evenementRequest);
        return redirect()->route('evenement.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        MemorisePathHelper::savePath($_SERVER['HTTP_REFERER']);
        $factures = $this->repos->facture()->getAll();
        $clients = $this->repos->client()->getAll();
        $data = $this->repos->evenement()->getById($id);
        $status = $this->repos->status()->getAll();
        $evenement_types = $this->repos->evenement()->getEvenementTypes();
        return view('evenement.edit', compact('data', 'factures', 'clients', 'status', 'evenement_types'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {


        $this->show($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EvenementRequest $evenementRequest, string $id)
    {


        $this->repos->evenement()->update($evenementRequest, $id);

        return redirect(MemorisePathHelper::getLastPath());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->repos->evenement()->deleteById($id);
        return redirect()->route('evenement.index')->with('success', 'Supprimer avec success');
    }
}
