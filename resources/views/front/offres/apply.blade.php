@extends('layouts.front')
@section('title', 'Postuler | Cmlink')
@section('content')
@include('front.partials.header')

<section class="py-5">
    <div class="container">
        <div style="max-width:780px;margin:0 auto;">

            {{-- En-tête offre --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4 p-4">
                <div class="d-flex justify-content-between align-items-start gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge rounded-pill"
                                style="font-size:11px;
                                background:{{ $offre->type === 'stage' ? '#EEEDFE' : '#E1F5EE' }};
                                color:{{ $offre->type === 'stage' ? '#3C3489' : '#085041' }};">
                                {{ $offre->type === 'stage' ? 'Stage' : 'Emploi' }}
                            </span>
                            @if($offre->teletravail)
                                <span class="badge rounded-pill"
                                    style="font-size:11px;background:#FAEEDA;color:#633806;">
                                    Télétravail
                                </span>
                            @endif
                            @if($offre->niveau_experience)
                                <span class="badge rounded-pill"
                                    style="font-size:11px;background:#F1EFE8;color:#444441;">
                                    {{ ucfirst($offre->niveau_experience) }}
                                </span>
                            @endif
                        </div>
                        <h4 class="fw-bold mb-1">{{ $offre->titre }}</h4>
                        <p class="text-muted mb-0" style="font-size:13px;">
                            <i class="bi bi-building me-1"></i>
                            {{ $offre->entreprise->nom ?? '—' }}
                            @if($offre->localisation)
                                &nbsp;·&nbsp;
                                <i class="bi bi-geo-alt me-1"></i>
                                {{ $offre->localisation }}
                            @endif
                            @if($offre->salaire_min || $offre->salaire_max)
                                &nbsp;·&nbsp;
                                <i class="bi bi-cash me-1"></i>
                                @if($offre->salaire_min && $offre->salaire_max)
                                    {{ number_format($offre->salaire_min, 0, ',', ' ') }}
                                    – {{ number_format($offre->salaire_max, 0, ',', ' ') }} MAD
                                @elseif($offre->salaire_min)
                                    Dès {{ number_format($offre->salaire_min, 0, ',', ' ') }} MAD
                                @endif
                            @endif
                        </p>
                    </div>
                    @if($offre->date_expiration)
                        <div class="text-end flex-shrink-0">
                            <p class="text-muted mb-0" style="font-size:12px;">Expire le</p>
                            <p class="fw-semibold mb-0" style="font-size:13px;">
                                {{ $offre->date_expiration->format('d/m/Y') }}
                            </p>
                        </div>
                    @endif
                </div>

                {{-- Compétences requises --}}
                @if($offre->competences->isNotEmpty())
                    <div class="mt-3 pt-3" style="border-top:0.5px solid rgba(0,0,0,.07);">
                        <p class="text-muted mb-2" style="font-size:12px;">Compétences requises</p>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($offre->competences as $competence)
                                @php
                                    $etudiantACompetence = auth()->user()->etudiant
                                        ?->competences
                                        ->contains($competence->id);
                                @endphp
                                <span class="badge rounded-pill d-flex align-items-center gap-1"
                                    style="font-size:11px;padding:5px 10px;
                                    background:{{ $etudiantACompetence ? '#E1F5EE' : '#F1EFE8' }};
                                    color:{{ $etudiantACompetence ? '#085041' : '#444441' }};">
                                    @if($etudiantACompetence)
                                        <i class="bi bi-check-circle" style="font-size:10px;"></i>
                                    @endif
                                    {{ $competence->nom }}
                                    <span style="opacity:.6;">· {{ ucfirst($competence->pivot->niveau_requis) }}</span>
                                    @if($competence->pivot->obligatoire)
                                        <span style="opacity:.5;">*</span>
                                    @endif
                                </span>
                            @endforeach
                        </div>
                        <p class="text-muted mt-2 mb-0" style="font-size:11px;">
                            <i class="bi bi-check-circle text-success me-1"></i> = compétence dans votre profil
                            &nbsp;·&nbsp; * = obligatoire
                        </p>
                    </div>
                @endif
            </div>

            {{-- Formulaire --}}
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold mb-4">Ma candidature</h5>

                @if($errors->any())
                    <div class="alert alert-danger rounded-3 mb-4">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('front.offres.postuler', $offre) }}"
                    method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">

                        {{-- Nom --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:13px;">
                                Nom complet <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nom"
                                class="form-control rounded-3 @error('nom') is-invalid @enderror"
                                value="{{ old('nom', auth()->user()->name) }}" required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:13px;">
                                Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" name="email"
                                class="form-control rounded-3 @error('email') is-invalid @enderror"
                                value="{{ old('email', auth()->user()->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Téléphone --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:13px;">Téléphone</label>
                            <input type="text" name="telephone"
                                class="form-control rounded-3 @error('telephone') is-invalid @enderror"
                                value="{{ old('telephone', auth()->user()->etudiant->telephone ?? '') }}"
                                placeholder="Ex: 06XXXXXXXX">
                            @error('telephone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- CV --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:13px;">
                                CV (PDF) <span class="text-danger">*</span>
                            </label>
                            @php
                                $cvPrincipal = auth()->user()->etudiant?->cvPrincipal;
                            @endphp
                            @if($cvPrincipal)
                                <div class="d-flex align-items-center gap-2 p-2 rounded-3 mb-2"
                                    style="background:#E1F5EE;border:0.5px solid #9FE1CB;">
                                    <i class="bi bi-file-earmark-check" style="color:#085041;"></i>
                                    <span style="font-size:12px;color:#085041;">
                                        CV principal : {{ $cvPrincipal->titre }}
                                    </span>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox"
                                        name="utiliser_cv_principal" id="utiliserCvPrincipal"
                                        value="1" {{ old('utiliser_cv_principal') ? 'checked' : '' }}
                                        onchange="toggleCvUpload(this)">
                                    <label class="form-check-label" style="font-size:13px;"
                                        for="utiliserCvPrincipal">
                                        Utiliser mon CV principal
                                    </label>
                                </div>
                            @endif
                            <div id="cvUploadZone">
                                <input type="file" name="cv_path"
                                    class="form-control rounded-3 @error('cv_path') is-invalid @enderror"
                                    accept=".pdf">
                                @error('cv_path')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">PDF uniquement, max 5 Mo</small>
                            </div>
                        </div>

                        {{-- Lettre de motivation --}}
                        <div class="col-12">
                            <label class="form-label fw-semibold" style="font-size:13px;">
                                Lettre de motivation
                            </label>
                            @php
                                $lettres = auth()->user()->etudiant?->lettres ?? collect();
                            @endphp
                            @if($lettres->isNotEmpty())
                                <div class="mb-2">
                                    <select name="lettre_motivation_id"
                                        class="form-select rounded-3 @error('lettre_motivation_id') is-invalid @enderror">
                                        <option value="">-- Sélectionner une lettre existante --</option>
                                        @foreach($lettres as $lettre)
                                            <option value="{{ $lettre->id }}"
                                                {{ old('lettre_motivation_id') == $lettre->id ? 'selected' : '' }}>
                                                {{ $lettre->titre }}
                                                ({{ $lettre->updated_at->format('d/m/Y') }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('lettre_motivation_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">
                                        Ou rédigez un message ci-dessous.
                                    </small>
                                </div>
                            @endif
                            <textarea name="message"
                                class="form-control rounded-3 @error('message') is-invalid @enderror"
                                rows="5"
                                placeholder="Décrivez votre motivation pour ce poste...">{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    {{-- Actions --}}
                    <div class="d-flex gap-3 flex-wrap mt-4">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-send me-2"></i> Envoyer ma candidature
                        </button>
                        <a href="{{ route('front.offres.show', $offre) }}"
                            class="btn btn-light rounded-pill border px-4">
                            Annuler
                        </a>
                    </div>

                </form>
            </div>

        </div>
    </div>
</section>

@include('front.partials.footer')

@push('scripts')
<script>
function toggleCvUpload(checkbox) {
    const zone = document.getElementById('cvUploadZone');
    const input = zone.querySelector('input[type="file"]');
    zone.style.display = checkbox.checked ? 'none' : 'block';
    input.required = !checkbox.checked;
}
// Init
const cb = document.getElementById('utiliserCvPrincipal');
if (cb) toggleCvUpload(cb);
</script>
@endpush

@endsection
