<?php

namespace App\Http\Controllers;

use App\Models\Cellier;
use App\Models\Bouteille;
use App\Models\BouteilleCellier;
use Illuminate\Http\Request;

class BouteilleController extends Controller
{
    //afficher la liste des bouteilles dans la base de données
    public function index($cellier_id)
    {
        
        //faire un fetch de toutes les bouteilles
        $bottles = Bouteille::all();
        // trouver les bouteilles du cellier
        $owned_bottles = BouteilleCellier::where('cellier_id', $cellier_id)
        ->pluck('code_saq_bouteille')
        ->toArray();
        // dd($owned_bottles);

        //faire la pagination par 10
        $bottles = Bouteille::paginate(10);
        // retourner la vue index avec les bouteilles
        return view('bouteilles.AjouterBouteilles', ['bottles' => $bottles, 'owned_bottles' => $owned_bottles, 'cellier_id' => $cellier_id]);
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

    /**
     * ajouter une bouteille au cellier
     * @param Request $request
     * @param string $id
     */
    public function addBouteille(Request $request, $id)
    {   
        // stocker l'id du cellier
        $cellierId = $request->input('cellier_id');
        // trouver la bouteille avec l'id de la bouteille sélectionnée dans Bouteille
        $bouteille = Bouteille::findOrFail($id);
        // stocker la quantité de bouteille
        $quantite = $request->input("quantite");
        // ajouter une nouvelle bouteille dans le cellier
        $bouteilleCellier = new BouteilleCellier();
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
        $bouteilleCelliers = BouteilleCellier::where(
            "cellier_id",
            $cellierId,
        )->get();

        // trouver le cellier avec l'id du cellier sélectionné
        $cellier = Cellier::findOrFail($cellierId);
        // retourner vers la vue monCellier
        return view(
            "cellier.monCellier",
            compact("bouteilleCelliers", "cellier"),
        )->with("success", "Bouteille ajoutée au cellier.");
    }
}
