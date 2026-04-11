@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="mb-1 fw-bold">Détail de l'étudiant</h2>
            <p class="text-muted mb-0">Informations complètes du profil étudiant.</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.etudiants.edit', $etudiant) }}" class="btn btn-warning">
                <i class="bi bi-pencil-square me-1"></i>
                Modifier
            </a>
            <a href="{{ route('admin.etudiants.index') }}" class="btn btn-light border">
                Retour
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <h6 class="text-muted">Nom</h6>
                    <p class="fw-semibold mb-0">{{ $etudiant->nom }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Prénom</h6>
                    <p class="fw-semibold mb-0">{{ $etudiant->prenom }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Email</h6>
                    <p class="fw-semibold mb-0">{{ $etudiant->email }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Téléphone</h6>
                    <p class="fw-semibold mb-0">{{ $etudiant->telephone ?: '-' }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Filière</h6>
                    <p class="fw-semibold mb-0">{{ $etudiant->filiere->nom ?? '-' }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Créé le</h6>
                    <p class="fw-semibold mb-0">{{ $etudiant->created_at?->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mt-4">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="mb-0 fw-bold">Candidatures</h5>
        </div>
        <div class="card-body p-4 pt-3">
            @if($etudiant->candidatures->count())
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Offre</th>
                                <th>Statut</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($etudiant->candidatures as $candidature)
                                <tr>
                                    <td>{{ $candidature->offre->titre ?? '-' }}</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $candidature->statut)) }}</td>
                                    <td>{{ $candidature->created_at?->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted mb-0">Aucune candidature pour cet étudiant.</p>
            @endif
        </div>
    </div>
</div>
@endsection