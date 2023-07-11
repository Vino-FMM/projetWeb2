@extends('layouts.app')
@section('title', 'welcome')
@section('titleHeader', 'welcome')
@section('content')
<header class="bg-dark py-5">
@if(Auth::check() && Auth::user()->celliers)
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header">
                        {{ Auth::user()->celliers[0]->nom_cellier }}
                    </div>
                    <div class="card-body">
                        <p class="card-text">Ajouter bouteille</p>
                        <a href="#" class="btn btn-primary">Ajouter</a>
                    </div>
                </div>
            </div>
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
                        <a class="btn btn-primary btn-lg px-4 me-sm-3" href="#features">Get Started</a>
                        <a class="btn btn-outline-light btn-lg px-4" href="#!">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
</header>
@endsection
