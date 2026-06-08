<div class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-top">

        {{-- Brand --}}
        <div class="brand-box" id="sidebarToggle">
            <div class="brand-icon">C</div>

            <div class="brand-text">
                <h4>Cmlink</h4>
                <span>Administration</span>
            </div>
        </div>

        {{-- Menu --}}
        <ul class="sidebar-menu">

            {{-- Dashboard --}}
            @can('view admin dashboard')
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Tableau de bord</span>
                    </a>
                </li>
            @endcan

            {{-- Administration --}}
            @if (auth()->user()->can('manage users') ||
                    auth()->user()->can('manage roles') ||
                    auth()->user()->can('manage sanctions'))
                <li
                    class="sidebar-dropdown {{ request()->routeIs('admin.users.*') || request()->routeIs('admin.roles.*') || request()->routeIs('admin.sanctions.*') ? 'open' : '' }}">

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

            {{-- Étudiants --}}
            @can('manage etudiants')
                <li>
                    <a href="{{ route('admin.etudiants.index') }}"
                        class="{{ request()->routeIs('admin.etudiants.*') ? 'active' : '' }}">
                        <i class="bi bi-mortarboard"></i>
                        <span>Étudiants</span>
                    </a>
                </li>
            @endcan

            {{-- Entreprises --}}
            @can('manage entreprises')
                <li>
                    <a href="{{ route('admin.entreprises.index') }}"
                        class="{{ request()->routeIs('admin.entreprises.*') ? 'active' : '' }}">
                        <i class="bi bi-building"></i>
                        <span>Entreprises</span>
                    </a>
                </li>
            @endcan

            {{-- Offres --}}
            @can('manage offres')
                <li>
                    <a href="{{ route('admin.offres.index') }}"
                        class="{{ request()->routeIs('admin.offres.*') ? 'active' : '' }}">
                        <i class="bi bi-briefcase"></i>
                        <span>Offres</span>
                    </a>
                </li>
            @endcan

            {{-- Mes candidatures --}}

            @auth
                @if (auth()->user()->account_type === 'etudiant' || auth()->user()->account_type === 'admin')
                    <li class="sidebar-dropdown {{ request()->routeIs('admin.mes-candidatures.*') ? 'open' : '' }}">

                        <button type="button" class="sidebar-link sidebar-dropdown-toggle">
                            <i class="bi bi-folder2-open"></i>

                            <span>
                                {{ auth()->user()->account_type === 'admin' ? 'postulés' : 'postulations' }}
                            </span>

                            <i class="bi bi-chevron-down dropdown-arrow"></i>
                        </button>

                        <ul class="submenu">

                            {{-- Toutes les candidatures --}}
                            <li>
                                <a href="{{ route('admin.mes-candidatures.index') }}"
                                    class="{{ request()->routeIs('admin.mes-candidatures.index') ? 'active' : '' }}">
                                    <i class="bi bi-send-check"></i>
                                    <span>Toutes mes candidatures</span>
                                </a>
                            </li>

                            {{-- CV --}}
                            <li>
                                <a href="{{ route('admin.mes-candidatures.cv') }}"
                                    class="{{ request()->routeIs('admin.mes-candidatures.cv') ? 'active' : '' }}">
                                    <i class="bi bi-file-earmark-person"></i>
                                    <span>Mes CV</span>
                                </a>
                            </li>

                            {{-- Lettres de motivation --}}
                            <li>
                                <a href="{{ route('admin.mes-candidatures.motivations') }}"
                                    class="{{ request()->routeIs('admin.mes-candidatures.motivations') ? 'active' : '' }}">
                                    <i class="bi bi-file-earmark-text"></i>
                                    <span>Mes motivations</span>
                                </a>
                            </li>

                            {{-- Acceptées --}}
                            <li>
                                <a href="{{ route('admin.mes-candidatures.acceptees') }}"
                                    class="{{ request()->routeIs('admin.mes-candidatures.acceptees') ? 'active' : '' }}">
                                    <i class="bi bi-patch-check"></i>
                                    <span>Candidatures acceptées</span>
                                </a>
                            </li>

                            {{-- Refusées --}}
                            <li>
                                <a href="{{ route('admin.mes-candidatures.refusees') }}"
                                    class="{{ request()->routeIs('admin.mes-candidatures.refusees') ? 'active' : '' }}">
                                    <i class="bi bi-x-circle"></i>
                                    <span>Candidatures refusées</span>
                                </a>
                            </li>

                            {{-- En attente --}}
                            <li>
                                <a href="{{ route('admin.mes-candidatures.attente') }}"
                                    class="{{ request()->routeIs('admin.mes-candidatures.attente') ? 'active' : '' }}">
                                    <i class="bi bi-hourglass-split"></i>
                                    <span>En attente</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                @endif
            @endauth


            {{-- Candidatures --}}
            @can('manage candidatures')
                <li>
                    <a href="{{ route('admin.candidatures.index') }}"
                        class="{{ request()->routeIs('admin.candidatures.*') ? 'active' : '' }}">
                        <i class="bi bi-send"></i>
                        <span>Candidatures</span>
                    </a>
                </li>
            @endcan

            {{-- Profils publics (talents visibles) --}}
            @role('admin|entreprise')
                <li>
                    <a href="{{ route('admin.profils-publics.index') }}"
                        class="{{ request()->routeIs('admin.profils-publics.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        <span>Profils publics</span>
                    </a>
                </li>
            @endrole

            {{-- Catégories --}}
            @can('manage categories')
                <li>
                    <a href="{{ route('admin.categories.index') }}"
                        class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i class="bi bi-funnel"></i>
                        <span>Catégories</span>
                    </a>
                </li>
            @endcan

            {{-- Filières --}}
            @can('manage filieres')
                <li>
                    <a href="{{ route('admin.filieres.index') }}"
                        class="{{ request()->routeIs('admin.filieres.*') ? 'active' : '' }}">
                        <i class="bi bi-diagram-3"></i>
                        <span>Filières</span>
                    </a>
                </li>
            @endcan

            {{-- Messages --}}
            @can('manage messages')
                <li>
                    <a href="{{ route('admin.messages.index') }}"
                        class="{{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                        <i class="bi bi-chat-left-text"></i>
                        <span>Messages</span>
                    </a>
                </li>
            @endcan

            {{-- Signalements --}}
            @can('manage signalements')
                <li>
                    <a href="{{ route('admin.signalements.index') }}"
                        class="{{ request()->routeIs('admin.signalements.*') ? 'active' : '' }}">
                        <i class="bi bi-exclamation-triangle"></i>
                        <span>Signalements</span>
                    </a>
                </li>
            @endcan

            {{-- Statistiques --}}
            @can('manage statistiques')
                <li>
                    <a href="{{ route('admin.statistiques.index') }}"
                        class="{{ request()->routeIs('admin.statistiques.*') ? 'active' : '' }}">
                        <i class="bi bi-graph-up-arrow"></i>
                        <span>Statistiques</span>
                    </a>
                </li>
            @endcan

            {{-- Pages --}}
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

            {{-- Paramètres --}}
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

    {{-- Bottom --}}
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
