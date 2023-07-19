@extends('layouts.app')
@section('title', 'Ajouter un cellier')
@section('titleHeader', 'Ajouter un cellier')
@section('content')

<main>
    <div class="header">
        <h2>Ajouter un cellier</h2>
    </div>        
    <div class="carte-ajout">
        <div class="formulaire_connexion">
            <form action="{{route('cellier.store')}}" method="post" >
                @csrf
                    <div>
                        <input id="nom_cellier" type="text" name="nom_cellier" placeholder="Nom du cellier" value="{{old('nom_cellier')}}" />
                        <!-- <label for="nom_cellier">nom_cellier</label> -->
                        @if ($errors->has('nom_cellier'))
                            <div>
                                {{$errors->first('nom_cellier')}}
                            </div>
                        @endif
                    </div>
                    <!-- Submit Button-->
                    <button id="Login" type="submit" class="bouton">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
</main>
<footer>
    <div>
        <a href="{{ route('home') }}"><img src="https://s2.svgbox.net/octicons.svg?ic=home&color=000" width="22" height="22"></a>
        <span>Acueil</span>
    </div>
    <div>
    <a href="{{route('cellier.create')}}"><img src="https://s2.svgbox.net/hero-outline.svg?ic=plus-sm&color=000000" width="22" height="22"></a>
        <span>Ajout</span>
    </div>
    <!-- <div>
    <img src="https://s2.svgbox.net/octicons.svg?ic=search&color=000" width="32" height="32">
        <span>Recherche</span>
    </div>
    <div>
    <img src="https://s2.svgbox.net/materialui.svg?ic=list&color=000" width="32" height="32">
        <span>Liste</span>
    </div> -->
</footer>
@endsection
