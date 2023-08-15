<?php

namespace App\Http\Controllers;

use App\Models\Cellier;
use App\Models\Bouteille;
use App\Models\BouteilleCellier;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class BouteilleController extends Controller
{
    //afficher la liste des bouteilles dans la base de données
    public function index($cellier_id)
    {
       
        // $user_id = auth()->user()->id;
        // dd($user_id);
        // dd($cellier_id);
        //faire un fetch de toutes les bouteilles
        $bottles = Bouteille::all();
        // trouver les bouteilles du cellier
        if ($cellier_id == 0) {
            $mon_cellier = Cellier::findOrFail(1);
            $mon_cellier->id = 0;
            $mon_cellier->nom_cellier = "aucun cellier";
            $owned_bottles = [];
        } else {
            $owned_bottles = BouteilleCellier::where('cellier_id', $cellier_id)
                ->pluck('code_saq_bouteille')
                ->toArray();
            //trouver mon cellier
            $mon_cellier = Cellier::findOrFail($cellier_id);
            // dd($mon_cellier);
        }


        //faire la pagination par 10
        $bottles = Bouteille::paginate(10);

       // Trouver les pays, millésimes, et types distincts
        $countries = Bouteille::distinct()->pluck('pays');
        $millesimes = Bouteille::whereBetween('millesime', [1900, 3000])
            ->distinct()
            ->orderBy('millesime', 'asc')
            ->pluck('millesime');
        $types = Bouteille::distinct()->pluck('type');

        // Combiner les filtres
        $filters_elements = [
            'countries' => $countries,
            'millesimes' => $millesimes,
            'types' => $types,
        ];
        // retourner la vue index avec les bouteilles
        return view('bouteilles.AjouterBouteilles', ['bottles' => $bottles, 'owned_bottles' => $owned_bottles, 'cellier_id' => $cellier_id, 'mon_cellier' => $mon_cellier, 'filters_elements' => $filters_elements]);
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
    // Lire le contenu du fichier JSON qui contient les pays
    $jsonFilePath = base_path('public/Json/pays.json');
    $paysJson = file_get_contents($jsonFilePath);
    
    // Convertir le contenu JSON en tableau associatif
    $paysArray = json_decode($paysJson, true);
        // renvoyer vers la vue addBouteilleManuellement
        return view('bouteilles.addBouteilleManuellement', compact('cellier_id', 'paysArray'));
    }

    public function addBouteilleManuellementPost(Request $request)
    {
        $request->validate([
            'file' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            'pays' => 'required',
            'Titre' => 'required|max:30',
            'prix' => 'required|numeric',
        ], [
            'Titre.required' => 'Veuillez entrer un titre de bouteille.',
            'Titre.max' => 'Le champ Titre ne doit pas dépasser 30 caractères.',
            'prix.required' => 'Le champ Prix est obligatoire.',
            'prix.numeric' => 'Le champ Prix doit être un nombre.',
        ]);
        // dd($request->all());
        // ajouter une bouteille dans Bouteille cellier
        $bouteilleCellier = new BouteilleCellier();
        $bouteilleCellier->user_id = auth()->user()->id;
        $bouteilleCellier->cellier_id = $request->input('cellier_id');
        $bouteilleCellier->quantite = $request->input('quantite');
        $bouteilleCellier->nom_bouteille = $request->input('Titre');
        $bouteilleCellier->format_bouteille = $request->input('format');
        $bouteilleCellier->prix_bouteille = $request->input('prix');
        $bouteilleCellier->pays_bouteille = $request->input('pays');
        //pour l'image on va prendre celle dans le file
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $path = $file->store('assets/persoBouteilles');
            //si on a une image on va la mettre dans le dossier assets/files et on va mettre le chemin dans la base de données
            $bouteilleCellier->url_img_bouteille = $path;
            // dd($path);
        } else {
            //sinon on va mettre l'image par défaut
            $bouteilleCellier->url_img_bouteille = "https://media.istockphoto.com/id/694772120/vector/mockup-wine-bottle-vector-design.jpg?s=612x612&w=0&k=20&c=bkIy1HaSE8WtgBVwmC3oTrKDidCRLbtvsAi2Tlg6098=";
        }
        
        $bouteilleCellier->type_bouteille = $request->input('type');
        $bouteilleCellier->save();
        
        $bouteilleCelliers = BouteilleCellier::where(
            "cellier_id",
            $bouteilleCellier->cellier_id,
        )->get();
    
        // trouver le cellier avec l'id du cellier sélectionné
        $cellier = Cellier::findOrFail($bouteilleCellier->cellier_id);
        // nom du cellier
        $nomCellier = $cellier->nom_cellier;
        // retourner vers la vue monCellier

        return view(
            "cellier.monCellier",
            compact("bouteilleCelliers", "cellier", "nomCellier"),
        )->with("success", "Bouteille ajoutée au cellier.");
    }

        public function destroy(Request $request,string $id)
    {
        
        // Supprimer les notes de la bouteille du cellier en utilisant input->"id_bouteille"
        Note::where('bouteille_cellier_id', $request->input('id_bouteille'))->delete();
        // Supprimer la bouteille du cellier de la base de données
        BouteilleCellier::destroy($id);
        // stocker l'id du cellier
        $cellierId = $request->input('cellier_id');
        // Trouver les bouteilles du cellier
        $bouteilleCelliers = BouteilleCellier::where('cellier_id', $cellierId)->get();
        // Trouver le cellier avec l'id du cellier sélectionné
        $cellier = Cellier::findOrFail($cellierId);
        // Nom du cellier
        $nomCellier = $request->input('nomCellier');
        // Retourner vers la vue monCellier
        return view('cellier.monCellier', compact('bouteilleCelliers', 'cellier', 'nomCellier'))->with('success', 'Bouteille supprimée du cellier.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $bottles = Bouteille::where('nom', 'LIKE', "%$query%")

            ->get();

        return response()->json($bottles);
    }

    public function addBouteilleSearch($id, Request $request)
{
    // dd($request->input('cellier_id'));
    $bottle = Bouteille::findOrFail($id);
    $cellier_id = $request->input('cellier_id');
    // Retrieve the bottle with the given ID from the database
    $bottle = Bouteille::findOrFail($id);

    // Retrieve the cellier_id from the request
    $cellierId = $request->query('cellier_id');

    // Additional data retrieval if needed (e.g., cellier details)

    // Return the view with the bottle details and cellier_id
    return view('bouteilles.addBouteilleSearch', ['bouteille' => $bottle, 'cellier_id' => $cellierId]);
}

// pour le filtre de recherche
public function filter(Request $request, $cellier_id)
{
    
    $bottles = Bouteille::query();
    
    if($request->input('price') !== null){
        if ($request->has('price')) {
            if ($request->price === 'asc') {
                $bottles->orderBy('prix', 'asc');
            } elseif ($request->price === 'desc') {
                $bottles->orderBy('prix', 'desc');
            }
        }
    }
    // Apply 'country' filter
    if($request->input('country') !== null){

        if ($request->has('country') && $request->country !== '') {
            $bottles->where('pays', $request->country);
        }
    }
 

    // Apply 'millesime' filter
    if($request->input('millesime') !== null){
        if ($request->has('millesime') && $request->millesime !== '') {
            $bottles->where('millesime', $request->millesime);
        }
    }

    // Apply 'type' filter
    if($request->input('type') !== null){
        if ($request->has('type') && $request->type !== '') {
            $bottles->where('type', $request->type);
        }
    }
            // trouver les bouteilles du cellier
            $owned_bottles = BouteilleCellier::where('cellier_id', $cellier_id)
            ->pluck('code_saq_bouteille')
            ->toArray();
            //trouver mon cellier
            $mon_cellier = Cellier::findorFail($cellier_id);
            // dd($bottles->toSql());
            $bottles = $bottles->paginate(10);

          // Trouver les pays, millésimes, et types distincts
          $countries = Bouteille::distinct()->pluck('pays');
          $millesimes = Bouteille::whereBetween('millesime', [1900, 3000])
            ->distinct()
            ->orderBy('millesime', 'asc')
            ->pluck('millesime');
          $types = Bouteille::distinct()->pluck('type');
  
          // Combiner les filtres
          $filters_elements = [
              'countries' => $countries,
              'millesimes' => $millesimes,
              'types' => $types,
          ];
          // retourner la vue index avec les bouteilles
          return view('bouteilles.AjouterBouteilles', ['bottles' => $bottles, 'owned_bottles' => $owned_bottles, 'cellier_id' => $cellier_id, 'mon_cellier' => $mon_cellier, 'filters_elements' => $filters_elements]);
      }
    //   ajouterNote


   

}

