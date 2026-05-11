@if($categories->count())
    <div class="category-ticker">
        <div class="category-track">
            @foreach($categories as $categorie)
                <a href="{{ route('front.offres.index', ['categorie' => $categorie->id]) }}">
                    {{ $categorie->nom }}
                    <span>{{ $categorie->offres_count }} offres</span>
                </a>
            @endforeach

            @foreach($categories as $categorie)
                <a href="{{ route('front.offres.index', ['categorie' => $categorie->id]) }}">
                    {{ $categorie->nom }}
                    <span>{{ $categorie->offres_count }} offres</span>
                </a>
            @endforeach
        </div>
    </div>
@endif

<style>
    /* Style pour l'effet machine à écrire */
    .typewriter {
        display: inline-block;
        font-family: inherit;
        font-size: inherit;
        font-weight: inherit;
        color: inherit;
    }

    .typewriter .cursor {
        display: inline-block;
        width: 3px;
        margin-left: 4px;
        background-color: currentColor;
        animation: blink 0.7s step-end infinite;
        vertical-align: middle;
    }

    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0; }
    }

    /* Optionnel : adoucir l'apparition du conteneur */
    .hero h1 {
        min-height: 4rem; /* évite le saut de layout */
    }
</style>

<div class="container hero">
    <h1>
        <span class="typewriter" id="typewriter-title"></span>
        <span class="cursor"></span>
    </h1>

    <p>
        {{ $pageContent['hero']['subtitle'] ?? 'Connectez-vous directement avec les meilleures entreprises.' }}
    </p>

    <div class="btn-group">
        <a href="{{ route('register') }}" class="btn-primary">
            {{ $pageContent['hero']['button_primary'] ?? 'Commencer maintenant' }}
        </a>

        <a href="#pourquoi-cmlink" class="btn-outline">
            {{ $pageContent['hero']['button_secondary'] ?? 'En savoir plus →' }}
        </a>
    </div>

    <div class="hero-badge">
        🔗 Connexion directe avec les entreprises
    </div>
</div>

<script>
    (function() {
        // Liste des titres à afficher (personnalisable)
        const phrases = [
            "Trouvez votre prochaine opportunité",
            "Décrochez le stage de vos rêves",
            "Connectez-vous aux meilleures entreprises",
            "Construisez votre avenir professionnel",
            "Des offres adaptées à votre profil"
        ];

        // Vitesse d'écriture : moyenne (temps en ms par caractère)
        const TYPING_SPEED = 50;   // 50ms/caractère -> vitesse moyenne
        const PAUSE_BETWEEN_PHRASES = 10000; // 10 secondes entre chaque phrase
        const ERASE_SPEED = 30;     // vitesse d'effacement (un peu plus rapide)

        let currentIndex = 0;
        let currentText = '';
        let isDeleting = false;
        let timeoutId = null;
        const typewriterElement = document.getElementById('typewriter-title');

        if (!typewriterElement) return;

        function typeEffect() {
            const fullText = phrases[currentIndex];

            if (isDeleting) {
                // Effacement
                currentText = fullText.substring(0, currentText.length - 1);
                typewriterElement.textContent = currentText;

                if (currentText === '') {
                    isDeleting = false;
                    currentIndex = (currentIndex + 1) % phrases.length;
                    // Pause avant d'écrire la prochaine phrase
                    timeoutId = setTimeout(typeEffect, 500);
                } else {
                    timeoutId = setTimeout(typeEffect, ERASE_SPEED);
                }
            } else {
                // Écriture
                currentText = fullText.substring(0, currentText.length + 1);
                typewriterElement.textContent = currentText;

                if (currentText === fullText) {
                    // Phrase terminée : attendre 10 secondes puis effacer
                    isDeleting = true;
                    timeoutId = setTimeout(typeEffect, PAUSE_BETWEEN_PHRASES);
                } else {
                    timeoutId = setTimeout(typeEffect, TYPING_SPEED);
                }
            }
        }

        // Démarrer l'effet
        typeEffect();

        // Nettoyage optionnel (si nécessaire pour éviter les fuites mémoire)
        window.addEventListener('beforeunload', function() {
            if (timeoutId) clearTimeout(timeoutId);
        });
    })();
</script>
