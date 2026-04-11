@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="mb-1 fw-bold">Détail de l'entreprise</h2>
            <p class="text-muted mb-0">Informations complètes de l'entreprise.</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.entreprises.edit', $entreprise) }}" class="btn btn-warning">
                <i class="bi bi-pencil-square me-1"></i>
                Modifier
            </a>
            <a href="{{ route('admin.entreprises.index') }}" class="btn btn-light border">
                Retour
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <h6 class="text-muted">Nom</h6>
                    <p class="fw-semibold mb-0">{{ $entreprise->nom }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Email</h6>
                    <p class="fw-semibold mb-0">{{ $entreprise->email }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Téléphone</h6>
                    <p class="fw-semibold mb-0">{{ $entreprise->telephone ?: '-' }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Adresse</h6>
                    <p class="fw-semibold mb-0">{{ $entreprise->adresse ?: '-' }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Nombre d'offres</h6>
                    <p class="fw-semibold mb-0">{{ $entreprise->offres->count() }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Créée le</h6>
                    <p class="fw-semibold mb-0">{{ $entreprise->created_at?->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="mb-0 fw-bold">Offres publiées</h5>
        </div>
        <div class="card-body p-4 pt-3">
            @if($entreprise->offres->count())
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Titre</th>
                                <th>Type</th>
                                <th>Localisation</th>
                                <th>Date d'expiration</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($entreprise->offres as $offre)
                                <tr>
                                    <td>{{ $offre->id }}</td>
                                    <td>{{ $offre->titre }}</td>
                                    <td>
                                        <span class="badge {{ $offre->type === 'stage' ? 'bg-info' : 'bg-success' }}">
                                            {{ ucfirst($offre->type) }}
                                        </span>
                                    </td>
                                    <td>{{ $offre->localisation ?: '-' }}</td>
                                    <td>{{ $offre->date_expiration?->format('d/m/Y') ?: '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted mb-0">Aucune offre publiée pour cette entreprise.</p>
            @endif
        </div>
    </div>
</div>
@endsection