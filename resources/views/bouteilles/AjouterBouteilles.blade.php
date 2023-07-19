@extends('layouts.app')
@section('title', 'Liste des bouteilles')
@section('content')
    <main>
        <div class="header">
            <h4>Liste des bouteilles</h4>
            <small>cellier: {{ $mon_cellier->nom_cellier }}</small>
        </div> 
        <div class="container-bouteilles">
            @foreach($bottles as $bottle)
                <div class="carte-bouteille">
                    <div>
                        <div class="cercle {{ $bottle->type === 'Vin rouge' ? 'cercle-rouge' : ($bottle->type === 'Vin blanc' ? 'cercle-doré' : '') }}"></div>
                        <img src="{{ $bottle->url_img }}" alt="{{ $bottle->nom }}" style="max-width: 100%; height: auto;">
                    </div>  
                    <div class="carte-details">
                        <h4>{{ $bottle->nom }}</h4>
                        <small>{{ $bottle->type }} | {{ $bottle->format }} | {{ $bottle->pays }}</small>
                        <small> prix: {{ $bottle->prix }} $</small>
                        <small>code SAQ: {{ $bottle->code_saq }}</small>
                        <div>
                            @if(in_array($bottle->code_saq, $owned_bottles))
                                <p type="button" class="bouton-disabled" disabled>
                                <img src="https://s2.svgbox.net/octicons.svg?ic=check&color=000" width="15" height="15">vous avez déja cette bouteille!
                                </p>
                            @else
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

                            @endif
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


@endsection