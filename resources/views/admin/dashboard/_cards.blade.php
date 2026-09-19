<div class="row g-3 g-lg-4 mb-4">

    {{-- UTILISATEURS EN LIGNE --}}
    <div class="col-12 col-sm-6 col-lg-4 col-xxl">
        <div class="card border-0 shadow-sm rounded-4 h-100 dashboard-stat-card">
            <div class="card-body p-3 p-xl-4">

                <div class="d-flex justify-content-between align-items-start gap-2">

                    <div class="min-w-0">
                        <p class="text-muted mb-1 small text-truncate">
                            Actuellement en ligne
                        </p>

                        <h3
                            class="fw-bold mb-0"
                            id="online-users-count"
                        >
                            {{ $stats['online'] }}
                        </h3>
                    </div>

                    <div class="stat-icon text-success flex-shrink-0">
                        <i class="bi bi-circle-fill"></i>
                    </div>

                </div>

                <div class="mt-2 small text-muted text-truncate">
                    Actifs ces 5 dernières minutes
                </div>

            </div>
        </div>
    </div>


    {{-- ÉTUDIANTS --}}
    <div class="col-12 col-sm-6 col-lg-4 col-xxl">
        <div class="card border-0 shadow-sm rounded-4 h-100 dashboard-stat-card">
            <div class="card-body p-3 p-xl-4">

                <div class="d-flex justify-content-between align-items-start gap-2">

                    <div class="min-w-0">
                        <p class="text-muted mb-1 small text-truncate">
                            Étudiants inscrits
                        </p>

                        <h3 class="fw-bold mb-0">
                            {{ $stats['etudiants'] }}
                        </h3>
                    </div>

                    <div class="stat-icon text-primary flex-shrink-0">
                        <i class="bi bi-people"></i>
                    </div>

                </div>

            </div>
        </div>
    </div>


    {{-- ENTREPRISES --}}
    <div class="col-12 col-sm-6 col-lg-4 col-xxl">
        <div class="card border-0 shadow-sm rounded-4 h-100 dashboard-stat-card">
            <div class="card-body p-3 p-xl-4">

                <div class="d-flex justify-content-between align-items-start gap-2">

                    <div class="min-w-0">
                        <p class="text-muted mb-1 small text-truncate">
                            Entreprises
                        </p>

                        <h3 class="fw-bold mb-0">
                            {{ $stats['entreprises'] }}
                        </h3>
                    </div>

                    <div class="stat-icon text-success flex-shrink-0">
                        <i class="bi bi-building"></i>
                    </div>

                </div>

            </div>
        </div>
    </div>


    {{-- OFFRES --}}
    <div class="col-12 col-sm-6 col-lg-6 col-xxl">
        <div class="card border-0 shadow-sm rounded-4 h-100 dashboard-stat-card">
            <div class="card-body p-3 p-xl-4">

                <div class="d-flex justify-content-between align-items-start gap-2">

                    <div class="min-w-0">
                        <p class="text-muted mb-1 small text-truncate">
                            Offres publiées
                        </p>

                        <h3 class="fw-bold mb-0">
                            {{ $stats['offres'] }}
                        </h3>
                    </div>

                    <div class="stat-icon text-info flex-shrink-0">
                        <i class="bi bi-briefcase"></i>
                    </div>

                </div>

                <div class="mt-2 small text-muted text-truncate">
                    {{ $stats['stages'] }} stages
                    <span class="mx-1">•</span>
                    {{ $stats['emplois'] }} emplois
                </div>

            </div>
        </div>
    </div>


    {{-- CANDIDATURES --}}
    <div class="col-12 col-sm-6 col-lg-6 col-xxl">
        <div class="card border-0 shadow-sm rounded-4 h-100 dashboard-stat-card">
            <div class="card-body p-3 p-xl-4">

                <div class="d-flex justify-content-between align-items-start gap-2">

                    <div class="min-w-0">
                        <p class="text-muted mb-1 small text-truncate">
                            Candidatures
                        </p>

                        <h3 class="fw-bold mb-0">
                            {{ $stats['candidatures'] }}
                        </h3>
                    </div>

                    <div class="stat-icon text-warning flex-shrink-0">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>

                </div>

                <div class="mt-2 small text-muted text-truncate">
                    {{ $stats['candidatures_en_attente'] }} en attente
                    <span class="mx-1">•</span>
                    {{ $stats['candidatures_acceptees'] }} acceptées
                </div>

            </div>
        </div>
    </div>

</div>


{{-- HEARTBEAT / ACTUALISATION DU COMPTEUR --}}
@auth
<script>
    document.addEventListener('DOMContentLoaded', () => {

        const onlineCountElement =
            document.getElementById('online-users-count');

        if (!onlineCountElement) {
            return;
        }

        const updateOnlineCount = async () => {

            try {

                const response = await fetch(
                    @json(route('admin.dashboard.online-count')),
                    {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        credentials: 'same-origin',
                    }
                );

                if (!response.ok) {
                    return;
                }

                const data = await response.json();

                onlineCountElement.textContent = data.online;

            } catch (error) {

                console.warn(
                    'Impossible de récupérer le nombre d’utilisateurs en ligne.',
                    error
                );

            }
        };

        // Première récupération immédiate
        updateOnlineCount();

        // Actualisation toutes les 30 secondes
        setInterval(updateOnlineCount, 30000);

    });
</script>
@endauth
<style>
    .dashboard-stat-card {
        min-width: 0;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .dashboard-stat-card:hover {
        transform: translateY(-2px);
    }

    .dashboard-stat-card .card-body {
        min-width: 0;
    }

    .stat-icon {
        font-size: 1.65rem;
        line-height: 1;
    }

    @media (max-width: 575.98px) {
        .dashboard-stat-card .card-body {
            padding: 1rem !important;
        }

        .stat-icon {
            font-size: 1.4rem;
        }
    }

    @media (min-width: 1400px) {
        .col-xxl {
            flex: 1 0 0%;
            width: auto;
        }
    }
</style>
