<?php

namespace App\Http\Controllers;

use App\Models\Cellier;
use App\Models\Bouteille;
use App\Models\BouteilleCellier;
use Illuminate\Http\Request;

class BouteilleController extends Controller
{
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
        
        // trouver la bouteille avec l'id de la bouteille sélectionnée dans BouteilleCellier
        $bouteilleCellier = BouteilleCellier::findOrFail($bouteille_id);
        // mettre à jour la quantité de bouteille dans le cellier
        $bouteilleCellier->quantite = $request->input('quantite');
        $bouteilleCellier->save();
        // stocker l'id du cellier
        $cellierId = $bouteilleCellier->cellier_id;
        // trouver les bouteilles du cellier
        $bouteilleCelliers = BouteilleCellier::where('cellier_id', $cellierId)->get();
        // trouver le cellier avec l'id du cellier sélectionné
        $cellier = Cellier::findOrFail($cellierId);
        //retour vers la vue monCellier
        return view('cellier.monCellier', compact('bouteilleCelliers', 'cellier'))->with('success', 'Quantité modifiée.');
    }
}
