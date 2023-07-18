@extends('layouts.app')
@section('title', 'Liste des bouteilles')
@section('content')
    <main>
        <div class="header">
            <h2>Liste des bouteilles</h2>
            <small>nom du cellier : {{ $mon_cellier->nom_cellier }}</small>

      
        </div> 
        <div class="container-bouteilles">
            @foreach($bottles as $bottle)
                <div class="carte-bouteille">
                    <img src="{{ $bottle->url_img }}" alt="{{ $bottle->nom }}" style="max-width: 100%; height: auto;">
                        <div class="carte-details">
                            <h4>{{ $bottle->nom }}</h4>
                            <p>{{ $bottle->type }} | {{ $bottle->format }} | {{ $bottle->pays }}</p>
                            <p>{{ $bottle->prix }} $</p>
                            <!-- <small>{{ $bottle->code_saq }}</small> -->
                            <div>
                                @if(in_array($bottle->code_saq, $owned_bottles))
                                    <button type="button" class="bouton ajout-bouteille" disabled style="background-color: #ccc; color: red;">
                                        <i class="bi bi-patch-plus"></i>Bouteille déjà dans le cellier
                                    </button>
                                @else
                                    <form method="POST" action="{{ route('bouteilles.addBouteille', ['id' => $bottle->id]) }}">
                                        @csrf
                                        <input type="hidden" name="cellier_id" value="{{ $cellier_id }}">
                                        <input type="number" name="quantite" value="1" min="1" max="99" class="quantite">
                                        <button type="submit" class="bouton ajout-bouteille">
                                            <i class="bi bi-patch-plus"></i>Ajouter au cellier
                                        </button>
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
    <!-- Footer content here -->
</footer>
@endsection
