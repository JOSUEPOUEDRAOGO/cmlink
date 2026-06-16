<header class="front-header">
    <div class="container">
        <div class="front-navbar">
            <a href="{{ route('front.home') }}" class="logo">
                <img src="{{ asset('assets/img/cmlink.png') }}" alt="Cmlink Logo">
            </a>

            <button type="button" class="mobile-menu-btn" id="frontMenuToggle"
                aria-label="Ouvrir le menu"
                aria-controls="frontNavLinks"
                aria-expanded="false">
                <i class="bi bi-list"></i>
            </button>

            <nav class="nav-links" id="frontNavLinks">

                <a href="{{ route('front.offres.index') }}">
                    Offres
                </a>

                <div class="nav-dropdown">
                    <button type="button" class="nav-dropdown-btn" aria-expanded="false">
                        Catégories <span>⌄</span>
                    </button>
                    <div class="nav-dropdown-menu">
                        @if(isset($frontCategories) && $frontCategories->count())
                            @foreach($frontCategories as $categorie)
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

                    {{-- Cloche alertes (étudiant uniquement) --}}
                    @role('etudiant')
                        @php
                            $alerteActive = auth()->user()->alerteOffre?->active ?? false;
                        @endphp
                        <a href="{{ route('front.alertes.index') }}"
                            class="alerte-bell {{ $alerteActive ? 'is-active' : '' }}"
                            title="{{ $alerteActive ? 'Alertes activées' : 'Activer les alertes' }}">
                            <i class="bi bi-bell{{ $alerteActive ? '-fill' : '' }}"></i>
                            @if($alerteActive)
                                <span class="alerte-dot"></span>
                            @endif
                        </a>
                    @endrole

                    @role('admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn-outline">
                            Dashboard
                        </a>
                    @endrole

                    @role('entreprise')
                        <a href="{{ route('admin.offres.index') }}" class="btn-outline">
                            Espace entreprise
                        </a>
                    @endrole

                    @role('etudiant')
                        <a href="{{ route('admin.mes-candidatures.index') }}" class="btn-outline">
                            Mon espace
                        </a>
                    @endrole

                    <form action="{{ route('logout') }}" method="POST" class="logout-form">
                        @csrf
                        <button type="submit" class="btn-primary">
                            Déconnexion
                        </button>
                    </form>

                @else
                    <a href="{{ route('login') }}" class="btn-outline">Connexion</a>
                    <a href="{{ route('register') }}">S'inscrire</a>
                @endauth

            </nav>
        </div>
    </div>
</header>

<style>
.alerte-bell {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    color: #557c9c;
    font-size: 1.1rem;
    text-decoration: none;
    transition: all .2s ease;
    border: 1px solid rgba(30, 74, 118, 0.15);
    background: transparent;
}

.alerte-bell:hover {
    background: rgba(30, 74, 118, 0.08);
    color: #1e4a76;
}

.alerte-bell.is-active {
    color: #1e4a76;
    background: rgba(30, 74, 118, 0.08);
    border-color: rgba(30, 74, 118, 0.25);
}

.alerte-dot {
    position: absolute;
    top: 6px;
    right: 6px;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #e74c3c;
    border: 2px solid #fff;
    animation: pulse-dot 2s infinite;
}

@keyframes pulse-dot {
    0%, 100% { transform: scale(1); opacity: 1; }
    50%       { transform: scale(1.3); opacity: .7; }
}
</style>
