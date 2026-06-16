<div class="row g-4">

    {{-- Titre --}}
    <div class="col-md-8">
        <label for="titre" class="form-label fw-semibold">Titre de l'offre <span class="text-danger">*</span></label>
        <input type="text" name="titre" id="titre"
            class="form-control rounded-3 @error('titre') is-invalid @enderror"
            value="{{ old('titre', $offre->titre ?? '') }}" placeholder="Titre de l'offre">
        @error('titre')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Type --}}
    <div class="col-md-4">
        <label for="type" class="form-label fw-semibold">Type <span class="text-danger">*</span></label>
        <select name="type" id="type" class="form-select rounded-3 @error('type') is-invalid @enderror">
            <option value="">Sélectionner un type</option>
            <option value="stage" @selected(old('type', $offre->type ?? '') === 'stage')>Stage</option>
            <option value="emploi" @selected(old('type', $offre->type ?? '') === 'emploi')>Emploi</option>
        </select>
        @error('type')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Entreprise --}}
    <div class="col-md-6">
        <label for="entreprise_id" class="form-label fw-semibold">Entreprise <span class="text-danger">*</span></label>
        <select name="entreprise_id" id="entreprise_id"
            class="form-select rounded-3 @error('entreprise_id') is-invalid @enderror">
            <option value="">Sélectionner une entreprise</option>
            @foreach ($entreprises as $entreprise)
                <option value="{{ $entreprise->id }}" @selected(old('entreprise_id', $offre->entreprise_id ?? ($entrepriseConnectee?->id ?? '')) == $entreprise->id)>
                    {{ $entreprise->nom }}
                </option>
            @endforeach
        </select>
        @error('entreprise_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Catégorie --}}
    <div class="col-md-6">
        <label for="categorie_id" class="form-label fw-semibold">Catégorie</label>
        <select name="categorie_id" id="categorie_id"
            class="form-select rounded-3 @error('categorie_id') is-invalid @enderror">
            <option value="">Sélectionner une catégorie</option>
            @foreach ($categories as $categorie)
                <option value="{{ $categorie->id }}" @selected(old('categorie_id', $offre->categorie_id ?? '') == $categorie->id)>
                    {{ $categorie->nom }}
                </option>
            @endforeach
        </select>
        @error('categorie_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Localisation --}}
    <div class="col-md-6">
        <label for="localisation" class="form-label fw-semibold">Localisation</label>
        <input type="text" name="localisation" id="localisation"
            class="form-control rounded-3 @error('localisation') is-invalid @enderror"
            value="{{ old('localisation', $offre->localisation ?? '') }}" placeholder="Ville ou adresse">
        @error('localisation')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Date expiration --}}
    <div class="col-md-6">
        <label for="date_expiration" class="form-label fw-semibold">Date d'expiration</label>
        <input type="date" name="date_expiration" id="date_expiration"
            class="form-control rounded-3 @error('date_expiration') is-invalid @enderror"
            value="{{ old('date_expiration', isset($offre) && $offre->date_expiration ? $offre->date_expiration->format('Y-m-d') : '') }}"
            min="{{ now()->format('Y-m-d') }}">
        @error('date_expiration')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Salaire min --}}
    <div class="col-md-3">
        <label for="salaire_min" class="form-label fw-semibold">Salaire min (MAD)</label>
        <input type="number" name="salaire_min" id="salaire_min"
            class="form-control rounded-3 @error('salaire_min') is-invalid @enderror"
            value="{{ old('salaire_min', $offre->salaire_min ?? '') }}" placeholder="Ex: 3000" min="0">
        @error('salaire_min')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Salaire max --}}
    <div class="col-md-3">
        <label for="salaire_max" class="form-label fw-semibold">Salaire max (MAD)</label>
        <input type="number" name="salaire_max" id="salaire_max"
            class="form-control rounded-3 @error('salaire_max') is-invalid @enderror"
            value="{{ old('salaire_max', $offre->salaire_max ?? '') }}" placeholder="Ex: 6000" min="0">
        @error('salaire_max')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Niveau expérience --}}
    <div class="col-md-3">
        <label for="niveau_experience" class="form-label fw-semibold">Niveau d'expérience</label>
        <select name="niveau_experience" id="niveau_experience"
            class="form-select rounded-3 @error('niveau_experience') is-invalid @enderror">
            <option value="">-- Sélectionner --</option>
            <option value="debutant" @selected(old('niveau_experience', $offre->niveau_experience ?? '') === 'debutant')>Débutant</option>
            <option value="junior" @selected(old('niveau_experience', $offre->niveau_experience ?? '') === 'junior')>Junior</option>
            <option value="intermediaire" @selected(old('niveau_experience', $offre->niveau_experience ?? '') === 'intermediaire')>Intermédiaire</option>
            <option value="senior" @selected(old('niveau_experience', $offre->niveau_experience ?? '') === 'senior')>Senior</option>
        </select>
        @error('niveau_experience')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Nb postes --}}
    <div class="col-md-3">
        <label for="nb_postes" class="form-label fw-semibold">Nombre de postes</label>
        <input type="number" name="nb_postes" id="nb_postes"
            class="form-control rounded-3 @error('nb_postes') is-invalid @enderror"
            value="{{ old('nb_postes', $offre->nb_postes ?? 1) }}" min="1">
        @error('nb_postes')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Télétravail --}}
    <div class="col-12">
        <div class="form-check form-switch">
            <input type="hidden" name="teletravail" value="0">
            <input class="form-check-input" type="checkbox" name="teletravail" id="teletravail" value="1"
                {{ old('teletravail', $offre->teletravail ?? false) ? 'checked' : '' }}>
            <label class="form-check-label fw-semibold" for="teletravail">
                Télétravail possible
            </label>
        </div>
    </div>

    {{-- Description --}}
    <div class="col-12">
        <label for="description" class="form-label fw-semibold">Description <span
                class="text-danger">*</span></label>
        <textarea name="description" id="description" rows="6"
            class="form-control rounded-3 @error('description') is-invalid @enderror"
            placeholder="Description détaillée de l'offre">{{ old('description', $offre->description ?? '') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Compétences requises --}}
    <div class="col-12">
        <label class="form-label fw-semibold">Compétences requises</label>
        <small class="text-muted d-block mb-3">
            Sélectionnez les compétences nécessaires pour ce poste.
        </small>

        @php
            $competencesSelectionnees = isset($offre) ? $offre->competences->map(function ($c) {
                return [
                    'id' => $c->id,
                    'niveau_requis' => $c->pivot->niveau_requis,
                    'obligatoire' => $c->pivot->obligatoire,
                ];
            })->values()->toArray() : [];
        @endphp

        {{-- Compétences déjà sélectionnées --}}
        <div id="competences-container" class="d-flex flex-column gap-2 mb-3">
            @foreach ($competencesSelectionnees as $index => $comp)
                <div class="competence-row d-flex align-items-center gap-2 p-3 rounded-3"
                    style="background:#FAFAFA;border:0.5px solid rgba(0,0,0,.08);">
                    <select name="competences[{{ $index }}][id]"
                        class="form-select form-select-sm rounded-3 competence-select"
                        data-selected="{{ $comp['id'] ?? '' }}" style="max-width:220px;">
                        <option value="">-- Compétence --</option>
                    </select>
                    <select name="competences[{{ $index }}][niveau_requis]"
                        class="form-select form-select-sm rounded-3" style="max-width:160px;">
                        <option value="debutant" @selected(($comp['niveau_requis'] ?? '') === 'debutant')>Débutant</option>
                        <option value="intermediaire" @selected(($comp['niveau_requis'] ?? '') === 'intermediaire')>Intermédiaire</option>
                        <option value="avance" @selected(($comp['niveau_requis'] ?? '') === 'avance')>Avancé</option>
                        <option value="expert" @selected(($comp['niveau_requis'] ?? '') === 'expert')>Expert</option>
                    </select>
                    <div class="form-check mb-0 ms-1">
                        <input type="hidden" name="competences[{{ $index }}][obligatoire]" value="0">
                        <input class="form-check-input" type="checkbox"
                            name="competences[{{ $index }}][obligatoire]"
                            id="obligatoire_{{ $index }}" value="1"
                            {{ $comp['obligatoire'] ?? true ? 'checked' : '' }}>
                        <label class="form-check-label" style="font-size:13px;"
                            for="obligatoire_{{ $index }}">Obligatoire</label>
                    </div>
                    <button type="button"
                        class="btn btn-sm btn-light rounded-pill text-danger ms-auto remove-competence">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            @endforeach
        </div>

        <button type="button" id="add-competence" class="btn btn-light rounded-pill"
            style="font-size:13px;border:0.5px dashed rgba(0,0,0,.2);">
            <i class="bi bi-plus-lg me-1"></i> Ajouter une compétence
        </button>

        {{-- Template HTML sans Blade --}}
        <template id="competence-template">
            <div class="competence-row d-flex align-items-center gap-2 p-3 rounded-3"
                style="background:#FAFAFA;border:0.5px solid rgba(0,0,0,.08);">
                <select name="competences[__INDEX__][id]"
                    class="form-select form-select-sm rounded-3 competence-select" style="max-width:220px;">
                    <option value="">-- Compétence --</option>
                </select>
                <select name="competences[__INDEX__][niveau_requis]" class="form-select form-select-sm rounded-3"
                    style="max-width:160px;">
                    <option value="debutant">Débutant</option>
                    <option value="intermediaire">Intermédiaire</option>
                    <option value="avance">Avancé</option>
                    <option value="expert">Expert</option>
                </select>
                <div class="form-check mb-0 ms-1">
                    <input type="hidden" name="competences[__INDEX__][obligatoire]" value="0">
                    <input class="form-check-input" type="checkbox" name="competences[__INDEX__][obligatoire]"
                        id="obligatoire___INDEX__" value="1" checked>
                    <label class="form-check-label" style="font-size:13px;"
                        for="obligatoire___INDEX__">Obligatoire</label>
                </div>
                <button type="button"
                    class="btn btn-sm btn-light rounded-pill text-danger ms-auto remove-competence">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        </template>
    </div>

