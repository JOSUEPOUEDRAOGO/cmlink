@extends('layouts.admin')

@section('title', 'Lettre de motivation')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 p-4">
                    <h3 class="fw-bold">Lettre de motivation de {{ $etudiant->prenom }} {{ $etudiant->nom }}</h3>
                    @if($lettre->titre)
                        <p class="text-muted mb-0 mt-2">{{ $lettre->titre }}</p>
                    @endif
                </div>
                <div class="card-body p-4">
                    <div class="border rounded-4 p-4 bg-light">
                        {!! nl2br(e($lettre->contenu)) !!}
                    </div>
                </div>
                <div class="card-footer bg-white border-0 p-4">
                    <a href="{{ route('admin.profils-publics.index') }}" class="btn btn-secondary rounded-pill">
                        <i class="bi bi-arrow-left me-2"></i> Retour
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
