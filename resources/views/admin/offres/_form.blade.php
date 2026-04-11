<div class="row g-4">
    <div class="col-md-8">
        <label for="titre" class="form-label fw-semibold">Titre de l'offre <span class="text-danger">*</span></label>
        <input
            type="text"
            name="titre"
            id="titre"
            class="form-control @error('titre') is-invalid @enderror"
            value="{{ old('titre', $offre->titre ?? '') }}"
            placeholder="Titre de l'offre"
        >
        @error('titre')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="type" class="form-label fw-semibold">Type <span class="text-danger">*</span></label>
        <select
            name="type"
            id="type"
            class="form-select @error('type') is-invalid @enderror"
        >
            <option value="">Sélectionner un type</option>
            <option value="stage" @selected(old('type', $offre->type ?? '') === 'stage')>Stage</option>
            <option value="emploi" @selected(old('type', $offre->type ?? '') === 'emploi')>Emploi</option>
        </select>
        @error('type')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="entreprise_id" class="form-label fw-semibold">Entreprise <span class="text-danger">*</span></label>
        <select
            name="entreprise_id"
            id="entreprise_id"
            class="form-select @error('entreprise_id') is-invalid @enderror"
        >
            <option value="">Sélectionner une entreprise</option>
            @foreach($entreprises as $entreprise)
                <option
                    value="{{ $entreprise->id }}"
                    @selected(old('entreprise_id', $offre->entreprise_id ?? '') == $entreprise->id)
                >
                    {{ $entreprise->nom }}
                </option>
            @endforeach
        </select>
        @error('entreprise_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="categorie_id" class="form-label fw-semibold">Catégorie</label>
        <select
            name="categorie_id"
            id="categorie_id"
            class="form-select @error('categorie_id') is-invalid @enderror"
        >
            <option value="">Sélectionner une catégorie</option>
            @foreach($categories as $categorie)
                <option
                    value="{{ $categorie->id }}"
                    @selected(old('categorie_id', $offre->categorie_id ?? '') == $categorie->id)
                >
                    {{ $categorie->nom }}
                </option>
            @endforeach
        </select>
        @error('categorie_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="localisation" class="form-label fw-semibold">Localisation</label>
        <input
            type="text"
            name="localisation"
            id="localisation"
            class="form-control @error('localisation') is-invalid @enderror"
            value="{{ old('localisation', $offre->localisation ?? '') }}"
            placeholder="Ville ou adresse"
        >
        @error('localisation')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="date_expiration" class="form-label fw-semibold">Date d'expiration</label>
        <input
            type="date"
            name="date_expiration"
            id="date_expiration"
            class="form-control @error('date_expiration') is-invalid @enderror"
            value="{{ old('date_expiration', isset($offre) && $offre->date_expiration ? $offre->date_expiration->format('Y-m-d') : '') }}"
        >
        @error('date_expiration')
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
            placeholder="Description détaillée de l'offre"
        >{{ old('description', $offre->description ?? '') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.offres.index') }}" class="btn btn-light border">
        Annuler
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-check-circle me-1"></i>
        {{ $buttonLabel ?? 'Enregistrer' }}
    </button>
</div>