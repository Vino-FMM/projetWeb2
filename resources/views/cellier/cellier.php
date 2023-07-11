<div class="cellier">
    <div class="menu-actions-container">
        <a class="no-underline" href="{{ route('ajouterNouvelleBouteilleCellier') }}">
            <span class="bouton-carre-label">Ajouter une bouteille</span>
            <div class="btn-rond-rouge"><i class="fa-solid fa-plus"></i></div>
        </a>
    </div>
    <section class="bouteilles-container">
        @foreach ($data as $cle => $bouteille)
            <div class="bouteille" data-quantite="{{ $bouteille['quantite'] }}">
                <a href="{{ route('ficheDetailsBouteille', ['bte' => $bouteille['vino__bouteille_id']]) }}">
                    <div class="bouteille-img-container">
                        <img src="{{ asset('images/vin-fallback.png') }}">
                    </div>
                </a>
                <div class="description">
                    <a href="{{ route('ficheDetailsBouteille', ['bte' => $bouteille['vino__bouteille_id']]) }}">
                        <p class="type {{ strtolower($bouteille['type']) }}">{{ $bouteille['type'] }}</p>
                        <p class="nom">{{ $bouteille['nom'] }}</p>
                        <p class="pays">{{ $bouteille['pays'] }}</p>
                        @if ($bouteille['millesime'] != 0)
                            <p class="millesime">Millésime {{ $bouteille['millesime'] }}</p>
                        @endif
                    </a>
                    <div class="quantity-wrapper">
                        <div class="bouton-carre btnBoire" data-id="{{ $bouteille['id_bouteille_cellier'] }}">
                            <i class="fa-solid fa-minus btnBoire" data-id="{{ $bouteille['id_bouteille_cellier'] }}"></i>
                        </div>
                        <p class="quantite">{{ $bouteille['quantite'] }}</p>
                        <div class="bouton-carre btnAjouter" data-id="{{ $bouteille['id_bouteille_cellier'] }}">
                            <i class="fa-solid fa-plus btnAjouter" data-id="{{ $bouteille['id_bouteille_cellier'] }}"></i>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </section>
</div>
