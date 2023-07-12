@extends('layouts.app')
@section('title', 'welcome')
@section('titleHeader', 'welcome')
@section('content')
<header class="bg-dark py-5">
@if(Auth::check() && Auth::user()->celliers->count() > 0)
    <div class="container mt-5">
        <div class="row">
            @foreach(Auth::user()->celliers as $cellier)
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        {{ $cellier->nom_cellier }}
                    </div>
                    <div class="card-body">
                        <a href="{{ route('cellier.edit', ['id' => $cellier->id]) }}" class="btn btn-primary">Modifier nom cellier</a>
                    </div>
                    <div class="card-body">
                        <a href="#" class="btn btn-primary">Ajouter bouteille</a>
                    </div>
                    <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                        <a class="btn btn-danger btn-lg px-4 me-sm-3" href="{{ route('cellier.destroy', ['id' => $cellier->id]) }}" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $cellier->id }}').submit();">
                            Supprimer
                        </a>
                        <form id="delete-form-{{ $cellier->id }}" action="{{ route('cellier.destroy', ['id' => $cellier->id]) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                        <a class="btn btn-primary btn-lg px-4 me-sm-3" href="{{route('cellier.create')}}">Ajouter un cellier</a>
                    </div>
    </div>
@else
    <div class="container px-5">
        <div class="row gx-5 justify-content-center">
            <div class="col-lg-6">
                <div class="text-center my-5">
                    <h1 class="display-5 fw-bolder text-white mb-2">welcome to Vino</h1>
                    <p class="lead text-white-50 mb-4">pas de cellier</p>
                    <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                        <a class="btn btn-primary btn-lg px-4 me-sm-3" href="{{route('cellier.create')}}">Ajouter un cellier</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
</header>
@endsection
