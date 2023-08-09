@extends('layouts.app')
@section('title', 'Login')
@section('titleHeader', 'Login')
@section('content')

<section>
    <div class="header">
        <h4 id="connexion">S'enregistrer</h4>
    </div>
    <div class="formulaire-container">
        <div class="formulaire_connexion"> 
            <form action="/register" method="post">
                @csrf
                <!-- Name input-->
                <div>
                    <input id="nom" type="text" name="nom" placeholder="Nom" value="{{old('nom')}}" />
                    <!-- <label for="name">Last name</label> -->
                    @if ($errors->has('name'))
                        <div>
                            {{$errors->first('name')}}
                        </div>
                    @endif
                </div>

                <div>
                    <input id="prenom" type="text" name="prenom" placeholder="Prénom" value="{{old('prenom')}}" />
                    <!-- <label for="prenom">First name</label> -->
                    @if ($errors->has('name'))
                        <div>
                            {{$errors->first('name')}}
                        </div>
                    @endif
                </div>

                <!-- Email address input-->
                <div>
                    <input id="email" type="email" name="email" placeholder="nom@exemple.com" value="{{old('email')}}" />
                    <!-- <label for="email">Email address</label> -->
                    @if ($errors->has('email'))
                        <div>
                            {{$errors->first('email')}}
                        </div>
                    @endif
                </div>

                <!-- Password input-->
                <div>
                    <input id="password" name="password" type="password" placeholder="Mot de passe"  />
                    <!-- <label for="password">Password</label> -->
                    @if ($errors->has('password'))
                        <div>
                            {{$errors->first('password')}}
                        </div>
                    @endif
                </div>

                <!-- date of birth input-->
                <!-- <div>
                    <input id="date_of_birth" type="date" name="date_naissance" placeholder="Date de naissance" />
                    @if ($errors->has('date_of_birth'))
                        <div>
                            {{$errors->first('date_of_birth')}}
                        </div>
                    @endif
                </div> -->

                    <!-- Submit Button-->
                    <button id="Login" type="submit" class="bouton">S'enregistrer</button>
            </form> 
        </div>
        <section>
            <a href="{{ route('login') }}">J'ai déja un compte</a>
        </section>
        <div class="img-login">
            <img src="{{ asset('assets/img/bouteilles.png') }}" alt="bouteille" class="img-accueil1">
        </div>
    </div>     
</section>

@endsection
