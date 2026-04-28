@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="mb-1 fw-bold">Détail de la catégorie</h2>
            <p class="text-muted mb-0">Informations complètes de la catégorie.</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.categories.edit', $categorie) }}" class="btn btn-warning">
                <i class="bi bi-pencil-square me-1"></i>
                Modifier
            </a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-light border">
                Retour
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <h6 class="text-muted">Nom</h6>
                    <p class="fw-semibold mb-0">{{ $categorie->nom }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Nombre d'offres</h6>
                    <p class="fw-semibold mb-0">{{ $categorie->offres->count() }}</p>
                </div>

                <div class="col-12">
                    <h6 class="text-muted">Description</h6>
                    <p class="fw-semibold mb-0">{{ $categorie->description ?: '-' }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Créée le</h6>
                    <p class="fw-semibold mb-0">{{ $categorie->created_at?->format('d/m/Y H:i') }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Dernière mise à jour</h6>
                    <p class="fw-semibold mb-0">{{ $categorie->updated_at?->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="mb-0 fw-bold">Offres liées à cette catégorie</h5>
        </div>
        <div class="card-body p-4 pt-3">
            @if($categorie->offres->count())
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Titre</th>
                                <th>Type</th>
                                <th>Entreprise</th>
                                <th>Localisation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categorie->offres as $offre)
                                <tr>
                                    <td>{{ $offre->id }}</td>
                                    <td>{{ $offre->titre }}</td>
                                    <td>
                                        <span class="badge {{ $offre->type === 'stage' ? 'bg-info' : 'bg-success' }}">
                                            {{ ucfirst($offre->type) }}
                                        </span>
                                    </td>
                                    <td>{{ $offre->entreprise->nom ?? '-' }}</td>
                                    <td>{{ $offre->localisation ?: '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted mb-0">Aucune offre liée à cette catégorie.</p>
            @endif
        </div>
    </div>
</div>
@endsection
