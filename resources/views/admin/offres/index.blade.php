@extends('layouts.admin')

@section('title', 'Offres')

@section('content')
<div class="container-fluid">

    {{-- En-tête --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-0">Offres</h4>
            <p class="text-muted mb-0" style="font-size:13px;">
                {{ $offres->total() }} offre(s) au total
            </p>
        </div>
        <a href="{{ route('admin.offres.create') }}" class="btn btn-primary rounded-pill">
            <i class="bi bi-plus-lg me-2"></i> Ajouter une offre
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Filtres --}}
    <div class="card border-0 shadow-sm rounded-4 mb-3">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('admin.offres.index') }}"
                class="d-flex flex-wrap gap-2 align-items-end">

                <div>
                    <label class="form-label mb-1" style="font-size:12px;color:var(--bs-secondary);">Recherche</label>
                    <input type="text" name="q" value="{{ request('q') }}"
                        class="form-control form-control-sm rounded-3"
                        placeholder="Titre, entreprise..."
                        style="min-width:200px;">
                </div>

                <div>
                    <label class="form-label mb-1" style="font-size:12px;color:var(--bs-secondary);">Type</label>
                    <select name="type" class="form-select form-select-sm rounded-3">
                        <option value="">Tous</option>
                        <option value="stage"  {{ request('type') === 'stage'  ? 'selected' : '' }}>Stage</option>
                        <option value="emploi" {{ request('type') === 'emploi' ? 'selected' : '' }}>Emploi</option>
                    </select>
                </div>

                <div>
                    <label class="form-label mb-1" style="font-size:12px;color:var(--bs-secondary);">Télétravail</label>
                    <select name="teletravail" class="form-select form-select-sm rounded-3">
                        <option value="">Tous</option>
                        <option value="1" {{ request('teletravail') === '1' ? 'selected' : '' }}>Oui</option>
                        <option value="0" {{ request('teletravail') === '0' ? 'selected' : '' }}>Non</option>
                    </select>
                </div>

                <div>
                    <label class="form-label mb-1" style="font-size:12px;color:var(--bs-secondary);">Statut</label>
                    <select name="statut" class="form-select form-select-sm rounded-3">
                        <option value="">Tous</option>
                        <option value="actif"  {{ request('statut') === 'actif'  ? 'selected' : '' }}>Actives</option>
                        <option value="expire" {{ request('statut') === 'expire' ? 'selected' : '' }}>Expirées</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-sm btn-primary rounded-pill">
                        <i class="bi bi-search me-1"></i> Filtrer
                    </button>
                    <a href="{{ route('admin.offres.index') }}"
                        class="btn btn-sm btn-light rounded-pill border">
                        <i class="bi bi-x-lg"></i>
                    </a>
                </div>

            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3">Offre</th>
                            <th class="py-3">Entreprise</th>
                            <th class="py-3">Détails</th>
                            <th class="py-3">Compétences</th>
                            <th class="py-3">Expiration</th>
                            <th class="py-3">Candidatures</th>
                            <th class="py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($offres as $offre)
                            <tr>
                                {{-- Offre --}}
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <span class="badge rounded-pill"
                                            style="font-size:11px;
                                            background:{{ $offre->type === 'stage' ? '#EEEDFE' : '#E1F5EE' }};
                                            color:{{ $offre->type === 'stage' ? '#3C3489' : '#085041' }};">
                                            {{ $offre->type === 'stage' ? 'Stage' : 'Emploi' }}
                                        </span>
                                        @if($offre->teletravail)
                                            <span class="badge rounded-pill"
                                                style="font-size:11px;background:#FAEEDA;color:#633806;">
                                                Télétravail
                                            </span>
                                        @endif
                                    </div>
                                    <p class="fw-semibold mb-0" style="font-size:14px;">
                                        {{ $offre->titre }}
                                    </p>
                                    @if($offre->localisation)
                                        <p class="text-muted mb-0" style="font-size:12px;">
                                            <i class="bi bi-geo-alt me-1"></i>{{ $offre->localisation }}
                                        </p>
                                    @endif
                                </td>

                                {{-- Entreprise --}}
                                <td>
                                    <p class="fw-semibold mb-0" style="font-size:13px;">
                                        {{ $offre->entreprise->nom ?? '—' }}
                                    </p>
                                    @if($offre->categorie)
                                        <p class="text-muted mb-0" style="font-size:12px;">
                                            {{ $offre->categorie->nom }}
                                        </p>
                                    @endif
                                </td>

                                {{-- Détails --}}
                                <td>
                                    @if($offre->salaire_min || $offre->salaire_max)
                                        <p class="mb-0" style="font-size:12px;">
                                            <i class="bi bi-cash me-1 text-muted"></i>
                                            @if($offre->salaire_min && $offre->salaire_max)
                                                {{ number_format($offre->salaire_min, 0, ',', ' ') }}
                                                – {{ number_format($offre->salaire_max, 0, ',', ' ') }} MAD
                                            @elseif($offre->salaire_min)
                                                Dès {{ number_format($offre->salaire_min, 0, ',', ' ') }} MAD
                                            @endif
                                        </p>
                                    @endif
                                    @if($offre->niveau_experience)
                                        <p class="mb-0" style="font-size:12px;">
                                            <i class="bi bi-bar-chart me-1 text-muted"></i>
                                            {{ ucfirst($offre->niveau_experience) }}
                                        </p>
                                    @endif
                                    @if($offre->nb_postes > 1)
                                        <p class="mb-0" style="font-size:12px;">
                                            <i class="bi bi-people me-1 text-muted"></i>
                                            {{ $offre->nb_postes }} postes
                                        </p>
                                    @endif
                                </td>

                                {{-- Compétences --}}
                                <td>
                                    @if($offre->competences->isNotEmpty())
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach($offre->competences->take(3) as $competence)
                                                <span class="badge rounded-pill"
                                                    style="font-size:11px;background:#F1EFE8;color:#2C2C2A;">
                                                    {{ $competence->nom }}
                                                </span>
                                            @endforeach
                                            @if($offre->competences->count() > 3)
                                                <span class="badge rounded-pill"
                                                    style="font-size:11px;background:#F1EFE8;color:#888780;">
                                                    +{{ $offre->competences->count() - 3 }}
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-muted" style="font-size:12px;">—</span>
                                    @endif
                                </td>

                                {{-- Expiration --}}
                                <td>
                                    @if($offre->date_expiration)
                                        @if($offre->date_expiration->isPast())
                                            <span class="badge rounded-pill"
                                                style="font-size:11px;background:#FCEBEB;color:#791F1F;">
                                                <i class="bi bi-x-circle me-1"></i>
                                                Expirée
                                            </span>
                                        @elseif($offre->date_expiration->diffInDays(now()) <= 7)
                                            <span class="badge rounded-pill"
                                                style="font-size:11px;background:#FAEEDA;color:#633806;">
                                                <i class="bi bi-clock me-1"></i>
                                                {{ $offre->date_expiration->format('d/m/Y') }}
                                            </span>
                                        @else
                                            <span style="font-size:12px;color:var(--bs-body-color);">
                                                {{ $offre->date_expiration->format('d/m/Y') }}
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-muted" style="font-size:12px;">—</span>
                                    @endif
                                </td>

                                {{-- Candidatures --}}
                                <td>
                                    <span class="badge rounded-pill"
                                        style="background:#EEEDFE;color:#3C3489;font-size:12px;padding:5px 10px;">
                                        {{ $offre->candidatures_count }}
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td class="text-center">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('admin.offres.show', $offre) }}"
                                            class="btn btn-sm btn-light rounded-pill">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.offres.edit', $offre) }}"
                                            class="btn btn-sm btn-light rounded-pill">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.offres.destroy', $offre) }}"
                                            method="POST"
                                            onsubmit="return confirm('Supprimer cette offre ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-sm btn-light rounded-pill text-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-briefcase fs-3 d-block mb-2"></i>
                                    Aucune offre trouvée.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($offres->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4">
                {{ $offres->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
