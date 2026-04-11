<div class="row g-4">
    <div class="col-md-6">
        <label for="nom" class="form-label fw-semibold">Nom de l'entreprise <span class="text-danger">*</span></label>
        <input
            type="text"
            name="nom"
            id="nom"
            class="form-control @error('nom') is-invalid @enderror"
            value="{{ old('nom', $entreprise->nom ?? '') }}"
            placeholder="Nom de l'entreprise"
        >
        @error('nom')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
        <input
            type="email"
            name="email"
            id="email"
            class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $entreprise->email ?? '') }}"
            placeholder="contact@entreprise.com"
        >
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="telephone" class="form-label fw-semibold">Téléphone</label>
        <input
            type="text"
            name="telephone"
            id="telephone"
            class="form-control @error('telephone') is-invalid @enderror"
            value="{{ old('telephone', $entreprise->telephone ?? '') }}"
            placeholder="Téléphone"
        >
        @error('telephone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="adresse" class="form-label fw-semibold">Adresse</label>
        <input
            type="text"
            name="adresse"
            id="adresse"
            class="form-control @error('adresse') is-invalid @enderror"
            value="{{ old('adresse', $entreprise->adresse ?? '') }}"
            placeholder="Adresse de l'entreprise"
        >
        @error('adresse')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.entreprises.index') }}" class="btn btn-light border">
        Annuler
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-check-circle me-1"></i>
        {{ $buttonLabel ?? 'Enregistrer' }}
    </button>
</div>