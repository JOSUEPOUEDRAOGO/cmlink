@extends('layouts.admin')

@section('title', 'Détail de ma candidature')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white border-0 p-4 pb-0">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="fw-bold mb-1">{{ $candidature->offre->titre }}</h3>
                            <p class="text-muted">{{ $candidature->offre->entreprise->nom ?? 'Entreprise inconnue' }}</p>
                        </div>
                        <span class="badge bg-{{ match($candidature->statut) {
                            'accepte' => 'success',
                            'refuse' => 'danger',
                            default => 'warning'
                        } }} rounded-pill px-3 py-2">
                            {{ ucfirst($candidature->statut) }}
                        </span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="border rounded-4 p-3 bg-light">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class="bi bi-calendar3 text-primary"></i>
                                    <span class="fw-semibold">Date de candidature</span>
                                </div>
                                <p class="mb-0">{{ $candidature->created_at->format('d/m/Y à H:i') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border rounded-4 p-3 bg-light">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class="bi bi-building text-primary"></i>
                                    <span class="fw-semibold">Localisation</span>
                                </div>
                                <p class="mb-0">{{ $candidature->offre->localisation ?: 'Non spécifiée' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Message de motivation --}}
                    <div class="mt-4">
                        <h5 class="fw-semibold"><i class="bi bi-chat-text me-2"></i> Message de motivation</h5>
                        <div class="border rounded-4 p-3 bg-white mt-2">
                            <p class="mb-0">{{ $candidature->message ?? 'Aucun message fourni.' }}</p>
                        </div>
                    </div>

                    {{-- CV --}}
                    @if($candidature->cv_path)
                    <div class="mt-4">
                        <h5 class="fw-semibold"><i class="bi bi-file-pdf me-2"></i> CV joint</h5>
                        <div class="border rounded-4 p-3 bg-white mt-2">
                            <a href="{{ asset('storage/'.$candidature->cv_path) }}" target="_blank" class="btn btn-outline-primary rounded-pill">
                                <i class="bi bi-download me-2"></i> Télécharger mon CV
                            </a>
                        </div>
                    </div>
                    @endif

                    {{-- Bouton annuler --}}
                    @if($candidature->statut === 'en_attente')
                    <div class="mt-5 text-center">
                        <form action="{{ route('admin.mes-candidatures.destroy', $candidature) }}" method="POST" onsubmit="return confirm('Retirer définitivement cette candidature ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger rounded-pill px-4">
                                <i class="bi bi-x-circle me-2"></i> Annuler ma candidature
                            </button>
                        </form>
                        <p class="text-muted small mt-2">Seules les candidatures en attente peuvent être annulées.</p>
                    </div>
                    @endif
                </div>

                <div class="card-footer bg-white border-0 p-4 text-center">
                    <a href="{{ route('admin.mes-candidatures.index') }}" class="btn btn-secondary rounded-pill px-4">
                        <i class="bi bi-arrow-left me-2"></i> Retour à la liste
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
