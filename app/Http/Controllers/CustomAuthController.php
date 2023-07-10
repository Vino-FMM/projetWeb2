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

    // fonction store pour enregistrer un user
    public function store(Request $request)
    {
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

    // finction Authentification pour se connecter
    public function authentication(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|min:6|max:20'
        ]);
    
        $credentials = $request->only('email', 'password');
        
        if (!Auth::validate($credentials)) {
            return redirect('login')
                ->withErrors([
                    'email' => 'Invalid credentials'
                ])
                ->withInput();
        }
    
        $user = Auth::getProvider()->retrieveByCredentials($credentials);
    
        Auth::login($user, $request->get('remember'));
    

            return redirect()->route('home')->with('success', 'Signed in successfully')->with('name', $user->nom);
            
    }

    // fonction logout pour se deconnecter
    public function logout(){
        Auth::logout();
        Session::flush();
        return redirect(route('login'))->withSuccess('Logged out');
    }

}