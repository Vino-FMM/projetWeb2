@extends('layouts.app')
@section('title', 'mon cellier')
@section('titleHeader', 'mon cellier')
@section('content')

<main>
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
            <img src="{{ $bouteilleCellier->url_img_bouteille }}" alt="{{ $bouteilleCellier->nom_bouteille }}" style="max-width: 100%; height: auto;">
            <div class="carte-details">
                <h4>{{ $bouteilleCellier->nom_bouteille }}</h4> 
                <small>{{ $bouteilleCellier->type_bouteille }} | {{ $bouteilleCellier->format_bouteille }} | {{ $bouteilleCellier->pays_bouteille }}</small>
                <small>Qté: {{ $bouteilleCellier->quantite }}</small>
                <!-- <small>Date d'ajout: {{ $bouteilleCellier->created_at->format('d-m-Y') }}</small> -->
                  
            </div> 
            <div class="carte-action">
                <a href="{{ route('modifier-Qte', ['bouteille_id' => $bouteilleCellier->id]) }}"><img src="https://s2.svgbox.net/hero-outline.svg?ic=pencil&color=000000" width="28" height="28"></a>
                    <a href="#" data-cellier-id="{{ $bouteilleCellier->id }}" data-cellier="{{ $cellier->id }}"><img src="https://s2.svgbox.net/materialui.svg?ic=delete&color=000" width="28" height="28"></a>
                    <form id="delete-form-{{ $bouteilleCellier->id }}" action="{{ route('bouteilles.destroy', ['id' => $bouteilleCellier->id, 'cellier_id' => $cellier->id]) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>


            </div> 
          
    </div>
    @endforeach
    @else
        <div class='carte-vide'>
            <h3>Aucune bouteille dans ce cellier</h3>
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
        <a href="{{ route('home') }}"><img src="https://s2.svgbox.net/octicons.svg?ic=home&color=000" width="32" height="32"></a>
        <span>Acueil</span>
    </div>
    <div>
        <a href="{{route('cellier.create')}}"><img src="https://s2.svgbox.net/hero-outline.svg?ic=plus-sm&color=000000" width="32" height="32"></a>
        <span>Ajout</span>
    </div>
    <div>
        <img src="https://s2.svgbox.net/octicons.svg?ic=search&color=000" width="32" height="32">
        <span>Recherche</span>
    </div>
    <div>
        <img src="https://s2.svgbox.net/materialui.svg?ic=list&color=000" width="32" height="32">
        <span>Liste</span>
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
