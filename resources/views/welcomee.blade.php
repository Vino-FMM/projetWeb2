@extends('layouts.app')
@section('title', 'welcome')
@section('titleHeader', 'welcome')
@section('content')

<main>
@if(Auth::check() && Auth::user()->celliers->count() > 0)
    <div>
        <div class="header">
            <h3>Mes celliers</h3>
            <a href="{{route('cellier.create')}}"><img src="https://s2.svgbox.net/octicons.svg?ic=plus-circle-bold&color=000000" width="50" height="50"></a>
        </div>
        
        <div>
            @foreach(Auth::user()->celliers as $cellier)
            <div>
                <div class="carte-cellier">
                    <img src="https://s2.svgbox.net/materialui.svg?ic=wine_bar&color=000" width="80" height="80">    
                    <a href="#">{{ $cellier->nom_cellier }}</a>  
                    <div>
                        <a href="{{ route('cellier.edit', ['id' => $cellier->id]) }}"><img src="https://s2.svgbox.net/hero-outline.svg?ic=pencil&color=000000" width="32" height="32"></a>
                        <a href="#" data-cellier-id="{{ $cellier->id }}"><img src="https://s2.svgbox.net/materialui.svg?ic=delete&color=000" width="32" height="32"></a>
                        <form id="delete-form-{{ $cellier->id }}" action="{{ route('cellier.destroy', ['id' => $cellier->id]) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>  
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
                    <p>pas de cellier</p>
                    <div>
                        <a href="{{route('cellier.create')}}">Ajouter un cellier</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
</main>
<!--  Confirmation de supression Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <p>Êtes-vous sûr de vouloir supprimer ce cellier?</p>
        <button id="closeBtn" class="close-button">&times;</button>
        <button id="confirmBtn" class="confirm-button">Supprimer</button>
    </div>
</div>

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
