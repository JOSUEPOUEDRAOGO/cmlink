@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="mb-1 fw-bold">Offres</h2>
            <p class="text-muted mb-0">Gestion des offres de stages et d'emplois.</p>
        </div>

        <a href="{{ route('admin.offres.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Ajouter une offre
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">#</th>
                            <th class="py-3">Titre</th>
                            <th class="py-3">Type</th>
                            <th class="py-3">Entreprise</th>
                            <th class="py-3">Catégorie</th>
                            <th class="py-3">Localisation</th>
                            <th class="py-3">Expiration</th>
                            <th class="py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($offres as $offre)
                            <tr>
                                <td class="px-4">{{ $offre->id }}</td>
                                <td class="fw-semibold">{{ $offre->titre }}</td>
                                <td>
                                    <span class="badge {{ $offre->type === 'stage' ? 'bg-info' : 'bg-success' }}">
                                        {{ ucfirst($offre->type) }}
                                    </span>
                                </td>
                                <td>{{ $offre->entreprise->nom ?? '-' }}</td>
                                <td>{{ $offre->categorie->nom ?? '-' }}</td>
                                <td>{{ $offre->localisation ?: '-' }}</td>
                                <td>{{ $offre->date_expiration?->format('d/m/Y') ?: '-' }}</td>
                                <td class="text-center">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('admin.offres.show', $offre) }}" class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="{{ route('admin.offres.edit', $offre) }}" class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('admin.offres.destroy', $offre) }}" method="POST" onsubmit="return confirm('Supprimer cette offre ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    Aucune offre trouvée.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($offres->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $offres->links() }}
            </div>
        @endif
    </div>
</div>
@endsection