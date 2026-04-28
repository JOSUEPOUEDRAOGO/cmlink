<section>
    <div class="container">
        <h2 class="section-title">Offres récentes</h2>

        <div class="offers-grid">
            @forelse($offresRecentes as $offre)
                <div class="offer-card">
                    <div class="company">{{ $offre->entreprise->nom ?? 'Entreprise' }}</div>
                    <div class="job-title">{{ $offre->titre }}</div>

                    <div class="details">
                        <span>📍 {{ $offre->localisation ?: 'Non précisée' }}</span>
                        <span>
                            {{ $offre->type === 'stage' ? '📘 Stage' : '💼 Emploi' }}
                        </span>
                    </div>

                    <div class="salary">
                        {{ $offre->categorie?->nom ? '🏷️ '.$offre->categorie->nom : 'Catégorie non précisée' }}
                    </div>

                    <div class="tags">
                        <span class="tag">{{ ucfirst($offre->type) }}</span>

                        @if($offre->categorie)
                            <span class="tag">{{ $offre->categorie->nom }}</span>
                        @endif

                        @if($offre->date_expiration)
                            <span class="tag">Expire le {{ $offre->date_expiration->format('d/m/Y') }}</span>
                        @endif
                    </div>

                    <a href="{{ route('front.offres.show', $offre) }}" class="view-link">Voir l'offre →</a>
                </div>
            @empty
                <p style="text-align:center; width:100%; color:#557c9c;">Aucune offre disponible pour le moment.</p>
            @endforelse
        </div>

        <div class="offers-more">
            <a href="{{ route('front.offres.index') }}" class="btn-secondary">Voir toutes les offres →</a>
        </div>
    </div>
</section>
