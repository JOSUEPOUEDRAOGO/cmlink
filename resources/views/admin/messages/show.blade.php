@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="mb-1 fw-bold">Détail du message</h2>
            <p class="text-muted mb-0">Informations complètes du message.</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.messages.edit', $message) }}" class="btn btn-warning">
                <i class="bi bi-pencil-square me-1"></i>
                Modifier
            </a>
            <a href="{{ route('admin.messages.index') }}" class="btn btn-light border">
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
                        @if($message->etudiant)
                            {{ $message->etudiant->prenom }} {{ $message->etudiant->nom }}
                        @else
                            -
                        @endif
                    </p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Entreprise</h6>
                    <p class="fw-semibold mb-0">{{ $message->entreprise->nom ?? '-' }}</p>
                </div>

                <div class="col-12">
                    <h6 class="text-muted">Contenu</h6>
                    <div class="p-3 bg-light rounded-3">
                        {{ $message->contenu }}
                    </div>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Créé le</h6>
                    <p class="fw-semibold mb-0">{{ $message->created_at?->format('d/m/Y H:i') }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Dernière mise à jour</h6>
                    <p class="fw-semibold mb-0">{{ $message->updated_at?->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection