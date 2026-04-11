<div class="row g-4">
    <div class="col-xl-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Offres récentes</h5>
                <a href="{{ route('admin.offres.index') }}" class="btn btn-sm btn-light border">Voir tout</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4">Titre</th>
                                <th>Type</th>
                                <th>Entreprise</th>
                                <th class="pe-4">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dernieresOffres as $offre)
                                <tr>
                                    <td class="px-4 fw-semibold">{{ $offre->titre }}</td>
                                    <td>
                                        <span class="badge {{ $offre->type === 'stage' ? 'bg-info' : 'bg-success' }}">
                                            {{ ucfirst($offre->type) }}
                                        </span>
                                    </td>
                                    <td>{{ $offre->entreprise->nom ?? '-' }}</td>
                                    <td class="pe-4">{{ $offre->created_at?->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Aucune offre récente.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Dernières candidatures</h5>
                <a href="{{ route('admin.candidatures.index') }}" class="btn btn-sm btn-light border">Voir tout</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4">Étudiant</th>
                                <th>Offre</th>
                                <th>Statut</th>
                                <th class="pe-4">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dernieresCandidatures as $candidature)
                                <tr>
                                    <td class="px-4 fw-semibold">
                                        {{ $candidature->etudiant->prenom ?? '' }} {{ $candidature->etudiant->nom ?? '' }}
                                    </td>
                                    <td>{{ $candidature->offre->titre ?? '-' }}</td>
                                    <td>
                                        @php
                                            $badgeClass = match($candidature->statut) {
                                                'accepte' => 'bg-success',
                                                'refuse' => 'bg-danger',
                                                default => 'bg-warning text-dark',
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">
                                            {{ ucfirst(str_replace('_', ' ', $candidature->statut)) }}
                                        </span>
                                    </td>
                                    <td class="pe-4">{{ $candidature->created_at?->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Aucune candidature récente.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-1">
    <div class="col-xl-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h5 class="mb-0 fw-bold">Top entreprises</h5>
            </div>
            <div class="card-body">
                @forelse($topEntreprises as $entreprise)
                    <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                        <div>
                            <div class="fw-semibold">{{ $entreprise->nom }}</div>
                            <small class="text-muted">{{ $entreprise->email }}</small>
                        </div>
                        <span class="badge bg-light text-dark">{{ $entreprise->offres_count }} offres</span>
                    </div>
                @empty
                    <p class="text-muted mb-0">Aucune donnée disponible.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>