@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="mb-1 fw-bold">Étudiants</h2>
            <p class="text-muted mb-0">Gestion des étudiants inscrits sur la plateforme.</p>
        </div>

        <a href="{{ route('admin.etudiants.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Ajouter un étudiant
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
                            <th class="py-3">Nom complet</th>
                            <th class="py-3">Email</th>
                            <th class="py-3">Téléphone</th>
                            <th class="py-3">Filière</th>
                            <th class="py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($etudiants as $etudiant)
                            <tr>
                                <td class="px-4">{{ $etudiant->id }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $etudiant->prenom }} {{ $etudiant->nom }}</div>
                                </td>
                                <td>{{ $etudiant->email }}</td>
                                <td>{{ $etudiant->telephone ?: '-' }}</td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        {{ $etudiant->filiere->nom ?? '-' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('admin.etudiants.show', $etudiant) }}" class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="{{ route('admin.etudiants.edit', $etudiant) }}" class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('admin.etudiants.destroy', $etudiant) }}" method="POST" onsubmit="return confirm('Supprimer cet étudiant ?')">
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
                                <td colspan="6" class="text-center py-5 text-muted">
                                    Aucun étudiant trouvé.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($etudiants->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $etudiants->links() }}
            </div>
        @endif
    </div>
</div>
@endsection