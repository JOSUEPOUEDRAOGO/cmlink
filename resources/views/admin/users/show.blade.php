@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold mb-1">Détail utilisateur</h2>
            <p class="text-muted mb-0">{{ $user->email }}</p>
        </div>

        <a href="{{ route('admin.users.index') }}" class="btn btn-light border">
            Retour
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger rounded-4">{{ session('error') }}</div>
    @endif

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Informations générales</h5>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Nom</h6>
                            <p class="fw-semibold">{{ $user->name }}</p>
                        </div>

                        <div class="col-md-6">
                            <h6 class="text-muted">Email</h6>
                            <p class="fw-semibold">{{ $user->email }}</p>
                        </div>

                        <div class="col-md-6">
                            <h6 class="text-muted">Type</h6>
                            <p class="fw-semibold">{{ ucfirst($user->account_type ?? '-') }}</p>
                        </div>

                        <div class="col-md-6">
                            <h6 class="text-muted">Statut</h6>
                            <p class="fw-semibold">{{ ucfirst($user->status ?? '-') }}</p>
                        </div>

                        @if($user->etudiant)
                            <div class="col-md-6">
                                <h6 class="text-muted">Profil étudiant</h6>
                                <p class="fw-semibold">{{ $user->etudiant->prenom }} {{ $user->etudiant->nom }}</p>
                            </div>

                            <div class="col-md-6">
                                <h6 class="text-muted">Filière</h6>
                                <p class="fw-semibold">{{ $user->etudiant->filiere->nom ?? '-' }}</p>
                            </div>
                        @endif

                        @if($user->entreprise)
                            <div class="col-md-6">
                                <h6 class="text-muted">Entreprise</h6>
                                <p class="fw-semibold">{{ $user->entreprise->nom }}</p>
                            </div>

                            <div class="col-md-6">
                                <h6 class="text-muted">Téléphone</h6>
                                <p class="fw-semibold">{{ $user->entreprise->telephone ?? '-' }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Modifier le statut</h5>

                    <form action="{{ route('admin.users.status', $user) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <select name="status" class="form-select mb-3">
                            @foreach(['actif', 'en_attente', 'refuse', 'suspendu'] as $status)
                                <option value="{{ $status }}" @selected($user->status === $status)>
                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                </option>
                            @endforeach
                        </select>

                        <button class="btn btn-primary">
                            Enregistrer le statut
                        </button>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Modifier le rôle</h5>

                    <form action="{{ route('admin.users.role', $user) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <select name="role" class="form-select mb-3">
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" @selected($user->hasRole($role->name))>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>

                        <button class="btn btn-warning">
                            Mettre à jour le rôle
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection