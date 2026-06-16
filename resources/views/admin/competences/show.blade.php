@extends('layouts.admin')
@section('title', 'Compétence — ' . $competence->nom)
@section('content')

<div class="container py-4" style="max-width:720px;">

    <div class="mb-4">
        <a href="{{ route('admin.competences.index') }}" class="text-muted text-decoration-none" style="font-size:13px;">
            <i class="bi bi-arrow-left me-1"></i> Retour aux compétences
        </a>
    </div>

    {{-- En-tête --}}
    <div class="card border-0 shadow-sm rounded-4 mb-3">
        <div class="card-body p-4 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1">{{ $competence->nom }}</h4>
                @if($competence->categorie)
                    <span class="badge rounded-pill bg-light text-dark border">
                        {{ $competence->categorie }}
                    </span>
                @endif
            </div>
            <a href="{{ route('admin.competences.edit', $competence) }}"
                class="btn btn-light rounded-pill">
                <i class="bi bi-pencil me-1"></i> Modifier
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-3">
        <div class="col-6">
            <div class="card border-0 rounded-4 text-center py-4"
                style="background:#EEEDFE;">
                <p class="fw-bold mb-0" style="font-size:28px;color:#3C3489;">
                    {{ $competence->etudiants_count }}
                </p>
                <p class="mb-0" style="font-size:13px;color:#534AB7;">Étudiants</p>
            </div>
        </div>
        <div class="col-6">
            <div class="card border-0 rounded-4 text-center py-4"
                style="background:#E1F5EE;">
                <p class="fw-bold mb-0" style="font-size:28px;color:#085041;">
                    {{ $competence->offres_count }}
                </p>
                <p class="mb-0" style="font-size:13px;color:#0F6E56;">Offres requises</p>
            </div>
        </div>
    </div>

    {{-- Étudiants liés --}}
    <div class="card border-0 shadow-sm rounded-4 mb-3">
        <div class="card-header bg-white border-0 p-4 pb-0">
            <h6 class="fw-bold mb-0">Étudiants avec cette compétence</h6>
        </div>
        <div class="card-body p-4">
            @if($competence->etudiants->isEmpty())
                <p class="text-muted mb-0" style="font-size:13px;">Aucun étudiant pour l'instant.</p>
            @else
                <div class="d-flex flex-wrap gap-2">
                    @foreach($competence->etudiants as $etudiant)
                        <a href="{{ route('admin.etudiants.show', $etudiant) }}"
                            class="badge rounded-pill text-decoration-none"
                            style="background:#F1EFE8;color:#2C2C2A;font-size:12px;padding:6px 12px;">
                            {{ $etudiant->prenom }} {{ $etudiant->nom }}
                            <span class="ms-1 opacity-50">{{ $etudiant->pivot->niveau }}</span>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Offres liées --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 p-4 pb-0">
            <h6 class="fw-bold mb-0">Offres requérant cette compétence</h6>
        </div>
        <div class="card-body p-4">
            @if($competence->offres->isEmpty())
                <p class="text-muted mb-0" style="font-size:13px;">Aucune offre pour l'instant.</p>
            @else
                <div class="d-flex flex-column gap-2">
                    @foreach($competence->offres as $offre)
                        <a href="{{ route('admin.offres.show', $offre) }}"
                            class="d-flex justify-content-between align-items-center text-decoration-none p-3 rounded-3"
                            style="background:#FAFAFA;border:0.5px solid rgba(0,0,0,.07);">
                            <div>
                                <p class="fw-semibold mb-0" style="font-size:14px;color:#2C2C2A;">
                                    {{ $offre->titre }}
                                </p>
                                <p class="mb-0" style="font-size:12px;color:#888780;">
                                    {{ $offre->entreprise->nom ?? '—' }}
                                </p>
                            </div>
                            <span class="badge rounded-pill"
                                style="background:#EEEDFE;color:#3C3489;font-size:11px;">
                                {{ $offre->pivot->niveau_requis }}
                                @if($offre->pivot->obligatoire)
                                    · obligatoire
                                @endif
                            </span>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

</div>

@endsection
