@extends('layouts.admin')

@section('title', 'Mes lettres de motivation')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-lg-5">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <i class="bi bi-file-earmark-text fs-1 text-primary"></i>
                        <h3 class="fw-bold mb-0">Mes lettres de motivation</h3>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success rounded-4">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger rounded-4">{{ session('error') }}</div>
                    @endif

                    @if(!$etudiant)
                        <div class="alert alert-warning rounded-4">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Aucun profil étudiant associé à votre compte. Veuillez contacter l'administration.
                        </div>
                    @else
                        {{-- Dernière lettre (actuelle) --}}
                        <div class="mb-4">
                            <h5 class="fw-semibold">Dernière lettre</h5>
                            @if($derniereLettre)
                                <div class="alert alert-info rounded-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <i class="bi bi-envelope-paper me-2"></i>
                                            <strong>{{ $derniereLettre->titre }}</strong>
                                            <span class="text-muted ms-2">({{ $derniereLettre->created_at->format('d/m/Y H:i') }})</span>
                                        </div>
                                        <a href="#" class="btn btn-sm btn-outline-primary rounded-pill voir-lettre" data-contenu="{{ e($derniereLettre->contenu) }}" data-bs-toggle="modal" data-bs-target="#modalLettre">
                                            <i class="bi bi-eye me-1"></i> Lire
                                        </a>
                                    </div>
                                    <div class="mt-2 p-2 bg-white rounded-3">
                                        {{ \Illuminate\Support\Str::limit($derniereLettre->contenu, 200) }}
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-secondary rounded-4">
                                    <i class="bi bi-info-circle me-2"></i> Aucune lettre de motivation enregistrée.
                                </div>
                            @endif
                        </div>

                        {{-- Historique des anciennes lettres --}}
                        @if($anciennesLettres->count())
                            <div class="mb-4">
                                <h5 class="fw-semibold">Historique des lettres</h5>
                                <div class="list-group rounded-4 overflow-hidden">
                                    @foreach($anciennesLettres as $lettre)
                                        <div class="list-group-item border-0 border-bottom">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div class="flex-grow-1">
                                                    <strong>{{ $lettre->titre }}</strong>
                                                    <small class="text-muted ms-2">({{ $lettre->created_at->format('d/m/Y H:i') }})</small>
                                                    <div class="mt-1 text-muted small">
                                                        {{ \Illuminate\Support\Str::limit($lettre->contenu, 100) }}
                                                    </div>
                                                </div>
                                                <button class="btn btn-sm btn-outline-secondary rounded-pill ms-3 voir-lettre" data-contenu="{{ e($lettre->contenu) }}" data-bs-toggle="modal" data-bs-target="#modalLettre">
                                                    <i class="bi bi-eye me-1"></i> Lire
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Formulaire pour ajouter une nouvelle lettre --}}
                        <form action="{{ route('admin.mes-candidatures.motivations.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Nouvelle lettre (une nouvelle version sera créée)</label>
                                <textarea name="lettre_motivation" rows="10" class="form-control @error('lettre_motivation') is-invalid @enderror" placeholder="Rédigez votre lettre de motivation...">{{ old('lettre_motivation', '') }}</textarea>
                                @error('lettre_motivation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div class="form-text">Minimum 50 caractères, maximum 2000.</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Titre (optionnel)</label>
                                <input type="text" name="titre" class="form-control" placeholder="Ex: Candidature stage 2026 - Développeur" value="{{ old('titre', 'Lettre de motivation') }}">
                            </div>
                            <div class="d-flex gap-3">
                                <button type="submit" class="btn btn-primary rounded-pill px-4">
                                    <i class="bi bi-save me-2"></i> Enregistrer (nouvelle version)
                                </button>
                                @if($derniereLettre)
                                    <form action="{{ route('admin.mes-candidatures.motivations.destroy') }}" method="POST" onsubmit="return confirm('Supprimer définitivement toutes vos lettres ?')" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger rounded-pill px-4">
                                            <i class="bi bi-trash me-2"></i> Supprimer tout l'historique
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </form>

                        <hr class="my-4">

                        {{-- Visibilité publique --}}
                        <div class="mt-4">
                            <h5 class="fw-semibold"><i class="bi bi-eye-slash me-2"></i> Visibilité de la lettre</h5>
                            <p class="text-muted small">Si vous activez cette option, votre lettre de motivation (la plus récente) sera visible publiquement par toutes les entreprises dans l'annuaire des talents.</p>
                            <form action="{{ route('admin.mes-candidatures.motivations.visibility') }}" method="POST" class="mt-3">
                                @csrf
                                @method('PATCH')
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="lettre_public" id="lettrePublic"
                                           value="1" {{ $etudiant->lettre_public ? 'checked' : '' }}>
                                    <label class="form-check-label" for="lettrePublic">
                                        Rendre ma lettre de motivation visible publiquement par les entreprises
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-sm btn-outline-secondary mt-2">
                                    <i class="bi bi-save me-1"></i> Enregistrer la préférence
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal pour afficher le texte complet d'une lettre --}}
<div class="modal fade" id="modalLettre" tabindex="-1" aria-labelledby="modalLettreLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="modalLettreLabel">Lettre de motivation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body p-4">
                <div class="border rounded-4 p-3 bg-light" id="modalLettreContenu"></div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const voirBtns = document.querySelectorAll('.voir-lettre');
        const modalContenu = document.getElementById('modalLettreContenu');
        const modalTitle = document.getElementById('modalLettreLabel');

        voirBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const contenu = this.getAttribute('data-contenu');
                modalContenu.innerHTML = contenu.replace(/\n/g, '<br>');

                const parent = this.closest('.alert-info, .list-group-item');
                if (parent) {
                    const titreElem = parent.querySelector('strong');
                    if (titreElem) {
                        modalTitle.innerText = 'Lettre : ' + titreElem.innerText;
                    } else {
                        modalTitle.innerText = 'Lettre de motivation';
                    }
                } else {
                    modalTitle.innerText = 'Lettre de motivation';
                }
            });
        });
    });
</script>
@endpush
@endsection
