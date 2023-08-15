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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.registration');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //  dd($request->all());
        $request->validate([
            'nom' => 'required|min:2|max:20|alpha',
            'prenom' => 'required|min:2|max:20|alpha',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ],
        [
            'nom.required' => 'Veuillez saisir votre nom',
            'nom.min' => 'Votre nom doit contenir au moins 2 caractères',
            'nom.max' => 'Votre nom ne doit pas dépasser 20 caractères',
            'nom.alpha' => 'Votre nom ne doit contenir que des lettres',
            'prenom.required' => 'Veuillez saisir votre prenom',
            'prenom.min' => 'Votre prenom doit contenir au moins 2 caractères',
            'prenom.max' => 'Votre prenom ne doit pas dépasser 20 caractères',
            'prenom.alpha' => 'Votre prenom ne doit contenir que des lettres',
            'email.required' => 'Veuillez saisir votre adresse email',
            'password.required' => 'Veuillez saisir votre mot de passe',
            'password.min' => 'Votre mot de passe doit contenir au moins 6 caractères',
        ]
    );

        $user = new User;
        $user->nom = $request->input('nom');
        $user->prenom = $request->input('prenom');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        // $user->date_naissance = $request->input('date_naissance');
        $user->save();
       return redirect(route('login'))->withSuccess('utilisateur enregistré');
    }

    public function authentication(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required'
        ], [
            
            'email.required' => 'Veuillez saisir votre adresse email',
            'password.required' => 'Veuillez saisir votre mot de passe',
            ]
        );
    
        $credentials = $request->only('email', 'password');
        // dd($credentials);
    // dd(Auth::validate($credentials)
    // );
        if (!Auth::validate($credentials)) {
            return redirect('login')
                ->withErrors([
                    'email' => 'ladresse email ou le mot de passe est incorrect'
                ])
                ->withInput();
        }
    
        $user = Auth::getProvider()->retrieveByCredentials($credentials);
    
        Auth::login($user, $request->get('remember'));
    

            return redirect()->route('home')->with('success', 'Vous êtes connectés')->with('name', $user->nom);
            
    }
    

    public function logout(){
        Auth::logout();
        Session::flush();
        return redirect(route('login'))->withSuccess('Vous êtes déconnectés');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

}