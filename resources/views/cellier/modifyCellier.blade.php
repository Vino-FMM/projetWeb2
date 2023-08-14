@extends('layouts.app')
@section('title', 'Modifier un cellier')
@section('titleHeader', 'Modifier un cellier')
@section('content')

<main>
    <div class="header">
        <h4>Modifier un cellier</h4>
    </div>
    <div class="carte-ajout">
        <div class="formulaire_connexion">
                <form action="{{ route('cellier.update', $cellier->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div>
                        <input id="nom_cellier" type="text" name="nom_cellier" placeholder="Nom Cellier" value="{{ $cellier->nom_cellier }}" />
                        <!-- <label for="nom_cellier">Nom Cellier</label> -->
                        @if ($errors->has('nom_cellier'))
                            <div>
                                {{ $errors->first('nom_cellier') }}
                            </div>
                        @endif
                    </div>
                    <!-- Submit Button-->
                    <button id="Login" type="submit" class="bouton">Modifier</button>
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
        <span>Ajout cellier</span>
    </div>
    <div>
        <a href=""><img src="https://s2.svgbox.net/octicons.svg?ic=search&color=000" width="22" height="22"></a>
        <span>Recherche</span>
    </div>
</footer>
@endsection
