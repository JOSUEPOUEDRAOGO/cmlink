@extends('layouts.front')

@section('title', 'Entreprises | Cmlink')

@section('content')
    @include('front.partials.header')

    @php
        $canSeeCompanyPrivateInfo = auth()->check()
            && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('entreprise'));

        $isStudent = auth()->check() && auth()->user()->hasRole('etudiant');
    @endphp

    <section class="companies-page-section" id="companiesPage">
        <div class="container">

            <div class="companies-hero">
                <span class="companies-kicker">
                    <i class="bi bi-buildings"></i>
                    Entreprises partenaires
                </span>

                <h1>Explorez les entreprises qui recrutent</h1>

                <p>
                    Découvrez les structures présentes sur Cmlink, leurs domaines d’activité et les opportunités qu’elles publient.
                </p>
            </div>

            <form method="GET" action="{{ route('front.entreprises.index') }}" class="companies-filter-card">
                <div class="filter-field filter-search">
                    <div class="filter-input-icon">
                        <i class="bi bi-search"></i>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Nom d’entreprise, adresse, mot-clé...">
                    </div>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="filter-submit">
                        <i class="bi bi-sliders"></i>
                        Rechercher
                    </button>

                    <a href="{{ route('front.entreprises.index') }}" class="filter-reset">
                        Réinitialiser
                    </a>
                </div>
            </form>

            <div class="companies-grid">
                @forelse($entreprises as $entreprise)
                    @php
                        $initial = strtoupper(substr($entreprise->nom ?? 'C', 0, 1));
                    @endphp

                    <article class="company-card">
                        <div class="company-card-bg"></div>

                        <div class="company-top">
                            <div class="company-logo">
                                @if(!empty($entreprise->logo_path))
                                    <img src="{{ asset('storage/'.$entreprise->logo_path) }}" alt="Logo {{ $entreprise->nom }}">
                                @else
                                    <span>{{ $initial }}</span>
                                @endif
                            </div>

                            <div class="company-identity">
                                <h2>{{ $entreprise->nom }}</h2>

                                <span>
                                    <i class="bi bi-briefcase"></i>
                                    {{ $entreprise->offres_count ?? 0 }} offre(s)
                                </span>
                            </div>
                        </div>

                        <div class="company-description">
                            @if(!empty($entreprise->description))
                                {{ \Illuminate\Support\Str::limit($entreprise->description, 120) }}
                            @else
                                Entreprise présente sur Cmlink, ouverte aux opportunités et aux nouveaux talents.
                            @endif
                        </div>

                        <div class="company-info-list">
                            <div class="company-info-item">
                                <i class="bi bi-geo-alt"></i>
                                <span>{{ $entreprise->adresse ?: 'Adresse non précisée' }}</span>
                            </div>

                            @if($canSeeCompanyPrivateInfo && !$isStudent)
                                <div class="company-info-item">
                                    <i class="bi bi-envelope"></i>
                                    <span>{{ $entreprise->email }}</span>
                                </div>

                                <div class="company-info-item">
                                    <i class="bi bi-telephone"></i>
                                    <span>{{ $entreprise->telephone ?: 'Téléphone non précisé' }}</span>
                                </div>
                            @else
                                <div class="company-info-item muted">
                                    <i class="bi bi-shield-lock"></i>
                                    <span>Contact privé protégé</span>
                                </div>
                            @endif
                        </div>

                        <a href="{{ route('front.entreprises.show', $entreprise) }}" class="company-view-btn">
                            Voir l’entreprise
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </article>
                @empty
                    <div class="empty-companies-box">
                        <i class="bi bi-building-x"></i>
                        <h3>Aucune entreprise trouvée</h3>
                        <p>Essayez une autre recherche ou revenez plus tard.</p>
                    </div>
                @endforelse
            </div>

            @if($entreprises->hasPages())
                <div class="companies-pagination">
                    {{ $entreprises->links() }}
                </div>
            @endif
        </div>
    </section>

    @include('front.partials.footer')

    <style>
        .companies-page-section {
            padding: 88px 0;
            background:
                radial-gradient(circle at 12% 14%, rgba(30, 74, 118, 0.10), transparent 34%),
                radial-gradient(circle at 88% 82%, rgba(20, 184, 166, 0.08), transparent 35%),
                #fbfdff;
            overflow: hidden;
        }

        .companies-hero {
            max-width: 850px;
            margin: 0 auto 42px;
            text-align: center;
        }

        .companies-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 999px;
            background: rgba(30, 74, 118, 0.08);
            color: #1e4a76;
            font-size: 0.88rem;
            font-weight: 850;
            margin-bottom: 18px;
        }

        .companies-hero h1 {
            font-size: clamp(2rem, 5vw, 4rem);
            line-height: 1.05;
            font-weight: 950;
            letter-spacing: -0.045em;
            color: #0c2e44;
            margin-bottom: 18px;
        }

        .companies-hero p {
            color: #557c9c;
            font-size: 1.08rem;
            line-height: 1.75;
            max-width: 670px;
            margin: 0 auto;
        }

        .companies-filter-card {
            display: grid;
            grid-template-columns: minmax(250px, 1fr) auto;
            gap: 16px;
            align-items: end;
            background: rgba(255,255,255,0.94);
            border: 1px solid rgba(226, 232, 240, 0.95);
            border-radius: 30px;
            padding: 22px;
            box-shadow: 0 28px 65px rgba(15, 23, 42, 0.11);
            margin-bottom: 30px;
        }

        .filter-field label {
            display: block;
            color: #0c2e44;
            font-size: 0.84rem;
            font-weight: 850;
            margin-bottom: 8px;
        }

        .filter-input-icon {
            position: relative;
        }

        .filter-input-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
        }

        .filter-field input {
            width: 100%;
            min-height: 48px;
            border-radius: 16px;
            border: 1px solid #dbe6f0;
            background: #ffffff;
            color: #0c2e44;
            padding: 12px 15px 12px 42px;
            outline: none;
            font-weight: 600;
        }

        .filter-field input:focus {
            border-color: #1e4a76;
            box-shadow: 0 0 0 4px rgba(30, 74, 118, 0.10);
        }

        .filter-actions {
            display: flex;
            gap: 10px;
        }

        .filter-submit,
        .filter-reset {
            min-height: 48px;
            border-radius: 999px;
            padding: 12px 18px;
            font-weight: 850;
            text-decoration: none;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }

        .filter-submit {
            border: none;
            background: linear-gradient(135deg, #1e4a76, #2b6a9f);
            color: #ffffff;
            box-shadow: 0 14px 30px rgba(30, 74, 118, 0.20);
        }

        .filter-reset {
            border: 1px solid rgba(30, 74, 118, 0.18);
            color: #1e4a76;
            background: #ffffff;
        }

        .companies-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 26px;
        }

        .company-card {
            position: relative;
            min-height: 385px;
            padding: 26px;
            border-radius: 30px;
            background: rgba(255,255,255,0.93);
            border: 1px solid rgba(226, 232, 240, 0.95);
            box-shadow:
                0 28px 65px rgba(15, 23, 42, 0.12),
                inset 0 1px 0 rgba(255,255,255,0.95);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            opacity: 0;
            transform: translateY(42px) scale(0.97);
            transition: opacity 0.72s ease, transform 0.72s cubic-bezier(.2,.85,.25,1), box-shadow 0.3s ease;
        }

        .companies-page-section.is-visible .company-card {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .company-card:hover {
            transform: translateY(-8px) scale(1.01);
            box-shadow: 0 42px 90px rgba(15, 23, 42, 0.18);
        }

        .company-card-bg {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(145deg, rgba(255,255,255,0.96), rgba(240,253,250,0.82)),
                radial-gradient(circle at 92% 8%, rgba(20, 184, 166, 0.18), transparent 35%);
            pointer-events: none;
        }

        .company-top,
        .company-description,
        .company-info-list,
        .company-view-btn {
            position: relative;
            z-index: 2;
        }

        .company-top {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 22px;
        }

        .company-logo {
            width: 74px;
            height: 74px;
            min-width: 74px;
            border-radius: 24px;
            background: #ffffff;
            color: #1e4a76;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            font-weight: 950;
            font-size: 1.35rem;
            box-shadow: 0 16px 34px rgba(15, 23, 42, 0.13);
        }

        .company-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .company-identity h2 {
            color: #0c2e44;
            font-size: 1.35rem;
            line-height: 1.25;
            font-weight: 900;
            margin: 0 0 8px;
        }

        .company-identity span {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: #557c9c;
            font-size: 0.92rem;
            font-weight: 750;
        }

        .company-description {
            color: #3a5a78;
            font-size: 0.98rem;
            line-height: 1.7;
            margin-bottom: 22px;
        }

        .company-info-list {
            display: grid;
            gap: 12px;
            margin-bottom: 24px;
        }

        .company-info-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 13px 14px;
            border-radius: 18px;
            background: rgba(255,255,255,0.78);
            border: 1px solid rgba(226, 232, 240, 0.9);
            color: #345a76;
            font-weight: 650;
            line-height: 1.45;
        }

        .company-info-item i {
            color: #1e4a76;
            margin-top: 2px;
        }

        .company-info-item.muted {
            color: #64748b;
            background: rgba(248, 250, 252, 0.88);
        }

        .company-view-btn {
            margin-top: auto;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 46px;
            padding: 11px 18px;
            border-radius: 999px;
            color: #ffffff;
            background: linear-gradient(135deg, #1e4a76, #2b6a9f);
            text-decoration: none;
            font-weight: 850;
            box-shadow: 0 14px 30px rgba(30, 74, 118, 0.20);
        }

        .empty-companies-box {
            grid-column: 1 / -1;
            text-align: center;
            background: #ffffff;
            border: 1px solid #eef2f8;
            border-radius: 30px;
            padding: 55px 24px;
            box-shadow: 0 22px 50px rgba(15, 23, 42, 0.08);
        }

        .empty-companies-box i {
            font-size: 2.8rem;
            color: #1e4a76;
            margin-bottom: 14px;
        }

        .empty-companies-box h3 {
            color: #0c2e44;
            font-weight: 900;
        }

        .empty-companies-box p {
            color: #557c9c;
            margin: 0;
        }

        .companies-pagination {
            margin-top: 38px;
        }

        @media (max-width: 1150px) {
            .companies-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 720px) {
            .companies-page-section {
                padding: 62px 0;
            }

            .companies-filter-card {
                grid-template-columns: 1fr;
                padding: 18px;
                border-radius: 24px;
            }

            .filter-actions {
                flex-direction: column;
            }

            .filter-submit,
            .filter-reset {
                width: 100%;
            }

            .companies-grid {
                grid-template-columns: 1fr;
            }

            .company-card {
                min-height: auto;
                padding: 22px;
                border-radius: 26px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const section = document.getElementById('companiesPage');

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