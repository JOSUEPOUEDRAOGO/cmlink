@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="mb-1 fw-bold">Entreprises</h2>
            <p class="text-muted mb-0">Gestion des entreprises partenaires et recruteurs.</p>
        </div>

        <a href="{{ route('admin.entreprises.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Ajouter une entreprise
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
                            <th class="py-3">Nom</th>
                            <th class="py-3">Email</th>
                            <th class="py-3">Téléphone</th>
                            <th class="py-3">Adresse</th>
                            <th class="py-3">Offres</th>
                            <th class="py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($entreprises as $entreprise)
                            <tr>
                                <td class="px-4">{{ $entreprise->id }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $entreprise->nom }}</div>
                                </td>
                                <td>{{ $entreprise->email }}</td>
                                <td>{{ $entreprise->telephone ?: '-' }}</td>
                                <td>{{ $entreprise->adresse ?: '-' }}</td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        {{ $entreprise->offres_count ?? 0 }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('admin.entreprises.show', $entreprise) }}" class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="{{ route('admin.entreprises.edit', $entreprise) }}" class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('admin.entreprises.destroy', $entreprise) }}" method="POST" onsubmit="return confirm('Supprimer cette entreprise ?')">
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
                                <td colspan="7" class="text-center py-5 text-muted">
                                    Aucune entreprise trouvée.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($entreprises->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $entreprises->links() }}
            </div>
        @endif
    </div>
</div>
@endsection