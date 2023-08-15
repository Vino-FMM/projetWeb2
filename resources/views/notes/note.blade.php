@extends('layouts.app')
@section('title', 'Note de la bouteille')
@section('titleHeader', 'Note de la bouteille')
@section('content')
    <main>
        <div class="header">
            <h4>Notes</h4> 
            <a href="#" class="back">retour</a>
        </div> 
        <div class="container-bouteilles">
                <div class="carte-bouteille carte-modification">
                    <div>
                        <img src="{{ $bouteille->url_img_bouteille }}" alt="{{ $bouteille->nom_bouteille }}" style="max-width: 100%; height: auto;">
                    </div>
                    
                    <div class="carte-details">
                        <h4>{{ $bouteille->nom_bouteille }}</h4>

                        <form method="POST" action="{{ route('bouteilles.ajouterNote', ['id_bouteille' => $bouteille->id, 'cellier_id' => $cellier_id]) }}">
                                @csrf
                                <input type="text" name="note" placeholder="Ajouter une note" class="notes_input">
                                <input type="hidden" name="cellier_id" value="{{ $cellier_id }}">
                                <button type="submit" class="bouton ajout-bouteille">Ajouter</button>
                        </form>
                        </div>
                    </div>
                    @if(!empty($notes))
                        <div class="container_notes">
                            <p>Notes:</p>
                            @foreach($notes as $note)
                                <div class="one_note">
                                    <div>
                                        <p>{{ $note['text'] }}</p>
                                    </div>
                                    
                                    <form method="POST" action="{{ route('note.destroyNote', ['id_bouteille' => $bouteille->id, 'cellier_id' => $cellier_id]) }}" id="delete-form-{{ $note['id'] }}">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="note" value="{{ $note['text']  }}">
                                        <input type="hidden" name="id_note" value="{{ $note['id'] }}">
                                        <a href="#" data-cellier-id="{{ $note['id'] }}" data-cellier="{{ $cellier_id }}" class="bouton-outline">Supprimer</a>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="no-notes">
                            <small>Vouz n'avez laissé aucune note pour cette bouteille</small>
                        </div>
                    @endif
                </div>
        </div>
    </main>

    <!-- Confirmation de suppression Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <p>Êtes-vous sûr de vouloir supprimer cette note ?</p>
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
        <span>Ajout cellier</span>
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
    let selectedNoteId = null;

    document.querySelectorAll("[data-cellier-id]").forEach((btn) => {
        btn.addEventListener("click", (e) => {
            e.preventDefault();
            selectedNoteId = btn.getAttribute("data-cellier-id");
            deleteModal.style.display = "block";
        });
    });

    confirmBtn.addEventListener("click", () => {
        if (selectedNoteId) {
            let deleteForm = document.getElementById("delete-form-" + selectedNoteId);
            if (deleteForm) {
                deleteForm.submit();
            }
        }
    });

    closeBtn.addEventListener("click", () => {
        deleteModal.style.display = "none";
        selectedNoteId = null; // Reset the selected note ID
    });

    window.onclick = (event) => {
        if (event.target == deleteModal) {
            deleteModal.style.display = "none";
            selectedNoteId = null; // Reset the selected note ID
        }
    };
</script>
@endsection
