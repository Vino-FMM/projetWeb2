@extends('layouts.app')
@section('title', 'ajouter une bouteille')
@section('titleHeader', 'ajouter une bouteille')
@section('content')
    <main>
        <div class="header">
            <h4>Details bouteille</h4> 
        </div> 
        <div class="container-bouteilles">
                <div class="carte-bouteille carte-modification">
                    <div>
                        <img src="{{ $bouteille->url_img }}" alt="{{ $bouteille->nom }}" style="max-width: 100%; height: auto;">
                    </div>
                    
                    <div class="carte-details">
                        <h4>{{ $bouteille->nom }}</h4>
                        <small>{{ $bouteille->type }} | {{ $bouteille->format }} | {{ $bouteille->pays }}</small>
                        <small>{{ $bouteille->prix }} $</small>
                        <div>
                        <form method="POST" action="{{ route('bouteilles.addBouteille', ['id' => $bouteille->id]) }}">
                                @csrf
                                <input type="hidden" name="cellier_id" value="{{ $cellier_id }}">
                                <div class='container-incrementation'>
                                    <label for="quantite"><small>Qté: </small></label>
                                    <button type="button" onclick="decrementQuantity(this.parentElement)">-</button>
                                    <input id="quantity-input" type="number" name="quantite" value="1" min="1" max="99" class="quantite">
                                    <button type="button" onclick="incrementQuantity(this.parentElement)">+</button>
                                </div>

                                <button type="submit" class="bouton ajout-bouteille">Ajouter</button>
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
        <span>Ajout cellier</span>
    </div>
    <div>
    <a href="{{route('bouteilles.rechercheFooterBouteille')}}"><img src="https://s2.svgbox.net/octicons.svg?ic=search&color=000" width="22" height="22"></a>
        <span>Recherche</span>
    </div>
</footer>
@endsection
<script>
    function decrementQuantity(parent) {
        const input = parent.querySelector('input');
        const currentValue = Number(input.value);
        if (currentValue > 1) {
            input.value = currentValue - 1;
        }
    }

    function incrementQuantity(parent) {
        const input = parent.querySelector('input');
        const currentValue = Number(input.value);
        if (currentValue < 99) {
            input.value = currentValue + 1;
        }
    }
</script>