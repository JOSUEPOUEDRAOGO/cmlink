@extends('layouts.front')

@section('title', 'Mes alertes offres | Cmlink')

@section('content')
@include('front.partials.header')

<section class="alertes-section">
    <div class="container">

        <div class="alertes-hero">
            <span class="alertes-kicker">
                <i class="bi bi-bell"></i>
                Alertes offres
            </span>
            <h1>Soyez notifié en temps réel</h1>
            <p>Recevez une notification dès qu'une nouvelle offre correspond à vos critères.</p>
        </div>

        @if(session('success'))
            <div class="alertes-flash">
                <i class="bi bi-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="alertes-grid">

            {{-- Carte statut --}}
            <div class="alerte-card">
                <div class="alerte-card-header">
                    <div class="alerte-card-icon">
                        <i class="bi bi-bell{{ ($alerte && $alerte->active) ? '-fill' : '' }}"></i>
                    </div>
                    <div>
                        <h6>Statut de mes alertes</h6>
                        <p>
                            @if($alerte && $alerte->active)
                                Alertes actives —
                                {{ $alerte->toutes_categories
                                    ? 'toutes les catégories'
                                    : count($alerte->categories_ids ?? []) . ' catégorie(s) sélectionnée(s)' }}
                            @else
                                Aucune alerte active
                            @endif
                        </p>
                    </div>
                </div>
                <form action="{{ route('front.alertes.toggle') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="alerte-toggle-btn {{ ($alerte && $alerte->active) ? 'is-on' : 'is-off' }}">
                        <i class="bi bi-{{ ($alerte && $alerte->active) ? 'bell-slash' : 'bell' }}"></i>
                        {{ ($alerte && $alerte->active) ? 'Désactiver les alertes' : 'Activer les alertes' }}
                    </button>
                </form>
            </div>

            {{-- Carte préférences --}}
            <div class="alerte-card">
                <h6 class="alerte-section-title">
                    <i class="bi bi-sliders"></i>
                    Mes préférences
                </h6>

                <form action="{{ route('front.alertes.store') }}" method="POST">
                    @csrf

                    {{-- Type d'offre --}}
                    <div class="alerte-field">
                        <label>Type d'offre</label>
                        <div class="pills-row">
                            @foreach([
                                'les_deux' => 'Toutes les offres',
                                'stage'    => 'Stages uniquement',
                                'emploi'   => 'Emplois uniquement',
                            ] as $val => $lbl)
                                <label class="pill {{ ($alerte?->type_offre ?? 'les_deux') === $val ? 'active' : '' }}">
                                    <input type="radio" name="type_offre" value="{{ $val }}"
                                        {{ ($alerte?->type_offre ?? 'les_deux') === $val ? 'checked' : '' }}
                                        style="display:none;">
                                    {{ $lbl }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Catégories --}}
                    <div class="alerte-field">
                        <label>Catégories</label>

                        <label class="alerte-check">
                            <input type="checkbox"
                                name="toutes_categories"
                                id="toutesCategories"
                                value="1"
                                {{ ($alerte?->toutes_categories) ? 'checked' : '' }}
                                onchange="toggleCategories(this)">
                            <span>Toutes les catégories</span>
                        </label>

                        <div id="categoriesGrid"
                            class="categories-grid"
                            style="{{ ($alerte?->toutes_categories) ? 'display:none;' : '' }}">
                            @foreach($categories as $categorie)
                                @php
                                    $checked = $alerte
                                        && !$alerte->toutes_categories
                                        && in_array($categorie->id, $alerte->categories_ids ?? []);
                                @endphp
                                <label class="pill {{ $checked ? 'active' : '' }}">
                                    <input type="checkbox"
                                        name="categories_ids[]"
                                        value="{{ $categorie->id }}"
                                        {{ $checked ? 'checked' : '' }}
                                        style="display:none;">
                                    {{ $categorie->nom }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="alerte-save-btn">
                        <i class="bi bi-check-lg"></i>
                        Enregistrer mes préférences
                    </button>

                </form>
            </div>

            {{-- Carte info --}}
            <div class="alerte-card alerte-info-card">
                <h6 class="alerte-section-title">
                    <i class="bi bi-info-circle"></i>
                    Comment ça marche ?
                </h6>
                <ul class="alerte-steps">
                    <li>
                        <div class="step-num">1</div>
                        <div>
                            <strong>Choisissez vos critères</strong>
                            <p>Sélectionnez les catégories et types d'offres qui vous intéressent.</p>
                        </div>
                    </li>
                    <li>
                        <div class="step-num">2</div>
                        <div>
                            <strong>Activez vos alertes</strong>
                            <p>Cliquez sur "Activer les alertes" pour commencer à recevoir des notifications.</p>
                        </div>
                    </li>
                    <li>
                        <div class="step-num">3</div>
                        <div>
                            <strong>Soyez notifié en temps réel</strong>
                            <p>Dès qu'une nouvelle offre correspond à vos critères, une notification apparaît.</p>
                        </div>
                    </li>
                </ul>
            </div>

            {{-- Supprimer --}}
            @if($alerte)
                <div class="alerte-card alerte-danger-card">
                    <h6 class="alerte-section-title">
                        <i class="bi bi-exclamation-triangle"></i>
                        Zone de suppression
                    </h6>
                    <p style="font-size:13px;color:#557c9c;margin-bottom:16px;">
                        Supprimer toutes vos alertes et préférences de façon permanente.
                    </p>
                    <form action="{{ route('front.alertes.destroy') }}" method="POST"
                        onsubmit="return confirm('Supprimer toutes vos alertes ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="alerte-danger-btn">
                            <i class="bi bi-trash me-1"></i>
                            Supprimer mes alertes
                        </button>
                    </form>
                </div>
            @endif

        </div>
    </div>
</section>

@include('front.partials.footer')

<style>
.alertes-section {
    padding: 86px 0;
    background:
        radial-gradient(circle at 12% 14%, rgba(30, 74, 118, 0.08), transparent 34%),
        radial-gradient(circle at 88% 78%, rgba(20, 184, 166, 0.06), transparent 35%),
        #fbfdff;
    min-height: 100vh;
}

.alertes-hero {
    text-align: center;
    max-width: 600px;
    margin: 0 auto 48px;
}

.alertes-kicker {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border-radius: 999px;
    background: rgba(30, 74, 118, 0.08);
    color: #1e4a76;
    font-size: 0.88rem;
    font-weight: 700;
    margin-bottom: 18px;
}

.alertes-hero h1 {
    font-size: clamp(1.8rem, 4vw, 2.8rem);
    font-weight: 900;
    color: #0c2e44;
    margin-bottom: 12px;
    letter-spacing: -0.03em;
}

.alertes-hero p {
    color: #557c9c;
    font-size: 1rem;
    line-height: 1.7;
    margin: 0;
}

.alertes-flash {
    display: flex;
    align-items: center;
    gap: 10px;
    background: rgba(20, 184, 166, 0.1);
    border: 1px solid rgba(20, 184, 166, 0.3);
    border-radius: 16px;
    padding: 14px 20px;
    color: #0f766e;
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 28px;
    max-width: 760px;
    margin-left: auto;
    margin-right: auto;
}

.alertes-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 24px;
    max-width: 860px;
    margin: 0 auto;
}

.alerte-card {
    background: rgba(255,255,255,0.92);
    border: 1px solid rgba(226, 232, 240, 0.95);
    border-radius: 24px;
    padding: 28px;
    box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
}

.alerte-card-header {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 20px;
}

.alerte-card-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    background: rgba(30, 74, 118, 0.08);
    color: #1e4a76;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    flex-shrink: 0;
}

