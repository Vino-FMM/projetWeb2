@extends('layouts.app')
@section('title', 'Selecetionner un cellier')
@section('titleHeader', 'Selecetionner un cellier')
@section('content')
    <main>
        <div class="header">
            <h4>Veuillez sélectionner un cellier</h4>
        </div> 
       
        <form class="recherche-nav" id="select-form" action="{{ route('bouteilles.rechercheFooterBouteillePost') }}" method="POST">
            @csrf
            <select name="cellier_id" id="cellier_id">
                <option value="">Sélectionner un cellier</option>
                @foreach ($celliers as $cellier)
                    <option value="{{ $cellier->id }}">{{ $cellier->nom_cellier }}</option>
                @endforeach
            </select>
            <button type="submit">Sélectionner</button>
        </form>

        
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
<div id="modal" class="modal">
        <div class="modal-content">
            <h4>Veuillez sélectionner un cellier.</h4>
            <button id="modal-close" type="button">Fermer</button>
        </div>
    </div>

    <script>
        document.getElementById('select-form').addEventListener('submit', function(event) {
            var select = document.getElementById('cellier_id');
            if (!select.value) {
                event.preventDefault();
                var modal = document.getElementById('modal');
                var modalClose = document.getElementById('modal-close');
                modal.style.display = 'block';
                modalClose.addEventListener('click', function() {
                    modal.style.display = 'none';
                });
            }
        });
    </script>
@endsection

