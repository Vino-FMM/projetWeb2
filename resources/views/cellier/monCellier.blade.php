@extends('layouts.app')
@section('title', 'mon cellier')
@section('titleHeader', 'mon cellier')
@section('content')

<main>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($bouteilleCelliers->count() > 0)
        <div>
            <div>
                <a href="{{ route('Ajouter-bouteilles', ['cellier_id' => $cellier->id]) }}">Ajouter Bouteille<svg height="22px" width="22px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 58.166 58.166" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path style="fill:#010002;" d="M33.349,6.666V1.65c0-0.912-0.738-1.65-1.647-1.65h-5.234c-0.912,0-1.65,0.739-1.65,1.65v5.016 H33.349z"></path> <path style="fill:#010002;" d="M35.517,17.009c-1.578-1.264-2.61-2.191-2.61-3.509V9.583h-7.646V13.5 c0,1.318-1.034,2.245-2.61,3.509c-1.349,1.081-2.877,2.306-2.877,4.21v8.613h9.309v15.751h-9.311V56.24 c0,1.063,0.862,1.926,1.926,1.926h14.77c1.063,0,1.926-0.862,1.926-1.926V21.22C38.394,19.315,36.864,18.09,35.517,17.009z"></path> </g> </g> </g></svg></a>
                @foreach($bouteilleCelliers as $bouteilleCellier)
                    <div>
                        <div class="carte-cellier">
                            <div>
                                <img src="https://s2.svgbox.net/materialui.svg?ic=no_drinks&color=000" width="40" height="40"> 
                                <a href="#">{{ $bouteilleCellier->nom_bouteille }}</a> &nbsp;&nbsp;&nbsp;
                                <h3>Quantite : {{ $bouteilleCellier->quantite }}</h3>
                            </div>
                           
                            <div>
                                <a href="#">Modifier<img src="https://s2.svgbox.net/hero-outline.svg?ic=pencil&color=000000" width="22" height="22"></a>
                                <a href="#" data-cellier-id="{{ $bouteilleCellier->id }}">Supprimer<img src="https://s2.svgbox.net/materialui.svg?ic=delete&color=000" width="22" height="22"></a>
                                <form id="delete-form-{{ $bouteilleCellier->id }}" action="#" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>  
                            <small>Date d'ajout: {{ $bouteilleCellier->created_at->format('d-m-Y') }}</small>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div>
            <div>
                <div>
                    <div>
                        <h1>welcome to Vino</h1>
                        <p>pas de Bouteille</p>
                        <div>
                            <a href="{{route('cellier.create')}}">Ajouter une Bouteille</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</main>

<!-- Confirmation de suppression Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <p>Êtes-vous sûr de vouloir supprimer ce cellier?</p>
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
        <img src="https://s2.svgbox.net/hero-outline.svg?ic=plus-sm&color=000000" width="32" height="32">
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
