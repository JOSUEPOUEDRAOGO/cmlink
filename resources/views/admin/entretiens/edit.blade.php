@extends('layouts.admin')
@section('title', 'Modifier l\'entretien')
@section('content')

<div class="container py-4" style="max-width:680px;">

    <div class="mb-4">
        <a href="{{ route('admin.entretiens.index') }}" class="text-muted text-decoration-none" style="font-size:13px;">
            <i class="bi bi-arrow-left me-1"></i> Retour aux entretiens
        </a>
        <h4 class="fw-bold mt-2 mb-0">Modifier l'entretien</h4>
        <p class="text-muted mb-0" style="font-size:13px;">
            {{ $entretien->candidature->etudiant->prenom ?? $entretien->candidature->nom }}
            {{ $entretien->candidature->etudiant->nom ?? '' }}
            — {{ $entretien->candidature->offre->titre }}
        </p>
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
            <form action="{{ route('admin.entretiens.update', $entretien) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Date & heure --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Date & heure <span class="text-danger">*</span></label>
                    <input type="datetime-local"
                        name="date_rdv"
                        value="{{ old('date_rdv', $entretien->date_rdv->format('Y-m-d\TH:i')) }}"
                        class="form-control rounded-3 @error('date_rdv') is-invalid @enderror">
                    @error('date_rdv')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Type --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Type d'entretien</label>
                    <select name="type"
                        class="form-select rounded-3 @error('type') is-invalid @enderror"
                        id="typeSelect"
                        onchange="toggleTypeFields()">
                        <option value="presentiel" {{ old('type', $entretien->type) === 'presentiel' ? 'selected' : '' }}>Présentiel</option>
                        <option value="visio"      {{ old('type', $entretien->type) === 'visio'      ? 'selected' : '' }}>Visio</option>
                        <option value="telephonique" {{ old('type', $entretien->type) === 'telephonique' ? 'selected' : '' }}>Téléphonique</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Lien visio --}}
                <div class="mb-3" id="fieldVisio" style="display:none;">
                    <label class="form-label fw-semibold">Lien visio</label>
                    <input type="url"
                        name="lien_visio"
                        value="{{ old('lien_visio', $entretien->lien_visio) }}"
                        class="form-control rounded-3 @error('lien_visio') is-invalid @enderror"
                        placeholder="https://meet.google.com/...">
                    @error('lien_visio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Adresse --}}
                <div class="mb-3" id="fieldAdresse" style="display:none;">
                    <label class="form-label fw-semibold">Adresse</label>
                    <input type="text"
                        name="adresse"
                        value="{{ old('adresse', $entretien->adresse) }}"
                        class="form-control rounded-3 @error('adresse') is-invalid @enderror"
                        placeholder="Ex: 12 rue des Acacias, Rabat">
                    @error('adresse')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Statut --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Statut</label>
                    <select name="statut"
                        class="form-select rounded-3 @error('statut') is-invalid @enderror">
                        <option value="planifie"  {{ old('statut', $entretien->statut) === 'planifie'  ? 'selected' : '' }}>Planifié</option>
                        <option value="confirme"  {{ old('statut', $entretien->statut) === 'confirme'  ? 'selected' : '' }}>Confirmé</option>
                        <option value="annule"    {{ old('statut', $entretien->statut) === 'annule'    ? 'selected' : '' }}>Annulé</option>
                        <option value="effectue"  {{ old('statut', $entretien->statut) === 'effectue'  ? 'selected' : '' }}>Effectué</option>
                    </select>
                    @error('statut')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Notes --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Notes</label>
                    <textarea name="notes"
                        rows="3"
                        class="form-control rounded-3 @error('notes') is-invalid @enderror"
                        placeholder="Instructions, informations complémentaires...">{{ old('notes', $entretien->notes) }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Résultat --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">Résultat / Feedback</label>
                    <textarea name="resultat"
                        rows="3"
                        class="form-control rounded-3 @error('resultat') is-invalid @enderror"
                        placeholder="Retour post-entretien...">{{ old('resultat', $entretien->resultat) }}</textarea>
                    @error('resultat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <form action="{{ route('admin.entretiens.destroy', $entretien) }}"
                        method="POST"
                        onsubmit="return confirm('Supprimer cet entretien ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-light rounded-pill text-danger">
                            <i class="bi bi-trash me-1"></i> Supprimer
                        </button>
                    </form>

                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.entretiens.index') }}" class="btn btn-light rounded-pill">
                            Annuler
                        </a>
                        <button type="submit" class="btn btn-primary rounded-pill">
                            <i class="bi bi-check-lg me-2"></i> Mettre à jour
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

</div>

@push('scripts')
<script>
function toggleTypeFields() {
    const type = document.getElementById('typeSelect').value;
    document.getElementById('fieldVisio').style.display   = type === 'visio'      ? 'block' : 'none';
    document.getElementById('fieldAdresse').style.display = type === 'presentiel' ? 'block' : 'none';
}
toggleTypeFields();
</script>
@endpush

@endsection
