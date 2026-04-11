<div class="row g-4">
    <div class="col-md-6">
        <label for="etudiant_id" class="form-label fw-semibold">Étudiant</label>
        <select
            name="etudiant_id"
            id="etudiant_id"
            class="form-select @error('etudiant_id') is-invalid @enderror"
        >
            <option value="">Sélectionner un étudiant</option>
            @foreach($etudiants as $etudiantItem)
                <option
                    value="{{ $etudiantItem->id }}"
                    @selected(old('etudiant_id', $signalement->etudiant_id ?? '') == $etudiantItem->id)
                >
                    {{ $etudiantItem->prenom }} {{ $etudiantItem->nom }}
                </option>
            @endforeach
        </select>
        @error('etudiant_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="entreprise_id" class="form-label fw-semibold">Entreprise</label>
        <select
            name="entreprise_id"
            id="entreprise_id"
            class="form-select @error('entreprise_id') is-invalid @enderror"
        >
            <option value="">Sélectionner une entreprise</option>
            @foreach($entreprises as $entrepriseItem)
                <option
                    value="{{ $entrepriseItem->id }}"
                    @selected(old('entreprise_id', $signalement->entreprise_id ?? '') == $entrepriseItem->id)
                >
                    {{ $entrepriseItem->nom }}
                </option>
            @endforeach
        </select>
        @error('entreprise_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="description" class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
        <textarea
            name="description"
            id="description"
            rows="6"
            class="form-control @error('description') is-invalid @enderror"
            placeholder="Décrire le signalement"
        >{{ old('description', $signalement->description ?? '') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.signalements.index') }}" class="btn btn-light border">
        Annuler
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-check-circle me-1"></i>
        {{ $buttonLabel ?? 'Enregistrer' }}
    </button>
</div>