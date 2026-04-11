<div class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-top">
        <div class="brand-box">
            <div class="brand-icon">C</div>
            <div class="brand-text">
                <h4>Cmlink</h4>
                <span>Administration</span>
            </div>
        </div>

        <ul class="sidebar-menu">

            {{-- Dashboard --}}
            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Tableau de bord</span>
                </a>
            </li>

            {{-- Étudiants --}}
            <li>
                <a href="{{ route('admin.etudiants.index') }}"
                   class="{{ request()->routeIs('admin.etudiants.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span>Étudiants</span>
                </a>
            </li>

            {{-- Entreprises --}}
            <li>
                <a href="{{ route('admin.entreprises.index') }}"
                   class="{{ request()->routeIs('admin.entreprises.*') ? 'active' : '' }}">
                    <i class="bi bi-building"></i>
                    <span>Entreprises</span>
                </a>
            </li>

            {{-- Offres --}}
            <li>
                <a href="{{ route('admin.offres.index') }}"
                   class="{{ request()->routeIs('admin.offres.*') ? 'active' : '' }}">
                    <i class="bi bi-briefcase"></i>
                    <span>Offres</span>
                </a>
            </li>

            {{-- Candidatures --}}
            <li>
                <a href="{{ route('admin.candidatures.index') }}"
                   class="{{ request()->routeIs('admin.candidatures.*') ? 'active' : '' }}">
                    <i class="bi bi-send"></i>
                    <span>Candidatures</span>
                </a>
            </li>

            {{-- Catégories --}}
            <li>
                <a href="{{ route('admin.categories.index') }}"
                   class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="bi bi-funnel"></i>
                    <span>Catégories</span>
                </a>
            </li>

            {{-- Filières --}}
            <li>
                <a href="{{ route('admin.filieres.index') }}"
                   class="{{ request()->routeIs('admin.filieres.*') ? 'active' : '' }}">
                    <i class="bi bi-diagram-3"></i>
                    <span>Filières</span>
                </a>
            </li>

            {{-- Messages --}}
            <li>
                <a href="{{ route('admin.messages.index') }}"
                   class="{{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                    <i class="bi bi-chat-left"></i>
                    <span>Messages</span>
                </a>
            </li>

            {{-- Signalements --}}
            <li>
                <a href="{{ route('admin.signalements.index') }}"
                   class="{{ request()->routeIs('admin.signalements.*') ? 'active' : '' }}">
                    <i class="bi bi-exclamation-triangle"></i>
                    <span>Signalements</span>
                </a>
            </li>

            {{-- Statistiques --}}
            <li>
                <a href="{{ route('admin.statistiques.index') }}"
                   class="{{ request()->routeIs('admin.statistiques.*') ? 'active' : '' }}">
                    <i class="bi bi-graph-up-arrow"></i>
                    <span>Statistiques</span>
                </a>
            </li>

            {{-- Paramètres --}}
            <li>
                <a href="{{ route('admin.parametres.index') }}"
                   class="{{ request()->routeIs('admin.parametres.*') ? 'active' : '' }}">
                    <i class="bi bi-gear"></i>
                    <span>Paramètres</span>
                </a>
            </li>

        </ul>
    </div>

    <div class="sidebar-bottom">
        <div class="platform-status">
            <h6>Statut de la plateforme</h6>
            <div class="status-line">
                <span class="status-dot"></span>
                <span>En ligne</span>
            </div>
        </div>
    </div>
</div>