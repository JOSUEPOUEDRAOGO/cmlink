@extends('layouts.admin')

@section('title', 'Mon profil')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            {{-- Messages flash --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <ul class="nav nav-tabs card-header-tabs" id="profileTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab">
                                <i class="bi bi-person-circle me-1"></i> Informations
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button" role="tab">
                                <i class="bi bi-shield-lock me-1"></i> Sécurité
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="danger-tab" data-bs-toggle="tab" data-bs-target="#danger" type="button" role="tab">
                                <i class="bi bi-exclamation-triangle text-danger me-1"></i> Zone dangereuse
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="card-body p-4">
                    <div class="tab-content">
                        {{-- ONGLET INFORMATIONS --}}
                        <div class="tab-pane fade show active" id="info" role="tabpanel">
                            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')

                                {{-- Avatar --}}
                                <div class="text-center mb-4">
                                    <div class="position-relative d-inline-block">
                                        <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('assets/img/default-avatar.png') }}"
     alt="Avatar" class="rounded-circle border" width="120" height="120" style="object-fit: cover;" id="avatarPreview">
                                           
                                        <button type="button" class="btn btn-sm btn-light rounded-circle position-absolute bottom-0 end-0"
                                                id="uploadAvatarBtn" style="transform: translate(10%, -10%);">
                                            <i class="bi bi-camera"></i>
                                        </button>
                                        <input type="file" id="avatarInput" name="avatar" style="display: none;" accept="image/*">
                                    </div>
                                    <p class="text-muted small mt-2">Cliquez sur l'icône pour changer votre photo</p>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Nom complet</label>
                                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Email</label>
                                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                                    </div>

                                    {{-- Téléphone depuis la table fille --}}
                                    @php
                                        $telephone = null;
                                        if ($user->account_type === 'etudiant' && $user->etudiant) {
                                            $telephone = $user->etudiant->telephone;
                                        } elseif ($user->account_type === 'entreprise' && $user->entreprise) {
                                            $telephone = $user->entreprise->telephone;
                                        }
                                    @endphp
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Téléphone</label>
                                        <input type="tel" name="telephone" class="form-control" value="{{ old('telephone', $telephone) }}">
                                    </div>

                                    @if($user->account_type === 'etudiant')
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Nom</label>
                                            <input type="text" name="nom" class="form-control" value="{{ old('nom', $user->etudiant->nom ?? '') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Prénom</label>
                                            <input type="text" name="prenom" class="form-control" value="{{ old('prenom', $user->etudiant->prenom ?? '') }}">
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label fw-semibold">Filière</label>
                                            <select name="filiere_id" class="form-select">
                                                <option value="">Sélectionner une filière</option>
                                                @foreach($filieres as $filiere)
                                                    <option value="{{ $filiere->id }}" @selected(($user->etudiant->filiere_id ?? null) == $filiere->id)>
                                                        {{ $filiere->nom }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif

                                    @if($user->account_type === 'entreprise')
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Nom de l'entreprise</label>
                                            <input type="text" name="nom_entreprise" class="form-control" value="{{ old('nom_entreprise', $user->entreprise->nom ?? '') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Adresse</label>
                                            <input type="text" name="adresse" class="form-control" value="{{ old('adresse', $user->entreprise->adresse ?? '') }}">
                                        </div>
                                    @endif

                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Bio / Présentation</label>
                                        <textarea name="bio" class="form-control" rows="4">{{ old('bio', $user->bio) }}</textarea>
                                    </div>
                                </div>

                                <div class="mt-4 text-end">
                                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                                        <i class="bi bi-save me-1"></i> Enregistrer les modifications
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- ONGLET SÉCURITÉ --}}
                        <div class="tab-pane fade" id="security" role="tabpanel">
                            <form method="POST" action="{{ route('profile.update') }}">
                                @csrf
                                @method('PATCH')
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Nouveau mot de passe</label>
                                        <input type="password" name="password" class="form-control" autocomplete="new-password">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Confirmation</label>
                                        <input type="password" name="password_confirmation" class="form-control">
                                    </div>
                                </div>
                                <div class="mt-4 text-end">
                                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                                        <i class="bi bi-key me-1"></i> Changer le mot de passe
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- ONGLET ZONE DANGEREUSE --}}
                        <div class="tab-pane fade" id="danger" role="tabpanel">
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                La suppression de votre compte est irréversible. Toutes vos données seront effacées.
                            </div>
                            <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer définitivement votre compte ?');">
                                @csrf
                                @method('DELETE')
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Mot de passe actuel</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-danger rounded-pill px-4">
                                    <i class="bi bi-trash3 me-1"></i> Supprimer mon compte
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const avatarInput = document.getElementById('avatarInput');
    const avatarPreview = document.getElementById('avatarPreview');
    const uploadBtn = document.getElementById('uploadAvatarBtn');

    uploadBtn.addEventListener('click', () => avatarInput.click());

    avatarInput.addEventListener('change', function() {
        const file = this.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = e => avatarPreview.src = e.target.result;
        reader.readAsDataURL(file);

        const formData = new FormData();
        formData.append('avatar', file);
        fetch('{{ route("profile.avatar") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (!data.success) alert('Erreur lors de l\'upload');
        })
        .catch(err => console.error(err));
    });
</script>
@endsection