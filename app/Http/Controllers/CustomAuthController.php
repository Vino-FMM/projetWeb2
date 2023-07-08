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

}