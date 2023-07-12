@extends('layouts.app')
@section('title', 'Modifier un cellier')
@section('titleHeader', 'Modifier un cellier')
@section('content')
<section class="bg-light py-5">
            <div class="container px-5 my-5 px-5">
                <div class="text-center mb-5">
                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-bag-plus"></i></div>
                    <h2 class="fw-bolder">Modifier un cellier</h2>
                    <p class="lead mb-0">infos</p>
                </div>
                <div class="row gx-5 justify-content-center">
                    <div class="col-lg-6">
                    <form action="{{ route('cellier.update', $cellier->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-floating mb-3">
                            <input class="form-control" id="nom_cellier" type="text" name="nom_cellier" placeholder="Nom Cellier" value="{{ $cellier->nom_cellier }}" />
                            <label for="nom_cellier">Nom Cellier</label>
                            @if ($errors->has('nom_cellier'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('nom_cellier') }}
                                </div>
                            @endif
                        </div>
                        <!-- Submit Button-->
                        <button class="btn btn-primary btn-lg" id="Login" type="submit">Modifier</button>
                    </form>
                    </div>
                </div>
            </div>
        </section>
@endsection