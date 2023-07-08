<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});
// la page d'accueil
Route::get('/home', function () {
    return view('welcomee');
})->name('home');

// la page de login
Route::get('/login', [CustomAuthController::class, 'index'])->name('login');
Route::post('/login', [CustomAuthController::class, 'authentication'])->name('login.authentication');
// la page d'inscription
Route::get('/register', [CustomAuthController::class, 'create'])->name('register');
Route::post('/register', [CustomAuthController::class, 'store'])->name('register.store');
// logout
Route::get('/logout', [CustomAuthController::class, 'logout'])->name('logout');
