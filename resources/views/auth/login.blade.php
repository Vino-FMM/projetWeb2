@extends('layouts.app')
@section('title', 'Login')
@section('titleHeader', 'Login')
@section('content')


<section>
        <div class="header">
            <h4 id="connexion">Se connecter</h4>
        </div>
        <div class="formulaire-container">
            <div class="formulaire_connexion">
                <form action="{{route('login.authentication')}}" method="post">
                    @csrf
                    <!-- Email address input-->
                    <div>
                        <input id="email" type="email" name="email" placeholder="courriel" value="{{old('email')}}" />
                        <!-- <label for="email">Email address</label> -->
                        @if ($errors->has('email'))
                            <div class="alert-validation">
                                {{$errors->first('email')}}
                            </div>
                        @endif
                    </div>

                    <!-- Password input-->
                    <div>
                        <input id="password" type="password" name="password" placeholder="mot de passe" />
                        <!-- <label for="password">Password</label> -->
                        @if ($errors->has('password'))
                            <div class="alert-validation">
                                {{$errors->first('password')}}
                            </div>
                        @endif
                    </div>

                    <!-- Submit Button-->
                    <button id="Login" type="submit" class="bouton">
                        Se connecter <i class="fas fa-lock"></i>
                    </button>
                </form>
            </div>
            <div>
                <a href="{{ route('register') }}">Créer mon compte</a>
            </div>   
        </div>
        <img src="{{ asset('assets/img/bouteilles.png') }}" alt="bouteille" class="img-accueil1">         
</section>

@endsection
