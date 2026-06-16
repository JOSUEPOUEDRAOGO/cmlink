@extends('layouts.admin')

@section('title', 'Paramètres')

@section('content')

@php
    $groupeLabels = [
        'general'       => ['label' => 'Général',               'icon' => 'bi-gear'],
        'inscription'   => ['label' => 'Inscription & Accès',   'icon' => 'bi-person-plus'],
        'offres'        => ['label' => 'Offres',                 'icon' => 'bi-briefcase'],
        'candidatures'  => ['label' => 'Candidatures',           'icon' => 'bi-send'],
        'notifications' => ['label' => 'Emails & Notifications', 'icon' => 'bi-bell'],
        'maintenance'   => ['label' => 'Maintenance',            'icon' => 'bi-tools'],
        'securite'      => ['label' => 'Sécurité',              'icon' => 'bi-shield-lock'],
    ];

    $maintenanceActive = ($groupes['maintenance'] ?? collect())
        ->firstWhere('cle', 'mode_maintenance')?->valeur === '1';
@endphp

<div class="container-fluid" style="max-width:960px;">

    {{-- En-tête --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Paramètres</h4>
            <p class="text-muted mb-0" style="font-size:13px;">
                Configuration globale de la plateforme Cmlink
            </p>
        </div>

        {{-- Bouton maintenance rapide --}}
        <form action="{{ route('admin.parametres.maintenance') }}" method="POST">
            @csrf
            <button type="submit"
                class="btn rounded-pill d-flex align-items-center gap-2"
                style="font-size:13px;
                background:{{ $maintenanceActive ? '#FCEBEB' : '#F1EFE8' }};
                color:{{ $maintenanceActive ? '#791F1F' : '#444441' }};
                border:0.5px solid {{ $maintenanceActive ? '#F09595' : '#B4B2A9' }};"
                onclick="return confirm('{{ $maintenanceActive ? 'Désactiver' : 'Activer' }} le mode maintenance ?')">
                <i class="bi bi-{{ $maintenanceActive ? 'check-circle' : 'tools' }}"></i>
                {{ $maintenanceActive ? 'Désactiver maintenance' : 'Activer maintenance' }}
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($maintenanceActive)
        <div class="d-flex align-items-center gap-3 p-3 mb-4 rounded-3"
            style="background:#FCEBEB;border:0.5px solid #F09595;">
            <i class="bi bi-exclamation-triangle" style="color:#791F1F;font-size:18px;"></i>
            <div>
                <p class="fw-semibold mb-0" style="font-size:14px;color:#791F1F;">
                    Mode maintenance activé
                </p>
                <p class="mb-0" style="font-size:12px;color:#A32D2D;">
                    La plateforme est inaccessible aux visiteurs. Seul l'admin voit le site.
                </p>
            </div>
        </div>
    @endif

    {{-- Onglets groupes --}}
    <div class="d-flex gap-2 flex-wrap mb-4">
        @foreach($groupeLabels as $key => $config)
            @if(isset($groupes[$key]))
                <button type="button"
                    class="btn btn-sm rounded-pill groupe-tab {{ $key === 'general' ? 'active' : '' }}"
                    data-groupe="{{ $key }}"
                    style="font-size:13px;">
                    <i class="bi {{ $config['icon'] }} me-1"></i>
                    {{ $config['label'] }}
                </button>
            @endif
        @endforeach
    </div>

    {{-- Formulaire principal --}}
    <form action="{{ route('admin.parametres.update') }}" method="POST" id="parametres-form">
        @csrf

        {{-- Champs cachés pour tracker tous les booléens --}}
        @foreach($groupes as $groupe => $params)
            @foreach($params as $p)
                @if($p->type === 'boolean')
                    <input type="hidden" name="all_cles[]" value="{{ $p->cle }}">
                @endif
            @endforeach
        @endforeach

        @foreach($groupeLabels as $key => $config)
            @if(!isset($groupes[$key])) @continue @endif

            <div class="groupe-panel {{ $key !== 'general' ? 'd-none' : '' }}"
                data-panel="{{ $key }}">

                <div class="card border-0 shadow-sm rounded-4 mb-3">
                    <div class="card-header bg-white border-0 p-4 pb-0 d-flex align-items-center gap-2">
                        <i class="bi {{ $config['icon'] }}" style="font-size:18px;color:#534AB7;"></i>
                        <h6 class="fw-bold mb-0">{{ $config['label'] }}</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex flex-column gap-4">

                            @foreach($groupes[$key] as $p)
                                <div class="parametre-row {{ $p->is_locked ? 'opacity-75' : '' }}">

                                    @if($p->type === 'boolean')
                                        {{-- Toggle switch --}}
                                        <div class="d-flex justify-content-between align-items-start gap-3">
                                            <div class="flex-grow-1">
                                                <p class="fw-semibold mb-0" style="font-size:14px;">
                                                    {{ $p->label ?? $p->cle }}
                                                    @if($p->is_locked)
                                                        <i class="bi bi-lock ms-1 text-muted" style="font-size:12px;"></i>
                                                    @endif
                                                </p>
                                                @if($p->description)
                                                    <p class="text-muted mb-0" style="font-size:12px;">
                                                        {{ $p->description }}
                                                    </p>
                                                @endif
                                            </div>
                                            <div class="form-check form-switch flex-shrink-0 mt-1">
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    role="switch"
                                                    name="parametres[{{ $p->cle }}]"
                                                    id="param_{{ $p->cle }}"
                                                    value="1"
                                                    style="width:42px;height:22px;cursor:pointer;"
                                                    {{ $p->valeur === '1' ? 'checked' : '' }}
                                                    {{ $p->is_locked ? 'disabled' : '' }}>
                                            </div>
                                        </div>

                                    @elseif($p->type === 'number')
                                        {{-- Champ numérique --}}
                                        <div>
                                            <label class="form-label fw-semibold mb-1"
                                                style="font-size:14px;">
                                                {{ $p->label ?? $p->cle }}
                                                @if($p->is_locked)
                                                    <i class="bi bi-lock ms-1 text-muted" style="font-size:12px;"></i>
                                                @endif
                                            </label>
                                            @if($p->description)
                                                <p class="text-muted mb-2" style="font-size:12px;">
                                                    {{ $p->description }}
                                                </p>
                                            @endif
                                            <input
                                                type="number"
                                                name="parametres[{{ $p->cle }}]"
                                                value="{{ old('parametres.' . $p->cle, $p->valeur) }}"
                                                class="form-control rounded-3"
                                                style="max-width:180px;"
                                                min="0"
                                                {{ $p->is_locked ? 'disabled' : '' }}>
                                        </div>

                                    @elseif($p->type === 'select')
                                        {{-- Select --}}
                                        <div>
                                            <label class="form-label fw-semibold mb-1"
                                                style="font-size:14px;">
                                                {{ $p->label ?? $p->cle }}
                                            </label>
                                            @if($p->description)
                                                <p class="text-muted mb-2" style="font-size:12px;">
                                                    {{ $p->description }}
                                                </p>
                                            @endif
                                            <select
                                                name="parametres[{{ $p->cle }}]"
                                                class="form-select rounded-3"
                                                style="max-width:280px;"
                                                {{ $p->is_locked ? 'disabled' : '' }}>
                                                @foreach($p->options_array as $val => $lbl)
                                                    <option value="{{ $val }}"
                                                        {{ $p->valeur === (string)$val ? 'selected' : '' }}>
                                                        {{ $lbl }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                    @else
                                        {{-- Champ texte --}}
                                        <div>
                                            <label class="form-label fw-semibold mb-1"
                                                style="font-size:14px;">
                                                {{ $p->label ?? $p->cle }}
                                                @if($p->is_locked)
                                                    <i class="bi bi-lock ms-1 text-muted" style="font-size:12px;"></i>
                                                @endif
                                            </label>
                                            @if($p->description)
                                                <p class="text-muted mb-2" style="font-size:12px;">
                                                    {{ $p->description }}
                                                </p>
                                            @endif
                                            <input
                                                type="text"
                                                name="parametres[{{ $p->cle }}]"
                                                value="{{ old('parametres.' . $p->cle, $p->valeur) }}"
                                                class="form-control rounded-3"
                                                style="max-width:420px;"
                                                {{ $p->is_locked ? 'disabled' : '' }}>
                                        </div>
                                    @endif

                                    {{-- Séparateur --}}
                                    @if(!$loop->last)
                                        <hr style="border-color:rgba(0,0,0,.06);margin:0;">
                                    @endif

                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>

            </div>
        @endforeach

        {{-- Bouton sauvegarder --}}
        <div class="d-flex justify-content-end mt-2 mb-5">
            <button type="submit" class="btn btn-primary rounded-pill px-4">
                <i class="bi bi-check-lg me-2"></i> Enregistrer les paramètres
            </button>
        </div>

    </form>

</div>

<style>
.groupe-tab {
    background: var(--bs-light);
    color: var(--bs-body-color);
    border: 0.5px solid rgba(0,0,0,.1);
    transition: all .2s;
}
.groupe-tab.active {
    background: #EEEDFE;
    color: #3C3489;
    border-color: #AFA9EC;
    font-weight: 500;
}
.groupe-tab:hover:not(.active) {
    background: var(--bs-secondary-bg);
}
.parametre-row {
    display: flex;
    flex-direction: column;
    gap: 0;
}
.form-check-input:checked {
    background-color: #534AB7;
    border-color: #534AB7;
}
</style>

<script>
document.querySelectorAll('.groupe-tab').forEach(btn => {
    btn.addEventListener('click', function () {
        document.querySelectorAll('.groupe-tab').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.groupe-panel').forEach(p => p.classList.add('d-none'));
        this.classList.add('active');
        document.querySelector(`[data-panel="${this.dataset.groupe}"]`).classList.remove('d-none');
    });
});
</script>

@endsection
