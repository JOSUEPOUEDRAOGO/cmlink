<div class="row g-4">
    <div class="col-md-6">
        <label for="etudiant_id" class="form-label fw-semibold">Étudiant <span class="text-danger">*</span></label>
        <select
            name="etudiant_id"
            id="etudiant_id"
            class="form-select @error('etudiant_id') is-invalid @enderror"
        >
            <option value="">Sélectionner un étudiant</option>
            @foreach($etudiants as $etudiantItem)
                <option
                    value="{{ $etudiantItem->id }}"
                    @selected(old('etudiant_id', $candidature->etudiant_id ?? '') == $etudiantItem->id)
                >
                    {{ $etudiantItem->prenom }} {{ $etudiantItem->nom }}
                    @if($etudiantItem->filiere)
                        — {{ $etudiantItem->filiere->nom }}
                    @endif
                </option>
            @endforeach
        </select>
        @error('etudiant_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="offre_id" class="form-label fw-semibold">Offre <span class="text-danger">*</span></label>
        <select
            name="offre_id"
            id="offre_id"
            class="form-select @error('offre_id') is-invalid @enderror"
        >
            <option value="">Sélectionner une offre</option>
            @foreach($offres as $offreItem)
                <option
                    value="{{ $offreItem->id }}"
                    @selected(old('offre_id', $candidature->offre_id ?? '') == $offreItem->id)
                >
                    {{ $offreItem->titre }}
                    @if($offreItem->entreprise)
                        — {{ $offreItem->entreprise->nom }}
                    @endif
                </option>
            @endforeach
        </select>
        @error('offre_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="statut" class="form-label fw-semibold">Statut <span class="text-danger">*</span></label>
        <select
            name="statut"
            id="statut"
            class="form-select @error('statut') is-invalid @enderror"
        >
            <option value="">Sélectionner un statut</option>
            <option value="en_attente" @selected(old('statut', $candidature->statut ?? '') === 'en_attente')>En attente</option>
            <option value="accepte" @selected(old('statut', $candidature->statut ?? '') === 'accepte')>Accepté</option>
            <option value="refuse" @selected(old('statut', $candidature->statut ?? '') === 'refuse')>Refusé</option>
        </select>
        @error('statut')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.candidatures.index') }}" class="btn btn-light border">
        Annuler
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-check-circle me-1"></i>
        {{ $buttonLabel ?? 'Enregistrer' }}
    </button>
</div>