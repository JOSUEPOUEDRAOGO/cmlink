@extends('layouts.front')

@section('title', 'Toutes les offres | Cmlink')

@section('content')
    @include('front.partials.header')

    @php
        $etudiant = (auth()->check() && auth()->user()->account_type === 'etudiant')
            ? auth()->user()->etudiant
            : null;
    @endphp

    <section class="offers-page-section" id="offersPage">
        <div class="container">

            <div class="offers-page-hero">
                <span class="offers-kicker">
                    <i class="bi bi-search-heart"></i>
                    Opportunités disponibles
                </span>
                <h1>Trouvez l'offre qui correspond à votre ambition</h1>
                <p>Explorez les stages et emplois publiés par les entreprises partenaires de Cmlink.</p>
            </div>

            <form method="GET" action="{{ route('front.offres.index') }}" class="offers-filter-card">
                <div class="filter-field filter-search">
                    <div class="filter-input-icon">
                        <i class="bi bi-search"></i>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Titre, entreprise, mot-clé...">
                    </div>
                </div>
                <div class="filter-field">
                    <select name="type">
                        <option value="">Tous les types</option>
                        <option value="stage"  @selected(request('type') === 'stage')>Stage</option>
                        <option value="emploi" @selected(request('type') === 'emploi')>Emploi</option>
                    </select>
                </div>
                <div class="filter-field">
                    <select name="categorie">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $categorie)
                            <option value="{{ $categorie->id }}"
                                @selected((string) request('categorie') === (string) $categorie->id)>
                                {{ $categorie->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-actions">
                    <button type="submit" class="filter-submit">
                        <i class="bi bi-sliders"></i> Filtrer
                    </button>
                    <a href="{{ route('front.offres.index') }}" class="filter-reset">
                        Réinitialiser
                    </a>
                </div>
            </form>

            <div class="offers-count-line">
                <span>
                    <i class="bi bi-briefcase"></i>
                    {{ $offres->total() }} offre(s) trouvée(s)
                </span>
            </div>

            <div class="offers-page-grid">
                @forelse($offres as $offre)
                    @php
                        $isStage   = $offre->type === 'stage';
                        $typeLabel = $isStage ? 'Stage' : 'Emploi';
                        $typeClass = $isStage ? 'is-stage' : 'is-emploi';
                        $typeIcon  = $isStage ? 'bi-mortarboard' : 'bi-briefcase';
                        $estFavori = $etudiant
                            ? $etudiant->favoris->contains('offre_id', $offre->id)
                            : false;
                        $favori = $estFavori
                            ? $etudiant->favoris->firstWhere('offre_id', $offre->id)
                            : null;
                    @endphp

                    <article class="offer-list-card {{ $typeClass }}">

                        <div class="offer-list-top">
                            <div class="company-avatar">
                                {{ strtoupper(substr($offre->entreprise->nom ?? 'C', 0, 1)) }}
                            </div>
                            <div>
                                <div class="company-name">
                                    {{ $offre->entreprise->nom ?? 'Entreprise' }}
                                </div>
                                <div class="offer-small-info">
                                    <i class="bi bi-clock"></i>
                                    {{ $offre->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>

                        <div class="offer-type-badge">
                            <i class="bi {{ $typeIcon }}"></i>
                            {{ $typeLabel }}
                            @if($offre->teletravail)
                                &nbsp;·&nbsp; <i class="bi bi-house"></i> Télétravail
                            @endif
                        </div>

                        <h2 class="offer-list-title">{{ $offre->titre }}</h2>

                        <div class="offer-list-meta">
                            <span>
                                <i class="bi bi-geo-alt"></i>
                                {{ $offre->localisation ?: 'Localisation non précisée' }}
                            </span>
                            <span>
                                <i class="bi bi-grid"></i>
                                {{ $offre->categorie?->nom ?: 'Catégorie non précisée' }}
                            </span>
                            @if($offre->salaire_min || $offre->salaire_max)
                                <span>
                                    <i class="bi bi-cash"></i>
                                    @if($offre->salaire_min && $offre->salaire_max)
                                        {{ number_format($offre->salaire_min, 0, ',', ' ') }}
                                        – {{ number_format($offre->salaire_max, 0, ',', ' ') }} MAD
                                    @elseif($offre->salaire_min)
                                        Dès {{ number_format($offre->salaire_min, 0, ',', ' ') }} MAD
                                    @endif
                                </span>
                            @endif
                        </div>

                        <div class="offer-list-footer">
                            <div class="deadline">
                                @if($offre->date_expiration)
                                    <i class="bi bi-calendar-event"></i>
                                    Expire le {{ $offre->date_expiration->format('d/m/Y') }}
                                @else
                                    <i class="bi bi-infinity"></i>
                                    Date flexible
                                @endif
                            </div>

                            <div class="offer-actions">
                                {{-- Bouton favori --}}
                                @if($etudiant)
                                    <form action="{{ $estFavori
                                        ? route('admin.favoris.destroy', $favori)
                                        : route('admin.favoris.store') }}"
                                        method="POST">
                                        @csrf
                                        @if($estFavori)
                                            @method('DELETE')
                                        @else
                                            <input type="hidden" name="offre_id" value="{{ $offre->id }}">
                                        @endif
                                        <button type="submit"
                                            class="favori-btn {{ $estFavori ? 'is-saved' : '' }}"
                                            title="{{ $estFavori ? 'Retirer des favoris' : 'Sauvegarder cette offre' }}">
                                            <i class="bi bi-bookmark{{ $estFavori ? '-fill' : '' }}"></i>
                                        </button>
                                    </form>
                                @endif

                                <a href="{{ route('front.offres.show', $offre) }}" class="view-offer-btn">
                                    Voir l'offre
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>

                    </article>
                @empty
                    <div class="empty-offers-box">
                        <i class="bi bi-inbox"></i>
                        <h3>Aucune offre trouvée</h3>
                        <p>Essayez de modifier vos filtres ou revenez plus tard.</p>
                    </div>
                @endforelse
            </div>

            @if($offres->hasPages())
                <div class="offers-pagination">
                    {{ $offres->links() }}
                </div>
            @endif

        </div>
    </section>

    @include('front.partials.footer')

    <style>
        .offers-page-section {
            position: relative;
            padding: 86px 0;
            background:
                radial-gradient(circle at 12% 14%, rgba(30, 74, 118, 0.10), transparent 34%),
                radial-gradient(circle at 88% 78%, rgba(20, 184, 166, 0.08), transparent 35%),
                #fbfdff;
            overflow: hidden;
        }

        .offers-page-hero {
            max-width: 860px;
            text-align: center;
            margin: 0 auto 42px;
        }

        .offers-kicker {
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

        .offers-page-hero h1 {
            font-size: clamp(2rem, 5vw, 4rem);
            line-height: 1.05;
            font-weight: 950;
            letter-spacing: -0.045em;
            color: #0c2e44;
            margin-bottom: 18px;
        }

        .offers-page-hero p {
            color: #557c9c;
            font-size: 1.08rem;
            line-height: 1.75;
            max-width: 650px;
            margin: 0 auto;
        }

        .offers-filter-card {
            display: grid;
            grid-template-columns: minmax(240px, 1.4fr) minmax(180px, 0.8fr) minmax(210px, 1fr) auto;
            gap: 16px;
            align-items: end;
            background: rgba(255,255,255,0.92);
            border: 1px solid rgba(226, 232, 240, 0.95);
            border-radius: 30px;
            padding: 22px;
            box-shadow: 0 28px 65px rgba(15, 23, 42, 0.11);
            margin-bottom: 26px;
        }

        .filter-field label {
            display: block;
            color: #0c2e44;
            font-size: 0.84rem;
            font-weight: 850;
            margin-bottom: 8px;
        }

        .filter-input-icon { position: relative; }

        .filter-input-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
        }

        .filter-field input,
        .filter-field select {
            width: 100%;
            min-height: 48px;
            border-radius: 16px;
            border: 1px solid #dbe6f0;
            background: #ffffff;
            color: #0c2e44;
            padding: 12px 15px;
            outline: none;
            font-weight: 600;
        }

        .filter-search input { padding-left: 42px; }

        .filter-field input:focus,
        .filter-field select:focus {
            border-color: #1e4a76;
            box-shadow: 0 0 0 4px rgba(30, 74, 118, 0.10);
        }

        .filter-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .filter-submit,
        .filter-reset {
            min-height: 48px;
            border-radius: 999px;
            padding: 12px 18px;
            font-weight: 850;
            text-decoration: none;
            white-space: nowrap;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
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

        .offers-count-line {
            margin: 0 0 22px;
            color: #557c9c;
            font-weight: 750;
        }

        .offers-count-line span {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .offers-page-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 26px;
        }

        .offer-list-card {
            position: relative;
            min-height: 350px;
            padding: 26px;
            border-radius: 30px;
            background: rgba(255,255,255,0.92);
            border: 1px solid rgba(226, 232, 240, 0.95);
            box-shadow: 0 26px 60px rgba(15, 23, 42, 0.12);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            opacity: 0;
            transform: translateY(42px) scale(0.97);
            transition:
                opacity 0.72s ease,
                transform 0.72s cubic-bezier(.2,.85,.25,1),
                box-shadow 0.3s ease;
        }

        .offers-page-section.is-visible .offer-list-card {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .offer-list-card:hover {
            transform: translateY(-8px) scale(1.01);
            box-shadow: 0 40px 88px rgba(15, 23, 42, 0.18);
        }

        .offer-list-card::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .offer-list-card.is-stage::before {
            background:
                linear-gradient(145deg, rgba(255,255,255,0.96), rgba(239,246,255,0.80)),
                radial-gradient(circle at 92% 8%, rgba(37, 99, 235, 0.16), transparent 35%);
        }

        .offer-list-card.is-emploi::before {
            background:
                linear-gradient(145deg, rgba(255,255,255,0.96), rgba(240,253,250,0.82)),
                radial-gradient(circle at 92% 8%, rgba(20, 184, 166, 0.18), transparent 35%);
        }

        .offer-list-top,
        .offer-type-badge,
        .offer-list-title,
        .offer-list-meta,
        .offer-list-footer {
            position: relative;
            z-index: 2;
        }

        .offer-list-top {
            display: flex;
            align-items: center;
            gap: 13px;
            margin-bottom: 22px;
        }

        .company-avatar {
            width: 52px;
            height: 52px;
            min-width: 52px;
            border-radius: 18px;
            background: #ffffff;
            color: #1e4a76;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 950;
            font-size: 1.15rem;
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.12);
        }

        .company-name {
            color: #0c2e44;
            font-weight: 850;
            line-height: 1.25;
        }

        .offer-small-info {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #64748b;
            font-size: 0.82rem;
            margin-top: 4px;
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
            margin-bottom: 16px;
        }

        .is-stage .offer-type-badge {
            background: rgba(37, 99, 235, 0.10);
            color: #1d4ed8;
        }

        .is-emploi .offer-type-badge {
            background: rgba(20, 184, 166, 0.12);
            color: #0f766e;
        }

        .offer-list-title {
            color: #0c2e44;
            font-size: 1.28rem;
            line-height: 1.32;
            font-weight: 900;
            margin: 0 0 18px;
        }

        .offer-list-meta {
            display: grid;
            gap: 10px;
            margin-bottom: 24px;
        }

        .offer-list-meta span {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            color: #3a5a78;
            font-size: 0.94rem;
            line-height: 1.45;
        }

        .offer-list-meta i {
            color: #1e4a76;
            font-size: 1rem;
            margin-top: 2px;
        }

        .offer-list-footer {
            margin-top: auto;
            padding-top: 18px;
            border-top: 1px solid rgba(30, 74, 118, 0.12);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
        }

        .offer-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .deadline {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #64748b;
            font-size: 0.86rem;
            font-weight: 650;
        }

        .view-offer-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            text-decoration: none;
            color: #ffffff;
            background: linear-gradient(135deg, #1e4a76, #2b6a9f);
            border-radius: 999px;
            padding: 10px 15px;
            font-size: 0.9rem;
            font-weight: 850;
            box-shadow: 0 12px 24px rgba(30, 74, 118, 0.18);
        }

        .view-offer-btn:hover {
            color: #ffffff;
            transform: translateY(-1px);
        }

        .favori-btn {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            border: 1px solid rgba(30, 74, 118, 0.18);
            background: #ffffff;
            color: #1e4a76;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .favori-btn:hover {
            background: rgba(30, 74, 118, 0.08);
            transform: scale(1.1);
        }

        .favori-btn.is-saved {
            background: #1e4a76;
            color: #ffffff;
            border-color: #1e4a76;
        }

        .favori-btn.is-saved:hover {
            background: #c0392b;
            border-color: #c0392b;
        }

        .empty-offers-box {
            grid-column: 1 / -1;
            text-align: center;
            background: #ffffff;
            border: 1px solid #eef2f8;
            border-radius: 30px;
            padding: 55px 24px;
            box-shadow: 0 22px 50px rgba(15, 23, 42, 0.08);
        }

        .empty-offers-box i {
            font-size: 2.8rem;
            color: #1e4a76;
            margin-bottom: 14px;
        }

        .empty-offers-box h3 { color: #0c2e44; font-weight: 900; }
        .empty-offers-box p  { color: #557c9c; margin: 0; }

        .offers-pagination { margin-top: 38px; }

        @media (max-width: 1180px) {
            .offers-filter-card {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            .filter-actions { grid-column: 1 / -1; }
            .offers-page-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 720px) {
            .offers-page-section { padding: 62px 0; }
            .offers-filter-card {
                grid-template-columns: 1fr;
                padding: 18px;
                border-radius: 24px;
            }
            .filter-actions {
                flex-direction: column;
                align-items: stretch;
            }
            .filter-submit,
            .filter-reset { width: 100%; }
            .offers-page-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            .offer-list-card {
                min-height: auto;
                padding: 22px;
                border-radius: 26px;
            }
            .offer-list-footer {
                flex-direction: column;
                align-items: stretch;
            }
            .offer-actions {
                justify-content: space-between;
            }
            .view-offer-btn {
                flex: 1;
                justify-content: center;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const section = document.getElementById('offersPage');
            if (!section) return;
            const observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        section.classList.add('is-visible');
                    }
                });
            }, { threshold: 0.15 });
            observer.observe(section);
        });
    </script>
@endsection
