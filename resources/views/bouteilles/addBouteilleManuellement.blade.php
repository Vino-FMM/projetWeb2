@extends('layouts.app')
@section('title', 'Ajouter Bouteille Manuellement')
@section('titleHeader', 'Ajouter Bouteille Manuellement')
@section('content')
<main>
<div class="header">
        <h3 id="connexion">Ajouter une bouteille personnalisée</h3>
    </div>
    <div class="formulaire-container">
        <div class="formulaire_connexion"> 
            <form action="/addBouteilleManuellementPost" class="form_bouteille_personnalisee" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="cellier_id" value="{{ $cellier_id }}">
                <div>
                    <input id="Titre" type="text" name="Titre" placeholder="Titre" value="{{old('titre')}}" />
                    @if ($errors->has('Titre'))
                        <div>
                            {{$errors->first('Titre')}}
                        </div>
                    @endif
                </div>
                <div>
                    <input id="prix" type="text" name="prix" placeholder="prix" value="{{old('prix')}}" />
                    @if ($errors->has('prix'))
                        <div>
                            {{$errors->first('prix')}}
                        </div>
                    @endif
                </div>
                <div>
                    Format bouteille :
                    <select name="format">
                        <option value="750ml">750ml</option>
                        <option value="1L">1L</option>
                        <option value="1.5L">1.5L</option>
                    </select> 
                </div>
                <div>
                    type de vin :
                    <select name="type">
                        <option value="Rouge">Rouge</option>
                        <option value="Blanc">Blanc</option>
                        <option value="Rosé">Rosé</option>
                    </select> 
                </div>
                <div>
                    pays:
                    <select name="pays">
                    @foreach ($paysArray['pays'] as $pays)
                        <option value="{{ $pays }}">{{ $pays }}</option>
                    @endforeach
                    </select> 
                </div>
                <div class='container-incrementation'>
                    <label for="quantite">Qté: </label>
                    <button type="button" onclick="decrementQuantity(this.parentElement)">-</button>
                    <input id="quantity-input" type="number" name="quantite" value="1" min="1" max="99" class="quantite">
                    <button type="button" onclick="incrementQuantity(this.parentElement)">+</button>
                </div>
                <!-- <div class="form-group">
                    <label for="file">Image:</label><br><br>
                    <input type="file" name="file" id="file" class="form-control-file">
                </div> -->
                <button type="submit" class="bouton">Ajouter</button>
            </form>
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
        
<script>
    const searchInput = document.getElementById('search-input');
    const searchResults = document.getElementById('search-results');

    searchInput.addEventListener('input', function() {
        const query = searchInput.value;
        if (query.length > 1) {
            fetch(`/search?q=${query}`)
                .then(response => response.json())
                .then(data => {
                    searchResults.innerHTML = '';
                    data.forEach(bottle => {
                        const result = document.createElement('div');
                        result.classList.add('search-result');
                        result.innerHTML = `
                            <div class="cercle
                                ${bottle.type === 'Vin rouge' ? 'cercle-rouge' : (bottle.type === 'Vin blanc' ? 'cercle-doré' : (bottle.type === 'Vin rosé' ? 'cercle-rose' : (bottle.type === 'Vin de tomate' ? 'cercle-tomate' : (bottle.type === 'Vin de dessert' ? 'cercle-bleu' : ''))))}">
                            </div>
                            <div class="search-result-details">
                                <h4>${bottle.nom}</h4>
                                <small>${bottle.type} | ${bottle.format} | ${bottle.pays}</small>
                                <small>prix: ${bottle.prix} $</small>
                                <small>code SAQ: ${bottle.code_saq}</small>
                            </div>
                        `;
                        searchResults.appendChild(result);
                    });
                });
        } else {
            searchResults.innerHTML = '';
        }
    });

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
@endsection