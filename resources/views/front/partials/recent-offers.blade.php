<section class="recent-offers-section" id="recentOffers">
    <div class="container">
        <div class="recent-offers-header">
            <span class="recent-offers-kicker">
                <i class="bi bi-lightning-charge"></i>
                Opportunités fraîches
            </span>

            <h2 class="section-title">Offres récentes</h2>

            <p class="recent-offers-subtitle">
                Découvrez les dernières opportunités publiées par les entreprises partenaires de Cmlink.
            </p>
        </div>

        <div class="recent-offers-grid">
            @forelse($offresRecentes as $offre)
                @php
                    $isStage = $offre->type === 'stage';
                    $typeLabel = $isStage ? 'Stage' : 'Emploi';
                    $typeClass = $isStage ? 'is-stage' : 'is-emploi';
                    $typeIcon = $isStage ? 'bi-mortarboard' : 'bi-briefcase';
                @endphp

                <article class="recent-offer-card {{ $typeClass }}">
                    <div class="offer-card-top">
                        <div class="company-avatar">
                            {{ strtoupper(substr($offre->entreprise->nom ?? 'C', 0, 1)) }}
                        </div>

                        <div>
                            <div class="company-name">
                                {{ $offre->entreprise->nom ?? 'Entreprise' }}
                            </div>

                            <div class="offer-date">
                                <i class="bi bi-clock"></i>
                                Publiée récemment
                            </div>
                        </div>
                    </div>

                    <div class="offer-type-badge">
                        <i class="bi {{ $typeIcon }}"></i>
                        {{ $typeLabel }}
                    </div>

                    <h3 class="recent-offer-title">
                        {{ $offre->titre }}
                    </h3>

                    <div class="recent-offer-meta">
                        <span>
                            <i class="bi bi-geo-alt"></i>
                            {{ $offre->localisation ?: 'Localisation non précisée' }}
                        </span>

                        <span>
                            <i class="bi bi-grid"></i>
                            {{ $offre->categorie?->nom ?: 'Catégorie non précisée' }}
                        </span>
                    </div>

                    <div class="recent-offer-footer">
                        <div class="offer-deadline">
                            @if($offre->date_expiration)
                                <i class="bi bi-calendar-event"></i>
                                Expire le {{ $offre->date_expiration->format('d/m/Y') }}
                            @else
                                <i class="bi bi-infinity"></i>
                                Date flexible
                            @endif
                        </div>

                        <a href="{{ route('front.offres.show', $offre) }}" class="offer-view-btn">
                            Voir l'offre
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </article>
            @empty
                <div class="empty-offers-box">
                    <i class="bi bi-inbox"></i>
                    <h3>Aucune offre disponible</h3>
                    <p>Les nouvelles opportunités apparaîtront ici dès leur publication.</p>
                </div>
            @endforelse
        </div>

        <div class="offers-more">
            <a href="{{ route('front.offres.index') }}" class="offers-more-btn">
                Voir toutes les offres
                <i class="bi bi-arrow-right-circle"></i>
            </a>
        </div>
    </div>
</section>

<style>
.recent-offers-section {
    position: relative;
    padding: 95px 0;
    overflow: hidden;
    background:
        radial-gradient(circle at 15% 15%, rgba(30, 74, 118, 0.08), transparent 32%),
        radial-gradient(circle at 85% 85%, rgba(20, 184, 166, 0.08), transparent 32%),
        #fbfdff;
}

.recent-offers-header {
    max-width: 760px;
    margin: 0 auto 52px;
    text-align: center;
}

.recent-offers-kicker {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border-radius: 999px;
    background: rgba(30, 74, 118, 0.08);
    color: #1e4a76;
    font-size: 0.88rem;
    font-weight: 800;
    margin-bottom: 16px;
}

.recent-offers-subtitle {
    max-width: 620px;
    margin: -24px auto 0;
    color: #557c9c;
    font-size: 1.05rem;
    line-height: 1.75;
}

.recent-offers-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 26px;
}

.recent-offer-card {
    position: relative;
    min-height: 345px;
    border-radius: 30px;
    padding: 26px;
    background: rgba(255,255,255,0.9);
    border: 1px solid rgba(226, 232, 240, 0.95);
    box-shadow:
        0 26px 60px rgba(15, 23, 42, 0.12),
        inset 0 1px 0 rgba(255,255,255,0.95);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    opacity: 0;
    transform: translateY(45px) scale(0.96);
    transition:
        opacity 0.75s ease,
        transform 0.75s cubic-bezier(.2,.85,.25,1),
        box-shadow 0.3s ease;
}

.recent-offers-section.is-visible .recent-offer-card {
    opacity: 1;
    transform: translateY(0) scale(1);
}

.recent-offer-card:nth-child(1) { transition-delay: 80ms; }
.recent-offer-card:nth-child(2) { transition-delay: 180ms; }
.recent-offer-card:nth-child(3) { transition-delay: 280ms; }
.recent-offer-card:nth-child(4) { transition-delay: 380ms; }
.recent-offer-card:nth-child(5) { transition-delay: 480ms; }
.recent-offer-card:nth-child(6) { transition-delay: 580ms; }

.recent-offer-card:hover {
    transform: translateY(-8px) scale(1.01);
    box-shadow:
        0 38px 85px rgba(15, 23, 42, 0.18),
        inset 0 1px 0 rgba(255,255,255,0.95);
}

.recent-offer-card::before {
    content: "";
    position: absolute;
    inset: 0;
    opacity: 0.95;
    pointer-events: none;
}

.recent-offer-card.is-stage::before {
    background:
        linear-gradient(145deg, rgba(255,255,255,0.95), rgba(239,246,255,0.78)),
        radial-gradient(circle at 92% 8%, rgba(37, 99, 235, 0.16), transparent 35%);
}

.recent-offer-card.is-emploi::before {
    background:
        linear-gradient(145deg, rgba(255,255,255,0.95), rgba(240,253,250,0.78)),
        radial-gradient(circle at 92% 8%, rgba(20, 184, 166, 0.18), transparent 35%);
}

.offer-card-top,
.offer-type-badge,
.recent-offer-title,
.recent-offer-meta,
.recent-offer-footer {
    position: relative;
    z-index: 2;
}

.offer-card-top {
    display: flex;
    align-items: center;
    gap: 13px;
    margin-bottom: 24px;
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
    box-shadow:
        0 14px 28px rgba(15, 23, 42, 0.12),
        inset 0 1px 0 rgba(255,255,255,1);
}

.company-name {
    color: #0c2e44;
    font-weight: 850;
    font-size: 1rem;
    line-height: 1.25;
}

.offer-date {
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
    background: rgba(37, 99, 235, 0.1);
    color: #1d4ed8;
}

.is-emploi .offer-type-badge {
    background: rgba(20, 184, 166, 0.12);
    color: #0f766e;
}

.recent-offer-title {
    color: #0c2e44;
    font-size: 1.28rem;
    line-height: 1.32;
    font-weight: 900;
    margin: 0 0 18px;
}

.recent-offer-meta {
    display: grid;
    gap: 10px;
    margin-bottom: 24px;
}

.recent-offer-meta span {
    display: flex;
    align-items: flex-start;
    gap: 9px;
    color: #3a5a78;
    font-size: 0.94rem;
    line-height: 1.45;
}

.recent-offer-meta i {
    color: #1e4a76;
    font-size: 1rem;
    margin-top: 2px;
}

.recent-offer-footer {
    margin-top: auto;
    padding-top: 18px;
    border-top: 1px solid rgba(30, 74, 118, 0.12);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
}

.offer-deadline {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #64748b;
    font-size: 0.86rem;
    font-weight: 650;
}

.offer-view-btn {
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
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.offer-view-btn:hover {
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 16px 30px rgba(30, 74, 118, 0.24);
}

.offers-more {
    text-align: center;
    margin-top: 46px;
}

.offers-more-btn {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    text-decoration: none;
    background: #ffffff;
    color: #1e4a76;
    padding: 13px 24px;
    border-radius: 999px;
    font-weight: 850;
    border: 1px solid rgba(30, 74, 118, 0.18);
    box-shadow: 0 18px 36px rgba(15, 23, 42, 0.08);
    transition: transform 0.2s ease, background 0.2s ease;
}

.offers-more-btn:hover {
    background: #eef4fa;
    transform: translateY(-2px);
}

.empty-offers-box {
    grid-column: 1 / -1;
    text-align: center;
    background: #ffffff;
    border: 1px solid #eef2f8;
    border-radius: 30px;
    padding: 52px 24px;
    box-shadow: 0 22px 50px rgba(15, 23, 42, 0.08);
}

.empty-offers-box i {
    font-size: 2.7rem;
    color: #1e4a76;
    margin-bottom: 14px;
}

.empty-offers-box h3 {
    color: #0c2e44;
    font-weight: 850;
    margin-bottom: 8px;
}

.empty-offers-box p {
    color: #557c9c;
    margin: 0;
}

@media (max-width: 1150px) {
    .recent-offers-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 720px) {
    .recent-offers-section {
        padding: 68px 0;
    }

    .recent-offers-subtitle {
        margin-top: -18px;
        font-size: 0.98rem;
    }

    .recent-offers-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .recent-offer-card {
        min-height: auto;
        padding: 22px;
        border-radius: 26px;
    }

    .recent-offer-footer {
        flex-direction: column;
        align-items: stretch;
    }

    .offer-view-btn,
    .offers-more-btn {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const section = document.getElementById('recentOffers');

    if (!section) return;

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                section.classList.add('is-visible');
            }
        });
    }, {
        threshold: 0.2
    });

    observer.observe(section);
});
</script>