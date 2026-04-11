@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="mb-1 fw-bold">Détail du paramètre</h2>
            <p class="text-muted mb-0">Informations complètes du paramètre.</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.parametres.edit', $parametre) }}" class="btn btn-warning">
                <i class="bi bi-pencil-square me-1"></i>
                Modifier
            </a>
            <a href="{{ route('admin.parametres.index') }}" class="btn btn-light border">
                Retour
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <h6 class="text-muted">Clé</h6>
                    <p class="fw-semibold mb-0">{{ $parametre->cle }}</p>
                </div>

                <div class="col-12">
                    <h6 class="text-muted">Valeur</h6>
                    <div class="p-3 bg-light rounded-3">
                        {{ $parametre->valeur ?: '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Créé le</h6>
                    <p class="fw-semibold mb-0">{{ $parametre->created_at?->format('d/m/Y H:i') }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Dernière mise à jour</h6>
                    <p class="fw-semibold mb-0">{{ $parametre->updated_at?->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection