@extends('layouts.app')
@section('title', 'Modifier un cellier')
@section('titleHeader', 'Modifier un cellier')
@section('content')

<main>
    <div class="header">
        <h2>Modifier un cellier</h2>
    </div>
    <div class="carte-ajout">
        <div class="formulaire_connexion">
                <form action="{{ route('cellier.update', $cellier->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div>
                        <input id="nom_cellier" type="text" name="nom_cellier" placeholder="Nom Cellier" value="{{ $cellier->nom_cellier }}" />
                        <!-- <label for="nom_cellier">Nom Cellier</label> -->
                        @if ($errors->has('nom_cellier'))
                            <div>
                                {{ $errors->first('nom_cellier') }}
                            </div>
                        @endif
                    </div>
                    <!-- Submit Button-->
                    <button id="Login" type="submit" class="bouton">Modifier</button>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
