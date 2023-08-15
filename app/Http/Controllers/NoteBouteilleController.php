<?php

namespace App\Http\Controllers;
use App\Models\Cellier;
use App\Models\Bouteille;
use App\Models\BouteilleCellier;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class NoteBouteilleController extends Controller
{
           public function destroyNote(Request $request)
    {
        // trouver la note
        $note = Note::findOrFail(request()->input('id_note'));
        $note->delete();
        return back()->withSuccess("Votre note a été supprimée avec succès.");
    }

    public function listeNote(Request $request)
    {
        $notes = Note::where('bouteille_cellier_id', $request->input('bouteille_cellier_id'))
        ->select('id', 'text')
        ->get()
        ->toArray();
        $bouteille = BouteilleCellier::findOrFail($request->input('bouteille_cellier_id'));
        $cellier_id = $request->input('cellier_id');
        return view('notes.note', compact('bouteille', 'cellier_id', 'notes'));
    }

    // Route::post('/bouteilles/ajouterNote', [BouteilleController::class, 'ajouterNote'])->name('bouteilles.ajouterNote');
    public function ajouterNote(Request $request)
    {
        // dd($request->all());
        //validation
        $request->validate([
            'note' => 'required|min:2|max:40',
        ],
        [
            'note.required' => 'Le champ note est requis',
            'note.min' => 'Le champ note doit avoir au moins 2 caractères',
            'note.max' => 'Le champ note doit avoir au plus 40 caractères',
        ]
    );
        // trouver les elements pour la vue
        $bouteille = BouteilleCellier::findOrFail($request->input('id_bouteille'));
        $cellier_id = $request->input('cellier_id');
        $notes = Note::where('bouteille_cellier_id', $request->input('id_bouteille'))
        ->select('id', 'text')
        ->get();
        // dd($notes);
        // ici on ajoute la note
        $note = new Note();
        $note->text = $request->input('note');
        $note->bouteille_cellier_id = $request->input('id_bouteille');
        $note->save();

        // Redirigez vers la méthode qui affiche la liste des notes
    return redirect()->action(
    [NoteBouteilleController::class, 'listeNote'],
    ['bouteille_cellier_id' => $bouteille->id, 'cellier_id' => $cellier_id]
    )->withSuccess("Votre note a été ajoutée avec succès.");

    }
}
