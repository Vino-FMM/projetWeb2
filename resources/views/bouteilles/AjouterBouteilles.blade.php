@extends('layouts.app')
@section('title', 'Liste des bouteilles')
@section('content')

    <main>
        <div class="header">
            <h4>Liste des bouteilles</h4>
            <small>cellier: {{ $mon_cellier->nom_cellier }}</small>
        </div>
        <a href="{{ route('Ajouter-bouteille-manuellement', ['cellier_id' => $mon_cellier->id]) }}">Ajouter une bouteille manuellement</a> 
            <div class="container-recherche">
                <input type="text" id="searchInput" placeholder="Rechercher une bouteille" >
                <div id="searchResults"></div>
            </div>
            <div class="filter-container">
                <form class="filter">
                    <div><small class="close">X</small></div>
                    <div>
                        <div class="form-group">
                            <label for="price">Price:</label>
                            <select id="price" name="price">
                                <option value="">Any</option>
                                <option value="asc">Low to high</option>
                                <option value="desc">High to low</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="country">Country:</label>
                            <select id="country" name="country">
                                <option value="">Any</option>
                                <option value="france">France</option>
                                <option value="italy">Italy</option>
                                <option value="spain">Spain</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="millisime">Millisime:</label>
                            <select id="millisime" name="millisime">
                                <option value="">Any</option>
                                <option value="2010">2010</option>
                                <option value="2011">2011</option>
                                <option value="2012">2012</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="type">Type:</label>
                            <select id="type" name="type">
                                <option value="">Any</option>
                                <option value="red">Red</option>
                                <option value="white">White</option>
                                <option value="rose">Rosé</option>
                            </select>
                        </div>
                        <button type="submit" class="bouton">appliquer le filtre</button>
                    </div>
                </form>
                <a class="toggle-filter" href="#"><img src='https://s2.svgbox.net/materialui.svg?ic=filter_alt'></a>
            </div>
            <div class="container-bouteilles">
        @foreach($bottles as $bottle)
        <div class="carte-bouteille">
            <div>
                <div class="cercle
                    {{ $bottle->type === 'Vin rouge' ? 'cercle-rouge' : ($bottle->type === 'Vin blanc' ? 'cercle-doré' : ($bottle->type === 'Vin rosé' ? 'cercle-rose' : ($bottle->type === 'Vin de tomate' ? 'cercle-tomate' : ($bottle->type === 'Vin de dessert' ? 'cercle-bleu' : '')))) }}">
                </div>
                <img src="{{ $bottle->url_img }}" alt="{{ $bottle->nom }}" style="max-width: 100%; height: auto;">
            </div>  
            <div class="carte-details">
                <h4>{{ $bottle->nom }}</h4>
                <small>{{ $bottle->type }} | {{ $bottle->format }} | {{ $bottle->pays }}</small>
                <small> prix: {{ $bottle->prix }} $</small>
                <small>code SAQ: {{ $bottle->code_saq }}</small>
                <div>
                    <form method="POST" action="{{ route('bouteilles.addBouteille', ['id' => $bottle->id]) }}">
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
        @endforeach

        {{ $bottles->appends(request()->query())->links('vendor.pagination.custom') }}
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




// ====== script pour la recherche ======
document.addEventListener('DOMContentLoaded', function() {
    // Set up variables for the input and results container
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');

    // Function to update the search results container with the filtered data
    function updateResults(data) {
        searchResults.innerHTML = '';
        // Check if the query is empty
        const query = searchInput.value.trim();
        if (query === '') {
            return;
        }
        if (data.length > 0) {
            data.forEach((bottle) => {
                searchResults.insertAdjacentHTML('beforeend', `
                <div class="search-result" style="display: flex; align-items: center; padding: 0.5rem 1rem; border-bottom: 1px solid #ccc; cursor: pointer;" data-bottle-id="${bottle.id}" data-celler-id="{{ $mon_cellier->id }}" onmouseover="this.style.backgroundColor='#f2f2f2';" onmouseout="this.style.backgroundColor='transparent';" onclick="this.style.backgroundColor='rgb(214, 172, 172)'; this.style.transition='background-color 1s';">
                    <img src="${bottle.url_img_small}" alt="" style="max-width: 5%; height: auto;">
                    <h5>${bottle.nom}</h5>
                </div>
                `);
            });
        } else {
            searchResults.innerHTML = '<p>Aucun résultat.</p>';
        }
    }

    // Function to handle the search input change event
    searchInput.addEventListener('input', function() {
        const query = this.value;

        // Send an AJAX request to the search route with the query
        fetch(`/bouteilles/search?query=${query}`).then(response => response.json()).then(data => updateResults(data));
    });

    searchResults.addEventListener('click', function(event) {
    let targetElement = event.target;

    // Recherche récursive du parent avec la classe 'search-result'
    while (targetElement && !targetElement.classList.contains('search-result')) {
        targetElement = targetElement.parentElement;
    }

    if (targetElement) {
        // Extract the bottle ID and cellier ID from the clicked element's data attributes
        // Notez que nous utilisons camelCase ici pour correspondre aux attributs de données hyphenés
        const bottleId = targetElement.dataset.bottleId;
        const cellierId = targetElement.dataset.cellerId;

        // Redirect to the addBouteilleSearch view with the bottle ID and cellier ID as URL parameters
        window.location.href = `/bouteilles/addBouteilleSearch/${bottleId}?cellier_id=${cellierId}`;
    }
});


});



// ===== script pour le filtre =====
const filterContainer = document.querySelector('.filter-container');
const filter = filterContainer.querySelector('.filter');
const toggleFilter = filterContainer.querySelector('.toggle-filter');
const closeButton = filterContainer.querySelector('.close');

toggleFilter.addEventListener('click', function(event) {
    event.preventDefault();
    filter.classList.toggle('show');
    toggleFilter.classList.toggle('active');  

});
closeButton.addEventListener('click', function(event) {
    filter.classList.remove('show');
    toggleFilter.classList.remove('active');
});


</script>


@endsection