<div class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-top">
        <div class="brand-box" id="sidebarToggle">
            <div class="brand-icon">C</div>
            <div class="brand-text">
                <h4>Cmlink</h4>
                <span>Administration</span>
            </div>
        </div>

        <ul class="sidebar-menu">

            @can('view admin dashboard')
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                       class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Tableau de bord</span>
                    </a>
                </li>
            @endcan

            @if(auth()->user()->can('manage users') || auth()->user()->can('manage roles') || auth()->user()->can('manage sanctions'))
                <li class="sidebar-dropdown {{ request()->routeIs('admin.users.*') || request()->routeIs('admin.roles.*') || request()->routeIs('admin.sanctions.*') ? 'open' : '' }}">
                    <button type="button" class="sidebar-link sidebar-dropdown-toggle">
                        <i class="bi bi-shield-lock"></i>
                        <span>Administration</span>
                        <i class="bi bi-chevron-down dropdown-arrow"></i>
                    </button>

                    <ul class="submenu">
                        @can('manage users')
                            <li>
                                <a href="{{ route('admin.users.index') }}"
                                   class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                    <i class="bi bi-people"></i>
                                    <span>Utilisateurs</span>
                                </a>
                            </li>
                        @endcan

                        @can('manage roles')
                            <li>
                                <a href="{{ route('admin.roles.index') }}"
                                   class="{{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                                    <i class="bi bi-key"></i>
                                    <span>Rôles & accès</span>
                                </a>
                            </li>
                        @endcan

                        @can('manage sanctions')
                            <li>
                                <a href="{{ route('admin.sanctions.index') }}"
                                   class="{{ request()->routeIs('admin.sanctions.*') ? 'active' : '' }}">
                                    <i class="bi bi-exclamation-octagon"></i>
                                    <span>Sanctions</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif

            @can('manage etudiants')
                <li>
                    <a href="{{ route('admin.etudiants.index') }}"
                       class="{{ request()->routeIs('admin.etudiants.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        <span>Étudiants</span>
                    </a>
                </li>
            @endcan

            @can('manage entreprises')
                <li>
                    <a href="{{ route('admin.entreprises.index') }}"
                       class="{{ request()->routeIs('admin.entreprises.*') ? 'active' : '' }}">
                        <i class="bi bi-building"></i>
                        <span>Entreprises</span>
                    </a>
                </li>
            @endcan

            @can('manage offres')
                <li>
                    <a href="{{ route('admin.offres.index') }}"
                       class="{{ request()->routeIs('admin.offres.*') ? 'active' : '' }}">
                        <i class="bi bi-briefcase"></i>
                        <span>Offres</span>
                    </a>
                </li>
            @endcan

            @can('manage candidatures')
                <li>
                    <a href="{{ route('admin.candidatures.index') }}"
                       class="{{ request()->routeIs('admin.candidatures.*') ? 'active' : '' }}">
                        <i class="bi bi-send"></i>
                        <span>Candidatures</span>
                    </a>
                </li>
            @endcan

            @can('manage categories')
                <li>
                    <a href="{{ route('admin.categories.index') }}"
                       class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i class="bi bi-funnel"></i>
                        <span>Catégories</span>
                    </a>
                </li>
            @endcan

            @can('manage filieres')
                <li>
                    <a href="{{ route('admin.filieres.index') }}"
                       class="{{ request()->routeIs('admin.filieres.*') ? 'active' : '' }}">
                        <i class="bi bi-diagram-3"></i>
                        <span>Filières</span>
                    </a>
                </li>
            @endcan

            @can('manage messages')
                <li>
                    <a href="{{ route('admin.messages.index') }}"
                       class="{{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                        <i class="bi bi-chat-left"></i>
                        <span>Messages</span>
                    </a>
                </li>
            @endcan

            @can('manage signalements')
                <li>
                    <a href="{{ route('admin.signalements.index') }}"
                       class="{{ request()->routeIs('admin.signalements.*') ? 'active' : '' }}">
                        <i class="bi bi-exclamation-triangle"></i>
                        <span>Signalements</span>
                    </a>
                </li>
            @endcan

            @can('manage statistiques')
                <li>
                    <a href="{{ route('admin.statistiques.index') }}"
                       class="{{ request()->routeIs('admin.statistiques.*') ? 'active' : '' }}">
                        <i class="bi bi-graph-up-arrow"></i>
                        <span>Statistiques</span>
                    </a>
                </li>
            @endcan

            @can('manage pages')
                <li class="sidebar-dropdown {{ request()->routeIs('admin.pages.*') ? 'open' : '' }}">
                    <button type="button" class="sidebar-link sidebar-dropdown-toggle">
                        <i class="bi bi-file-earmark-text"></i>
                        <span>Pages</span>
                        <i class="bi bi-chevron-down dropdown-arrow"></i>
                    </button>

                    <ul class="submenu">
                        <li>
                            <a href="{{ route('admin.pages.home') }}"
                               class="{{ request()->routeIs('admin.pages.home') ? 'active' : '' }}">
                                <i class="bi bi-house"></i>
                                <span>Accueil</span>
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <i class="bi bi-briefcase"></i>
                                <span>Offres</span>
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <i class="bi bi-layout-text-window"></i>
                                <span>Footer</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            @can('manage parametres')
                <li>
                    <a href="{{ route('admin.parametres.index') }}"
                       class="{{ request()->routeIs('admin.parametres.*') ? 'active' : '' }}">
                        <i class="bi bi-gear"></i>
                        <span>Paramètres</span>
                    </a>
                </li>
            @endcan

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