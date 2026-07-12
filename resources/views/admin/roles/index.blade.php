@extends('layouts.admin')

@section('title', 'IAM — Rôles & Accès')

@section('content')

<div class="container-fluid" style="max-width:1200px;">

    {{-- En-tête --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-0">Rôles & Accès</h4>
            <p class="text-muted mb-0" style="font-size:13px;">
                Identity & Access Management — gérez les rôles, permissions et accès utilisateurs.
            </p>
        </div>
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

    {{-- ═══════════ STATS ═══════════ --}}
    <div class="row g-3 mb-4">
        @php
            $statCards = [
                ['label' => 'Rôles',        'value' => $stats['roles'],       'bg' => '#EEEDFE', 'color' => '#3C3489', 'icon' => 'bi-shield-lock'],
                ['label' => 'Permissions',  'value' => $stats['permissions'], 'bg' => '#E1F5EE', 'color' => '#085041', 'icon' => 'bi-key'],
                ['label' => 'Admins',       'value' => $stats['admins'],      'bg' => '#FAEEDA', 'color' => '#633806', 'icon' => 'bi-person-gear'],
                ['label' => 'Entreprises',  'value' => $stats['entreprises'], 'bg' => '#EEF2FF', 'color' => '#3730A3', 'icon' => 'bi-building'],
                ['label' => 'Étudiants',    'value' => $stats['etudiants'],   'bg' => '#F0FDF4', 'color' => '#166534', 'icon' => 'bi-mortarboard'],
                ['label' => 'Actifs',       'value' => $stats['actifs'],      'bg' => '#F0F9FF', 'color' => '#0C4A6E', 'icon' => 'bi-circle-fill'],
            ];
        @endphp
        @foreach($statCards as $card)
            <div class="col-6 col-md-4 col-lg-2">
                <div class="card border-0 shadow-sm rounded-4 text-center py-3 px-2"
                    style="background:{{ $card['bg'] }};">
                    <i class="bi {{ $card['icon'] }} mb-1" style="font-size:20px;color:{{ $card['color'] }};"></i>
                    <p class="fw-bold mb-0" style="font-size:22px;color:{{ $card['color'] }};">{{ $card['value'] }}</p>
                    <p class="mb-0" style="font-size:11px;color:{{ $card['color'] }};opacity:.8;">{{ $card['label'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ═══════════ ONGLETS ═══════════ --}}
    <div class="d-flex gap-2 flex-wrap mb-4">
        @foreach(['roles' => '🛡️ Rôles', 'permissions' => '🔑 Permissions', 'access' => '🎯 Attribution des accès', 'users' => '👥 Utilisateurs & accès'] as $tab => $label)
            <button type="button" class="btn btn-sm rounded-pill iam-tab {{ $tab === 'roles' ? 'active' : '' }}"
                data-tab="{{ $tab }}" style="font-size:13px;">
                {{ $label }}
            </button>
        @endforeach
    </div>

    {{-- ═══════════════════════════════════════════ --}}
    {{-- MODULE 1 — RÔLES                           --}}
    {{-- ═══════════════════════════════════════════ --}}
    <div class="iam-panel" id="panel-roles">
        <div class="card border-0 shadow-sm rounded-4 mb-3">
            <div class="card-header bg-white border-0 p-4 pb-3 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0">🛡️ Gestion des rôles</h6>
                <button type="button" class="btn btn-primary rounded-pill btn-sm"
                    onclick="toggleForm('form-create-role')" style="font-size:13px;">
                    <i class="bi bi-plus me-1"></i> Nouveau rôle
                </button>
            </div>

            {{-- Formulaire création rôle --}}
            <div id="form-create-role" class="d-none px-4 pb-3">
                <form action="{{ route('admin.roles.store') }}" method="POST"
                    class="d-flex gap-2 align-items-end">
                    @csrf
                    <div class="flex-grow-1">
                        <label class="form-label mb-1" style="font-size:12px;">Nom du rôle</label>
                        <input type="text" name="name" class="form-control rounded-3"
                            placeholder="ex: recruteur" required>
                    </div>
                    <button type="submit" class="btn btn-primary rounded-pill" style="font-size:13px;">
                        Créer
                    </button>
                    <button type="button" class="btn btn-light rounded-pill border"
                        onclick="toggleForm('form-create-role')" style="font-size:13px;">
                        Annuler
                    </button>
                </form>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 py-3">Rôle</th>
                                <th class="py-3">Utilisateurs</th>
                                <th class="py-3">Permissions</th>
                                <th class="py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($roles as $role)
                                <tr>
                                    <td class="ps-4">
                                        <span class="fw-semibold" style="font-size:14px;">{{ $role->name }}</span>
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill"
                                            style="font-size:11px;background:#EEEDFE;color:#3C3489;">
                                            {{ $role->users_count }} utilisateur(s)
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill"
                                            style="font-size:11px;background:#E1F5EE;color:#085041;">
                                            {{ $role->permissions_count }} permission(s)
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <button type="button"
                                                class="btn btn-sm btn-light rounded-pill border"
                                                onclick="toggleRoleEdit({{ $role->id }})"
                                                style="font-size:12px;">
                                                <i class="bi bi-pencil me-1"></i> Modifier
                                            </button>
                                            @if(!in_array($role->name, ['admin', 'etudiant', 'entreprise']))
                                                <form action="{{ route('admin.roles.destroy', $role) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Supprimer le rôle {{ $role->name }} ?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-light rounded-pill border text-danger"
                                                        style="font-size:12px;">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                {{-- Formulaire édition inline --}}
                                <tr id="role-edit-{{ $role->id }}" class="d-none">
                                    <td colspan="4" class="p-4"
                                        style="background:#FAFAFA;border-top:0;">
                                        <form action="{{ route('admin.roles.update', $role) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <div class="row g-3">
                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold mb-1"
                                                        style="font-size:12px;">Nom du rôle</label>
                                                    <input type="text" name="name"
                                                        value="{{ $role->name }}"
                                                        class="form-control rounded-3">
                                                </div>
                                                <div class="col-md-8">
                                                    <label class="form-label fw-semibold mb-1"
                                                        style="font-size:12px;">Permissions associées</label>
                                                    <div class="d-flex flex-wrap gap-2">
                                                        @foreach($permissions as $permission)
                                                            @php $has = $role->hasPermissionTo($permission->name); @endphp
                                                            <label class="perm-toggle {{ $has ? 'is-on' : '' }}"
                                                                style="cursor:pointer;display:inline-flex;align-items:center;gap:6px;
                                                                padding:5px 12px;border-radius:999px;font-size:12px;
                                                                border:0.5px solid {{ $has ? '#6EE7B7' : 'rgba(0,0,0,.12)' }};
                                                                background:{{ $has ? '#E1F5EE' : '#fff' }};
                                                                color:{{ $has ? '#085041' : '#444' }};">
                                                                <input type="checkbox"
                                                                    name="permissions[]"
                                                                    value="{{ $permission->id }}"
                                                                    {{ $has ? 'checked' : '' }}
                                                                    style="display:none;">
                                                                <i class="bi {{ $has ? 'bi-check-circle-fill' : 'bi-circle' }}"
                                                                    style="font-size:11px;"></i>
                                                                {{ $permission->name }}
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="col-12 d-flex gap-2">
                                                    <button type="submit"
                                                        class="btn btn-primary rounded-pill btn-sm"
                                                        style="font-size:13px;">
                                                        <i class="bi bi-check-lg me-1"></i> Enregistrer
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-light rounded-pill border btn-sm"
                                                        onclick="toggleRoleEdit({{ $role->id }})"
                                                        style="font-size:13px;">
                                                        Annuler
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        Aucun rôle trouvé.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════ --}}
    {{-- MODULE 2 — PERMISSIONS                     --}}
    {{-- ═══════════════════════════════════════════ --}}
    <div class="iam-panel d-none" id="panel-permissions">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 p-4 pb-3 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0">🔑 Gestion des permissions</h6>
                <button type="button" class="btn btn-primary rounded-pill btn-sm"
                    onclick="toggleForm('form-create-permission')" style="font-size:13px;">
                    <i class="bi bi-plus me-1"></i> Nouvelle permission
                </button>
            </div>

            {{-- Formulaire création permission --}}
            <div id="form-create-permission" class="d-none px-4 pb-3">
                <form action="{{ route('admin.permissions.store') }}" method="POST"
                    class="d-flex gap-2 align-items-end">
                    @csrf
                    <div class="flex-grow-1">
                        <label class="form-label mb-1" style="font-size:12px;">Nom de la permission</label>
                        <input type="text" name="name" class="form-control rounded-3"
                            placeholder="ex: manage rapports" required>
                    </div>
                    <button type="submit" class="btn btn-primary rounded-pill" style="font-size:13px;">
                        Créer
                    </button>
                    <button type="button" class="btn btn-light rounded-pill border"
                        onclick="toggleForm('form-create-permission')" style="font-size:13px;">
                        Annuler
                    </button>
                </form>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 py-3">Permission</th>
                                <th class="py-3">Affectée aux rôles</th>
                                <th class="py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($permissions as $permission)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-shield" style="color:#085041;"></i>
                                            <span class="fw-semibold" style="font-size:14px;">
                                                {{ $permission->name }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            @forelse($permission->roles as $role)
                                                <span class="badge rounded-pill"
                                                    style="font-size:11px;background:#EEEDFE;color:#3C3489;">
                                                    {{ $role->name }}
                                                </span>
                                            @empty
                                                <span class="text-muted" style="font-size:12px;">—</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <button type="button"
                                                class="btn btn-sm btn-light rounded-pill border"
                                                onclick="togglePermEdit({{ $permission->id }})"
                                                style="font-size:12px;">
                                                <i class="bi bi-pencil me-1"></i> Renommer
                                            </button>
                                            <form action="{{ route('admin.permissions.destroy', $permission) }}"
                                                method="POST"
                                                onsubmit="return confirm('Supprimer {{ $permission->name }} ?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm btn-light rounded-pill border text-danger"
                                                    style="font-size:12px;">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                {{-- Formulaire renommage inline --}}
                                <tr id="perm-edit-{{ $permission->id }}" class="d-none">
                                    <td colspan="3" class="p-3" style="background:#FAFAFA;border-top:0;">
                                        <form action="{{ route('admin.permissions.update', $permission) }}"
                                            method="POST"
                                            class="d-flex gap-2 align-items-end">
                                            @csrf @method('PATCH')
                                            <div class="flex-grow-1">
                                                <input type="text" name="name"
                                                    value="{{ $permission->name }}"
                                                    class="form-control rounded-3 form-control-sm">
                                            </div>
                                            <button type="submit"
                                                class="btn btn-primary rounded-pill btn-sm"
                                                style="font-size:12px;">
                                                Enregistrer
                                            </button>
                                            <button type="button"
                                                class="btn btn-light rounded-pill border btn-sm"
                                                onclick="togglePermEdit({{ $permission->id }})"
                                                style="font-size:12px;">
                                                Annuler
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-5 text-muted">
                                        Aucune permission trouvée.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════ --}}
    {{-- MODULE 3 — ATTRIBUTION DES ACCÈS           --}}
    {{-- ═══════════════════════════════════════════ --}}
    <div class="iam-panel d-none" id="panel-access">
        <div class="row g-3">

            {{-- DONNER DES ACCÈS --}}
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-0 p-4 pb-0 d-flex align-items-center gap-2">
                        <span style="font-size:18px;">🎯</span>
                        <h6 class="fw-bold mb-0">Donner des accès</h6>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.access.give') }}" method="POST">
                            @csrf

                            {{-- Catégorie --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold mb-2" style="font-size:13px;">
                                    1. Catégorie d'utilisateurs
                                </label>
                                <div class="d-flex gap-2 flex-wrap">
                                    @foreach(['etudiant' => '🎓 Étudiants', 'entreprise' => '🏢 Entreprises', 'admin' => '⚙️ Admins'] as $cat => $lbl)
                                        <label class="cat-pill" data-form="give"
                                            style="cursor:pointer;padding:7px 14px;border-radius:999px;
                                            font-size:12px;font-weight:500;border:0.5px solid rgba(0,0,0,.12);
                                            background:#fff;color:#444;transition:all .15s;">
                                            <input type="radio" name="categorie_give" value="{{ $cat }}"
                                                style="display:none;">
                                            {{ $lbl }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Utilisateurs --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold mb-2" style="font-size:13px;">
                                    2. Sélectionner les utilisateurs
                                </label>
                                <div class="border rounded-3 p-3" style="max-height:180px;overflow-y:auto;">
                                    @foreach($utilisateurs as $u)
                                        <label class="d-flex align-items-center gap-2 py-1"
                                            style="cursor:pointer;font-size:13px;">
                                            <input type="checkbox" name="user_ids[]" value="{{ $u->id }}"
                                                class="form-check-input">
                                            <span class="fw-semibold">{{ $u->name }}</span>
                                            <span class="text-muted" style="font-size:11px;">
                                                {{ $u->email }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Rôles --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold mb-2" style="font-size:13px;">
                                    3. Rôles à attribuer
                                </label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($roles as $role)
                                        <label class="access-toggle"
                                            style="cursor:pointer;display:inline-flex;align-items:center;gap:6px;
                                            padding:6px 14px;border-radius:999px;font-size:12px;
                                            border:0.5px solid rgba(0,0,0,.12);background:#fff;color:#444;
                                            transition:all .15s;">
                                            <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                                                style="display:none;">
                                            <i class="bi bi-circle" style="font-size:11px;"></i>
                                            {{ $role->name }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Permissions supplémentaires --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold mb-2" style="font-size:13px;">
                                    4. Permissions directes supplémentaires
                                </label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($permissions as $perm)
                                        <label class="access-toggle"
                                            style="cursor:pointer;display:inline-flex;align-items:center;gap:6px;
                                            padding:6px 14px;border-radius:999px;font-size:12px;
                                            border:0.5px solid rgba(0,0,0,.12);background:#fff;color:#444;
                                            transition:all .15s;">
                                            <input type="checkbox" name="permissions[]" value="{{ $perm->id }}"
                                                style="display:none;">
                                            <i class="bi bi-circle" style="font-size:11px;"></i>
                                            {{ $perm->name }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary rounded-pill w-100"
                                style="font-size:13px;">
                                <i class="bi bi-check-lg me-2"></i> Donner les accès
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- RETIRER DES ACCÈS --}}
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 h-100"
                    style="background:rgba(252,235,235,.3);border:0.5px solid rgba(240,149,149,.2) !important;">
                    <div class="card-header border-0 p-4 pb-0 d-flex align-items-center gap-2"
                        style="background:transparent;">
                        <span style="font-size:18px;">🚫</span>
                        <h6 class="fw-bold mb-0" style="color:#791F1F;">Retirer des accès</h6>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.access.revoke') }}" method="POST">
                            @csrf

                            {{-- Catégorie --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold mb-2" style="font-size:13px;">
                                    1. Catégorie d'utilisateurs
                                </label>
                                <div class="d-flex gap-2 flex-wrap">
                                    @foreach(['etudiant' => '🎓 Étudiants', 'entreprise' => '🏢 Entreprises', 'admin' => '⚙️ Admins'] as $cat => $lbl)
                                        <label class="cat-pill"
                                            style="cursor:pointer;padding:7px 14px;border-radius:999px;
                                            font-size:12px;font-weight:500;border:0.5px solid rgba(0,0,0,.12);
                                            background:#fff;color:#444;transition:all .15s;">
                                            <input type="radio" name="categorie_revoke" value="{{ $cat }}"
                                                style="display:none;">
                                            {{ $lbl }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Utilisateurs --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold mb-2" style="font-size:13px;">
                                    2. Sélectionner les utilisateurs
                                </label>
                                <div class="border rounded-3 p-3" style="max-height:180px;overflow-y:auto;">
                                    @foreach($utilisateurs as $u)
                                        <label class="d-flex align-items-center gap-2 py-1"
                                            style="cursor:pointer;font-size:13px;">
                                            <input type="checkbox" name="user_ids[]" value="{{ $u->id }}"
                                                class="form-check-input">
                                            <span class="fw-semibold">{{ $u->name }}</span>
                                            <span class="text-muted" style="font-size:11px;">
                                                {{ $u->email }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Rôles à retirer --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold mb-2" style="font-size:13px;">
                                    3. Rôles à retirer
                                </label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($roles as $role)
                                        <label class="revoke-toggle"
                                            style="cursor:pointer;display:inline-flex;align-items:center;gap:6px;
                                            padding:6px 14px;border-radius:999px;font-size:12px;
                                            border:0.5px solid rgba(0,0,0,.12);background:#fff;color:#444;
                                            transition:all .15s;">
                                            <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                                                style="display:none;">
                                            <i class="bi bi-circle" style="font-size:11px;"></i>
                                            {{ $role->name }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Permissions à retirer --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold mb-2" style="font-size:13px;">
                                    4. Permissions à retirer
                                </label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($permissions as $perm)
                                        <label class="revoke-toggle"
                                            style="cursor:pointer;display:inline-flex;align-items:center;gap:6px;
                                            padding:6px 14px;border-radius:999px;font-size:12px;
                                            border:0.5px solid rgba(0,0,0,.12);background:#fff;color:#444;
                                            transition:all .15s;">
                                            <input type="checkbox" name="permissions[]" value="{{ $perm->id }}"
                                                style="display:none;">
                                            <i class="bi bi-circle" style="font-size:11px;"></i>
                                            {{ $perm->name }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <button type="submit"
                                class="btn rounded-pill w-100"
                                style="font-size:13px;background:#FCEBEB;color:#791F1F;border:0.5px solid #F09595;"
                                onclick="return confirm('Retirer ces accès aux utilisateurs sélectionnés ?')">
                                <i class="bi bi-x-lg me-2"></i> Retirer les accès
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ═══════════════════════════════════════════ --}}
    {{-- MODULE 4 — UTILISATEURS & ACCÈS            --}}
    {{-- ═══════════════════════════════════════════ --}}
    <div class="iam-panel d-none" id="panel-users">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 p-4 pb-3">
                <h6 class="fw-bold mb-3">👥 Utilisateurs & accès</h6>
                <form method="GET" action="{{ route('admin.roles.index') }}"
                    class="d-flex gap-2 flex-wrap align-items-end">
                    <input type="hidden" name="tab" value="users">
                    <div>
                        <label class="form-label mb-1" style="font-size:12px;">Catégorie</label>
                        <select name="categorie" class="form-select form-select-sm rounded-3"
                            onchange="this.form.submit()">
                            <option value="tous" {{ $categorie === 'tous' ? 'selected' : '' }}>Tous</option>
                            <option value="etudiant" {{ $categorie === 'etudiant' ? 'selected' : '' }}>Étudiants</option>
                            <option value="entreprise" {{ $categorie === 'entreprise' ? 'selected' : '' }}>Entreprises</option>
                            <option value="admin" {{ $categorie === 'admin' ? 'selected' : '' }}>Admins</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label mb-1" style="font-size:12px;">Recherche</label>
                        <input type="text" name="search" value="{{ $search }}"
                            class="form-control form-control-sm rounded-3"
                            placeholder="Nom ou email..."
                            style="min-width:200px;">
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary rounded-pill">
                        <i class="bi bi-search"></i>
                    </button>
                    <a href="{{ route('admin.roles.index', ['tab' => 'users']) }}"
                        class="btn btn-sm btn-light rounded-pill border">
                        <i class="bi bi-x-lg"></i>
                    </a>
                </form>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 py-3">Utilisateur</th>
                                <th class="py-3">Type</th>
                                <th class="py-3">Rôles</th>
                                <th class="py-3">Permissions directes</th>
                                <th class="py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($utilisateurs as $u)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
                                                style="width:34px;height:34px;background:#EEEDFE;color:#3C3489;font-size:12px;">
                                                {{ strtoupper(substr($u->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="fw-semibold mb-0" style="font-size:13px;">{{ $u->name }}</p>
                                                <p class="text-muted mb-0" style="font-size:11px;">{{ $u->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill"
                                            style="font-size:11px;background:#F1EFE8;color:#444441;">
                                            {{ ucfirst($u->account_type) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            @forelse($u->roles as $role)
                                                <span class="badge rounded-pill"
                                                    style="font-size:11px;background:#EEEDFE;color:#3C3489;">
                                                    {{ $role->name }}
                                                </span>
                                            @empty
                                                <span class="text-muted" style="font-size:12px;">—</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            @forelse($u->permissions as $perm)
                                                <span class="badge rounded-pill"
                                                    style="font-size:11px;background:#E1F5EE;color:#085041;">
                                                    {{ $perm->name }}
                                                </span>
                                            @empty
                                                <span class="text-muted" style="font-size:12px;">—</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.users.show', $u) }}"
                                            class="btn btn-sm btn-light rounded-pill border"
                                            style="font-size:12px;">
                                            <i class="bi bi-pencil me-1"></i> Gérer
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-people fs-3 d-block mb-2"></i>
                                        Aucun utilisateur trouvé.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($utilisateurs->hasPages())
                <div class="card-footer bg-white border-0 py-3 px-4">
                    {{ $utilisateurs->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>

</div>

<style>
.iam-tab {
    background: var(--bs-light);
    color: var(--bs-body-color);
    border: 0.5px solid rgba(0,0,0,.1);
    transition: all .2s;
}
.iam-tab.active {
    background: #EEEDFE;
    color: #3C3489;
    border-color: #AFA9EC;
    font-weight: 500;
}
.perm-toggle, .access-toggle, .revoke-toggle {
    user-select: none;
    transition: all .15s;
}
.perm-toggle:hover, .access-toggle:hover, .revoke-toggle:hover {
    filter: brightness(0.96);
}
</style>

<script>
// ── Onglets IAM ──────────────────────────────────────────────────
const tabs = document.querySelectorAll('.iam-tab');
const panels = document.querySelectorAll('.iam-panel');

// Restaure l'onglet actif depuis l'URL
const urlParams = new URLSearchParams(window.location.search);
const activeTab = urlParams.get('tab') || 'roles';
activateTab(activeTab);

tabs.forEach(tab => {
    tab.addEventListener('click', function () {
        activateTab(this.dataset.tab);
        // Mettre à jour l'URL sans rechargement
        const url = new URL(window.location);
        url.searchParams.set('tab', this.dataset.tab);
        window.history.replaceState({}, '', url);
    });
});

function activateTab(name) {
    tabs.forEach(t => t.classList.toggle('active', t.dataset.tab === name));
    panels.forEach(p => p.classList.toggle('d-none', p.id !== `panel-${name}`));
}

// ── Formulaires toggle ───────────────────────────────────────────
function toggleForm(id) {
    document.getElementById(id)?.classList.toggle('d-none');
}

// ── Édition inline rôle ──────────────────────────────────────────
function toggleRoleEdit(id) {
    document.getElementById(`role-edit-${id}`)?.classList.toggle('d-none');
}

// ── Édition inline permission ────────────────────────────────────
function togglePermEdit(id) {
    document.getElementById(`perm-edit-${id}`)?.classList.toggle('d-none');
}

// ── Toggle pills permissions rôle ────────────────────────────────
document.querySelectorAll('.perm-toggle').forEach(pill => {
    pill.addEventListener('click', function () {
        const cb   = this.querySelector('input');
        const icon = this.querySelector('i');
        cb.checked = !cb.checked;
        if (cb.checked) {
            this.style.background   = '#E1F5EE';
            this.style.color        = '#085041';
            this.style.borderColor  = '#6EE7B7';
            icon.className          = 'bi bi-check-circle-fill';
        } else {
            this.style.background  = '#fff';
            this.style.color       = '#444';
            this.style.borderColor = 'rgba(0,0,0,.12)';
            icon.className         = 'bi bi-circle';
        }
    });
});

// ── Toggle pills attribution accès ───────────────────────────────
document.querySelectorAll('.access-toggle').forEach(pill => {
    pill.addEventListener('click', function () {
        const cb   = this.querySelector('input');
        const icon = this.querySelector('i');
        cb.checked = !cb.checked;
        if (cb.checked) {
            this.style.background  = '#EEEDFE';
            this.style.color       = '#3C3489';
            this.style.borderColor = '#AFA9EC';
            icon.className         = 'bi bi-check-circle-fill';
        } else {
            this.style.background  = '#fff';
            this.style.color       = '#444';
            this.style.borderColor = 'rgba(0,0,0,.12)';
            icon.className         = 'bi bi-circle';
        }
    });
});

// ── Toggle pills retrait accès ───────────────────────────────────
document.querySelectorAll('.revoke-toggle').forEach(pill => {
    pill.addEventListener('click', function () {
        const cb   = this.querySelector('input');
        const icon = this.querySelector('i');
        cb.checked = !cb.checked;
        if (cb.checked) {
            this.style.background  = '#FCEBEB';
            this.style.color       = '#791F1F';
            this.style.borderColor = '#F09595';
            icon.className         = 'bi bi-x-circle-fill';
        } else {
            this.style.background  = '#fff';
            this.style.color       = '#444';
            this.style.borderColor = 'rgba(0,0,0,.12)';
            icon.className         = 'bi bi-circle';
        }
    });
});

// ── Pills catégorie ───────────────────────────────────────────────
document.querySelectorAll('.cat-pill').forEach(pill => {
    pill.addEventListener('click', function () {
        const form = this.dataset.form;
        document.querySelectorAll(`.cat-pill`).forEach(p => {
            p.style.background  = '#fff';
            p.style.color       = '#444';
            p.style.borderColor = 'rgba(0,0,0,.12)';
            p.style.fontWeight  = '500';
        });
        this.style.background  = '#EEEDFE';
        this.style.color       = '#3C3489';
        this.style.borderColor = '#AFA9EC';
        this.style.fontWeight  = '600';
        this.querySelector('input').checked = true;
    });
});
</script>

@endsection
