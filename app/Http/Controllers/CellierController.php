<?php

namespace App\Http\Controllers;

use App\Models\Cellier;
use App\Models\Bouteille;
use App\Models\BouteilleCellier;
use App\Models\Note;
use Illuminate\Http\Request;

class CellierController extends Controller
{
    /**
     * afficher la liste des celliers
     */

    public function index()
    {
        // stocker l'id de l'utilisateur connecté
        $cellierId = request("id");
       
        // récupérer les bouteilles du cellier de l'utilisateur connecté
        $cellier = Cellier::findOrFail($cellierId);
        //recuperer le nom du cellier
        $nomCellier = $cellier->nom_cellier;
        
        // récupérer les bouteilles du cellier de l'utilisateur connecté
        $bouteilleCelliers = BouteilleCellier::where(
            "cellier_id",
            $cellierId,
        )->get();
        // dd($cellierId);
        // retourner la vue monCellier avec les bouteilles du cellier de l'utilisateur connecté
        return view(
            "cellier.monCellier",
            compact("bouteilleCelliers", "cellier", "cellierId", "nomCellier"),
        );
    }

    /**
     * afficher la page pour créer un nouveau cellier
     */
    public function create()
    {
        return view("cellier.addCellier");
    }

    /**
     * fonction pour stocker un nouveau cellier dans la base de données
     */
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $request->validate(
            [
                "nom_cellier" => "required|max:10|min:1|unique:celliers,nom_cellier,NULL,id,user_id," . auth()->user()->id,

            ],
            [
                "nom_cellier.required" => "Veuillez entrer un nom de cellier.",
                "nom_cellier.max" => "Le nom du cellier ne doit pas dépasser 10 caractères.",
                "nom_cellier.min" => "Le nom du cellier doit contenir au moins 1 caractère.",
                "nom_cellier.unique" => "Ce nom de cellier existe déjà.",

            ],
        );

        // Créer un nouveau cellier dans la base de données
        $cellier = new Cellier();
        $cellier->nom_cellier = $request->input("nom_cellier");
        $cellier->user_id = auth()->user()->id;
        $cellier->save();
        // Rediriger vers la page d'accueil avec un message de succès
        return redirect()
            ->route("home")
            ->withSuccess("Cellier enregistré.");
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
        // trouver le cellier avec l'id du cellier sélectionné
        $cellier = Cellier::findOrFail($id);
        // retourner vers la vue modifyCellier
        return view("cellier.modifyCellier", compact("cellier"));
    }
    /**
     * mettre à jour le cellier sélectionné
     */
    public function update(Request $request, string $id)
    {
        // trouver le cellier avec l'id du cellier sélectionné
        $cellier = Cellier::findOrFail($id);
        // validation des données du formulaire
        $request->validate(
            [
                "nom_cellier" => "required|max:10|min:1|unique:celliers,nom_cellier," . $cellier->id . ",id,user_id," . auth()->user()->id,

            ],
            [
                "nom_cellier.required" => "Le champ nom_cellier est requis.",
                "nom_cellier.max" => "Le nom du cellier ne doit pas dépasser 10 caractères.",
                "nom_cellier.min" => "Le nom du cellier doit contenir au moins 1 caractère.",
                "nom_cellier.unique" => "Ce nom de cellier existe déjà.",

            ],
        );
        

        // mettre à jour le cellier dans la base de données
        $cellier->nom_cellier = $request->input("nom_cellier");
        $cellier->save();
        // redirection vers la page d'accueil avec un message de succès
        return redirect()
            ->route("home")
            ->withSuccess("Cellier modifié.");
    }

    /**
     * suppression du cellier sélectionné
     */
    public function destroy(Request $request, string $id)
    {   //get all the id's bottles in the cellar
        $bouteilleCelliers = BouteilleCellier::where(
            "cellier_id",
            $id,
        )->get();
        // ici on supprime les notes de la bouteille
        foreach ($bouteilleCelliers as $bouteilleCellier) {
            // dd($bouteilleCellier->id);
            Note::where("bouteille_cellier_id", $bouteilleCellier->id)->delete();
        }
        // Supprimer les bouteilles du cellier de la base de données
        BouteilleCellier::where("cellier_id", $id)->delete();
        // Supprimer le cellier de la base de données
        Cellier::destroy($id);
        // Rediriger vers la page d'accueil avec un message de succès
        return redirect()
            ->route("home")
            ->withSuccess("Cellier supprimé.");
    }
    
}
