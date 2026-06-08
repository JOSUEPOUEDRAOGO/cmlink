@extends('layouts.admin')

@section('title', 'Mon CV')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-lg-5">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <i class="bi bi-file-earmark-person fs-1 text-primary"></i>
                        <h3 class="fw-bold mb-0">Mon CV</h3>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success rounded-4">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger rounded-4">{{ session('error') }}</div>
                    @endif

                    @php
                        $etudiant = auth()->user()->etudiant;
                        $cvPrincipal = $etudiant?->cvPrincipal;
                        $anciensCvs = $etudiant?->cvs()->where('principal', false)->latest()->get();
                    @endphp

                    @if(!$etudiant)
                        <div class="alert alert-warning rounded-4">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Aucun profil étudiant associé à votre compte. Veuillez contacter l'administration.
                        </div>
                    @else
                        {{-- CV actuel (principal) --}}
                        <div class="mb-4">
                            <h5 class="fw-semibold">CV actuel</h5>
                            @if($cvPrincipal)
                                <div class="alert alert-info rounded-4 d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="bi bi-file-pdf me-2"></i>
                                        <strong>{{ $cvPrincipal->titre }}</strong>
                                        <span class="text-muted ms-2">(principal)</span>
                                    </div>
                                    <a href="{{ asset('storage/'.$cvPrincipal->cv_path) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill">
                                        <i class="bi bi-download me-1"></i> Télécharger
                                    </a>
                                </div>
                            @else
                                <div class="alert alert-secondary rounded-4">
                                    <i class="bi bi-info-circle me-2"></i> Aucun CV principal enregistré.
                                </div>
                            @endif
                        </div>

                        {{-- Historique des anciens CV --}}
                        @if($anciensCvs->count())
                            <div class="mb-4">
                                <h5 class="fw-semibold">Historique des CV</h5>
                                <div class="list-group rounded-4 overflow-hidden">
                                    @foreach($anciensCvs as $cv)
                                        <div class="list-group-item d-flex justify-content-between align-items-center border-0 border-bottom">
                                            <div>
                                                <i class="bi bi-file-pdf text-danger me-2"></i>
                                                <strong>{{ $cv->titre }}</strong>
                                                <small class="text-muted ms-2">(déposé le {{ $cv->created_at->format('d/m/Y H:i') }})</small>
                                            </div>
                                            <a href="{{ asset('storage/'.$cv->cv_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill">
                                                <i class="bi bi-download me-1"></i> Télécharger
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    {{-- Formulaire upload CV --}}
<form action="{{ route('admin.mes-candidatures.cv.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    ...
    <button type="submit">Remplacer mon CV</button>
</form>

{{-- Formulaire suppression CV — EN DEHORS du form upload --}}
@if($cvPrincipal)
<form action="{{ route('admin.mes-candidatures.cv.destroy') }}" method="POST"
      onsubmit="return confirm('Supprimer définitivement votre CV actuel ?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-outline-danger rounded-pill px-4">
        <i class="bi bi-trash me-2"></i> Supprimer le CV actuel
    </button>
</form>
@endif

<hr class="my-4">

{{-- Formulaire visibilité --}}
<form action="{{ route('admin.mes-candidatures.cv.visibility') }}" method="POST">
    @csrf
    @method('PATCH')
    <input type="hidden" name="cv_public" value="0">
    <div class="form-check form-switch">
        <input type="checkbox" name="cv_public" id="cvPublic"
               value="1" {{ $etudiant->cv_public ? 'checked' : '' }}>
        <label for="cvPublic">Rendre mon CV visible publiquement</label>
    </div>
    <button type="submit">Enregistrer</button>
</form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
