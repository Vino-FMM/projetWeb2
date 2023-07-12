@extends('layouts.app')
@section('title', 'Ajouter un cellier')
@section('titleHeader', 'Ajouter un cellier')
@section('content')

<main>
    <div class="header">
        <h2>Ajouter un cellier</h2>
    </div>        
    <div class="carte-ajout">
        <div class="formulaire_connexion">
            <form action="{{route('cellier.store')}}" method="post" >
                @csrf
                    <div>
                        <input id="nom_cellier" type="text" name="nom_cellier" placeholder="Nom du cellier" value="{{old('nom_cellier')}}" />
                        <!-- <label for="nom_cellier">nom_cellier</label> -->
                        @if ($errors->has('nom_cellier'))
                            <div>
                                {{$errors->first('nom_cellier')}}
                            </div>
                        @endif
                    </div>
                    <!-- Submit Button-->
                    <button id="Login" type="submit" class="bouton">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
