<section class="cta-section">
    <div class="container cta-box">
        <h2>
            {{ $pageContent['cta']['title'] ?? 'Prêt à transformer votre carrière ?' }}
        </h2>

        <p>
            {{ $pageContent['cta']['text'] ?? 'Rejoignez '.$stats['etudiants'].' étudiants et jeunes diplômés qui construisent leur avenir avec Cmlink.' }}
        </p>

        <div class="btn-group cta-actions">
            <a href="{{ route('register') }}" class="btn-primary btn-dark-primary">
                {{ $pageContent['cta']['button_primary'] ?? "S'inscrire gratuitement" }}
            </a>

            <a href="{{ route('front.offres.index') }}" class="btn-outline">
                {{ $pageContent['cta']['button_secondary'] ?? 'Voir les offres' }}
            </a>
        </div>

        <p class="cta-note">
            {{ $pageContent['cta']['note'] ?? 'Pas de carte bancaire requise. Inscription gratuite en 2 minutes.' }}
        </p>
    </div>
</section>
