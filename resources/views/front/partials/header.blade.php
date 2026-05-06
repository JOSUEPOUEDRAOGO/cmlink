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

                <a href="{{ route('front.etudiants.index') }}">Étudiants</a>
                <a href="{{ route('front.entreprises.index') }}">Entreprises</a>

                @auth
                    @role('admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn-outline">Admin</a>
                    @endrole

                    @role('entreprise')
                        <a href="{{ route('admin.offres.index') }}" class="btn-outline">Espace entreprise</a>
                    @endrole

                    @role('etudiant')
                        <a href="{{ route('front.offres.index') }}" class="btn-outline">Mes opportunités</a>
                    @endrole

                    <form action="{{ route('logout') }}" method="POST" class="logout-form">
                        @csrf
                        <button type="submit" class="btn-primary">
                            Déconnexion
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-outline">Connexion</a>
                    <a href="{{ route('register', ['type' => 'etudiant']) }}" class="btn-primary">Étudiant</a>
                    <a href="{{ route('register', ['type' => 'entreprise']) }}" class="btn-outline">Entreprise</a>
                @endauth
            </nav>
        </div>
    </div>
</header>
