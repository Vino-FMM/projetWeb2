<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\CellierController;
use App\Http\Controllers\SAQController;
use App\Http\Controllers\BouteilleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcomee');
// });


Route::middleware(['auth'])->group(function () {
    //les pages d'accueil
    Route::get('/', function () {
        return view('welcomee');
    })->name('home');

    Route::get('/home', function () {
        return view('welcomee');
    })->name('home');

    // pour ce deconnecter
    Route::get('/logout', [CustomAuthController::class, 'logout'])->name('logout');

    // pour ajouter un cellier
    Route::get('AjouterCellier', [CellierController::class, 'create'])->name('cellier.create');
    // pour modifier un cellier
    Route::get('ModifierCellier/{id}', [CellierController::class, 'edit'])->name('cellier.edit');
    // pour modifier un cellier
    Route::put('ModifierCellier/{id}', [CellierController::class, 'update'])->name('cellier.update');
    //pour supprimer un cellier
    Route::delete('AjouterCellier/{id}', [CellierController::class, 'destroy'])->name('cellier.destroy');
    Route::post('AjouterCellier', [CellierController::class, 'store'])->name('cellier.store');

    // pour ajouter une bouteille dans un cellier
    Route::get('/Ajouter-bouteilles/{cellier_id}', [BouteilleController::class, 'index'])->name('Ajouter-bouteilles');
    Route::get('/Ajouter-bouteille-manuellement/{cellier_id}', [BouteilleController::class, 'AjouterbouteilleManuellement'])->name('Ajouter-bouteille-manuellement');
    Route::post('/addBouteilleManuellementPost', [BouteilleController::class, 'addBouteilleManuellementPost'])->name('addBouteilleManuellementPost');
    Route::post('/bouteilles/addBouteille/{id}', [BouteilleController::class, 'addBouteille'])->name('bouteilles.addBouteille');

    //pour supprimer une bouteille dans un cellier
    Route::delete('bouteilles/{id}', [BouteilleController::class, 'destroy'])->name('bouteilles.destroy');


    // pour voir les bouteilles d'un cellier
    Route::get('/mon-cellier', [CellierController::class, 'index'])->name('mon-cellier');

    //pour modifier la quantité d'une bouteille dans un cellier
    Route::get('modifierQte/{bouteille_id}', [BouteilleController::class, 'modifierBouteille'])->name('modifier-Qte');
    Route::post('modifierQte/{bouteille_id}', [BouteilleController::class, 'modifierQteBouteille'])->name('modifier-Qte');

});

// pour ce connecter
Route::get('/login', [CustomAuthController::class, 'index'])->name('login');
Route::post('/login', [CustomAuthController::class, 'authentication'])->name('login.authentication');
// pour s'enregistrer
Route::get('/register', [CustomAuthController::class, 'create'])->name('register');
Route::post('/register', [CustomAuthController::class, 'store'])->name('register.store');


// pour faire un fetch des bouteille de la SAQ
Route::get('/import', 'App\Http\Controllers\SAQController@import');
// Route::get('/bouteilles/search', 'BouteilleController@search')->name('bouteilles.search');
Route::get('/bouteilles/search', [BouteilleController::class, 'search'])->name('bouteilles.search');


Route::get('/bouteilles/addBouteilleSearch/{id}', [BouteilleController::class, 'addBouteilleSearch'])->name('bouteilles.addBouteilleSearch');

//trouver les bouteilles par filtre
Route::get('/bouteilles/filter/{cellier_id}', [BouteilleController::class, 'filter'])->name('bouteilles.filter');

//route vers {{ route('notes.liste
Route::get('/notes/listeNote', [BouteilleController::class, 'listeNote'])->name('notes.listeNote');
// POST('bouteilles.ajouterNote', ['id_bouteille' => $bouteille->id, 'cellier_id' => $cellier_id]) }}">
Route::post('/bouteilles/ajouterNote', [BouteilleController::class, 'ajouterNote'])->name('bouteilles.ajouterNote');