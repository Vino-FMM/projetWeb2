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
    
                        <small>Vouz n'avez laissé aucune note pour cette bouteille</small>
                  
                        
                        <form method="POST" action="{{ route('bouteilles.ajouterNote', ['id_bouteille' => $bouteille->id, 'cellier_id' => $cellier_id]) }}">
                                @csrf
                                <input type="text" name="note" placeholder="Ajouter une note">
                                <input type="hidden" name="cellier_id" value="{{ $cellier_id }}">
                                <button type="submit" class="bouton ajout-bouteille">Ajouter</button>
                        </form>
                        </div>
                    </div>
                    @if(!empty($notes))
                        <div style="margin-top: 1rem;padding: 1rem;background-color: #f8f9fa;border: 1px solid #dee2e6;border-radius: .25rem;">
                            <small style="font-weight: bold;">Notes:</small>
                            @foreach($notes as $note)
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <p style="margin: .5rem 0;">{{ $note['text'] }}</p>
                                    <form method="POST" action="{{ route('note.destroyNote', ['id_bouteille' => $bouteille->id, 'cellier_id' => $cellier_id]) }}" id="delete-form-{{ $note['id'] }}">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="note" value="{{ $note['text']  }}">
                                        <a href="#" data-cellier-id="{{ $note['id'] }}" data-cellier="{{ $cellier_id }}" class="bouton-outline">Supprimer</a>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <small>Vouz n'avez laissé aucune note pour cette bouteille</small>
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

    document.querySelectorAll("[data-cellier-id]").forEach((btn) => {
        btn.addEventListener("click", (e) => {
            e.preventDefault();
            let deleteFormId = "delete-form-" + btn.getAttribute("data-cellier-id");
            confirmBtn.onclick = function () {
                console.log(deleteFormId);
                document.getElementById(deleteFormId).submit();
            };
            deleteModal.style.display = "block";
            console.log(deleteFormId);
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
