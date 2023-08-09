@extends('layouts.app')
@section('title', 'mon cellier')
@section('titleHeader', 'mon cellier')
@section('content')

<main>
<div class="header">
           
<small>nom cellier: {{ $nomCellier}}</small>
        </div> 
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if($bouteilleCelliers->count() > 0)
    <div class="header">
        <h3>Ajouter des bouteilles</h3>
        <a href="{{ route('Ajouter-bouteilles', ['cellier_id' => $cellier->id]) }}"><img src="https://s2.svgbox.net/hero-solid.svg?ic=plus-circle&color=000000" width="40" height="40"></a>
    </div>
    <div class="container-bouteilles">
        @foreach($bouteilleCelliers as $bouteilleCellier)
        <div class="carte-bouteille">
            <div>
                <img src="{{ $bouteilleCellier->url_img_bouteille }}" alt="{{ $bouteilleCellier->nom_bouteille }}" style="max-width: 100%; height: auto;">
            </div>
            <div class="carte-details">
                <h4>{{ $bouteilleCellier->nom_bouteille }}</h4> 
                <small>{{ $bouteilleCellier->type_bouteille }} | {{ $bouteilleCellier->format_bouteille }} | {{ $bouteilleCellier->pays_bouteille }}</small>
                <small>Qté: {{ $bouteilleCellier->quantite }}</small>
                <div class="carte-action">
                    <a href="{{ route('modifier-Qte', ['bouteille_id' => $bouteilleCellier->id]) }}" class="bouton-outline">Modifier</a>
                    <a href="#" data-cellier-id="{{ $bouteilleCellier->id }}" data-cellier="{{ $cellier->id }}" class="bouton-outline">Supprimer</a>
                    <form id="delete-form-{{ $bouteilleCellier->id }}" action="{{ route('bouteilles.destroy', ['id' => $bouteilleCellier->id, 'cellier_id' => $cellier->id]) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div> 
            </div> 
            
          
    </div>
    @endforeach
    @else
        <div class='carte-vide'>
            <h4>Aucune bouteille dans ce cellier</h4>
            <div>
                <a href="{{ route('Ajouter-bouteilles', ['cellier_id' => $cellier->id]) }}" class="bouton">Ajouter une bouteille</a>
            </div>
        </div>     
    @endif
</main>

<!-- Confirmation de suppression Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <p>Êtes-vous sûr de vouloir supprimer cette bouteille du cellier?</p>
        <button id="closeBtn" class="close-button">&times;</button>
        <button id="confirmBtn" class="confirm-button">Supprimer</button>
    </div>
</div>

<footer>
    <div>
        <a href="{{ route('home') }}"><img src="https://s2.svgbox.net/octicons.svg?ic=home&color=000" width="22" height="22"></a>
        <span>Acueil</span>
    </div>
    <div>
    <a href="{{route('cellier.create')}}"><img src="https://s2.svgbox.net/hero-outline.svg?ic=plus-sm&color=000000" width="22" height="22"></a>
        <span>Ajout</span>
    </div>
    <div>
        <a href=""><img src="https://s2.svgbox.net/octicons.svg?ic=search&color=000" width="22" height="22"></a>
        <span>Recherche</span>
    </div>
</footer>

<script>
    let deleteModal = document.getElementById("deleteModal");
    let closeBtn = document.getElementById("closeBtn");
    let confirmBtn = document.getElementById("confirmBtn");

    document.querySelectorAll("[data-cellier-id]").forEach((btn) => {
        btn.addEventListener("click", (e) => {
            e.preventDefault();
            let deleteFormId = "delete-form-" + btn.getAttribute("data-cellier-id");
            confirmBtn.onclick = function () {
                document.getElementById(deleteFormId).submit();
            };
            deleteModal.style.display = "block";
        });
    });

    closeBtn.addEventListener("click", () => {
        deleteModal.style.display = "none";
    });

    window.onclick = (event) => {
        if (event.target == deleteModal) {
            deleteModal.style.display = "none";
        }
    };
</script>

@endsection
