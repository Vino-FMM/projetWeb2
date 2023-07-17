<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\CellierController;
use App\Http\Controllers\SAQController;

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

Route::get('/', function () {
    return view('welcomee');
});
// Route::get('/home', function () {
//     return view('welcomee')->name('home');
// });
Route::get('/home', function () {
    return view('welcomee');
})->name('home');

// for login
Route::get('/login', [CustomAuthController::class, 'index'])->name('login');
Route::post('/login', [CustomAuthController::class, 'authentication'])->name('login.authentication');
// for register
Route::get('/register', [CustomAuthController::class, 'create'])->name('register');
Route::post('/register', [CustomAuthController::class, 'store'])->name('register.store');
// for logout
Route::get('/logout', [CustomAuthController::class, 'logout'])->name('logout');
//for cellier
Route::get('AjouterCellier', [CellierController::class, 'create'])->name('cellier.create');
//for modify cellier
Route::get('ModifierCellier/{id}', [CellierController::class, 'edit'])->name('cellier.edit');
//for update cellier
Route::put('ModifierCellier/{id}', [CellierController::class, 'update'])->name('cellier.update');
//for delete cellier
Route::delete('AjouterCellier/{id}', [CellierController::class, 'destroy'])->name('cellier.destroy');
Route::post('AjouterCellier', [CellierController::class, 'store'])->name('cellier.store');

Route::get('/import', 'App\Http\Controllers\SAQController@import');

Route::get('/Ajouter-bouteilles', [SAQController::class, 'index'])->name('Ajouter-bouteilles');
Route::post('/bouteilles/addBouteille/{id}', [CellierController::class, 'addBouteille'])->name('bouteilles.addBouteille');

Route::get('/mon-cellier', [CellierController::class, 'index'])->name('mon-cellier');