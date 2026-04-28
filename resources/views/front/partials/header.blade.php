<header class="front-header">
    <div class="container">
        <div class="front-navbar">
            <a href="{{ route('front.home') }}" class="logo">Cmlink</a>

            <button type="button" class="mobile-menu-btn" id="frontMenuToggle">
                <i class="bi bi-list"></i>
            </button>

            <nav class="nav-links" id="frontNavLinks">
                <a href="{{ route('front.offres.index') }}">Offres</a>

                <div class="nav-dropdown">
                    <button type="button" class="nav-dropdown-btn">
                        Catégories <span>⌄</span>
                    </button>

                    <div class="nav-dropdown-menu">
                        @if (isset($frontCategories) && $frontCategories->count())
                            @foreach ($frontCategories as $categorie)
                                <a href="{{ route('front.offres.index', ['categorie' => $categorie->id]) }}">
                                    {{ $categorie->nom }}
                                    <small>{{ $categorie->offres_count ?? 0 }} offres</small>
                                </a>
                            @endforeach
                        @else
                            <div class="px-3 py-2 text-muted small">
                                Aucune catégorie disponible
                            </div>
                        @endif
                    </div>
                </div>

                <a href="#">Étudiants</a>
                <a href="#">Entreprises</a>

                @auth
                    <a href="{{ route('admin.dashboard') }}" class="btn-outline">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-outline">Connexion</a>
                    <a href="{{ route('register') }}" class="btn-primary">S'inscrire</a>
                @endauth
            </nav>
        </div>
    </div>
</header>
