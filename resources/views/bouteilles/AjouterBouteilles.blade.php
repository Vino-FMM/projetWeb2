@extends('layouts.app')
@section('title', 'Liste des bouteilles')
@section('content')

    <main>
        <div class="header">
            <h4>Liste des bouteilles</h4>
            <small>cellier: {{ $mon_cellier->nom_cellier }}</small>
        </div>
        <a href="{{ route('Ajouter-bouteille-manuellement', ['cellier_id' => $mon_cellier->id]) }}" id="lien-personnalisee">Ajouter une bouteille personnalisée<img src="https://s2.svgbox.net/hero-outline.svg?ic=cursor-click&color=000" width="22" height="22"></a> 
            <div class="container-recherche">
                <input type="text" id="searchInput" placeholder="Rechercher une bouteille" >
                <a class="toggle-filter input-filter-icon" href="#"><img src='https://s2.svgbox.net/materialui.svg?ic=filter_alt'></a>
                <div id="searchResults"></div>
            </div>
            <div class="filter-container">
            <form class="filter" action="{{ route('bouteilles.filter', ['cellier_id' => $mon_cellier->id]) }}" method="GET">
                    <div><small class="close">X</small></div>
                    <h3>Tri et filtre</h3>
                    <div>
                    <div class="form-group">
                        <label for="price">Prix :</label>
                        <select id="price" name="price">
                            <option value="">Tous</option>
                            <option value="asc">Croissant</option>
                            <option value="desc">Décroissant</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="country">Pays :</label>
                        <select id="country" name="country">
                            <option value="">Tous</option>
                            @foreach ($filters_elements['countries'] as $country)
                                <option value="{{ $country }}">{{ $country }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="millesime">Millésime :</label>
                        <select id="millesime" name="millesime">
                            <option value="">Tous</option>
                            @foreach ($filters_elements['millesimes'] as $millesime)
                                <option value="{{ $millesime }}">{{ $millesime }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="type">Type :</label>
                        <select id="type" name="type">
                            <option value="">Tous</option>
                            @foreach ($filters_elements['types'] as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                        <button type="submit" class="bouton">Appliquer</button>
                    </div>
                </form>
            <div class="container-bouteilles">
            @if($bottles->isEmpty())
                <p class="message">Aucune bouteille trouvée !</p>
            @else
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
                    <form id="hi" method="POST" action="{{ route('bouteilles.addBouteille', ['id' => $bottle->id]) }}" onsubmit="return checkCellierId()">
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
        @endif

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
        <a href="{{route('bouteilles.rechercheFooterBouteille')}}"><img src="https://s2.svgbox.net/octicons.svg?ic=search&color=000" width="22" height="22"></a>
            <span>Recherche</span>
        </div> 
</footer>


<script>


function checkCellierId() {
        if ("{{ $mon_cellier->id }}" == "0") {
            // Show modal with select element
            var modal = document.createElement('div');
            modal.style.position = 'fixed';
            modal.style.top = '0';
            modal.style.left = '0';
            modal.style.width = '100%';
            modal.style.height = '100%';
            modal.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
            modal.style.display = 'flex';
            modal.style.justifyContent = 'center';
            modal.style.alignItems = 'center';
            modal.style.zIndex = '9999';

            var select = document.createElement('select');
            select.style.padding = '1rem';
            select.style.fontSize = '1.2rem';
            select.style.borderRadius = '0.5rem';
            select.style.border = 'none';
            select.style.backgroundColor = '#fff';

            var option1 = document.createElement('option');
            option1.value = '1';
            option1.text = 'Option 1';

            var option2 = document.createElement('option');
            option2.value = '2';
            option2.text = 'Option 2';

            var option3 = document.createElement('option');
            option3.value = '3';
            option3.text = 'Option 3';

            select.add(option1);
            select.add(option2);
            select.add(option3);

            var button = document.createElement('button');
            button.textContent = 'OK';
            button.style.padding = '1rem';
            button.style.fontSize = '1.2rem';
            button.style.borderRadius = '0.5rem';
            button.style.border = 'none';
            button.style.backgroundColor = '#fff';
            button.style.marginLeft = '1rem';

            var optionSelected = false; // Add variable to keep track of whether an option has been selected

button.addEventListener('click', function() {
    var selectedOption = select.options[select.selectedIndex].value;
    document.querySelector('input[name="cellier_id"]').value = selectedOption;
    optionSelected = true; // Set variable to true when an option is selected
    console.log(selectedOption);
    modal.remove();
    //then submit the form
    document.getElementById('hi').submit();
});

modal.appendChild(select);
modal.appendChild(button);
document.body.appendChild(modal);

return optionSelected; // Return value of variable after button event listener has been executed
}

        return true;
    }


    // ====== script pour l'incrémentation et la décrémentation ======


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
const filter = document.querySelector('.filter');
const closeButton = document.querySelector('.close');
const toggleFilter = document.querySelector('a.toggle-filter');


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