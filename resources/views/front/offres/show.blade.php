@extends('layouts.front')

@section('title', $offre->titre . ' | Cmlink')

@section('content')
    @include('front.partials.header')

    @php
        $isStage = $offre->type === 'stage';
        $typeLabel = $isStage ? 'Stage' : 'Emploi';
        $typeClass = $isStage ? 'offer-detail-stage' : 'offer-detail-emploi';
        $typeIcon = $isStage ? 'bi-mortarboard' : 'bi-briefcase';
    @endphp

    <section class="offer-detail-section {{ $typeClass }}">
        <div class="container">
            <div class="offer-detail-layout">

                <article class="offer-detail-main">
                    <div class="offer-detail-company">
                        <div class="offer-detail-avatar">
                            {{ strtoupper(substr($offre->entreprise->nom ?? 'C', 0, 1)) }}
                        </div>

                        <div>
                            <div class="offer-detail-company-name">
                                {{ $offre->entreprise->nom ?? 'Entreprise' }}
                            </div>

                            <div class="offer-detail-subinfo">
                                <i class="bi bi-clock"></i>
                                Offre publiée récemment
                            </div>
                        </div>
                    </div>

                    <div class="offer-type-pill">
                        <i class="bi {{ $typeIcon }}"></i>
                        {{ $typeLabel }}
                    </div>

                    <h1 class="offer-detail-title">
                        {{ $offre->titre }}
                    </h1>

                    <div class="offer-detail-meta">
                        <div class="offer-meta-item">
                            <i class="bi bi-geo-alt"></i>
                            <span>{{ $offre->localisation ?: 'Localisation non précisée' }}</span>
                        </div>

                        <div class="offer-meta-item">
                            <i class="bi bi-grid"></i>
                            <span>{{ $offre->categorie?->nom ?: 'Catégorie non précisée' }}</span>
                        </div>

                        <div class="offer-meta-item">
                            <i class="bi bi-calendar-event"></i>
                            <span>
                                @if($offre->date_expiration)
                                    Expire le {{ $offre->date_expiration->format('d/m/Y') }}
                                @else
                                    Date flexible
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="offer-detail-description">
                        <h2>Description de l’offre</h2>

                        <p>
                            {{ $offre->description }}
                        </p>
                    </div>
                </article>

                <aside class="offer-detail-aside">
                    <div class="apply-card">
                        <div class="apply-card-icon">
                            <i class="bi bi-send-check"></i>
                        </div>

                        <h3>Prêt à postuler ?</h3>

                        <p>
                            Envoyez votre candidature et laissez l’entreprise découvrir votre profil.
                        </p>

                        @auth
                            <a href="{{ route('front.offres.apply', $offre) }}" class="apply-btn">
                                Postuler maintenant
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        @else
                            <a href="{{ route('login', ['redirect' => route('front.offres.apply', $offre)]) }}" class="apply-btn">
                                Connectez-vous pour postuler
                                <i class="bi bi-box-arrow-in-right"></i>
                            </a>
                        @endauth

                        <a href="{{ route('front.offres.index') }}" class="back-btn">
                            <i class="bi bi-arrow-left"></i>
                            Retour aux offres
                        </a>
                    </div>

                    <div class="summary-card">
                        <h4>Résumé</h4>

                        <div class="summary-line">
                            <span>Type</span>
                            <strong>{{ $typeLabel }}</strong>
                        </div>

                        <div class="summary-line">
                            <span>Entreprise</span>
                            <strong>{{ $offre->entreprise->nom ?? '-' }}</strong>
                        </div>

                        <div class="summary-line">
                            <span>Catégorie</span>
                            <strong>{{ $offre->categorie?->nom ?? '-' }}</strong>
                        </div>
                    </div>
                </aside>

            </div>
        </div>
    </section>

    @include('front.partials.footer')

    <style>
        .offer-detail-section {
            position: relative;
            padding: 90px 0;
            overflow: hidden;
            background:
                radial-gradient(circle at 14% 16%, rgba(30, 74, 118, 0.10), transparent 34%),
                radial-gradient(circle at 84% 84%, rgba(20, 184, 166, 0.09), transparent 34%),
                #fbfdff;
        }

        .offer-detail-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 360px;
            gap: 32px;
            align-items: start;
        }

        .offer-detail-main,
        .apply-card,
        .summary-card {
            position: relative;
            border-radius: 34px;
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(226, 232, 240, 0.95);
            box-shadow:
                0 35px 80px rgba(15, 23, 42, 0.14),
                inset 0 1px 0 rgba(255,255,255,0.95);
            overflow: hidden;
        }

        .offer-detail-main {
            padding: 42px;
            min-height: 620px;
        }

        .offer-detail-main::before,
        .apply-card::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            background:
                linear-gradient(145deg, rgba(255,255,255,0.95), rgba(239,246,255,0.72)),
                radial-gradient(circle at 94% 8%, rgba(30, 74, 118, 0.16), transparent 34%);
            z-index: 0;
        }

        .offer-detail-emploi .offer-detail-main::before,
        .offer-detail-emploi .apply-card::before {
            background:
                linear-gradient(145deg, rgba(255,255,255,0.95), rgba(240,253,250,0.72)),
                radial-gradient(circle at 94% 8%, rgba(20, 184, 166, 0.18), transparent 34%);
        }

        .offer-detail-company,
        .offer-type-pill,
        .offer-detail-title,
        .offer-detail-meta,
        .offer-detail-description,
        .apply-card > *,
        .summary-card > * {
            position: relative;
            z-index: 2;
        }

        .offer-detail-company {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 26px;
        }

        .offer-detail-avatar {
            width: 58px;
            height: 58px;
            min-width: 58px;
            border-radius: 20px;
            background: #ffffff;
            color: #1e4a76;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 950;
            font-size: 1.25rem;
            box-shadow: 0 16px 34px rgba(15, 23, 42, 0.13);
        }

        .offer-detail-company-name {
            color: #0c2e44;
            font-weight: 900;
            font-size: 1.05rem;
        }

        .offer-detail-subinfo {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: #64748b;
            font-size: 0.88rem;
            margin-top: 4px;
        }

        .offer-type-pill {
            width: fit-content;
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 9px 15px;
            border-radius: 999px;
            font-weight: 850;
            font-size: 0.88rem;
            margin-bottom: 18px;
        }

        .offer-detail-stage .offer-type-pill {
            background: rgba(37, 99, 235, 0.10);
            color: #1d4ed8;
        }

        .offer-detail-emploi .offer-type-pill {
            background: rgba(20, 184, 166, 0.13);
            color: #0f766e;
        }

        .offer-detail-title {
            color: #0c2e44;
            font-size: clamp(2rem, 4vw, 3.3rem);
            line-height: 1.08;
            font-weight: 950;
            max-width: 850px;
            margin: 0 0 26px;
            letter-spacing: -0.04em;
        }

        .offer-detail-meta {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 34px;
        }

        .offer-meta-item {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            padding: 16px;
            border-radius: 20px;
            background: rgba(255,255,255,0.78);
            border: 1px solid rgba(226, 232, 240, 0.9);
            color: #3a5a78;
            font-weight: 650;
            line-height: 1.45;
        }

        .offer-meta-item i {
            color: #1e4a76;
            font-size: 1.1rem;
            margin-top: 2px;
        }

        .offer-detail-description {
            border-top: 1px solid rgba(30, 74, 118, 0.12);
            padding-top: 28px;
        }

        .offer-detail-description h2 {
            font-size: 1.45rem;
            font-weight: 900;
            color: #0c2e44;
            margin-bottom: 14px;
        }

        .offer-detail-description p {
            white-space: pre-line;
            color: #345a76;
            font-size: 1.03rem;
            line-height: 1.9;
            margin: 0;
        }

        .offer-detail-aside {
            display: grid;
            gap: 22px;
            position: sticky;
            top: 112px;
        }

        .apply-card {
            padding: 30px;
        }

        .apply-card-icon {
            width: 62px;
            height: 62px;
            border-radius: 22px;
            background: #ffffff;
            color: #1e4a76;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.55rem;
            box-shadow: 0 16px 34px rgba(15, 23, 42, 0.13);
            margin-bottom: 20px;
        }

        .apply-card h3 {
            color: #0c2e44;
            font-weight: 900;
            font-size: 1.45rem;
            margin-bottom: 10px;
        }

        .apply-card p {
            color: #557c9c;
            line-height: 1.7;
            margin-bottom: 22px;
        }

        .apply-btn,
        .back-btn {
            width: 100%;
            min-height: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            border-radius: 999px;
            font-weight: 850;
            text-decoration: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }

        .apply-btn {
            color: #ffffff;
            background: linear-gradient(135deg, #1e4a76, #2b6a9f);
            box-shadow: 0 14px 30px rgba(30, 74, 118, 0.22);
            margin-bottom: 12px;
        }

        .apply-btn:hover {
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 18px 36px rgba(30, 74, 118, 0.27);
        }

        .back-btn {
            color: #1e4a76;
            background: #ffffff;
            border: 1px solid rgba(30, 74, 118, 0.18);
        }

        .back-btn:hover {
            background: #eef4fa;
            color: #1e4a76;
        }

        .summary-card {
            padding: 26px;
        }

        .summary-card h4 {
            color: #0c2e44;
            font-weight: 900;
            margin-bottom: 18px;
        }

        .summary-line {
            display: flex;
            justify-content: space-between;
            gap: 14px;
            padding: 13px 0;
            border-top: 1px solid rgba(30, 74, 118, 0.10);
        }

        .summary-line span {
            color: #64748b;
        }

        .summary-line strong {
            color: #0c2e44;
            text-align: right;
        }

        @media (max-width: 1050px) {
            .offer-detail-layout {
                grid-template-columns: 1fr;
            }

            .offer-detail-aside {
                position: static;
            }
        }

        @media (max-width: 760px) {
            .offer-detail-section {
                padding: 58px 0;
            }

            .offer-detail-main {
                padding: 26px;
                border-radius: 28px;
                min-height: auto;
            }

            .offer-detail-meta {
                grid-template-columns: 1fr;
            }

            .offer-detail-title {
                font-size: 2rem;
            }

            .apply-card,
            .summary-card {
                border-radius: 28px;
            }
        }
    </style>
@endsection