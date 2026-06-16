@extends('layouts.admin')
@section('title', 'Mon profil')
@section('content')

@php
    $initiales = strtoupper(substr($etudiant->prenom, 0, 1) . substr($etudiant->nom, 0, 1));
    $niveauLabels = [
        'debutant'      => 'Débutant',
        'intermediaire' => 'Intermédiaire',
        'avance'        => 'Avancé',
        'expert'        => 'Expert',
    ];
    $niveauColors = [
        'debutant'      => ['bg' => '#F1EFE8', 'color' => '#444441'],
        'intermediaire' => ['bg' => '#FAEEDA', 'color' => '#633806'],
        'avance'        => ['bg' => '#EEEDFE', 'color' => '#3C3489'],
        'expert'        => ['bg' => '#E1F5EE', 'color' => '#085041'],
    ];
@endphp

<div class="container py-4" style="max-width:860px;">

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-4 mb-4">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- En-tête profil --}}
    <div class="card border-0 shadow-sm rounded-4 mb-3">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
                    style="width:64px;height:64px;background:#EEEDFE;color:#3C3489;font-size:20px;">
                    {{ $initiales }}
                </div>
                <div class="flex-grow-1">
                    <h4 class="fw-bold mb-0">{{ $etudiant->prenom }} {{ $etudiant->nom }}</h4>
                    <p class="text-muted mb-1" style="font-size:13px;">
                        {{ $etudiant->filiere->nom ?? '—' }}
                        @if($etudiant->ville)
                            &nbsp;·&nbsp; <i class="bi bi-geo-alt"></i> {{ $etudiant->ville }}
                        @endif
                        @if($etudiant->disponible_le)
                            &nbsp;·&nbsp; Disponible le {{ $etudiant->disponible_le->format('d/m/Y') }}
                        @endif
                    </p>
                    <div class="d-flex gap-2 flex-wrap">
                        <span class="badge rounded-pill"
                            style="font-size:11px;background:{{ $etudiant->cv_public ? '#E1F5EE' : '#F1EFE8' }};color:{{ $etudiant->cv_public ? '#085041' : '#444441' }};">
                            <i class="bi bi-file-earmark-person me-1"></i>
                            CV {{ $etudiant->cv_public ? 'public' : 'privé' }}
                        </span>
                        <span class="badge rounded-pill"
                            style="font-size:11px;background:{{ $etudiant->lettre_public ? '#E1F5EE' : '#F1EFE8' }};color:{{ $etudiant->lettre_public ? '#085041' : '#444441' }};">
                            <i class="bi bi-file-earmark-text me-1"></i>
                            Lettre {{ $etudiant->lettre_public ? 'publique' : 'privée' }}
                        </span>
                        @if($etudiant->niveau_etudes)
                            <span class="badge rounded-pill"
                                style="font-size:11px;background:#EEEDFE;color:#3C3489;">
                                {{ strtoupper($etudiant->niveau_etudes) }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="d-flex flex-column gap-2 flex-shrink-0">
                    <form action="{{ route('admin.mon-profil.toggle-cv') }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit"
                            class="btn btn-sm rounded-pill w-100"
                            style="font-size:12px;background:{{ $etudiant->cv_public ? '#FCEBEB' : '#E1F5EE' }};color:{{ $etudiant->cv_public ? '#791F1F' : '#085041' }};border:none;">
                            <i class="bi bi-{{ $etudiant->cv_public ? 'eye-slash' : 'eye' }} me-1"></i>
                            CV {{ $etudiant->cv_public ? 'Rendre privé' : 'Rendre public' }}
                        </button>
                    </form>
                    <form action="{{ route('admin.mon-profil.toggle-lettre') }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit"
                            class="btn btn-sm rounded-pill w-100"
                            style="font-size:12px;background:{{ $etudiant->lettre_public ? '#FCEBEB' : '#E1F5EE' }};color:{{ $etudiant->lettre_public ? '#791F1F' : '#085041' }};border:none;">
                            <i class="bi bi-{{ $etudiant->lettre_public ? 'eye-slash' : 'eye' }} me-1"></i>
                            Lettre {{ $etudiant->lettre_public ? 'Rendre privée' : 'Rendre publique' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-7">

            {{-- Infos personnelles --}}
            <div class="card border-0 shadow-sm rounded-4 mb-3">
                <div class="card-header bg-white border-0 p-4 pb-0">
                    <h6 class="fw-bold mb-0">Informations personnelles</h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.mon-profil.update') }}" method="POST">
                        @csrf @method('PATCH')

                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label fw-semibold" style="font-size:13px;">Ville</label>
                                <input type="text"
                                    name="ville"
                                    value="{{ old('ville', $etudiant->ville) }}"
                                    class="form-control rounded-3 @error('ville') is-invalid @enderror"
                                    placeholder="Ex: Rabat">
                                @error('ville')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold" style="font-size:13px;">Téléphone</label>
                                <input type="text"
                                    name="telephone"
                                    value="{{ old('telephone', $etudiant->telephone) }}"
                                    class="form-control rounded-3 @error('telephone') is-invalid @enderror"
                                    placeholder="Ex: 06XXXXXXXX">
                                @error('telephone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold" style="font-size:13px;">Date de naissance</label>
                                <input type="date"
                                    name="date_naissance"
                                    value="{{ old('date_naissance', $etudiant->date_naissance?->format('Y-m-d')) }}"
                                    class="form-control rounded-3 @error('date_naissance') is-invalid @enderror">
                                @error('date_naissance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold" style="font-size:13px;">Disponible le</label>
                                <input type="date"
                                    name="disponible_le"
                                    value="{{ old('disponible_le', $etudiant->disponible_le?->format('Y-m-d')) }}"
                                    class="form-control rounded-3 @error('disponible_le') is-invalid @enderror">
                                @error('disponible_le')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold" style="font-size:13px;">Niveau d'études</label>
                                <select name="niveau_etudes"
                                    class="form-select rounded-3 @error('niveau_etudes') is-invalid @enderror">
                                    <option value="">-- Sélectionner --</option>
                                    @foreach(['bac' => 'Bac', 'bac+2' => 'Bac+2', 'bac+3' => 'Bac+3', 'bac+5' => 'Bac+5', 'doctorat' => 'Doctorat'] as $val => $label)
                                        <option value="{{ $val }}"
                                            {{ old('niveau_etudes', $etudiant->niveau_etudes) === $val ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('niveau_etudes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-primary rounded-pill">
                                <i class="bi bi-check-lg me-2"></i> Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Mes compétences --}}
            <div class="card border-0 shadow-sm rounded-4 mb-3">
                <div class="card-header bg-white border-0 p-4 pb-0">
                    <h6 class="fw-bold mb-0">Mes compétences</h6>
                </div>
                <div class="card-body p-4">

                    {{-- Compétences existantes --}}
                    @if($etudiant->competences->isEmpty())
                        <p class="text-muted mb-3" style="font-size:13px;">
                            Aucune compétence ajoutée pour l'instant.
                        </p>
                    @else
                        <div class="d-flex flex-column gap-2 mb-4">
                            @foreach($etudiant->competences as $competence)
                                <div class="d-flex align-items-center justify-content-between p-3 rounded-3"
                                    style="background:#FAFAFA;border:0.5px solid rgba(0,0,0,.07);">
                                    <div class="d-flex align-items-center gap-3">
                                        <div>
                                            <p class="fw-semibold mb-0" style="font-size:14px;">{{ $competence->nom }}</p>
                                            @if($competence->categorie)
                                                <p class="text-muted mb-0" style="font-size:11px;">{{ $competence->categorie }}</p>
                                            @endif
                                        </div>
                                        @php $nc = $niveauColors[$competence->pivot->niveau] ?? $niveauColors['debutant']; @endphp
                                        <span class="badge rounded-pill"
                                            style="font-size:11px;background:{{ $nc['bg'] }};color:{{ $nc['color'] }};">
                                            {{ $niveauLabels[$competence->pivot->niveau] ?? $competence->pivot->niveau }}
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        {{-- Changer niveau --}}
                                        <form action="{{ route('admin.mon-profil.competences.update', $competence) }}"
                                            method="POST" class="d-flex gap-1">
                                            @csrf @method('PATCH')
                                            <select name="niveau"
                                                class="form-select form-select-sm rounded-3"
                                                style="font-size:12px;width:auto;"
                                                onchange="this.form.submit()">
                                                @foreach($niveauLabels as $val => $label)
                                                    <option value="{{ $val }}"
                                                        {{ $competence->pivot->niveau === $val ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </form>
                                        {{-- Retirer --}}
                                        <form action="{{ route('admin.mon-profil.competences.destroy', $competence) }}"
                                            method="POST"
                                            onsubmit="return confirm('Retirer cette compétence ?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-sm btn-light rounded-pill text-danger"
                                                style="font-size:12px;">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Ajouter une compétence --}}
                    <form action="{{ route('admin.mon-profil.competences.store') }}" method="POST">
                        @csrf
                        <p class="fw-semibold mb-2" style="font-size:13px;">Ajouter une compétence</p>
                        <div class="d-flex gap-2">
                            <select name="competence_id"
                                class="form-select rounded-3 @error('competence_id') is-invalid @enderror"
                                style="font-size:13px;">
                                <option value="">-- Choisir --</option>
                                @foreach($competencesDisponibles as $c)
                                    @if(!$etudiant->competences->contains($c->id))
                                        <option value="{{ $c->id }}" {{ old('competence_id') == $c->id ? 'selected' : '' }}>
                                            {{ $c->nom }}
                                            @if($c->categorie) ({{ $c->categorie }}) @endif
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            <select name="niveau"
                                class="form-select rounded-3 @error('niveau') is-invalid @enderror"
                                style="font-size:13px;width:160px;">
                                @foreach($niveauLabels as $val => $label)
                                    <option value="{{ $val }}" {{ old('niveau') === $val ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary rounded-pill flex-shrink-0">
                                <i class="bi bi-plus-lg"></i>
                            </button>
                        </div>
                        @error('competence_id')
                            <div class="text-danger mt-1" style="font-size:12px;">{{ $message }}</div>
                        @enderror
                    </form>
                </div>
            </div>

        </div>

        <div class="col-lg-5">

            {{-- CV principal --}}
            <div class="card border-0 shadow-sm rounded-4 mb-3">
                <div class="card-header bg-white border-0 p-4 pb-0">
                    <h6 class="fw-bold mb-0">Mon CV</h6>
                </div>
                <div class="card-body p-4">
                    @if($etudiant->cvPrincipal)
                        <div class="d-flex align-items-center justify-content-between p-3 rounded-3"
                            style="background:#FAFAFA;border:0.5px solid rgba(0,0,0,.07);">
                            <div>
                                <p class="fw-semibold mb-0" style="font-size:13px;">
                                    {{ $etudiant->cvPrincipal->titre }}
                                </p>
                                <p class="text-muted mb-0" style="font-size:11px;">
                                    Ajouté le {{ $etudiant->cvPrincipal->created_at->format('d/m/Y') }}
                                </p>
                            </div>
                            <span class="badge rounded-pill"
                                style="background:#E1F5EE;color:#085041;font-size:11px;">
                                Principal
                            </span>
                        </div>
                    @else
                        <p class="text-muted mb-0" style="font-size:13px;">
                            Aucun CV principal défini.
                        </p>
                    @endif
                    <a href="{{ route('admin.mes-candidatures.cv') }}"
                        class="btn btn-light rounded-pill w-100 mt-3"
                        style="font-size:13px;">
                        <i class="bi bi-file-earmark-person me-2"></i> Gérer mes CV
                    </a>
                </div>
            </div>

            {{-- Dernière lettre --}}
            <div class="card border-0 shadow-sm rounded-4 mb-3">
                <div class="card-header bg-white border-0 p-4 pb-0">
                    <h6 class="fw-bold mb-0">Ma lettre de motivation</h6>
                </div>
                <div class="card-body p-4">
                    @if($etudiant->derniereLettre)
                        <div class="p-3 rounded-3"
                            style="background:#FAFAFA;border:0.5px solid rgba(0,0,0,.07);">
                            <p class="fw-semibold mb-1" style="font-size:13px;">
                                {{ $etudiant->derniereLettre->titre }}
                            </p>
                            <p class="text-muted mb-0" style="font-size:11px;">
                                Modifiée le {{ $etudiant->derniereLettre->updated_at->format('d/m/Y') }}
                            </p>
                        </div>
                    @else
                        <p class="text-muted mb-0" style="font-size:13px;">
                            Aucune lettre de motivation rédigée.
                        </p>
                    @endif
                    <a href="{{ route('admin.mes-candidatures.motivations') }}"
                        class="btn btn-light rounded-pill w-100 mt-3"
                        style="font-size:13px;">
                        <i class="bi bi-file-earmark-text me-2"></i> Gérer mes lettres
                    </a>
                </div>
            </div>

            {{-- Stats candidatures --}}
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 p-4 pb-0">
                    <h6 class="fw-bold mb-0">Mes candidatures</h6>
                </div>
                <div class="card-body p-4">
                    @php
                        $total     = $etudiant->candidatures->count();
                        $acceptees = $etudiant->candidatures->where('statut', 'accepte')->count();
                        $refusees  = $etudiant->candidatures->where('statut', 'refuse')->count();
                        $attente   = $etudiant->candidatures->where('statut', 'en_attente')->count();
                    @endphp
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <div class="rounded-3 text-center py-3"
                                style="background:#EEEDFE;">
                                <p class="fw-bold mb-0" style="font-size:22px;color:#3C3489;">{{ $total }}</p>
                                <p class="mb-0" style="font-size:11px;color:#534AB7;">Total</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="rounded-3 text-center py-3"
                                style="background:#E1F5EE;">
                                <p class="fw-bold mb-0" style="font-size:22px;color:#085041;">{{ $acceptees }}</p>
                                <p class="mb-0" style="font-size:11px;color:#0F6E56;">Acceptées</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="rounded-3 text-center py-3"
                                style="background:#FCEBEB;">
                                <p class="fw-bold mb-0" style="font-size:22px;color:#791F1F;">{{ $refusees }}</p>
                                <p class="mb-0" style="font-size:11px;color:#A32D2D;">Refusées</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="rounded-3 text-center py-3"
                                style="background:#FAEEDA;">
                                <p class="fw-bold mb-0" style="font-size:22px;color:#633806;">{{ $attente }}</p>
                                <p class="mb-0" style="font-size:11px;color:#854F0B;">En attente</p>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('admin.mes-candidatures.index') }}"
                        class="btn btn-light rounded-pill w-100"
                        style="font-size:13px;">
                        <i class="bi bi-send-check me-2"></i> Voir toutes mes candidatures
                    </a>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection
