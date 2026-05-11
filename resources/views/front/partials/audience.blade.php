<section class="audience-section">
    <div class="container">
        <div class="audience-grid">

            {{-- Bloc étudiants --}}
            <div class="audience-card audience-card-student">
                <div class="audience-card-glow"></div>

                <div class="audience-card-content">
                    {{-- <div class="audience-icon">🎓</div> --}}

                    <h2 class="block-title">
                        {{ $pageContent['audience']['student_title'] ?? 'Pour les étudiants et jeunes diplômés' }}
                    </h2>

                    <p class="block-text">
                        {{ $pageContent['audience']['student_text'] ?? 'Trouvez des stages et premiers emplois adaptés à votre niveau et vos ambitions.' }}
                    </p>

                    <ul class="benefit-list">
                        @for($i = 1; $i <= 3; $i++)
                            @php
                                $benefit = $pageContent['audience']["student_benefit_{$i}"] ?? null;
                            @endphp

                            @if(!empty($benefit))
                                <li><span>✓</span> {{ $benefit }}</li>
                            @endif
                        @endfor
                    </ul>

                    <div class="audience-actions">
                        @guest
                            <a href="{{ route('register', ['type' => 'etudiant']) }}" class="btn-primary">
                                {{ $pageContent['audience']['student_button'] ?? "S'inscrire en tant qu'étudiant" }}
                            </a>
                        @else
                            @if(auth()->user()->hasRole('admin'))
                                <a href="{{ route('admin.dashboard') }}" class="btn-primary">
                                    Aller au dashboard admin
                                </a>
                            @else
                                <a href="{{ route('front.offres.index') }}" class="btn-primary">
                                    Voir les offres
                                </a>
                            @endif
                        @endguest
                    </div>

                    <div class="audience-stats">
                        <div class="audience-stat-item">
                            <strong>{{ $stats['offres'] }}+</strong>
                            <span>offres</span>
                        </div>

                        <div class="audience-stat-item">
                            <strong>{{ $stats['entreprises'] }}+</strong>
                            <span>entreprises</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bloc entreprises --}}
            <div class="audience-card audience-card-company">
                <div class="audience-card-glow"></div>

                <div class="audience-card-content">
                    {{-- <div class="audience-icon">🏢</div> --}}

                    <h2 class="block-title">
                        {{ $pageContent['audience']['company_title'] ?? 'Pour les entreprises' }}
                    </h2>

                    <p class="block-text">
                        {{ $pageContent['audience']['company_text'] ?? 'Trouvez les meilleurs talents étudiants et jeunes diplômés adaptés à vos besoins.' }}
                    </p>

                    <ul class="benefit-list">
                        @for($i = 1; $i <= 3; $i++)
                            @php
                                $benefit = $pageContent['audience']["company_benefit_{$i}"] ?? null;
                            @endphp

                            @if(!empty($benefit))
                                <li><span>✓</span> {{ $benefit }}</li>
                            @endif
                        @endfor
                    </ul>

                    <div class="audience-actions">
                        @guest
                            <a href="{{ route('register', ['type' => 'entreprise']) }}" class="btn-outline">
                                {{ $pageContent['audience']['company_button'] ?? "Rejoindre en tant qu'entreprise →" }}
                            </a>
                        @else
                            @if(auth()->user()->hasRole('admin'))
                                <a href="{{ route('admin.dashboard') }}" class="btn-outline">
                                    Aller au dashboard admin →
                                </a>
                            @else
                                <a href="{{ route('front.offres.index') }}" class="btn-outline">
                                    Découvrir la plateforme →
                                </a>
                            @endif
                        @endguest
                    </div>

                    <div class="audience-stats">
                        <div class="audience-stat-item">
                            <strong>{{ $stats['etudiants'] }}+</strong>
                            <span>profils talents</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<style>
.audience-section {
    padding: 90px 0;
    background:
        radial-gradient(circle at top left, rgba(30, 74, 118, 0.08), transparent 34%),
        radial-gradient(circle at bottom right, rgba(43, 106, 159, 0.10), transparent 36%),
        #fbfdff;
}

.audience-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 34px;
    align-items: stretch;
}

.audience-card {
    position: relative;
    min-height: 520px;
    border-radius: 34px;
    padding: 2px;
    overflow: hidden;
    background: linear-gradient(145deg, rgba(255,255,255,0.9), rgba(219,234,254,0.5));
    box-shadow:
        0 35px 75px rgba(15, 23, 42, 0.16),
        18px 18px 45px rgba(30, 74, 118, 0.12),
        -14px -14px 40px rgba(255, 255, 255, 0.9);
    transition: transform 0.35s ease, box-shadow 0.35s ease;
}