</div>

{{-- Actions --}}
<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.offres.index') }}" class="btn btn-light rounded-pill border">
        Annuler
    </a>
    <button type="submit" class="btn btn-primary rounded-pill">
        <i class="bi bi-check-circle me-1"></i>
        {{ $buttonLabel ?? 'Enregistrer' }}
    </button>
</div>

@push('scripts')
    <script>
        @php
            $competencesJson = collect($competences ?? [])->map(function ($c) {
                return [
                    'id' => $c->id,
                    'nom' => $c->nom,
                    'categorie' => $c->categorie,
                ];
            });
        @endphp

        const competencesDisponibles = @json($competencesJson);

        let index = {{ count($competencesSelectionnees) }};

        function remplirSelect(select, selectedId = null) {
            competencesDisponibles.forEach(c => {
                const opt = document.createElement('option');
                opt.value = c.id;
                opt.textContent = c.nom + (c.categorie ? ` (${c.categorie})` : '');
                if (selectedId && c.id == selectedId) opt.selected = true;
                select.appendChild(opt);
            });
        }

        // Remplir et pré-sélectionner les selects existants (mode édition)
        document.querySelectorAll('.competence-select').forEach(select => {
            const selectedId = select.dataset.selected || null;
            remplirSelect(select, selectedId);
        });

        // Ajouter une ligne
        document.getElementById('add-competence').addEventListener('click', function() {
            const template = document.getElementById('competence-template').innerHTML;
            const html = template.replaceAll('__INDEX__', index);
            const div = document.createElement('div');
            div.innerHTML = html;
            const row = div.firstElementChild;
            remplirSelect(row.querySelector('.competence-select'));
            document.getElementById('competences-container').appendChild(row);
            index++;
        });

        // Supprimer une ligne
        document.getElementById('competences-container').addEventListener('click', function(e) {
            if (e.target.closest('.remove-competence')) {
                e.target.closest('.competence-row').remove();
            }
        });
    </script>
@endpush
