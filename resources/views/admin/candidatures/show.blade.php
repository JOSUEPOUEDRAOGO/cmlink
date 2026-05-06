@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="mb-1 fw-bold">Détail de la candidature</h2>
            <p class="text-muted mb-0">Informations complètes du candidat et de l’offre.</p>
        </div>

       <div class="d-flex gap-2">
    <div class="dropdown">
        <button class="btn btn-light border"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false">
            <i class="bi bi-three-dots-vertical me-1"></i>
            Actions
        </button>

        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-4">
            <li>
                <form action="{{ route('admin.candidatures.status', $candidature) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="statut" value="accepte">
                    <button class="dropdown-item" type="submit">
                        <i class="bi bi-check-circle me-2 text-success"></i>
                        Accepter
                    </button>
                </form>
            </li>

            <li>
                <form action="{{ route('admin.candidatures.status', $candidature) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="statut" value="refuse">
                    <button class="dropdown-item" type="submit">
                        <i class="bi bi-x-circle me-2 text-danger"></i>
                        Refuser
                    </button>
                </form>
            </li>

            <li>
                <form action="{{ route('admin.candidatures.status', $candidature) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="statut" value="en_attente">
                    <button class="dropdown-item" type="submit">
                        <i class="bi bi-hourglass-split me-2 text-warning"></i>
                        Remettre en attente
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <a href="{{ route('admin.candidatures.index') }}" class="btn btn-light border">
        Retour
    </a>
</div>
    </div>

    <div class="row g-4">

        {{-- Candidat --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 p-4">
                    <h5 class="fw-bold mb-1">Candidat</h5>
                    <p class="text-muted mb-0">Informations envoyées depuis le formulaire.</p>
                </div>

                <div class="card-body p-4">
                    <div class="mb-3">
                        <h6 class="text-muted">Nom complet</h6>
                        <p class="fw-semibold mb-0">
                            {{ $candidature->nom
                                ?? trim(($candidature->etudiant->prenom ?? '').' '.($candidature->etudiant->nom ?? ''))
                                ?: 'Candidat inconnu'
                            }}
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted">Email</h6>
                        <p class="fw-semibold mb-0">
                            {{ $candidature->email ?? '-' }}
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted">Téléphone</h6>
                        <p class="fw-semibold mb-0">
                            {{ $candidature->telephone ?? '-' }}
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted">Filière</h6>
                        <p class="fw-semibold mb-0">
                            {{ $candidature->etudiant->filiere->nom ?? '-' }}
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted">CV</h6>

                        @if($candidature->cv_path)
                            <a href="{{ asset('storage/'.$candidature->cv_path) }}" target="_blank" class="btn btn-outline-primary">
                                <i class="bi bi-file-earmark-pdf me-1"></i>
                                Ouvrir le CV
                            </a>
                        @else
                            <p class="text-muted mb-0">Aucun CV envoyé.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Offre --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 p-4">
                    <h5 class="fw-bold mb-1">Offre concernée</h5>
                    <p class="text-muted mb-0">Détails de l’offre liée à cette candidature.</p>
                </div>

                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Offre</h6>
                            <p class="fw-semibold mb-0">
                                {{ $candidature->offre->titre ?? '-' }}
                            </p>
                        </div>

                        <div class="col-md-6">
                            <h6 class="text-muted">Entreprise</h6>
                            <p class="fw-semibold mb-0">
                                {{ $candidature->offre->entreprise->nom ?? '-' }}
                            </p>
                        </div>

                        <div class="col-md-6">
                            <h6 class="text-muted">Catégorie</h6>
                            <p class="fw-semibold mb-0">
                                {{ $candidature->offre->categorie->nom ?? '-' }}
                            </p>
                        </div>

                        <div class="col-md-6">
                            <h6 class="text-muted">Statut</h6>

                            @php
                                $badgeClass = match($candidature->statut) {
                                    'accepte' => 'bg-success',
                                    'refuse' => 'bg-danger',
                                    default => 'bg-warning text-dark',
                                };
                            @endphp

                            <span class="badge {{ $badgeClass }}">
                                {{ ucfirst(str_replace('_', ' ', $candidature->statut)) }}
                            </span>
                        </div>

                        <div class="col-md-6">
                            <h6 class="text-muted">Créée le</h6>
                            <p class="fw-semibold mb-0">
                                {{ $candidature->created_at?->format('d/m/Y H:i') }}
                            </p>
                        </div>

                        <div class="col-md-6">
                            <h6 class="text-muted">Dernière mise à jour</h6>
                            <p class="fw-semibold mb-0">
                                {{ $candidature->updated_at?->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h6 class="text-muted">Message de motivation</h6>

                    @if($candidature->message)
                        <div class="p-3 bg-light rounded-4" style="white-space: pre-line;">
                            {{ $candidature->message }}
                        </div>
                    @else
                        <p class="text-muted mb-0">Aucun message envoyé.</p>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
