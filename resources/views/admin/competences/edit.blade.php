@extends('layouts.admin')
@section('title', 'Modifier la compétence')
@section('content')

<div class="container py-4" style="max-width:600px;">

    <div class="mb-4">
        <a href="{{ route('admin.competences.index') }}" class="text-muted text-decoration-none" style="font-size:13px;">
            <i class="bi bi-arrow-left me-1"></i> Retour aux compétences
        </a>
        <h4 class="fw-bold mt-2 mb-0">Modifier — {{ $competence->nom }}</h4>
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
            <form action="{{ route('admin.competences.update', $competence) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nom <span class="text-danger">*</span></label>
                    <input type="text"
                        name="nom"
                        value="{{ old('nom', $competence->nom) }}"
                        class="form-control rounded-3 @error('nom') is-invalid @enderror"
                        placeholder="Ex: Laravel, React, Management...">
                    @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Catégorie</label>
                    <input type="text"
                        name="categorie"
                        value="{{ old('categorie', $competence->categorie) }}"
                        class="form-control rounded-3 @error('categorie') is-invalid @enderror"
                        placeholder="Ex: Informatique, Management, Santé...">
                    @error('categorie')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <form action="{{ route('admin.competences.destroy', $competence) }}"
                        method="POST"
                        onsubmit="return confirm('Supprimer cette compétence ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-light rounded-pill text-danger">
                            <i class="bi bi-trash me-1"></i> Supprimer
                        </button>
                    </form>

                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.competences.index') }}"
                            class="btn btn-light rounded-pill">
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

@endsection
