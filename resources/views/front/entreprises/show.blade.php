@extends('layouts.front')

@section('title', $entreprise->nom . ' | Cmlink')

@section('content')
    @include('front.partials.header')

    @php
        $canSeeCompanyPrivateInfo = auth()->check()
            && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('entreprise'));

        $isStudent = auth()->check() && auth()->user()->hasRole('etudiant');

        $initial = strtoupper(substr($entreprise->nom ?? 'C', 0, 1));
    @endphp

    <section class="company-profile-section" id="companyProfile">
        <div class="container">
            <div class="company-profile-card">

                <div class="company-cover"></div>

                <div class="company-profile-header">
                    <div class="profile-company-logo">
                        @if(!empty($entreprise->logo_path))
                            <img src="{{ asset('storage/'.$entreprise->logo_path) }}" alt="Logo {{ $entreprise->nom }}">
                        @else
                            <span>{{ $initial }}</span>
                        @endif
                    </div>

                    <div class="company-main-info">
                        <span class="company-kicker">
                            <i class="bi bi-buildings"></i>
                            Profil entreprise
                        </span>

                        <h1>{{ $entreprise->nom }}</h1>

                        <p>
                            <i class="bi bi-briefcase"></i>
                            {{ $entreprise->offres->count() }} offre(s) publiée(s)
                        </p>
                    </div>
                </div>

                <div class="company-content-grid">
                    <div class="company-info-panel">
                        <h2>Présentation</h2>

                        <p class="company-description-full">
                            {{ $entreprise->description ?? 'Cette entreprise est présente sur Cmlink et peut publier des opportunités destinées aux étudiants et jeunes diplômés.' }}
                        </p>

                        <div class="company-info-list">
                            <div class="company-info-item">
                                <i class="bi bi-geo-alt"></i>
                                <div>
                                    <span>Adresse</span>
                                    <strong>{{ $entreprise->adresse ?: 'Adresse non précisée' }}</strong>
                                </div>
                            </div>

                            @if($canSeeCompanyPrivateInfo && !$isStudent)
                                <div class="company-info-item">
                                    <i class="bi bi-envelope"></i>
                                    <div>
                                        <span>Email</span>
                                        <strong>{{ $entreprise->email }}</strong>
                                    </div>
                                </div>

                                <div class="company-info-item">
                                    <i class="bi bi-telephone"></i>
                                    <div>
                                        <span>Téléphone</span>
                                        <strong>{{ $entreprise->telephone ?: 'Non précisé' }}</strong>
                                    </div>
                                </div>
                            @else
                                <div class="company-info-item locked">
                                    <i class="bi bi-shield-lock"></i>
                                    <div>
                                        <span>Contact</span>
                                        <strong>Email et téléphone protégés</strong>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="company-note-panel">
                        <div class="note-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>

                        <h2>Confidentialité entreprise</h2>

                        @if($canSeeCompanyPrivateInfo && !$isStudent)
                            <p>
                                Vous pouvez consulter les informations de contact car votre rôle est autorisé.
                            </p>
                        @else
                            <p>
                                Pour protéger les entreprises, les contacts directs ne sont pas visibles aux étudiants.
                                Vous pouvez découvrir leurs offres et postuler depuis la plateforme.
                            </p>
                        @endif

                        <a href="{{ route('front.entreprises.index') }}" class="back-companies-btn">
                            <i class="bi bi-arrow-left"></i>
                            Retour aux entreprises
                        </a>
                    </div>
                </div>

                <div class="company-offers-section">
                    <div class="company-offers-header">
                        <h2>Offres publiées</h2>
                        <p>Les opportunités actuellement associées à cette entreprise.</p>
                    </div>

                    @if($entreprise->offres->count())
                        <div class="company-offers-grid">
                            @foreach($entreprise->offres as $offre)
                                @php
                                    $isStage = $offre->type === 'stage';
                                    $typeClass = $isStage ? 'is-stage' : 'is-emploi';
                                    $typeLabel = $isStage ? 'Stage' : 'Emploi';
                                    $typeIcon = $isStage ? 'bi-mortarboard' : 'bi-briefcase';
                                @endphp

                                <article class="company-offer-card {{ $typeClass }}">
                                    <div class="offer-type-badge">
                                        <i class="bi {{ $typeIcon }}"></i>
                                        {{ $typeLabel }}
                                    </div>

                                    <h3>{{ $offre->titre }}</h3>

                                    <div class="offer-mini-meta">
                                        <span>
                                            <i class="bi bi-geo-alt"></i>
                                            {{ $offre->localisation ?: 'Non précisée' }}
                                        </span>

                                        @if($offre->categorie)
                                            <span>
                                                <i class="bi bi-grid"></i>
                                                {{ $offre->categorie->nom }}
                                            </span>
                                        @endif
                                    </div>

                                    <a href="{{ route('front.offres.show', $offre) }}" class="offer-view-btn">
                                        Voir l’offre
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </article>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-company-offers">
                            <i class="bi bi-inbox"></i>
                            <h3>Aucune offre publiée</h3>
                            <p>Cette entreprise n’a pas encore publié d’offre.</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </section>

    @include('front.partials.footer')

    <style>
        .company-profile-section {
            padding: 88px 0;
            background:
                radial-gradient(circle at 12% 14%, rgba(30, 74, 118, 0.10), transparent 34%),
                radial-gradient(circle at 88% 82%, rgba(20, 184, 166, 0.08), transparent 35%),
                #fbfdff;
            overflow: hidden;
        }

        .company-profile-card {
            max-width: 1100px;
            margin: 0 auto;
            border-radius: 36px;
            background: rgba(255,255,255,0.94);
            border: 1px solid rgba(226, 232, 240, 0.95);
            box-shadow: 0 38px 90px rgba(15, 23, 42, 0.15);
            overflow: hidden;
            opacity: 0;
            transform: translateY(44px) scale(0.98);
            transition: opacity 0.75s ease, transform 0.75s cubic-bezier(.2,.85,.25,1);
        }

        .company-profile-section.is-visible .company-profile-card {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .company-cover {
            height: 185px;
            background:
                linear-gradient(135deg, rgba(30,74,118,0.96), rgba(20,184,166,0.70)),
                radial-gradient(circle at 90% 20%, rgba(255,255,255,0.28), transparent 35%);
        }

        .company-profile-header {
            display: flex;
            gap: 26px;
            align-items: flex-end;
            padding: 0 42px 36px;
            margin-top: -74px;
        }

        .profile-company-logo {
            width: 150px;
            height: 150px;
            min-width: 150px;
            border-radius: 36px;
            border: 6px solid #ffffff;
            background: #ffffff;
            color: #1e4a76;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            font-weight: 950;
            font-size: 2.2rem;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.18);
        }

        .profile-company-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .company-main-info {
            padding-bottom: 8px;
        }

        .company-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            border-radius: 999px;
            background: rgba(30, 74, 118, 0.08);
            color: #1e4a76;
            font-size: 0.86rem;
            font-weight: 850;
            margin-bottom: 14px;
        }

        .company-main-info h1 {
            color: #0c2e44;
            font-size: clamp(2rem, 4vw, 3.4rem);
            line-height: 1.05;
            font-weight: 950;
            letter-spacing: -0.045em;
            margin-bottom: 10px;
        }

        .company-main-info p {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            color: #557c9c;
            font-size: 1.05rem;
            font-weight: 750;
            margin: 0;
        }

        .company-content-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.2fr) minmax(300px, 0.8fr);
            gap: 26px;
            padding: 0 42px 42px;
        }

        .company-info-panel,
        .company-note-panel {
            border-radius: 30px;
            padding: 30px;
            background:
                linear-gradient(145deg, rgba(255,255,255,0.96), rgba(240,253,250,0.80));
            border: 1px solid rgba(226, 232, 240, 0.95);
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.09);
        }

        .company-info-panel h2,
        .company-note-panel h2,
        .company-offers-header h2 {
            color: #0c2e44;
            font-size: 1.35rem;
            font-weight: 900;
            margin-bottom: 14px;
        }

        .company-description-full {
            color: #345a76;
            line-height: 1.85;
            margin-bottom: 22px;
        }

        .company-info-list {
            display: grid;
            gap: 14px;
        }

        .company-info-item {
            display: flex;
            gap: 14px;
            align-items: flex-start;
            padding: 16px;
            border-radius: 22px;
            background: rgba(255,255,255,0.82);
            border: 1px solid rgba(226, 232, 240, 0.95);
        }

        .company-info-item i {
            width: 42px;
            height: 42px;
            min-width: 42px;
            border-radius: 16px;
            background: rgba(30, 74, 118, 0.08);
            color: #1e4a76;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
        }

        .company-info-item span {
            display: block;
            color: #64748b;
            font-size: 0.86rem;
            font-weight: 750;
            margin-bottom: 4px;
        }

        .company-info-item strong {
            color: #0c2e44;
            font-size: 1rem;
            line-height: 1.45;
        }

        .company-info-item.locked i {
            background: rgba(100, 116, 139, 0.10);
            color: #64748b;
        }

        .note-icon {
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

        .company-note-panel p {
            color: #557c9c;
            line-height: 1.75;
            margin-bottom: 24px;
        }

        .back-companies-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            min-height: 48px;
            padding: 11px 18px;
            border-radius: 999px;
            text-decoration: none;
            color: #ffffff;
            background: linear-gradient(135deg, #1e4a76, #2b6a9f);
            font-weight: 850;
            box-shadow: 0 14px 30px rgba(30, 74, 118, 0.20);
        }

        .company-offers-section {
            padding: 0 42px 42px;
        }

        .company-offers-header {
            margin-bottom: 22px;
        }

        .company-offers-header p {
            color: #557c9c;
            margin: 0;
        }

        .company-offers-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
        }

        .company-offer-card {
            position: relative;
            border-radius: 26px;
            padding: 22px;
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.95);
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.10);
            overflow: hidden;
        }

        .company-offer-card::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .company-offer-card.is-stage::before {
            background:
                linear-gradient(145deg, rgba(255,255,255,0.96), rgba(239,246,255,0.80)),
                radial-gradient(circle at 92% 8%, rgba(37, 99, 235, 0.16), transparent 35%);
        }

        .company-offer-card.is-emploi::before {
            background:
                linear-gradient(145deg, rgba(255,255,255,0.96), rgba(240,253,250,0.82)),
                radial-gradient(circle at 92% 8%, rgba(20, 184, 166, 0.18), transparent 35%);
        }

        .offer-type-badge,
        .company-offer-card h3,
        .offer-mini-meta,
        .offer-view-btn {
            position: relative;
            z-index: 2;
        }

        .offer-type-badge {
            width: fit-content;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 13px;
            border-radius: 999px;
            font-weight: 850;
            font-size: 0.82rem;
            margin-bottom: 14px;
        }

        .is-stage .offer-type-badge {
            background: rgba(37, 99, 235, 0.10);
            color: #1d4ed8;
        }

        .is-emploi .offer-type-badge {
            background: rgba(20, 184, 166, 0.12);
            color: #0f766e;
        }

        .company-offer-card h3 {
            color: #0c2e44;
            font-weight: 900;
            font-size: 1.08rem;
            line-height: 1.35;
            margin-bottom: 14px;
        }

        .offer-mini-meta {
            display: grid;
            gap: 8px;
            margin-bottom: 18px;
            color: #3a5a78;
            font-size: 0.9rem;
            font-weight: 650;
        }

        .offer-mini-meta span {
            display: flex;
            gap: 8px;
            align-items: flex-start;
        }

        .offer-mini-meta i {
            color: #1e4a76;
        }

        .offer-view-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            min-height: 42px;
            border-radius: 999px;
            color: #ffffff;
            background: linear-gradient(135deg, #1e4a76, #2b6a9f);
            text-decoration: none;
            font-weight: 850;
        }

        .empty-company-offers {
            text-align: center;
            background: #ffffff;
            border: 1px solid #eef2f8;
            border-radius: 28px;
            padding: 45px 24px;
            box-shadow: 0 22px 50px rgba(15, 23, 42, 0.08);
        }

        .empty-company-offers i {
            font-size: 2.5rem;
            color: #1e4a76;
            margin-bottom: 12px;
        }

        .empty-company-offers h3 {
            color: #0c2e44;
            font-weight: 900;
        }

        .empty-company-offers p {
            color: #557c9c;
            margin: 0;
        }

        @media (max-width: 980px) {
            .company-content-grid {
                grid-template-columns: 1fr;
            }

            .company-offers-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .company-profile-header {
                align-items: center;
            }
        }

        @media (max-width: 640px) {
            .company-profile-section {
                padding: 60px 0;
            }

            .company-cover {
                height: 145px;
            }

            .company-profile-header {
                flex-direction: column;
                align-items: flex-start;
                padding: 0 24px 30px;
            }

            .profile-company-logo {
                width: 118px;
                height: 118px;
                min-width: 118px;
                border-radius: 28px;
            }

            .company-content-grid,
            .company-offers-section {
                padding-left: 24px;
                padding-right: 24px;
            }

            .company-info-panel,
            .company-note-panel {
                padding: 24px;
                border-radius: 26px;
            }

            .company-offers-grid {
                grid-template-columns: 1fr;
            }

            .back-companies-btn {
                width: 100%;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const section = document.getElementById('companyProfile');

            if (!section) return;

            const observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        section.classList.add('is-visible');
                    }
                });
            }, {
                threshold: 0.15
            });

            observer.observe(section);
        });
    </script>
@endsection