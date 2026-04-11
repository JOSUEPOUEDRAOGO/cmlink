@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="mb-1 fw-bold">Détail de la candidature</h2>
            <p class="text-muted mb-0">Informations complètes de la candidature.</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.candidatures.edit', $candidature) }}" class="btn btn-warning">
                <i class="bi bi-pencil-square me-1"></i>
                Modifier
            </a>
            <a href="{{ route('admin.candidatures.index') }}" class="btn btn-light border">
                Retour
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <h6 class="text-muted">Étudiant</h6>
                    <p class="fw-semibold mb-0">
                        {{ $candidature->etudiant->prenom ?? '' }} {{ $candidature->etudiant->nom ?? '' }}
                    </p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Filière</h6>
                    <p class="fw-semibold mb-0">{{ $candidature->etudiant->filiere->nom ?? '-' }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Offre</h6>
                    <p class="fw-semibold mb-0">{{ $candidature->offre->titre ?? '-' }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Entreprise</h6>
                    <p class="fw-semibold mb-0">{{ $candidature->offre->entreprise->nom ?? '-' }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Catégorie</h6>
                    <p class="fw-semibold mb-0">{{ $candidature->offre->categorie->nom ?? '-' }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Statut</h6>
                    <p class="fw-semibold mb-0">{{ ucfirst(str_replace('_', ' ', $candidature->statut)) }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Créée le</h6>
                    <p class="fw-semibold mb-0">{{ $candidature->created_at?->format('d/m/Y H:i') }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Dernière mise à jour</h6>
                    <p class="fw-semibold mb-0">{{ $candidature->updated_at?->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection