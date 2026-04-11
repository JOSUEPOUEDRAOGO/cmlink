<div class="row g-4">
    <div class="col-md-6">
        <label for="nom" class="form-label fw-semibold">Nom de la catégorie <span class="text-danger">*</span></label>
        <input
            type="text"
            name="nom"
            id="nom"
            class="form-control @error('nom') is-invalid @enderror"
            value="{{ old('nom', $categorie->nom ?? '') }}"
            placeholder="Nom de la catégorie"
        >
        @error('nom')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="description" class="form-label fw-semibold">Description</label>
        <textarea
            name="description"
            id="description"
            rows="5"
            class="form-control @error('description') is-invalid @enderror"
            placeholder="Description de la catégorie"
        >{{ old('description', $categorie->description ?? '') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.categories.index') }}" class="btn btn-light border">
        Annuler
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-check-circle me-1"></i>
        {{ $buttonLabel ?? 'Enregistrer' }}
    </button>
</div>