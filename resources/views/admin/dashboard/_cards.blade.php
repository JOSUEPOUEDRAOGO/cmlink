<div class="row g-4 mb-4">
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">

                    <div>
                        <p class="text-muted mb-2">
                            Actuellement en ligne
                        </p>

                        <h3 class="fw-bold mb-0" id="online-users-count">
                            {{ $stats['online'] }}
                        </h3>
                    </div>

                    <div class="fs-2 text-success">
                        <i class="bi bi-circle-fill"></i>
                    </div>

                </div>

                <div class="mt-3 small text-muted">
                    Utilisateurs actifs ces 5 dernières minutes
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-2">Étudiants inscrits</p>
                        <h3 class="fw-bold mb-0">{{ $stats['etudiants'] }}</h3>
                    </div>
                    <div class="fs-2 text-primary">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-2">Entreprises</p>
                        <h3 class="fw-bold mb-0">{{ $stats['entreprises'] }}</h3>
                    </div>
                    <div class="fs-2 text-success">
                        <i class="bi bi-building"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-2">Offres publiées</p>
                        <h3 class="fw-bold mb-0">{{ $stats['offres'] }}</h3>
                    </div>
                    <div class="fs-2 text-info">
                        <i class="bi bi-briefcase"></i>
                    </div>
                </div>
                <div class="mt-3 small text-muted">
                    {{ $stats['stages'] }} stages • {{ $stats['emplois'] }} emplois
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-2">Candidatures</p>
                        <h3 class="fw-bold mb-0">{{ $stats['candidatures'] }}</h3>
                    </div>
                    <div class="fs-2 text-warning">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                </div>
                <div class="mt-3 small text-muted">
                    {{ $stats['candidatures_en_attente'] }} en attente • {{ $stats['candidatures_acceptees'] }}
                    acceptées
                </div>
            </div>
        </div>
    </div>
</div>
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

        // Actualisation immédiate
        updateOnlineCount();

        // Puis toutes les 30 secondes
        setInterval(updateOnlineCount, 30000);
    });
</script>
@endauth