.audience-card::before {
    content: "";
    position: absolute;
    inset: 0;
    background:
        linear-gradient(135deg, rgba(255,255,255,0.85), rgba(255,255,255,0.25)),
        radial-gradient(circle at 15% 15%, rgba(30,74,118,0.18), transparent 32%);
    opacity: 0.9;
    pointer-events: none;
}

.audience-card::after {
    content: "";
    position: absolute;
    inset: auto 26px -22px 26px;
    height: 45px;
    background: rgba(15, 23, 42, 0.22);
    filter: blur(30px);
    border-radius: 50%;
    z-index: 0;
}

.audience-card:hover {
    transform: translateY(-8px);
    box-shadow:
        0 45px 95px rgba(15, 23, 42, 0.20),
        22px 22px 55px rgba(30, 74, 118, 0.16),
        -14px -14px 40px rgba(255, 255, 255, 0.92);
}

.audience-card-content {
    position: relative;
    z-index: 2;
    height: 100%;
    min-height: 516px;
    padding: 38px;
    border-radius: 32px;
    background: rgba(255,255,255,0.86);
    border: 1px solid rgba(255,255,255,0.85);
    backdrop-filter: blur(12px);
    display: flex;
    flex-direction: column;
}

.audience-card-student .audience-card-content {
    background:
        linear-gradient(145deg, rgba(255,255,255,0.92), rgba(239,246,255,0.90));
}

.audience-card-company .audience-card-content {
    background:
        linear-gradient(145deg, rgba(255,255,255,0.92), rgba(240,253,250,0.88));
}

.audience-card-glow {
    position: absolute;
    width: 260px;
    height: 260px;
    border-radius: 50%;
    top: -90px;
    right: -90px;
    background: rgba(30, 74, 118, 0.16);
    filter: blur(8px);
    z-index: 1;
}

.audience-card-company .audience-card-glow {
    background: rgba(20, 184, 166, 0.16);
}

.audience-icon {
    width: 64px;
    height: 64px;
    border-radius: 22px;
    background: #ffffff;
    box-shadow:
        0 16px 32px rgba(15, 23, 42, 0.12),
        inset 0 1px 0 rgba(255,255,255,0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 31px;
    margin-bottom: 24px;
}

.audience-card .block-title {
    font-size: clamp(1.55rem, 2.2vw, 2rem);
    line-height: 1.18;
    font-weight: 850;
    color: #0c2e44;
    margin-bottom: 16px;
}

.audience-card .block-text {
    color: #3a5a78;
    font-size: 1rem;
    line-height: 1.75;
    margin-bottom: 24px;
}

.audience-card .benefit-list {
    list-style: none;
    padding: 0;
    margin: 0 0 28px;
    display: grid;
    gap: 12px;
}

.audience-card .benefit-list li {
    display: flex;
    gap: 10px;
    align-items: flex-start;
    color: #24465f;
    font-weight: 600;
    line-height: 1.55;
}

.audience-card .benefit-list li span {
    width: 24px;
    height: 24px;
    min-width: 24px;
    border-radius: 50%;
    background: #e8f2fa;
    color: #1e4a76;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 900;
    font-size: 13px;
    margin-top: 1px;
}

.audience-actions {
    margin-top: auto;
    margin-bottom: 24px;
}

.audience-actions .btn-primary,
.audience-actions .btn-outline {
    width: fit-content;
    min-height: 46px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 14px 28px rgba(30, 74, 118, 0.18);
}

.audience-stats {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
    padding-top: 22px;
    border-top: 1px solid rgba(30, 74, 118, 0.12);
}

.audience-stat-item {
    flex: 1;
    min-width: 130px;
    padding: 18px;
    border-radius: 22px;
    background: rgba(255,255,255,0.72);
    border: 1px solid rgba(226, 232, 240, 0.9);
    box-shadow:
        0 14px 28px rgba(15, 23, 42, 0.08),
        inset 0 1px 0 rgba(255,255,255,0.9);
    text-align: center;
}

.audience-stat-item strong {
    display: block;
    color: #1e4a76;
    font-size: 2rem;
    font-weight: 900;
    line-height: 1;
    margin-bottom: 6px;
}

.audience-stat-item span {
    color: #557c9c;
    font-size: 0.92rem;
    font-weight: 650;
}

@media (max-width: 992px) {
    .audience-grid {
        grid-template-columns: 1fr;
    }

    .audience-card {
        min-height: auto;
    }

    .audience-card-content {
        min-height: auto;
    }
}

@media (max-width: 640px) {
    .audience-section {
        padding: 62px 0;
    }

    .audience-card-content {
        padding: 26px;
        border-radius: 26px;
    }

    .audience-card {
        border-radius: 28px;
    }

    .audience-icon {
        width: 56px;
        height: 56px;
        border-radius: 18px;
        font-size: 27px;
    }

    .audience-actions .btn-primary,
    .audience-actions .btn-outline {
        width: 100%;
        text-align: center;
    }

    .audience-stats {
        flex-direction: column;
    }
}
</style>
