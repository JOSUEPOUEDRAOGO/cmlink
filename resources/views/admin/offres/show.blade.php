@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="mb-1 fw-bold">Détail de l'offre</h2>
            <p class="text-muted mb-0">Informations complètes de l'offre.</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.offres.edit', $offre) }}" class="btn btn-warning">
                <i class="bi bi-pencil-square me-1"></i>
                Modifier
            </a>
            <a href="{{ route('admin.offres.index') }}" class="btn btn-light border">
                Retour
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <h6 class="text-muted">Titre</h6>
                    <p class="fw-semibold mb-0">{{ $offre->titre }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Type</h6>
                    <p class="fw-semibold mb-0">
                        <span class="badge {{ $offre->type === 'stage' ? 'bg-info' : 'bg-success' }}">
                            {{ ucfirst($offre->type) }}
                        </span>
                    </p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Entreprise</h6>
                    <p class="fw-semibold mb-0">{{ $offre->entreprise->nom ?? '-' }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Catégorie</h6>
                    <p class="fw-semibold mb-0">{{ $offre->categorie->nom ?? '-' }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Localisation</h6>
                    <p class="fw-semibold mb-0">{{ $offre->localisation ?: '-' }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Date d'expiration</h6>
                    <p class="fw-semibold mb-0">{{ $offre->date_expiration?->format('d/m/Y') ?: '-' }}</p>
                </div>

                <div class="col-12">
                    <h6 class="text-muted">Description</h6>
                    <p class="fw-semibold mb-0">{{ $offre->description }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Nombre de candidatures</h6>
                    <p class="fw-semibold mb-0">{{ $offre->candidatures->count() }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Créée le</h6>
                    <p class="fw-semibold mb-0">{{ $offre->created_at?->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="mb-0 fw-bold">Candidatures liées</h5>
        </div>
        <div class="card-body p-4 pt-3">
            @if($offre->candidatures->count())
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Étudiant</th>
                                <th>Statut</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($offre->candidatures as $candidature)
                                <tr>
                                    <td>{{ $candidature->id }}</td>
                                    <td>{{ $candidature->etudiant->prenom ?? '' }} {{ $candidature->etudiant->nom ?? '' }}</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $candidature->statut)) }}</td>
                                    <td>{{ $candidature->created_at?->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted mb-0">Aucune candidature liée à cette offre.</p>
            @endif
        </div>
    </div>
</div>
@endsection