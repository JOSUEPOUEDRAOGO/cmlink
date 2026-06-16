@extends('layouts.admin')
@section('title', 'Nouvelle compétence')
@section('content')

<div class="container py-4" style="max-width:600px;">

    <div class="mb-4">
        <a href="{{ route('admin.competences.index') }}" class="text-muted text-decoration-none" style="font-size:13px;">
            <i class="bi bi-arrow-left me-1"></i> Retour aux compétences
        </a>
        <h4 class="fw-bold mt-2 mb-0">Nouvelle compétence</h4>
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
            <form action="{{ route('admin.competences.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nom <span class="text-danger">*</span></label>
                    <input type="text"
                        name="nom"
                        value="{{ old('nom') }}"
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
                        value="{{ old('categorie') }}"
                        class="form-control rounded-3 @error('categorie') is-invalid @enderror"
                        placeholder="Ex: Informatique, Management, Santé...">
                    @error('categorie')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Permet de regrouper les compétences par domaine.</small>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.competences.index') }}"
                        class="btn btn-light rounded-pill">
                        Annuler
                    </a>
                    <button type="submit" class="btn btn-primary rounded-pill">
                        <i class="bi bi-check-lg me-2"></i> Enregistrer
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>

@endsection
