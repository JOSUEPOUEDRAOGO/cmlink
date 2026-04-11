<div class="row g-4">
    <div class="col-md-6">
        <label for="cle" class="form-label fw-semibold">Clé <span class="text-danger">*</span></label>
        <input
            type="text"
            name="cle"
            id="cle"
            class="form-control @error('cle') is-invalid @enderror"
            value="{{ old('cle', $parametre->cle ?? '') }}"
            placeholder="Ex: site_name"
        >
        @error('cle')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="valeur" class="form-label fw-semibold">Valeur</label>
        <textarea
            name="valeur"
            id="valeur"
            rows="5"
            class="form-control @error('valeur') is-invalid @enderror"
            placeholder="Valeur du paramètre"
        >{{ old('valeur', $parametre->valeur ?? '') }}</textarea>
        @error('valeur')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.parametres.index') }}" class="btn btn-light border">
        Annuler
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-check-circle me-1"></i>
        {{ $buttonLabel ?? 'Enregistrer' }}
    </button>
</div>