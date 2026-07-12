@extends('layouts.admin')

@section('title', 'Détail utilisateur')

@section('content')
<div class="container-fluid" style="max-width:1100px;">

    {{-- En-tête --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold"
                style="width:52px;height:52px;background:#EEEDFE;color:#3C3489;font-size:18px;flex-shrink:0;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h4 class="fw-bold mb-0">{{ $user->name }}</h4>
                <p class="text-muted mb-0" style="font-size:13px;">{{ $user->email }}</p>
            </div>
        </div>
        <a href="{{ route('admin.users.index') }}"
            class="btn btn-light rounded-pill border" style="font-size:13px;">
            <i class="bi bi-arrow-left me-1"></i> Retour
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-4 mb-4">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-3">

        {{-- ═══════════ 👤 INFORMATIONS GÉNÉRALES ═══════════ --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 p-4 pb-0 d-flex align-items-center gap-2">
                    <span style="font-size:18px;">👤</span>
                    <h6 class="fw-bold mb-0">Informations générales</h6>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-1" style="font-size:12px;">Nom complet</p>
                            <p class="fw-semibold mb-0">{{ $user->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1" style="font-size:12px;">Email</p>
                            <p class="fw-semibold mb-0">{{ $user->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1" style="font-size:12px;">Type de compte</p>
                            <span class="badge rounded-pill"
                                style="font-size:12px;background:#EEEDFE;color:#3C3489;padding:6px 12px;">
                                {{ ucfirst($user->account_type ?? '—') }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1" style="font-size:12px;">Membre depuis</p>
                            <p class="fw-semibold mb-0">{{ $user->created_at?->format('d/m/Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1" style="font-size:12px;">Dernière mise à jour</p>
                            <p class="fw-semibold mb-0">{{ $user->updated_at?->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1" style="font-size:12px;">Email vérifié</p>
                            @if($user->email_verified_at)
                                <span class="badge rounded-pill" style="font-size:11px;background:#E1F5EE;color:#085041;">
                                    <i class="bi bi-check-circle me-1"></i> Vérifié
                                </span>
                            @else
                                <span class="badge rounded-pill" style="font-size:11px;background:#FCEBEB;color:#791F1F;">
                                    <i class="bi bi-x-circle me-1"></i> Non vérifié
                                </span>
                            @endif
                        </div>
                        @if($user->bio)
                            <div class="col-12">
                                <p class="text-muted mb-1" style="font-size:12px;">Bio</p>
                                <p class="mb-0" style="font-size:13px;">{{ $user->bio }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══════════ 🔐 STATUT ═══════════ --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 p-4 pb-0 d-flex align-items-center gap-2">
                    <span style="font-size:18px;">🔐</span>
                    <h6 class="fw-bold mb-0">Statut du compte</h6>
                </div>
                <div class="card-body p-4">
                    @php
                        $statutConfig = [
                            'actif'      => ['bg' => '#E1F5EE', 'color' => '#085041', 'label' => 'Actif'],
                            'en_attente' => ['bg' => '#FAEEDA', 'color' => '#633806', 'label' => 'En attente'],
                            'refuse'     => ['bg' => '#FCEBEB', 'color' => '#791F1F', 'label' => 'Refusé'],
                            'suspendu'   => ['bg' => '#F1EFE8', 'color' => '#444441', 'label' => 'Suspendu'],
                        ];
                        $s = $statutConfig[$user->status] ?? ['bg' => '#F1EFE8', 'color' => '#444441', 'label' => $user->status];
                    @endphp
                    <div class="text-center mb-4">
                        <span class="badge rounded-pill"
                            style="font-size:14px;padding:10px 20px;background:{{ $s['bg'] }};color:{{ $s['color'] }};">
                            {{ $s['label'] }}
                        </span>
                    </div>
                    <form action="{{ route('admin.users.status', $user) }}" method="POST">
                        @csrf @method('PATCH')
                        <div class="d-flex flex-column gap-2 mb-3">
                            @foreach(['actif' => '✅ Actif', 'en_attente' => '⏳ En attente', 'refuse' => '❌ Refusé', 'suspendu' => '🚫 Suspendu'] as $val => $lbl)
                                <label class="statut-pill {{ $user->status === $val ? 'is-selected' : '' }}"
                                    data-value="{{ $val }}"
                                    style="cursor:pointer;padding:10px 14px;border-radius:12px;
                                    border:0.5px solid {{ $user->status === $val ? '#AFA9EC' : 'rgba(0,0,0,.1)' }};
                                    background:{{ $user->status === $val ? '#EEEDFE' : '#FAFAFA' }};
                                    font-size:13px;font-weight:{{ $user->status === $val ? '600' : '400' }};">
                                    <input type="radio" name="status" value="{{ $val }}"
                                        {{ $user->status === $val ? 'checked' : '' }}
                                        style="display:none;">
                                    {{ $lbl }}
                                </label>
                            @endforeach
                        </div>
                        <button class="btn btn-primary rounded-pill w-100" style="font-size:13px;">
                            <i class="bi bi-check-lg me-1"></i> Enregistrer
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ═══════════ 👥 RÔLES ═══════════ --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 p-4 pb-0 d-flex align-items-center gap-2">
                    <span style="font-size:18px;">👥</span>
                    <h6 class="fw-bold mb-0">Attribution des rôles</h6>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted mb-3" style="font-size:12px;">
                        Les rôles <span class="fw-semibold" style="color:#3C3489;">surlignés en violet</span>
                        sont déjà attribués. Cliquez pour ajouter ou retirer.
                    </p>
                    <form action="{{ route('admin.users.role', $user) }}" method="POST">
                        @csrf @method('PATCH')
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            @foreach($roles as $role)
                                @php $hasRole = $user->hasRole($role->name); @endphp
                                <label class="toggle-pill role-pill {{ $hasRole ? 'is-active' : '' }}"
                                    data-active-bg="#EEEDFE"
                                    data-active-color="#3C3489"
                                    data-active-border="#AFA9EC"
                                    data-active-icon="bi-check-circle-fill"
                                    data-inactive-icon="bi-circle"
                                    style="cursor:pointer;display:inline-flex;align-items:center;gap:8px;
                                    padding:8px 16px;border-radius:999px;font-size:13px;
                                    border:0.5px solid {{ $hasRole ? '#AFA9EC' : 'rgba(0,0,0,.12)' }};
                                    background:{{ $hasRole ? '#EEEDFE' : '#fff' }};
                                    color:{{ $hasRole ? '#3C3489' : '#444' }};
                                    font-weight:{{ $hasRole ? '600' : '400' }};
                                    transition:all .15s;">
                                    <input type="checkbox" name="roles[]"
                                        value="{{ $role->id }}"
                                        {{ $hasRole ? 'checked' : '' }}
                                        style="display:none;">
                                    <i class="bi {{ $hasRole ? 'bi-check-circle-fill' : 'bi-circle' }}"
                                        style="font-size:14px;"></i>
                                    {{ ucfirst($role->name) }}
                                    @if($hasRole)
                                        <span class="badge rounded-pill ms-1"
                                            style="font-size:9px;background:#3C3489;color:#fff;padding:2px 6px;">
                                            Actif
                                        </span>
                                    @endif
                                </label>
                            @endforeach
                        </div>
                        <button class="btn rounded-pill"
                            style="font-size:13px;background:#EEEDFE;color:#3C3489;border:0.5px solid #AFA9EC;">
                            <i class="bi bi-check-lg me-1"></i> Mettre à jour les rôles
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ═══════════ 🔑 PERMISSIONS ═══════════ --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 p-4 pb-0 d-flex align-items-center gap-2">
                    <span style="font-size:18px;">🔑</span>
                    <h6 class="fw-bold mb-0">Attribution des permissions</h6>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted mb-3" style="font-size:12px;">
                        Les permissions <span class="fw-semibold" style="color:#085041;">surlignées en vert</span>
                        sont déjà attribuées directement. Celles héritées des rôles ne sont pas modifiables ici.
                    </p>

                    {{-- Permissions héritées des rôles (lecture seule) --}}
                    @php
                        $permissionsViaRoles = $user->getPermissionsViaRoles()->pluck('name');
                    @endphp
                    @if($permissionsViaRoles->isNotEmpty())
                        <div class="mb-3 p-3 rounded-3" style="background:#F5F3FF;border:0.5px solid #D8D4F7;">
                            <p class="mb-2" style="font-size:11px;color:#3C3489;font-weight:600;">
                                <i class="bi bi-shield-check me-1"></i>
                                Héritées des rôles (lecture seule)
                            </p>
                            <div class="d-flex flex-wrap gap-1">
                                @foreach($permissionsViaRoles as $perm)
                                    <span class="badge rounded-pill"
                                        style="font-size:11px;background:#EEEDFE;color:#3C3489;padding:4px 10px;">
                                        {{ $perm }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('admin.users.permissions', $user) }}" method="POST">
                        @csrf @method('PATCH')
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            @foreach($permissions as $permission)
                                @php $hasDirect = $user->hasDirectPermission($permission->name); @endphp
                                <label class="toggle-pill perm-pill {{ $hasDirect ? 'is-active' : '' }}"
                                    data-active-bg="#E1F5EE"
                                    data-active-color="#085041"
                                    data-active-border="#6EE7B7"
                                    data-active-icon="bi-shield-fill-check"
                                    data-inactive-icon="bi-shield"
                                    style="cursor:pointer;display:inline-flex;align-items:center;gap:6px;
                                    padding:6px 14px;border-radius:999px;font-size:12px;
                                    border:0.5px solid {{ $hasDirect ? '#6EE7B7' : 'rgba(0,0,0,.12)' }};
                                    background:{{ $hasDirect ? '#E1F5EE' : '#fff' }};
                                    color:{{ $hasDirect ? '#085041' : '#444' }};
                                    font-weight:{{ $hasDirect ? '600' : '400' }};
                                    transition:all .15s;">
                                    <input type="checkbox" name="permissions[]"
                                        value="{{ $permission->id }}"
                                        {{ $hasDirect ? 'checked' : '' }}
                                        style="display:none;">
                                    <i class="bi {{ $hasDirect ? 'bi-shield-fill-check' : 'bi-shield' }}"
                                        style="font-size:12px;"></i>
                                    {{ $permission->name }}
                                    @if($hasDirect)
                                        <span class="badge rounded-pill ms-1"
                                            style="font-size:9px;background:#085041;color:#fff;padding:2px 6px;">
                                            Actif
                                        </span>
                                    @endif
                                </label>
                            @endforeach
                        </div>
                        <button class="btn rounded-pill"
                            style="font-size:13px;background:#E1F5EE;color:#085041;border:0.5px solid #6EE7B7;">
                            <i class="bi bi-check-lg me-1"></i> Mettre à jour les permissions
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ═══════════ 📋 PROFIL LIÉ ═══════════ --}}
        @if($user->etudiant || $user->entreprise)
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 p-4 pb-0 d-flex align-items-center gap-2">
                    <span style="font-size:18px;">📋</span>
                    <h6 class="fw-bold mb-0">Profil lié</h6>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        @if($user->etudiant)
                            <div class="col-md-3">
                                <p class="text-muted mb-1" style="font-size:12px;">Nom complet</p>
                                <p class="fw-semibold mb-0">{{ $user->etudiant->prenom }} {{ $user->etudiant->nom }}</p>
                            </div>
                            <div class="col-md-3">
                                <p class="text-muted mb-1" style="font-size:12px;">Filière</p>
                                <p class="fw-semibold mb-0">{{ $user->etudiant->filiere->nom ?? '—' }}</p>
                            </div>
                            <div class="col-md-3">
                                <p class="text-muted mb-1" style="font-size:12px;">Téléphone</p>
                                <p class="fw-semibold mb-0">{{ $user->etudiant->telephone ?? '—' }}</p>
                            </div>
                            <div class="col-md-3">
                                <p class="text-muted mb-1" style="font-size:12px;">CV public</p>
                                <span class="badge rounded-pill" style="font-size:11px;
                                    background:{{ $user->etudiant->cv_public ? '#E1F5EE' : '#F1EFE8' }};
                                    color:{{ $user->etudiant->cv_public ? '#085041' : '#444441' }};">
                                    {{ $user->etudiant->cv_public ? '✅ Public' : '🔒 Privé' }}
                                </span>
                            </div>
                        @endif
                        @if($user->entreprise)
                            <div class="col-md-3">
                                <p class="text-muted mb-1" style="font-size:12px;">Entreprise</p>
                                <p class="fw-semibold mb-0">{{ $user->entreprise->nom }}</p>
                            </div>
                            <div class="col-md-3">
                                <p class="text-muted mb-1" style="font-size:12px;">Email entreprise</p>
                                <p class="fw-semibold mb-0">{{ $user->entreprise->email ?? '—' }}</p>
                            </div>
                            <div class="col-md-3">
                                <p class="text-muted mb-1" style="font-size:12px;">Téléphone</p>
                                <p class="fw-semibold mb-0">{{ $user->entreprise->telephone ?? '—' }}</p>
                            </div>
                            <div class="col-md-3">
                                <p class="text-muted mb-1" style="font-size:12px;">Adresse</p>
                                <p class="fw-semibold mb-0">{{ $user->entreprise->adresse ?? '—' }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- ═══════════ ⚠️ ZONE DANGEREUSE ═══════════ --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4"
                style="background:rgba(252,235,235,.4);border:0.5px solid rgba(240,149,149,.3) !important;">
                <div class="card-header border-0 p-4 pb-0 d-flex align-items-center gap-2"
                    style="background:transparent;">
                    <span style="font-size:18px;">⚠️</span>
                    <h6 class="fw-bold mb-0" style="color:#791F1F;">Zone dangereuse</h6>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex flex-wrap gap-3 align-items-center">
                        <div class="flex-grow-1">
                            <p class="fw-semibold mb-1" style="font-size:14px;color:#791F1F;">
                                Supprimer ce compte
                            </p>
                            <p class="text-muted mb-0" style="font-size:12px;">
                                Cette action est irréversible. Toutes les données associées seront supprimées.
                            </p>
                        </div>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                            onsubmit="return confirm('Supprimer définitivement {{ $user->name }} ? Cette action est irréversible.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn rounded-pill"
                                style="font-size:13px;background:#FCEBEB;color:#791F1F;border:0.5px solid #F09595;">
                                <i class="bi bi-trash me-1"></i> Supprimer le compte
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
.toggle-pill { user-select: none; }
.toggle-pill:hover { filter: brightness(0.96); transform: scale(1.02); }
.statut-pill { user-select: none; }
.statut-pill:hover { filter: brightness(0.97); }
</style>

<script>
// ── Toggle générique pour rôles et permissions ──────────────────
document.querySelectorAll('.toggle-pill').forEach(pill => {
    pill.addEventListener('click', function () {
        const cb           = this.querySelector('input[type="checkbox"]');
        const icon         = this.querySelector('i');
        const badge        = this.querySelector('.badge');
        const activeBg     = this.dataset.activeBg;
        const activeColor  = this.dataset.activeColor;
        const activeBorder = this.dataset.activeBorder;
        const activeIcon   = this.dataset.activeIcon;
        const inactiveIcon = this.dataset.inactiveIcon;

        cb.checked = !cb.checked;

        if (cb.checked) {
            this.style.background   = activeBg;
            this.style.color        = activeColor;
            this.style.borderColor  = activeBorder;
            this.style.fontWeight   = '600';
            icon.className          = `bi ${activeIcon}`;
            if (!badge) {
                const b = document.createElement('span');
                b.className = 'badge rounded-pill ms-1';
                b.style.cssText = `font-size:9px;background:${activeColor};color:#fff;padding:2px 6px;`;
                b.textContent = 'Actif';
                this.appendChild(b);
            }
        } else {
            this.style.background  = '#fff';
            this.style.color       = '#444';
            this.style.borderColor = 'rgba(0,0,0,.12)';
            this.style.fontWeight  = '400';
            icon.className         = `bi ${inactiveIcon}`;
            if (badge) badge.remove();
        }
    });
});

// ── Toggle statut ───────────────────────────────────────────────
document.querySelectorAll('.statut-pill').forEach(pill => {
    pill.addEventListener('click', function () {
        document.querySelectorAll('.statut-pill').forEach(p => {
            p.style.background   = '#FAFAFA';
            p.style.borderColor  = 'rgba(0,0,0,.1)';
            p.style.fontWeight   = '400';
        });
        this.style.background  = '#EEEDFE';
        this.style.borderColor = '#AFA9EC';
        this.style.fontWeight  = '600';
        this.querySelector('input').checked = true;
    });
});
</script>

@endsection
