<div class="row g-4">
    <div class="col-md-6">
        <label for="nom" class="form-label fw-semibold">Nom <span class="text-danger">*</span></label>
        <input
            type="text"
            name="nom"
            id="nom"
            class="form-control @error('nom') is-invalid @enderror"
            value="{{ old('nom', $etudiant->nom ?? '') }}"
            placeholder="Nom de l'étudiant"
        >
        @error('nom')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="prenom" class="form-label fw-semibold">Prénom <span class="text-danger">*</span></label>
        <input
            type="text"
            name="prenom"
            id="prenom"
            class="form-control @error('prenom') is-invalid @enderror"
            value="{{ old('prenom', $etudiant->prenom ?? '') }}"
            placeholder="Prénom de l'étudiant"
        >
        @error('prenom')
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
            value="{{ old('email', $etudiant->email ?? '') }}"
            placeholder="exemple@email.com"
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
            value="{{ old('telephone', $etudiant->telephone ?? '') }}"
            placeholder="Téléphone"
        >
        @error('telephone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="filiere_id" class="form-label fw-semibold">Filière <span class="text-danger">*</span></label>
        <select
            name="filiere_id"
            id="filiere_id"
            class="form-select @error('filiere_id') is-invalid @enderror"
        >
            <option value="">Sélectionner une filière</option>
            @foreach($filieres as $filiere)
                <option
                    value="{{ $filiere->id }}"
                    @selected(old('filiere_id', $etudiant->filiere_id ?? '') == $filiere->id)
                >
                    {{ $filiere->nom }}
                </option>
            @endforeach
        </select>
        @error('filiere_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.etudiants.index') }}" class="btn btn-light border">
        Annuler
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-check-circle me-1"></i>
        {{ $buttonLabel ?? 'Enregistrer' }}
    </button>
</div>