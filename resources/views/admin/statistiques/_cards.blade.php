<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body">
                <h6 class="text-muted">Étudiants</h6>
                <h3 class="fw-bold mb-0">{{ $stats['total_etudiants'] }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body">
                <h6 class="text-muted">Entreprises</h6>
                <h3 class="fw-bold mb-0">{{ $stats['total_entreprises'] }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body">
                <h6 class="text-muted">Offres</h6>
                <h3 class="fw-bold mb-0">{{ $stats['total_offres'] }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body">
                <h6 class="text-muted">Candidatures</h6>
                <h3 class="fw-bold mb-0">{{ $stats['total_candidatures'] }}</h3>
            </div>
        </div>
    </div>
</div>