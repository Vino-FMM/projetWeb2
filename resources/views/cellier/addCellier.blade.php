@extends('layouts.app')
@section('title', 'Ajouter un cellier')
@section('titleHeader', 'Ajouter un cellier')
@section('content')
<section class="bg-light py-5">
            <div class="container px-5 my-5 px-5">
                <div class="text-center mb-5">
                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-bag-plus"></i></div>
                    <h2 class="fw-bolder">Ajouter un cellier</h2>
                    <p class="lead mb-0">infos</p>
                </div>
                <div class="row gx-5 justify-content-center">
                    <div class="col-lg-6">
                    <form action="{{route('cellier.store')}}" method="post">
                                @csrf
                                 <div class="form-floating mb-3">
                                <input class="form-control" id="nom_cellier" type="text" name="nom_cellier" placeholder="Nom Cellier" value="{{old('nom_cellier')}}" />
                                <label for="nom_cellier">nom_cellier</label>
                                @if ($errors->has('nom_cellier'))
                                        <div class="text-danger mt-2">
                                            {{$errors->first('nom_cellier')}}
                                        </div>
                                @endif
                            </div>
                                                        <!-- Submit Button-->
                            <button class="btn btn-primary btn-lg" id="Login" type="submit">Ajouter</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
@endsection