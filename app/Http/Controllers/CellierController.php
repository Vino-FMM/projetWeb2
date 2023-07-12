<?php

namespace App\Http\Controllers;

use App\Models\Cellier;
use Illuminate\Http\Request;

class CellierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cellier.addCellier');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'nom_cellier' => 'required',
        ], [
            'nom_cellier.required' => 'Le champ nom_cellier est requis.',
        ]);
    
        // Créer un nouveau cellier dans la base de données
        $cellier = new Cellier;
        $cellier->nom_cellier = $request->input('nom_cellier');
        $cellier->user_id = auth()->user()->id;
        $cellier->save();
    
        // Rediriger vers la page d'accueil avec un message de succès
        // return redirect(route('accueil'))->withSuccess('Cellier enregistré.');
        return redirect()->route('home')->withSuccess('Cellier enregistré.');

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
