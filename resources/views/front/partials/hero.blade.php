@if($categories->count())
    <div class="category-ticker">
        <div class="category-track">
            @foreach($categories as $categorie)
                <a href="{{ route('front.offres.index', ['categorie' => $categorie->id]) }}">
                    {{ $categorie->nom }}
                    <span>{{ $categorie->offres_count }} offres</span>
                </a>
            @endforeach

            @foreach($categories as $categorie)
                <a href="{{ route('front.offres.index', ['categorie' => $categorie->id]) }}">
                    {{ $categorie->nom }}
                    <span>{{ $categorie->offres_count }} offres</span>
                </a>
            @endforeach
        </div>
    </div>
@endif

<div class="container hero">
   <h1>{{ $pageContent['hero']['title'] ?? 'Trouvez votre prochaine opportunité' }}</h1>

<p>
    {{ $pageContent['hero']['subtitle'] ?? 'Connectez-vous directement avec les meilleures entreprises.' }}
</p>

<div class="btn-group">
    <a href="{{ route('register') }}" class="btn-primary">
        {{ $pageContent['hero']['button_primary'] ?? 'Commencer maintenant' }}
    </a>

    <a href="#pourquoi-cmlink" class="btn-outline">
        {{ $pageContent['hero']['button_secondary'] ?? 'En savoir plus →' }}
    </a>
</div>

    <div class="hero-badge">
        🔗 Connexion directe avec les entreprises
    </div>
</div>
