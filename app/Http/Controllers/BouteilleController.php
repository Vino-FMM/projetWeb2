<?php

namespace App\Http\Controllers;

use App\Models\Cellier;
use App\Models\Bouteille;
use App\Models\BouteilleCellier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


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
        //trouver mon cellier
        $mon_cellier = Cellier::findorFail($cellier_id);


        //faire la pagination par 10
        $bottles = Bouteille::paginate(10);
        // retourner la vue index avec les bouteilles
        return view('bouteilles.AjouterBouteilles', ['bottles' => $bottles, 'owned_bottles' => $owned_bottles, 'cellier_id' => $cellier_id, 'mon_cellier' => $mon_cellier]);
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
        // nom du cellier
        $nomCellier = $cellier->nom_cellier;
        //retour vers la vue monCellier
        return view('cellier.monCellier', compact('bouteilleCelliers', 'cellier', 'nomCellier'))->with('success', 'Quantité modifiée.');
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
        // dd($quantite);
        // trouver la bouteille dans le cellier
        $bouteilleCellier = BouteilleCellier::where('cellier_id', $cellierId)
                                            ->where('code_saq_bouteille', $bouteille->code_saq)
                                            ->first();
        if ($bouteilleCellier) {
            // si la bouteille existe déjà dans le cellier, mettre à jour la quantité
            $bouteilleCellier->quantite += $quantite;
            $bouteilleCellier->save();
        } else {
            // sinon, ajouter une nouvelle bouteille dans le cellier
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
            $bouteilleCellier->url_img_small_bouteille = $bouteille->url_img_small;
            $bouteilleCellier->millesime_bouteille = $bouteille->millesime;
            $bouteilleCellier->type_bouteille = $bouteille->type;
            $bouteilleCellier->save();
        }
        $bouteilleCelliers = BouteilleCellier::where(
            "cellier_id",
            $cellierId,
        )->get();
    
        // trouver le cellier avec l'id du cellier sélectionné
        $cellier = Cellier::findOrFail($cellierId);
        // nom du cellier
        $nomCellier = $cellier->nom_cellier;
        // retourner vers la vue monCellier
        return view(
            "cellier.monCellier",
            compact("bouteilleCelliers", "cellier", "nomCellier"),
        )->with("success", "Bouteille ajoutée au cellier.");
    }

    public function AjouterbouteilleManuellement(Request $request, $cellier_id)
    {
        // dd($cellier_id);
        // renvoyer vers la vue addBouteilleManuellement
        return view('bouteilles.addBouteilleManuellement', compact('cellier_id'));
    }

        public function destroy(Request $request,string $id)
    {
        
        // Supprimer la bouteille du cellier de la base de données
        BouteilleCellier::destroy($id);
        // stocker l'id du cellier
        $cellierId = $request->input('cellier_id');
        // Trouver les bouteilles du cellier
        $bouteilleCelliers = BouteilleCellier::where('cellier_id', $cellierId)->get();
        // Trouver le cellier avec l'id du cellier sélectionné
        $cellier = Cellier::findOrFail($cellierId);
        // Rediriger vers la page du cellier avec un message de succès
        return view('cellier.monCellier', compact('bouteilleCelliers', 'cellier'))->with('success', 'Boutelle supprimée du cellier.');
    }

    public function search(Request $request)
    {
        // dd('test');
        $query = $request->input('query');
        // $query = $request->input('query');

    // Log::info('Search Query: ' . $query);

        $bottles = Bouteille::where('nom', 'LIKE', "%$query%")
            // ->orWhere('type', 'LIKE', "%$query%")
            // ->orWhere('format', 'LIKE', "%$query%")
            // ->orWhere('pays', 'LIKE', "%$query%")
            // ->orWhere('code_saq', 'LIKE', "%$query%")
            ->get();

        return response()->json($bottles);
    }

    public function addBouteilleSearch($id, Request $request)
{
    // dd($request->input('cellier_id'));
    $bottle = Bouteille::findOrFail($id);
    // dd($bottle);
    $cellier_id = $request->input('cellier_id');
    // dd($bottle, $cellier_id);
    // Retrieve the bottle with the given ID from the database
    $bottle = Bouteille::findOrFail($id);

    // Retrieve the cellier_id from the request
    $cellierId = $request->query('cellier_id');

    // Additional data retrieval if needed (e.g., cellier details)

    // Return the view with the bottle details and cellier_id
    return view('bouteilles.addBouteilleSearch', ['bouteille' => $bottle, 'cellier_id' => $cellierId]);
}
}
