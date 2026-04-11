<div class="row g-4 mb-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h5 class="mb-0 fw-bold">Répartition des offres</h5>
            </div>
            <div class="card-body">
                <canvas id="offresChart" height="140"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h5 class="mb-0 fw-bold">Statut des candidatures</h5>
            </div>
            <div class="card-body">
                <canvas id="candidaturesChart" height="140"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const offresCtx = document.getElementById('offresChart');
    if (offresCtx) {
        new Chart(offresCtx, {
            type: 'doughnut',
            data: {
                labels: ['Stages', 'Emplois'],
                datasets: [{
                    data: [
                        {{ $offresParType['stages'] }},
                        {{ $offresParType['emplois'] }}
                    ]
                }]
            }
        });
    }

    const candidaturesCtx = document.getElementById('candidaturesChart');
    if (candidaturesCtx) {
        new Chart(candidaturesCtx, {
            type: 'bar',
            data: {
                labels: ['En attente', 'Acceptées', 'Refusées'],
                datasets: [{
                    label: 'Candidatures',
                    data: [
                        {{ $candidaturesParStatut['en_attente'] }},
                        {{ $candidaturesParStatut['accepte'] }},
                        {{ $candidaturesParStatut['refuse'] }}
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }
</script>