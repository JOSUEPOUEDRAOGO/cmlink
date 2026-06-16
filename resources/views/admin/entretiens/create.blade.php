@extends('layouts.admin')
@section('title', 'Planifier un entretien')
@section('content')

<div class="container py-4" style="max-width:680px;">

    <div class="mb-4">
        <a href="{{ route('admin.entretiens.index') }}" class="text-muted text-decoration-none" style="font-size:13px;">
            <i class="bi bi-arrow-left me-1"></i> Retour aux entretiens
        </a>
        <h4 class="fw-bold mt-2 mb-0">Planifier un entretien</h4>
    </div>

    @if($errors->any())
        <div class="alert alert-danger rounded-4 mb-4">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.entretiens.store') }}" method="POST" id="entretienForm">
                @csrf

                {{-- Candidature --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Candidature <span class="text-danger">*</span></label>
                    <select name="candidature_id"
                        class="form-select rounded-3 @error('candidature_id') is-invalid @enderror">
                        <option value="">-- Sélectionner une candidature acceptée --</option>
                        @foreach($candidatures as $candidature)
                            <option value="{{ $candidature->id }}"
                                {{ old('candidature_id') == $candidature->id ? 'selected' : '' }}>
                                {{ $candidature->etudiant->prenom ?? $candidature->nom }}
                                {{ $candidature->etudiant->nom ?? '' }}
                                — {{ $candidature->offre->titre }}
                            </option>
                        @endforeach
                    </select>
                    @error('candidature_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Date & heure --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Date & heure <span class="text-danger">*</span></label>
                    <input type="datetime-local"
                        name="date_rdv"
                        value="{{ old('date_rdv') }}"
                        class="form-control rounded-3 @error('date_rdv') is-invalid @enderror"
                        min="{{ now()->format('Y-m-d\TH:i') }}">
                    @error('date_rdv')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Type --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Type d'entretien <span class="text-danger">*</span></label>
                    <select name="type"
                        class="form-select rounded-3 @error('type') is-invalid @enderror"
                        id="typeSelect"
                        onchange="toggleTypeFields()">
                        <option value="">-- Choisir --</option>
                        <option value="presentiel" {{ old('type') === 'presentiel' ? 'selected' : '' }}>Présentiel</option>
                        <option value="visio" {{ old('type') === 'visio' ? 'selected' : '' }}>Visio</option>
                        <option value="telephonique" {{ old('type') === 'telephonique' ? 'selected' : '' }}>Téléphonique</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Lien visio (conditionnel) --}}
                <div class="mb-3" id="fieldVisio" style="display:none;">
                    <label class="form-label fw-semibold">Lien visio <span class="text-danger">*</span></label>
                    <input type="url"
                        name="lien_visio"
                        value="{{ old('lien_visio') }}"
                        class="form-control rounded-3 @error('lien_visio') is-invalid @enderror"
                        placeholder="https://meet.google.com/...">
                    @error('lien_visio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Adresse présentiel (conditionnel) --}}
                <div class="mb-3" id="fieldAdresse" style="display:none;">
                    <label class="form-label fw-semibold">Adresse <span class="text-danger">*</span></label>
                    <input type="text"
                        name="adresse"
                        value="{{ old('adresse') }}"
                        class="form-control rounded-3 @error('adresse') is-invalid @enderror"
                        placeholder="Ex: 12 rue des Acacias, Rabat">
                    @error('adresse')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Statut --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Statut <span class="text-danger">*</span></label>
                    <select name="statut"
                        class="form-select rounded-3 @error('statut') is-invalid @enderror">
                        <option value="planifie" {{ old('statut', 'planifie') === 'planifie' ? 'selected' : '' }}>Planifié</option>
                        <option value="confirme" {{ old('statut') === 'confirme' ? 'selected' : '' }}>Confirmé</option>
                        <option value="annule" {{ old('statut') === 'annule' ? 'selected' : '' }}>Annulé</option>
                        <option value="effectue" {{ old('statut') === 'effectue' ? 'selected' : '' }}>Effectué</option>
                    </select>
                    @error('statut')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Notes --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">Notes</label>
                    <textarea name="notes"
                        rows="3"
                        class="form-control rounded-3 @error('notes') is-invalid @enderror"
                        placeholder="Instructions, informations complémentaires...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.entretiens.index') }}" class="btn btn-light rounded-pill">
                        Annuler
                    </a>
                    <button type="submit" class="btn btn-primary rounded-pill">
                        <i class="bi bi-calendar-plus me-2"></i> Planifier
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>

@push('scripts')
<script>
function toggleTypeFields() {
    const type = document.getElementById('typeSelect').value;
    document.getElementById('fieldVisio').style.display   = type === 'visio'       ? 'block' : 'none';
    document.getElementById('fieldAdresse').style.display = type === 'presentiel'  ? 'block' : 'none';
}
toggleTypeFields();
</script>
@endpush

@endsection
