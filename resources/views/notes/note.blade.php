@extends('layouts.app')
@section('title', 'Note de la bouteille')
@section('titleHeader', 'Note de la bouteille')
@section('content')
    <main>
        <div class="header">
            <h4>Note</h4> 
        </div> 
        <div class="container-bouteilles">
                <div class="carte-bouteille carte-modification">
                    <div>
                        <img src="{{ $bouteille->url_img_bouteille }}" alt="{{ $bouteille->nom_bouteille }}" style="max-width: 100%; height: auto;">
                    </div>
                    
                    <div class="carte-details">
                        <h4>{{ $bouteille->nom_bouteille }}</h4>
                        <!-- <small>{{ $bouteille->type }} | {{ $bouteille->format }} | {{ $bouteille->pays }}</small>
                        <small>{{ $bouteille->prix }} $</small> -->
                        @if(!$notes->isEmpty())
                            <small>Notes:</small>
                            @foreach($notes as $note)
                                <p>{{ $note }}</p>
                            @endforeach
                        @else
                        <small>Vouz n'avez laissé aucune note pour cette bouteille</small>
                        @endif
                        
                        <form method="POST" action="{{ route('bouteilles.ajouterNote', ['id_bouteille' => $bouteille->id, 'cellier_id' => $cellier_id]) }}">
                                @csrf
                                <input type="text" name="note" placeholder="Ajouter une note" class="note">
                                <input type="hidden" name="cellier_id" value="{{ $cellier_id }}">
                                <!-- <div class='container-incrementation'>
                                    <label for="quantite"><small>Qté: </small></label>
                                    <button type="button" onclick="decrementQuantity(this.parentElement)">-</button>
                                    <input id="quantity-input" type="number" name="quantite" value="1" min="1" max="99" class="quantite">
                                    <button type="button" onclick="incrementQuantity(this.parentElement)">+</button>
                                </div> -->

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
        <a href=""><img src="https://s2.svgbox.net/octicons.svg?ic=search&color=000" width="22" height="22"></a>
        <span>Recherche</span>
    </div>
</footer>
@endsection
