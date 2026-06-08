@extends('layouts.admin')

@section('title', 'Profils publics')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold">Profils publics</h2>
            <p class="text-muted mb-0">Étudiants ayant rendu leur CV ou lettre de motivation visible.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">Étudiant</th>
                            <th class="py-3">Filière</th>
                            <th class="py-3">CV</th>
                            <th class="py-3">Lettre</th>
                            <th class="py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($etudiants as $etudiant)
                            @php
                                $cvPrincipal = $etudiant->cvPrincipal;
                                $derniereLettre = $etudiant->derniereLettre;
                            @endphp
                            <tr>
                                <td class="px-4">
                                    <div class="fw-semibold">{{ $etudiant->prenom }} {{ $etudiant->nom }}</div>
                                    <small class="text-muted">{{ $etudiant->user->email }}</small>
                                </td>
                                <td>{{ $etudiant->filiere->nom ?? '—' }}</td>
                                <td>
                                    @if($etudiant->cv_public && $cvPrincipal)
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">
                                            <i class="bi bi-check-circle me-1"></i> Public
                                        </span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-2">
                                            <i class="bi bi-lock me-1"></i> Privé
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($etudiant->lettre_public && $derniereLettre)
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">
                                            <i class="bi bi-check-circle me-1"></i> Public
                                        </span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-2">
                                            <i class="bi bi-lock me-1"></i> Privé
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        @if($etudiant->cv_public && $cvPrincipal)
                                            <a href="{{ route('admin.profils-publics.download-cv', $etudiant) }}"
                                               class="btn btn-sm btn-outline-primary rounded-circle"
                                               data-bs-toggle="tooltip" title="Télécharger le CV">
                                                <i class="bi bi-file-pdf"></i>
                                            </a>
                                        @endif
                                        @if($etudiant->lettre_public && $derniereLettre)
                                            <a href="{{ route('admin.profils-publics.lettre', $etudiant) }}"
                                               class="btn btn-sm btn-outline-info rounded-circle"
                                               data-bs-toggle="tooltip" title="Voir la lettre">
                                                <i class="bi bi-envelope"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <td>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-person-x fs-1 d-block mb-2"></i>
                                    Aucun étudiant n’a activé la visibilité publique.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($etudiants->hasPages())
            <div class="card-footer bg-white border-0 py-3">{{ $etudiants->links() }}</div>
        @endif
    </div>
</div>
@endsection