.alerte-card-header h6 {
    font-weight: 700;
    color: #0c2e44;
    margin: 0 0 4px;
    font-size: 15px;
}

.alerte-card-header p {
    font-size: 13px;
    color: #557c9c;
    margin: 0;
}

.alerte-toggle-btn {
    width: 100%;
    padding: 12px;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 700;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all .2s;
}

.alerte-toggle-btn.is-on {
    background: #FCEBEB;
    color: #791F1F;
}

.alerte-toggle-btn.is-on:hover {
    background: #f5c6c6;
}

.alerte-toggle-btn.is-off {
    background: linear-gradient(135deg, #1e4a76, #2b6a9f);
    color: #fff;
    box-shadow: 0 12px 28px rgba(30, 74, 118, 0.25);
}

.alerte-toggle-btn.is-off:hover {
    transform: translateY(-1px);
    box-shadow: 0 16px 36px rgba(30, 74, 118, 0.3);
}

.alerte-section-title {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 15px;
    font-weight: 700;
    color: #0c2e44;
    margin-bottom: 20px;
}

.alerte-field {
    margin-bottom: 24px;
}

.alerte-field > label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #3a5a78;
    margin-bottom: 10px;
}

.pills-row {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.pill {
    display: inline-flex;
    align-items: center;
    padding: 7px 16px;
    border-radius: 999px;
    font-size: 13px;
    cursor: pointer;
    border: 1px solid rgba(30, 74, 118, 0.18);
    background: #fff;
    color: #3a5a78;
    transition: all .15s;
    user-select: none;
}

.pill.active {
    background: #EEEDFE;
    color: #3C3489;
    border-color: #AFA9EC;
    font-weight: 600;
}

.pill:hover:not(.active) {
    background: rgba(30, 74, 118, 0.05);
}

.alerte-check {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    font-size: 13px;
    font-weight: 600;
    color: #0c2e44;
    margin-bottom: 14px;
}

.alerte-check input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: #1e4a76;
    cursor: pointer;
}

.categories-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 8px;
}

.alerte-save-btn {
    width: 100%;
    padding: 13px;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 700;
    border: none;
    cursor: pointer;
    background: linear-gradient(135deg, #1e4a76, #2b6a9f);
    color: #fff;
    box-shadow: 0 12px 28px rgba(30, 74, 118, 0.22);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all .2s;
}

.alerte-save-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 16px 36px rgba(30, 74, 118, 0.3);
}

.alerte-steps {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 18px;
}

