@extends('layouts.admin')

@section('title', 'Mes candidatures')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold">Mes candidatures</h2>
            <p class="text-muted mb-0">Suivez l’état de vos postulations.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4 shadow-sm"><i class="bi bi-check-circle me-2"></i> {{ session('success') }}</div>
    @endif

    {{-- Filtres --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('admin.mes-candidatures.index') }}" class="btn btn-sm {{ request()->routeIs('admin.mes-candidatures.index') ? 'btn-primary' : 'btn-outline-secondary' }} rounded-pill">Toutes</a>
                <a href="{{ route('admin.mes-candidatures.acceptees') }}" class="btn btn-sm {{ request()->routeIs('admin.mes-candidatures.acceptees') ? 'btn-success' : 'btn-outline-success' }} rounded-pill">Acceptées</a>
                <a href="{{ route('admin.mes-candidatures.refusees') }}" class="btn btn-sm {{ request()->routeIs('admin.mes-candidatures.refusees') ? 'btn-danger' : 'btn-outline-danger' }} rounded-pill">Refusées</a>
                <a href="{{ route('admin.mes-candidatures.attente') }}" class="btn btn-sm {{ request()->routeIs('admin.mes-candidatures.attente') ? 'btn-warning' : 'btn-outline-warning' }} rounded-pill">En attente</a>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">Offre</th>
                            <th class="py-3">Entreprise</th>
                            <th class="py-3">Postulée le</th>
                            <th class="py-3">Statut</th>
                            <th class="py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($candidatures as $candidature)
                            <tr>
                                <td class="px-4">
                                    <div class="fw-semibold">{{ $candidature->offre->titre }}</div>
                                    <small class="text-muted">{{ $candidature->offre->categorie->nom ?? 'Sans catégorie' }}</small>
                                </td>
                                <td>{{ $candidature->offre->entreprise->nom ?? '—' }}</td>
                                <td>{{ $candidature->created_at->format('d/m/Y') }}</td>
                                <td>
                                    @php
                                        $badgeClass = match($candidature->statut) {
                                            'accepte' => 'success',
                                            'refuse' => 'danger',
                                            default => 'warning'
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $badgeClass }} bg-opacity-10 text-dark rounded-pill px-3 py-2">
                                        {{ ucfirst($candidature->statut) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('admin.mes-candidatures.show', $candidature) }}"
                                           class="btn btn-sm btn-outline-info rounded-circle"
                                           data-bs-toggle="tooltip" title="Voir détail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.mes-candidatures.destroy', $candidature) }}"
                                              method="POST" onsubmit="return confirm('Retirer cette candidature ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle"
                                                    data-bs-toggle="tooltip" title="Annuler ma candidature">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i> Aucune candidature trouvée.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($candidatures->hasPages())
            <div class="card-footer bg-white border-0 py-3">{{ $candidatures->links() }}</div>
        @endif
    </div>
</div>
@endsection
