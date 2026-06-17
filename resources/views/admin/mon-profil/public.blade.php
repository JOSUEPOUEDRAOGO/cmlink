@extends('layouts.admin')

@section('title', 'Mon profil public')

@section('content')

@php
    $user = auth()->user();
    $cvs  = $etudiant->cvs;
    $hasAvatar = (bool) $user->avatar;
@endphp

<div class="container py-4" style="max-width:880px;">

    <div class="mb-4">
        <h4 class="fw-bold mb-1">Mon profil public</h4>
        <p class="text-muted mb-0" style="font-size:13px;">
            Contrôlez ce que les entreprises peuvent voir de votre profil.
        </p>
    </div>

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

    {{-- ═══════════════════ CARTE PHOTO DE PROFIL ═══════════════════ --}}
    <div class="card border-0 shadow-sm rounded-4 mb-3">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-4">

                <div class="position-relative flex-shrink-0">
                    @if($hasAvatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}"
                            class="rounded-circle border"
                            style="width:84px;height:84px;object-fit:cover;"
                            alt="Photo de profil">
                    @else
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                            style="width:84px;height:84px;background:#F1EFE8;color:#888780;font-size:28px;">
                            <i class="bi bi-person"></i>
                        </div>
                    @endif

                    @if($etudiant->photo_publique && $hasAvatar)
                        <span class="position-absolute bottom-0 end-0 rounded-circle d-flex align-items-center justify-content-center"
                            style="width:26px;height:26px;background:#10B981;border:3px solid #fff;">
                            <i class="bi bi-check-lg text-white" style="font-size:12px;"></i>
                        </span>
                    @endif
                </div>

                <div class="flex-grow-1">
                    <h6 class="fw-bold mb-1">Photo de profil publique</h6>
                    @if(!$hasAvatar)
                        <p class="text-muted mb-2" style="font-size:13px;">
                            Vous n'avez pas encore ajouté de photo à votre compte.
                        </p>
                        <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-light rounded-pill border"
                            style="font-size:12px;">
                            <i class="bi bi-camera me-1"></i> Ajouter une photo dans mon compte
                        </a>
                    @else
                        <p class="mb-0" style="font-size:13px;color:{{ $etudiant->photo_publique ? '#085041' : '#888780' }};">
                            {{ $etudiant->photo_publique
                                ? 'Visible par les entreprises sur votre profil public.'
                                : 'Actuellement masquée des recruteurs.' }}
                        </p>
                    @endif
                </div>

                @if($hasAvatar)
                    <form action="{{ route('admin.mon-profil-public.toggle-photo') }}" method="POST" class="flex-shrink-0">
                        @csrf @method('PATCH')
                        <button type="submit"
                            class="btn rounded-pill d-flex align-items-center gap-2"
                            style="font-size:13px;font-weight:500;
                            background:{{ $etudiant->photo_publique ? '#FCEBEB' : '#E1F5EE' }};
                            color:{{ $etudiant->photo_publique ? '#791F1F' : '#085041' }};
                            border:0.5px solid {{ $etudiant->photo_publique ? '#F09595' : '#6EE7B7' }};">
                            <i class="bi bi-{{ $etudiant->photo_publique ? 'eye-slash' : 'eye' }}"></i>
                            {{ $etudiant->photo_publique ? 'Rendre privée' : 'Rendre publique' }}
                        </button>
                    </form>
                @endif

            </div>
        </div>
    </div>

    {{-- ═══════════════════ CARTE LETTRE DE MOTIVATION ═══════════════════ --}}
    <div class="card border-0 shadow-sm rounded-4 mb-3">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-start gap-3">
                <div class="d-flex align-items-start gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width:44px;height:44px;background:#EEEDFE;">
                        <i class="bi bi-file-earmark-text" style="color:#3C3489;font-size:18px;"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Lettre de motivation</h6>
                        @if($etudiant->derniereLettre)
                            <p class="mb-0" style="font-size:13px;">
                                {{ $etudiant->derniereLettre->titre }}
                            </p>
                            <p class="text-muted mb-0" style="font-size:12px;">
                                Mise à jour le {{ $etudiant->derniereLettre->updated_at->format('d/m/Y') }}
                            </p>
                        @else
                            <p class="text-muted mb-0" style="font-size:13px;">
                                Aucune lettre rédigée.
                            </p>
                        @endif
                    </div>
                </div>

                @if($etudiant->derniereLettre)
                    <form action="{{ route('admin.mon-profil-public.toggle-lettre') }}" method="POST" class="flex-shrink-0">
                        @csrf @method('PATCH')
                        <button type="submit"
                            class="btn rounded-pill d-flex align-items-center gap-2"
                            style="font-size:13px;font-weight:500;
                            background:{{ $etudiant->lettre_public ? '#FCEBEB' : '#E1F5EE' }};
                            color:{{ $etudiant->lettre_public ? '#791F1F' : '#085041' }};
                            border:0.5px solid {{ $etudiant->lettre_public ? '#F09595' : '#6EE7B7' }};">
                            <i class="bi bi-{{ $etudiant->lettre_public ? 'eye-slash' : 'eye' }}"></i>
                            {{ $etudiant->lettre_public ? 'Rendre privée' : 'Rendre publique' }}
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    {{-- ═══════════════════ CARTE GESTION DES CV ═══════════════════ --}}
    <div class="card border-0 shadow-sm rounded-4 mb-3">
        <div class="card-header bg-white border-0 p-4 pb-0 d-flex justify-content-between align-items-center">
            <div>
                <h6 class="fw-bold mb-1">Mes CV</h6>
                <p class="text-muted mb-0" style="font-size:12px;">
                    {{ $cvs->count() }} CV enregistré(s)
                </p>
            </div>

            @if($etudiant->cvPrincipal)
                <form action="{{ route('admin.mon-profil-public.toggle-cv') }}" method="POST">
                    @csrf @method('PATCH')
                    <button type="submit"
                        class="btn rounded-pill d-flex align-items-center gap-2"
                        style="font-size:13px;font-weight:500;
                        background:{{ $etudiant->cv_public ? '#FCEBEB' : '#E1F5EE' }};
                        color:{{ $etudiant->cv_public ? '#791F1F' : '#085041' }};
                        border:0.5px solid {{ $etudiant->cv_public ? '#F09595' : '#6EE7B7' }};">
                        <i class="bi bi-{{ $etudiant->cv_public ? 'eye-slash' : 'eye' }}"></i>
                        {{ $etudiant->cv_public ? 'CV principal — Rendre privé' : 'CV principal — Rendre public' }}
                    </button>
                </form>
            @endif
        </div>

        <div class="card-body p-4">

            {{-- Liste des CV --}}
            @if($cvs->isEmpty())
                <div class="text-center py-4">
                    <i class="bi bi-file-earmark-x fs-3 text-muted d-block mb-2"></i>
                    <p class="text-muted mb-0" style="font-size:13px;">
                        Aucun CV pour l'instant. Ajoutez-en un ci-dessous.
                    </p>
                </div>
            @else
                <div class="d-flex flex-column gap-2 mb-4">
                    @foreach($cvs as $cv)
                        <div class="d-flex align-items-center justify-content-between p-3 rounded-3"
                            style="background:{{ $cv->principal ? '#F5F3FF' : '#FAFAFA' }};
                            border:0.5px solid {{ $cv->principal ? '#D8D4F7' : 'rgba(0,0,0,.07)' }};">

                            <div class="d-flex align-items-center gap-3 flex-grow-1" style="min-width:0;">
                                <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                                    style="width:38px;height:38px;background:{{ $cv->principal ? '#EEEDFE' : '#F1EFE8' }};">
                                    <i class="bi bi-file-earmark-pdf"
                                        style="color:{{ $cv->principal ? '#3C3489' : '#888780' }};"></i>
                                </div>
                                <div style="min-width:0;">
                                    <div class="d-flex align-items-center gap-2">
                                        <p class="fw-semibold mb-0" style="font-size:14px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                            {{ $cv->titre }}
                                        </p>
                                        @if($cv->principal)
                                            <span class="badge rounded-pill flex-shrink-0"
                                                style="font-size:10px;background:#3C3489;color:#fff;">
                                                Principal
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-muted mb-0" style="font-size:11px;">
                                        Ajouté le {{ $cv->created_at->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-2 flex-shrink-0">
                                <a href="{{ Storage::disk('public')->url($cv->cv_path) }}" target="_blank"
                                    class="btn btn-sm btn-light rounded-pill" style="font-size:12px;">
                                    <i class="bi bi-eye"></i>
                                </a>

                                @if(!$cv->principal)
                                    <form action="{{ route('admin.mon-profil-public.cv.principal', $cv) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-light rounded-pill"
                                            style="font-size:12px;" title="Définir comme principal">
                                            <i class="bi bi-star"></i>
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('admin.mon-profil-public.cv.destroy', $cv) }}" method="POST"
                                    onsubmit="return confirm('Supprimer ce CV définitivement ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light rounded-pill text-danger"
                                        style="font-size:12px;">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Formulaire ajout nouveau CV --}}
            <form action="{{ route('admin.mon-profil-public.cv.store') }}" method="POST"
                enctype="multipart/form-data"
                class="p-3 rounded-3" style="background:#FAFAFA;border:0.5px dashed rgba(0,0,0,.15);">
                @csrf
                <p class="fw-semibold mb-3" style="font-size:13px;">
                    <i class="bi bi-plus-circle me-1"></i> Ajouter un nouveau CV
                </p>
                <div class="row g-2">
                    <div class="col-md-5">
                        <input type="text" name="titre"
                            class="form-control rounded-3 @error('titre') is-invalid @enderror"
                            placeholder="Ex: CV Développeur 2026"
                            value="{{ old('titre') }}">
                        @error('titre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-5">
                        <input type="file" name="cv_file" accept=".pdf"
                            class="form-control rounded-3 @error('cv_file') is-invalid @enderror">
                        @error('cv_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary rounded-3 w-100">
                            <i class="bi bi-upload"></i>
                        </button>
                    </div>
                </div>
                <small class="text-muted d-block mt-2">PDF uniquement, max 5 Mo.</small>
            </form>

        </div>
    </div>

</div>

@endsection