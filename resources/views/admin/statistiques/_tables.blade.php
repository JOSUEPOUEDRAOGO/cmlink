<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h5 class="mb-0 fw-bold">Top filières</h5>
            </div>
            <div class="card-body">
                @forelse($topFilieres as $filiere)
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>{{ $filiere->nom }}</span>
                        <strong>{{ $filiere->etudiants_count }}</strong>
                    </div>
                @empty
                    <p class="text-muted mb-0">Aucune donnée.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h5 class="mb-0 fw-bold">Top catégories</h5>
            </div>
            <div class="card-body">
                @forelse($topCategories as $categorie)
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>{{ $categorie->nom }}</span>
                        <strong>{{ $categorie->offres_count }}</strong>
                    </div>
                @empty
                    <p class="text-muted mb-0">Aucune donnée.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h5 class="mb-0 fw-bold">Top entreprises</h5>
            </div>
            <div class="card-body">
                @forelse($topEntreprises as $entreprise)
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>{{ $entreprise->nom }}</span>
                        <strong>{{ $entreprise->offres_count }}</strong>
                    </div>
                @empty
                    <p class="text-muted mb-0">Aucune donnée.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>