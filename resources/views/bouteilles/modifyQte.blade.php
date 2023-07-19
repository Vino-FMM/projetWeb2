@extends('layouts.app')
@section('title', 'modifier quantité')
@section('titleHeader', 'modifier quantité')
@section('content')
    <main>
        <div class="header">
            <h4>Modification bouteille</h4>  
        </div> 
        <div class="container-bouteilles">
                <div class="carte-bouteille carte-modification">
                    <div>
                        <img src="{{ $bouteilleCellier->url_img_bouteille }}" alt="{{ $bouteilleCellier->nom_bouteille }}" style="max-width: 100%; height: auto;">
                    </div>
                    
                    <div class="carte-details">
                        <h4>{{ $bouteilleCellier->nom_bouteille }}</h4>
                        <small>{{ $bouteilleCellier->type_bouteille }} | {{ $bouteilleCellier->format_bouteille }} | {{ $bouteilleCellier->pays_bouteille }}</small>
                        <small>{{ $bouteilleCellier->prix_bouteille }} $</small>
                        <div>
                            <form method="POST" action="{{ route('modifier-Qte', ['bouteille_id' => $bouteilleCellier->id]) }}">
                                @csrf
                                <input type="number" name="quantite" value="{{ $bouteilleCellier->quantite }}" min="1" max="99" class="quantite">
                                <button type="submit" class="bouton ajout-bouteille"><i class="bi bi-patch-plus"></i>Modifier</button>
                            </form>  
                        </div>
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