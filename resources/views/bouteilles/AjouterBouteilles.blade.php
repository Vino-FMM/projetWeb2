    @extends('layouts.app')
    @section('title', 'Liste des bouteilles')
    @section('content')
        <div class="container">
            <h1>Liste des bouteilles</h1>
            <div class="row">
                @foreach($bottles as $bottle)
                    <div class="col-md-4">
                        <div class="card mb-4 box-shadow">
                            <img class="card-img-top" src="{{ $bottle->url_img }}" alt="{{ $bottle->nom }}" style="max-width: 100%;
        height: auto;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $bottle->nom }}</h5>
                                <p class="card-text">{{ $bottle->type }} | {{ $bottle->format }} | {{ $bottle->pays }}</p>
                                <p class="card-text">{{ $bottle->prix }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                <form method="POST" action="{{ route('bouteilles.addBouteille', ['id' => $bottle->id]) }}">


                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-secondary"><i class="bi bi-patch-plus"></i>+</button>
                                </form>
                                    <small class="text-muted">{{ $bottle->code_saq }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- <div class="pagination">
                            {{ $bottles->links() }}
                        </div>
            </div> -->
            <!-- <div class="custom-pagination"> -->
        {{ $bottles->links() }}
    <!-- </div> -->

        </div>
    @endsection