.alerte-steps li {
    display: flex;
    align-items: flex-start;
    gap: 14px;
}

.step-num {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: rgba(30, 74, 118, 0.08);
    color: #1e4a76;
    font-size: 13px;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.alerte-steps li strong {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: #0c2e44;
    margin-bottom: 3px;
}

.alerte-steps li p {
    font-size: 12px;
    color: #557c9c;
    margin: 0;
    line-height: 1.5;
}

.alerte-info-card {
    background: rgba(239, 246, 255, 0.6);
    border-color: rgba(30, 74, 118, 0.12);
}

.alerte-danger-card {
    grid-column: 1 / -1;
    background: rgba(252, 235, 235, 0.5);
    border-color: rgba(240, 149, 149, 0.3);
}

.alerte-danger-btn {
    padding: 10px 24px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 700;
    border: 1px solid rgba(240, 149, 149, 0.5);
    background: #fff;
    color: #791F1F;
    cursor: pointer;
    transition: all .2s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.alerte-danger-btn:hover {
    background: #FCEBEB;
}

@media (max-width: 720px) {
    .alertes-section { padding: 60px 0; }
    .alertes-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }
    .alerte-danger-card { grid-column: 1; }
}
</style>

<script>
// Toggle pills radio
document.querySelectorAll('.pills-row .pill').forEach(pill => {
    pill.addEventListener('click', function () {
        this.closest('.pills-row').querySelectorAll('.pill').forEach(p => p.classList.remove('active'));
        this.classList.add('active');
        this.querySelector('input[type="radio"]').checked = true;
    });
});

// Toggle pills checkbox catégories
document.querySelectorAll('.categories-grid .pill').forEach(pill => {
    pill.addEventListener('click', function () {
        this.classList.toggle('active');
        const cb = this.querySelector('input[type="checkbox"]');
        cb.checked = !cb.checked;
    });
});

function toggleCategories(checkbox) {
    const grid = document.getElementById('categoriesGrid');
    grid.style.display = checkbox.checked ? 'none' : 'flex';
}
</script>

{{-- Pusher — notification temps réel --}}
@auth
@if($alerte && $alerte->active)
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
    cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}'
});

const toutesCategories = {{ $alerte->toutes_categories ? 'true' : 'false' }};
const categoriesIds    = @json($alerte->categories_ids ?? []);
const typeOffre        = '{{ $alerte->type_offre }}';

const channel = pusher.subscribe('offres');

channel.bind('nouvelle.offre', function(data) {
    const typeOk = typeOffre === 'les_deux' || data.type === typeOffre;
    const catOk  = toutesCategories || categoriesIds.includes(data.categorie_id);

    if (typeOk && catOk) {
        afficherToast(data);
    }
});

function afficherToast(offre) {
    const existant = document.getElementById('alerte-toast');
    if (existant) existant.remove();

    const toast = document.createElement('div');
    toast.id = 'alerte-toast';
    toast.style.cssText = `
        position:fixed;bottom:28px;right:28px;z-index:9999;
        background:#fff;border-radius:20px;padding:18px 22px;
        box-shadow:0 24px 64px rgba(15,23,42,.18);
        border:1px solid rgba(226,232,240,.95);
        max-width:360px;
        animation:toastIn .35s cubic-bezier(.2,.85,.25,1);
    `;
    toast.innerHTML = `
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:10px;">
            <div style="width:40px;height:40px;border-radius:12px;background:rgba(30,74,118,.08);
                color:#1e4a76;display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0;">
                <i class="bi bi-briefcase"></i>
            </div>
            <div style="flex:1;min-width:0;">
                <p style="font-size:11px;color:#888;margin:0 0 2px;">Nouvelle offre</p>
                <p style="font-size:14px;font-weight:700;color:#0c2e44;margin:0;
                    white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                    ${offre.titre}
                </p>
            </div>
            <button onclick="document.getElementById('alerte-toast').remove()"
                style="background:none;border:none;cursor:pointer;color:#888;font-size:16px;
                padding:0;line-height:1;flex-shrink:0;">✕</button>
        </div>
        <p style="font-size:12px;color:#557c9c;margin:0 0 12px;">
            ${offre.entreprise}
            ${offre.localisation ? ' · ' + offre.localisation : ''}
            ${offre.categorie ? ' · ' + offre.categorie : ''}
        </p>
        <a href="${offre.url}"
            style="display:inline-flex;align-items:center;gap:6px;
            text-decoration:none;font-size:13px;font-weight:700;
            color:#fff;background:linear-gradient(135deg,#1e4a76,#2b6a9f);
            border-radius:999px;padding:8px 18px;">
            Voir l'offre <i class="bi bi-arrow-right"></i>
        </a>
    `;

    document.body.appendChild(toast);

    setTimeout(() => {
        if (document.getElementById('alerte-toast')) {
            document.getElementById('alerte-toast').remove();
        }
    }, 10000);
}
</script>

<style>
@keyframes toastIn {
    from { transform: translateX(120px); opacity: 0; }
    to   { transform: translateX(0);     opacity: 1; }
}
</style>
@endif
@endauth

@endsection
