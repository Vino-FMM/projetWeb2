@extends('layouts.app')
@section('title', 'Selecetionner un cellier')
@section('titleHeader', 'Selecetionner un cellier')
@section('content')
    <main>
        <div class="header">
            <h4>Veuillez sélectionner un cellier</h4>
        </div> 
       
        <form action="{{route('bouteilles.rechercheFooterBouteille')}}" method="POST">
                @csrf
            <select name="cellier_id" id="cellier_id">
                @foreach ($celliers as $cellier)
                    <option value="{{$cellier->id}}">{{$cellier->nom_cellier}}</option>
                @endforeach
            </select>
            <button type="submit">Sélectionner</button>
        
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
        <a href=""><img src="https://s2.svgbox.net/octicons.svg?ic=search&color=000" width="22" height="22"></a>
        <span>Recherche</span>
    </div>

</footer>
@endsection

