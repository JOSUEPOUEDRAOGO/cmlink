@extends('layouts.admin')
@section('title', 'Détail entretien')
@section('content')

<div class="container py-4" style="max-width:720px;">

    <div class="mb-4">
        <a href="{{ route('admin.entretiens.index') }}" class="text-muted text-decoration-none" style="font-size:13px;">
            <i class="bi bi-arrow-left me-1"></i> Retour aux entretiens
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- En-tête --}}
    <div class="card border-0 shadow-sm rounded-4 mb-3">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h5 class="fw-bold mb-1">
                        {{ $entretien->candidature->etudiant->prenom ?? $entretien->candidature->nom }}
                        {{ $entretien->candidature->etudiant->nom ?? '' }}
                    </h5>
                    <p class="text-muted mb-2" style="font-size:13px;">
                        {{ $entretien->candidature->offre->titre }}
                        · {{ $entretien->candidature->offre->entreprise->nom }}
                    </p>
                    @php
                        $statutConfig = [
                            'planifie' => ['bg' => '#FAEEDA', 'color' => '#633806', 'label' => 'Planifié'],
                            'confirme' => ['bg' => '#E1F5EE', 'color' => '#085041', 'label' => 'Confirmé'],
                            'annule'   => ['bg' => '#FCEBEB', 'color' => '#791F1F', 'label' => 'Annulé'],
                            'effectue' => ['bg' => '#EEEDFE', 'color' => '#3C3489', 'label' => 'Effectué'],
                        ];
                        $s = $statutConfig[$entretien->statut] ?? ['bg' => '#F1EFE8', 'color' => '#444441', 'label' => $entretien->statut];
                    @endphp
                    <span class="badge rounded-pill"
                        style="background:{{ $s['bg'] }};color:{{ $s['color'] }};font-size:12px;padding:5px 12px;">
                        {{ $s['label'] }}
                    </span>
                </div>
                <a href="{{ route('admin.entretiens.edit', $entretien) }}"
                    class="btn btn-light rounded-pill">
                    <i class="bi bi-pencil me-1"></i> Modifier
                </a>
            </div>
        </div>
    </div>

    {{-- Détails --}}
    <div class="card border-0 shadow-sm rounded-4 mb-3">
        <div class="card-body p-4">
            <h6 class="fw-bold mb-3">Détails du rendez-vous</h6>
            <div class="row g-3">
                <div class="col-6">
                    <p class="text-muted mb-1" style="font-size:12px;">Date</p>
                    <p class="fw-semibold mb-0">{{ $entretien->date_rdv->format('d/m/Y') }}</p>
                </div>
                <div class="col-6">
                    <p class="text-muted mb-1" style="font-size:12px;">Heure</p>
                    <p class="fw-semibold mb-0">{{ $entretien->date_rdv->format('H:i') }}</p>
                </div>
                <div class="col-6">
                    <p class="text-muted mb-1" style="font-size:12px;">Type</p>
                    @php
                        $typeLabels = [
                            'presentiel'   => 'Présentiel',
                            'visio'        => 'Visio',
                            'telephonique' => 'Téléphonique',
                        ];
                    @endphp
                    <p class="fw-semibold mb-0">{{ $typeLabels[$entretien->type] ?? $entretien->type }}</p>
                </div>
                <div class="col-6">
                    @if($entretien->type === 'visio' && $entretien->lien_visio)
                        <p class="text-muted mb-1" style="font-size:12px;">Lien visio</p>
                        <a href="{{ $entretien->lien_visio }}" target="_blank"
                            class="btn btn-sm rounded-pill"
                            style="background:#EEEDFE;color:#3C3489;font-size:12px;">
                            <i class="bi bi-camera-video me-1"></i> Rejoindre
                        </a>
                    @elseif($entretien->type === 'presentiel' && $entretien->adresse)
                        <p class="text-muted mb-1" style="font-size:12px;">Adresse</p>
                        <p class="fw-semibold mb-0">{{ $entretien->adresse }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Notes --}}
    @if($entretien->notes)
        <div class="card border-0 shadow-sm rounded-4 mb-3">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-2">Notes</h6>
                <p class="mb-0" style="font-size:14px;line-height:1.7;white-space:pre-wrap;">{{ $entretien->notes }}</p>
            </div>
        </div>
    @endif

    {{-- Résultat --}}
    @if($entretien->resultat)
        <div class="card border-0 shadow-sm rounded-4 mb-3">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-2">Résultat / Feedback</h6>
                <p class="mb-0" style="font-size:14px;line-height:1.7;white-space:pre-wrap;">{{ $entretien->resultat }}</p>
            </div>
        </div>
    @endif

    {{-- Lien candidature --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4 d-flex justify-content-between align-items-center">
            <div>
                <p class="fw-semibold mb-0" style="font-size:14px;">Voir la candidature associée</p>
                <p class="text-muted mb-0" style="font-size:12px;">
                    {{ $entretien->candidature->offre->titre }}
                    · {{ $entretien->candidature->created_at->format('d/m/Y') }}
                </p>
            </div>
            <a href="{{ route('admin.candidatures.show', $entretien->candidature) }}"
                class="btn btn-light rounded-pill">
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>

</div>

@endsection
