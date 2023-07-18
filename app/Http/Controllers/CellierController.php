<?php

namespace App\Http\Controllers;

use App\Models\Cellier;
use App\Models\Bouteille;
use App\Models\BouteilleCellier;
use Illuminate\Http\Request;

class CellierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cellierId = request('id');
        $cellier = Cellier::findOrFail($cellierId);
        $bouteilleCelliers = BouteilleCellier::where('cellier_id', $cellierId)->get();
        //return to monCellier.blade on cellier folder with BouteilleCellier
        return view('cellier.monCellier', compact('bouteilleCelliers', 'cellier'));
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
            // Retrieve the Cellier object with the given id
            $cellier = Cellier::findOrFail($id);
        
            // Pass the Cellier object to the view for editing
            return view('cellier.modifyCellier', compact('cellier'));
        }

        //modifier la quantité de bouteille dans le cellier (vue)

        public function modifierBouteille(Request $request, $id)
        {
            // trouver la bouteille avec l'id de la bouteille sélectionnée dans BouteilleCellier
            $bouteilleCellier = BouteilleCellier::findOrFail($id);
            //retour vers la vue modifyQte
            return view('bouteilles.modifyQte', compact('bouteilleCellier'));
        }

        public function modifierQteBouteille(Request $request, $bouteille_id)
        {
            
            // Find the BouteilleCellier record with the given ID
            $bouteilleCellier = BouteilleCellier::findOrFail($bouteille_id);
            // dd($bouteilleCellier);
            // Update the quantity of the BouteilleCellier record with the input value
            $bouteilleCellier->quantite = $request->input('quantite');
            $bouteilleCellier->save();

            // Get the ID of the cellier that the BouteilleCellier record belongs to
            $cellierId = $bouteilleCellier->cellier_id;

            // Get all the BouteilleCellier records for the cellier
            $bouteilleCelliers = BouteilleCellier::where('cellier_id', $cellierId)->get();

            // Get the Cellier record for the cellier
            $cellier = Cellier::findOrFail($cellierId);

            // Return the monCellier view with the updated BouteilleCellier records and Cellier record
            return view('cellier.monCellier', compact('bouteilleCelliers', 'cellier'))->with('success', 'Quantité modifiée.');
        }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Retrieve the Cellier object with the given id
        $cellier = Cellier::findOrFail($id);
    
        // Validate the form data
        $request->validate([
            'nom_cellier' => 'required',
        ], [
            'nom_cellier.required' => 'Le champ nom_cellier est requis.',
        ]);
    
        // Update the Cellier object with the new values from the form
        $cellier->nom_cellier = $request->input('nom_cellier');
        $cellier->save();
    
        // Redirect to the home page with a success message
        return redirect()->route('home')->withSuccess('Cellier modifié.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Supprimer les bouteilles du cellier de la base de données
        BouteilleCellier::where('cellier_id', $id)->delete();
    
        // Supprimer le cellier de la base de données
        Cellier::destroy($id);
    
        // Rediriger vers la page d'accueil avec un message de succès
        return redirect()->route('home')->withSuccess('Cellier supprimé.');
    }
        public function addBouteille(Request $request, $id)
    {
        $previousUrl = url()->previous();
        $queryParameters = parse_url($previousUrl, PHP_URL_QUERY);
        parse_str($queryParameters, $queryData);
        
        $cellierId = $queryData['cellier_id'];
        
        // Find bouteille with id of bouteille selected
        $bouteille = Bouteille::findOrFail($id);

         // Get the quantity from the form input
        $quantite = $request->input('quantite');
    
        // Create a new BouteilleCellier record in the database with quantity set to 1
        $bouteilleCellier = new BouteilleCellier;
        $bouteilleCellier->user_id = auth()->user()->id;
        $bouteilleCellier->cellier_id = $cellierId;
       $bouteilleCellier->quantite = $quantite;
        $bouteilleCellier->nom_bouteille = $bouteille->nom;
        $bouteilleCellier->format_bouteille = $bouteille->format;
        $bouteilleCellier->prix_bouteille = $bouteille->prix;
        $bouteilleCellier->pays_bouteille = $bouteille->pays;
        $bouteilleCellier->code_saq_bouteille = $bouteille->code_saq;
        $bouteilleCellier->url_saq_bouteille = $bouteille->url_saq;
        $bouteilleCellier->url_img_bouteille = $bouteille->url_img;
        $bouteilleCellier->millesime_bouteille = $bouteille->millesime;
        $bouteilleCellier->type_bouteille = $bouteille->type;
        $bouteilleCellier->save();
        $bouteilleCelliers = BouteilleCellier::where('cellier_id', $cellierId)->get();
        
        
        $cellier = Cellier::findOrFail($cellierId);
    
        return view('cellier.monCellier', compact( 'bouteilleCelliers','cellier'))->with('success', 'Bouteille ajoutée au cellier.');
        
    }

}
