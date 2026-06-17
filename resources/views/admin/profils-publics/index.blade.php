@extends('layouts.admin')

@section('title', 'Profils publics')

@section('content')
<div class="container-fluid px-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-0">Profils publics</h4>
            <p class="text-muted mb-0" style="font-size:13px;">
                Étudiants ayant rendu visible leur photo, CV ou lettre de motivation.
            </p>
        </div>
        <span class="badge rounded-pill" style="font-size:12px;background:#EEEDFE;color:#3C3489;padding:7px 14px;">
            {{ $etudiants->total() }} profil(s)
        </span>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3">Étudiant</th>
                            <th class="py-3">Filière</th>
                            <th class="py-3">Photo</th>
                            <th class="py-3">CV</th>
                            <th class="py-3">Lettre</th>
                            <th class="py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($etudiants as $etudiant)
                            @php
                                $cvPrincipal    = $etudiant->cvPrincipal;
                                $derniereLettre = $etudiant->derniereLettre;
                                $photoVisible   = $etudiant->photo_publique && $etudiant->user->avatar;
                                $initiales      = strtoupper(substr($etudiant->prenom, 0, 1) . substr($etudiant->nom, 0, 1));
                            @endphp
                            <tr>

                                {{-- Étudiant + avatar --}}
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        @if($photoVisible)
                                            <img src="{{ asset('storage/' . $etudiant->user->avatar) }}"
                                                class="rounded-circle border"
                                                style="width:40px;height:40px;object-fit:cover;"
                                                alt="{{ $etudiant->prenom }}">
                                        @else
                                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-semibold"
                                                style="width:40px;height:40px;background:#F1EFE8;color:#888780;font-size:13px;">
                                                {{ $initiales }}
                                            </div>
                                        @endif
                                        <div>
                                            <p class="fw-semibold mb-0" style="font-size:14px;">
                                                {{ $etudiant->prenom }} {{ $etudiant->nom }}
                                            </p>
                                            <p class="text-muted mb-0" style="font-size:12px;">
                                                {{ $etudiant->user->email }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Filière --}}
                                <td style="font-size:13px;">
                                    {{ $etudiant->filiere->nom ?? '—' }}
                                </td>

                                {{-- Photo --}}
                                <td>
                                    @if($photoVisible)
                                        <span class="badge rounded-pill" style="font-size:11px;background:#E1F5EE;color:#085041;">
                                            <i class="bi bi-check-circle me-1"></i> Publique
                                        </span>
                                    @else
                                        <span class="badge rounded-pill" style="font-size:11px;background:#F1EFE8;color:#444441;">
                                            <i class="bi bi-lock me-1"></i> Privée
                                        </span>
                                    @endif
                                </td>

                                {{-- CV --}}
                                <td>
                                    @if($etudiant->cv_public && $cvPrincipal)
                                        <span class="badge rounded-pill" style="font-size:11px;background:#E1F5EE;color:#085041;">
                                            <i class="bi bi-check-circle me-1"></i> Public
                                        </span>
                                    @else
                                        <span class="badge rounded-pill" style="font-size:11px;background:#F1EFE8;color:#444441;">
                                            <i class="bi bi-lock me-1"></i> Privé
                                        </span>
                                    @endif
                                </td>

                                {{-- Lettre --}}
                                <td>
                                    @if($etudiant->lettre_public && $derniereLettre)
                                        <span class="badge rounded-pill" style="font-size:11px;background:#E1F5EE;color:#085041;">
                                            <i class="bi bi-check-circle me-1"></i> Public
                                        </span>
                                    @else
                                        <span class="badge rounded-pill" style="font-size:11px;background:#F1EFE8;color:#444441;">
                                            <i class="bi bi-lock me-1"></i> Privé
                                        </span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        @if($etudiant->cv_public && $cvPrincipal)
                                            <a href="{{ route('admin.profils-publics.download-cv', $etudiant) }}"
                                                class="btn btn-sm btn-light rounded-pill"
                                                title="Télécharger le CV">
                                                <i class="bi bi-file-pdf"></i>
                                            </a>
                                        @endif
                                        @if($etudiant->lettre_public && $derniereLettre)
                                            <a href="{{ route('admin.profils-publics.lettre', $etudiant) }}"
                                                class="btn btn-sm btn-light rounded-pill"
                                                title="Voir la lettre">
                                                <i class="bi bi-envelope"></i>
                                            </a>
                                        @endif
                                        @if(!$photoVisible && !($etudiant->cv_public && $cvPrincipal) && !($etudiant->lettre_public && $derniereLettre))
                                            <span class="text-muted" style="font-size:12px;">—</span>
                                        @endif
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-person-x fs-3 d-block mb-2"></i>
                                    Aucun étudiant n'a activé la visibilité publique.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($etudiants->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4">
                {{ $etudiants->links() }}
            </div>
        @endif
    </div>
</div>
@endsection