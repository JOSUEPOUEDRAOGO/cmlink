<div class="row g-4 mb-4">
    <div class="col-xl-8">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h5 class="mb-0 fw-bold">Évolution mensuelle</h5>
            </div>
            <div class="card-body">
                <div style="height: 320px;">
                    <canvas id="evolutionChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h5 class="mb-0 fw-bold">Répartition des offres</h5>
            </div>
            <div class="card-body">
                <div style="height: 220px;">
                    <canvas id="offresTypeChart"></canvas>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h5 class="mb-0 fw-bold">Statut des candidatures</h5>
            </div>
            <div class="card-body">
                <div style="height: 220px;">
                    <canvas id="candidaturesStatutChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const evolutionCtx = document.getElementById('evolutionChart');
    if (evolutionCtx) {
        new Chart(evolutionCtx, {
            type: 'line',
            data: {
                labels: @json($moisLabels),
                datasets: [
                    {
                        label: 'Étudiants',
                        data: @json($etudiantsParMois),
                        tension: 0.35
                    },
                    {
                        label: 'Offres',
                        data: @json($offresParMois),
                        tension: 0.35
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    const offresTypeCtx = document.getElementById('offresTypeChart');
    if (offresTypeCtx) {
        new Chart(offresTypeCtx, {
            type: 'doughnut',
            data: {
                labels: ['Stages', 'Emplois'],
                datasets: [{
                    data: [
                        {{ $offresParType['stage'] }},
                        {{ $offresParType['emploi'] }}
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    const candidaturesStatutCtx = document.getElementById('candidaturesStatutChart');
    if (candidaturesStatutCtx) {
        new Chart(candidaturesStatutCtx, {
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
});
</script>