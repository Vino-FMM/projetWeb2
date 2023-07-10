<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Etudiant;

class CustomAuthController extends Controller
{
    // la page d'inscription
    public function index()
    {
        return view('auth.login');
    }
    // la page de login
    public function create()
    {
        return view('auth.registration');
    }

    public function store(Request $request)
    {

        //  dd($request);
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'date_naissance' => 'required|date',
        ]);

        $user = new User;
        $user->nom = $request->input('nom');
        $user->prenom = $request->input('prenom');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->date_naissance = $request->input('date_naissance');
        $user->save();
       return redirect(route('login'))->withSuccess('User enregistré');
    }

}