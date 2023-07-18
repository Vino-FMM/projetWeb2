@extends('layouts.app')
@section('title', 'Liste des bouteilles')
@section('content')
    <main>
        <div class="header">
            <h2>Liste des bouteilles</h2>
            <small>cellier id: {{ request()->query('cellier_id') }}</small>
        </div> 
        <div class="container-bouteilles">
            @foreach($bottles as $bottle)
                <div class="carte-bouteille">
                    <img src="{{ $bottle->url_img }}" alt="{{ $bottle->nom }}" style="max-width: 100%; height: auto;">
                        <div class="carte-details">
                            <h5>{{ $bottle->nom }}</h5>
                            <p>{{ $bottle->type }} | {{ $bottle->format }} | {{ $bottle->pays }}</p>
                            <p>{{ $bottle->prix }} $</p>
                            <!-- <small>{{ $bottle->code_saq }}</small> -->
                            <div>
                                <form method="POST" action="{{ route('bouteilles.addBouteille', ['id' => $bottle->id]) }}">
                                    @csrf
                                    <button type="submit" class="bouton ajout-bouteille"><i class="bi bi-patch-plus"></i>Ajouter au cellier</button>
                                </form>  
                            </div>
                        </div>
                </div>
            @endforeach

            {{ $bottles->appends(request()->query())->links('vendor.pagination.custom') }}
        </div>
    </main>

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
@endsection