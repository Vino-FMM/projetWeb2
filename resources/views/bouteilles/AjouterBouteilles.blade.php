@extends('layouts.app')
@section('title', 'Liste des bouteilles')
@section('content')
    <div>
        <h1>Liste des bouteilles</h1>
        <div>
            @foreach($bottles as $bottle)
                <div>
                    <div>
                        <img src="{{ $bottle->url_img }}" alt="{{ $bottle->nom }}" style="max-width: 100%; height: auto;">
                        <div>
                            <h5>{{ $bottle->nom }}</h5>
                            <p>{{ $bottle->type }} | {{ $bottle->format }} | {{ $bottle->pays }}</p>
                            <p>{{ $bottle->prix }}</p>
                            <div>
                                <form method="POST" action="{{ route('bouteilles.addBouteille', ['id' => $bottle->id]) }}">
                                    @csrf
                                    <button type="submit"><i class="bi bi-patch-plus"></i>+</button>
                                </form>
                                <small>{{ $bottle->code_saq }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            
            {{ $bottles->links('vendor.pagination.custom') }}
        </div>
    </div>
@endsection
