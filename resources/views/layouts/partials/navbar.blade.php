<nav class="navbar navbar-expand-lg bg-white border-bottom px-4 py-3 shadow-sm">
    <div class="d-flex align-items-center justify-content-between w-100">

        {{-- Partie gauche --}}
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-light border" id="toggleSidebar" type="button">
                <i class="bi bi-list fs-5"></i>
            </button>

            <div>
                <h5 class="mb-0 fw-bold">@yield('page_title', 'Tableau de bord administrateur')</h5>
                <small class="text-muted">@yield('page_subtitle', "Vue d'ensemble de la plateforme Cmlink")</small>
            </div>
        </div>


        <div class="dropdown">
    <button class="btn p-0 border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <div class="d-flex align-items-center gap-3 bg-light rounded-pill px-3 py-2 shadow-sm profile-menu-trigger">

            {{-- Photo avec le bon champ "avatar" --}}
            <img
                src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=0D8ABC&color=fff' }}"
                alt="Photo de profil"
                class="rounded-circle border"
                width="45"
                height="45"
                style="object-fit: cover;"
            >

            {{-- Infos --}}
            <div class="text-start d-none d-md-block">
                <div class="fw-semibold text-dark mb-0" style="line-height: 1.1;">
                    {{ auth()->user()->name }}
                </div>
                <small class="text-muted d-block">
                    {{ auth()->user()->account_type ?? 'Administrateur' }}
                </small>
            </div>

            {{-- Statut --}}
            <span class="btn btn-success btn-sm rounded-pill px-3 py-1 d-none d-md-inline-block">
                En ligne
            </span>

            {{-- Icône dropdown --}}
            <i class="bi bi-chevron-down text-muted"></i>
        </div>
    </button>

    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 p-2" style="min-width: 260px;">

        {{-- En-tête du dropdown --}}
        <li class="px-3 py-2 border-bottom mb-2">
            <div class="d-flex align-items-center gap-3">
                <img
                    src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=0D8ABC&color=fff' }}"
                    alt="Photo de profil"
                    class="rounded-circle border"
                    width="50"
                    height="50"
                    style="object-fit: cover;"
                />

                <div>
                    <div class="fw-bold text-dark">{{ auth()->user()->name }}</div>
                    <small class="text-muted d-block">{{ auth()->user()->email }}</small>
                    <span class="badge bg-success mt-1">En ligne</span>
                </div>
            </div>
        </li>

        <li>
            <a class="dropdown-item rounded-3 py-2" href="{{ route('profile.edit') }}">
                <i class="bi bi-person me-2 text-primary"></i> Profil
            </a>
        </li>

        <li>
            <a class="dropdown-item rounded-3 py-2" href="#">
                <i class="bi bi-gear me-2 text-warning"></i> Paramètres
            </a>
        </li>

        <li>
            <a class="dropdown-item rounded-3 py-2" href="#">
                <i class="bi bi-bar-chart me-2 text-info"></i> Rapports
            </a>
        </li>

        <li><hr class="dropdown-divider"></li>

        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item rounded-3 py-2 text-danger">
                    <i class="bi bi-box-arrow-right me-2"></i> Déconnexion
                </button>
            </form>
        </li>
    </ul>
</div>
    </div>
</nav>
