@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="mb-1 fw-bold">Détail de la filière</h2>
            <p class="text-muted mb-0">Informations complètes de la filière.</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.filieres.edit', $filiere) }}" class="btn btn-warning">
                <i class="bi bi-pencil-square me-1"></i>
                Modifier
            </a>
            <a href="{{ route('admin.filieres.index') }}" class="btn btn-light border">
                Retour
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <h6 class="text-muted">Nom</h6>
                    <p class="fw-semibold mb-0">{{ $filiere->nom }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Nombre d'étudiants</h6>
                    <p class="fw-semibold mb-0">{{ $filiere->etudiants->count() }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Créée le</h6>
                    <p class="fw-semibold mb-0">{{ $filiere->created_at?->format('d/m/Y H:i') }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Dernière mise à jour</h6>
                    <p class="fw-semibold mb-0">{{ $filiere->updated_at?->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="mb-0 fw-bold">Étudiants liés à cette filière</h5>
        </div>
        <div class="card-body p-4 pt-3">
            @if($filiere->etudiants->count())
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nom complet</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($filiere->etudiants as $etudiant)
                                <tr>
                                    <td>{{ $etudiant->id }}</td>
                                    <td>{{ $etudiant->prenom }} {{ $etudiant->nom }}</td>
                                    <td>{{ $etudiant->email }}</td>
                                    <td>{{ $etudiant->telephone ?: '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted mb-0">Aucun étudiant n'est rattaché à cette filière.</p>
            @endif
        </div>
    </div>
</div>
@endsection