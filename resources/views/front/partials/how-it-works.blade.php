<section class="how-pro-section" id="howCmlink">
    <div class="container">
        <div class="how-header">
            <span class="how-kicker">Processus simple</span>

            <h2 class="section-title">
                {{ $pageContent['how']['title'] ?? 'Comment ça marche ?' }}
            </h2>

            <p class="how-subtitle">
                Une progression claire, pensée pour guider chaque utilisateur vers son opportunité.
            </p>
        </div>

        <div class="how-steps-pro">
            @for($i = 1; $i <= 4; $i++)
                <div class="how-step-card" style="--delay: {{ ($i - 1) * 400 }}ms;">
                    <div class="how-step-top">
                        <div class="how-step-number" data-number="{{ $i }}">0</div>
                        <div class="how-step-line"></div>
                    </div>

                    <div class="how-step-content">
                        <h3>
                            {{ $pageContent['how']["step_{$i}_title"] ?? '' }}
                        </h3>

                        <p>
                            {{ $pageContent['how']["step_{$i}_text"] ?? '' }}
                        </p>
                    </div>

                    <div class="how-step-glow"></div>
                </div>
            @endfor
        </div>
    </div>
</section>

<style>
.how-pro-section {
    position: relative;
    padding: 95px 0;
    overflow: hidden;
    background:
        radial-gradient(circle at 12% 18%, rgba(30, 74, 118, 0.10), transparent 32%),
        radial-gradient(circle at 88% 78%, rgba(43, 106, 159, 0.10), transparent 35%),
        linear-gradient(180deg, #fbfdff 0%, #f5f9ff 100%);
}

.how-pro-section::before {
    content: "";
    position: absolute;
    inset: 90px 0 auto 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(30, 74, 118, 0.18), transparent);
}

.how-header {
    text-align: center;
    max-width: 760px;
    margin: 0 auto 52px;
}

.how-kicker {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 8px 16px;
    border-radius: 999px;
    background: rgba(30, 74, 118, 0.08);
    color: #1e4a76;
    font-weight: 800;
    font-size: 0.86rem;
    letter-spacing: 0.02em;
    margin-bottom: 16px;
}

.how-subtitle {
    color: #557c9c;
    font-size: 1.05rem;
    line-height: 1.7;
    margin: -26px auto 0;
    max-width: 620px;
}

.how-steps-pro {
    position: relative;
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 24px;
    perspective: 1400px;
}

.how-step-card {
    position: relative;
    min-height: 330px;
    padding: 28px 24px;
    border-radius: 30px;
    overflow: hidden;
    background:
        linear-gradient(145deg, rgba(255,255,255,0.95), rgba(239,246,255,0.82));
    border: 1px solid rgba(226, 232, 240, 0.95);
    box-shadow:
        0 30px 65px rgba(15, 23, 42, 0.13),
        12px 12px 34px rgba(30, 74, 118, 0.09),
        inset 0 1px 0 rgba(255,255,255,0.95);
    transform: translateX(-100px) translateY(45px) rotateY(-20deg) scale(0.88);
    opacity: 0;
    transition:
        transform 1.4s cubic-bezier(0.2, 0.9, 0.3, 1.05),
        opacity 1.2s ease,
        box-shadow 0.35s ease;
    transition-delay: var(--delay);
}

.how-step-card:nth-child(2) {
    transform: translateY(100px) rotateX(16deg) scale(0.88);
}

.how-step-card:nth-child(3) {
    transform: translateY(-100px) rotateX(-16deg) scale(0.88);
}

.how-step-card:nth-child(4) {
    transform: translateX(100px) translateY(45px) rotateY(20deg) scale(0.88);
}

/* Animation d'entrée des cartes */
.how-pro-section.is-visible .how-step-card {
    opacity: 1;
    transform: translateX(0) translateY(0) rotateX(0) rotateY(0) scale(1);
}

/* Animation de sortie pour réinitialisation */
.how-pro-section.resetting .how-step-card {
    transition: none;
    opacity: 0;
    transform: translateX(-100px) translateY(45px) rotateY(-20deg) scale(0.88);
}

.how-pro-section.resetting .how-step-card:nth-child(2) {
    transform: translateY(100px) rotateX(16deg) scale(0.88);
}

.how-pro-section.resetting .how-step-card:nth-child(3) {
    transform: translateY(-100px) rotateX(-16deg) scale(0.88);
}

.how-pro-section.resetting .how-step-card:nth-child(4) {
    transform: translateX(100px) translateY(45px) rotateY(20deg) scale(0.88);
}

.how-step-card:hover {
    transform: translateY(-10px) scale(1.015) !important;
    box-shadow:
        0 42px 90px rgba(15, 23, 42, 0.18),
        16px 16px 45px rgba(30, 74, 118, 0.12),
        inset 0 1px 0 rgba(255,255,255,0.95);
}

.how-step-card::before {
    content: "";
    position: absolute;
    inset: 0;
    background:
        radial-gradient(circle at 20% 15%, rgba(30, 74, 118, 0.14), transparent 30%),
        linear-gradient(135deg, rgba(255,255,255,0.8), transparent 45%);
    pointer-events: none;
    z-index: 0;
}

.how-step-card::after {
    content: "";
    position: absolute;
    left: 28px;
    right: 28px;
    bottom: -24px;
    height: 42px;
    border-radius: 50%;
    background: rgba(15, 23, 42, 0.22);
    filter: blur(26px);
    z-index: 0;
}

.how-step-top,
.how-step-content {
    position: relative;
    z-index: 2;
}

.how-step-top {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 38px;
}

.how-step-number {
    width: 64px;
    height: 64px;
    border-radius: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #ffffff;
    color: #1e4a76;
    font-size: 1.65rem;
    font-weight: 950;
    box-shadow:
        0 18px 34px rgba(30, 74, 118, 0.16),
        inset 0 1px 0 rgba(255,255,255,1);
    border: 1px solid rgba(226, 232, 240, 0.9);
}

.how-step-line {
    flex: 1;
    height: 2px;
    background: linear-gradient(90deg, rgba(30,74,118,0.35), transparent);
}

.how-step-content h3 {
    font-size: 1.35rem;
    line-height: 1.25;
    font-weight: 850;
    color: #0c2e44;
    margin-bottom: 14px;
}

.how-step-content p {
    color: #3a5a78;
    font-size: 0.98rem;
    line-height: 1.75;
    margin: 0;
}

.how-step-glow {
    position: absolute;
    width: 190px;
    height: 190px;
    right: -80px;
    bottom: -80px;
    border-radius: 50%;
    background: rgba(30, 74, 118, 0.12);
    filter: blur(6px);
    z-index: 1;
}

.how-step-card:nth-child(2) .how-step-glow {
    background: rgba(20, 184, 166, 0.12);
}

.how-step-card:nth-child(3) .how-step-glow {
    background: rgba(244, 162, 97, 0.14);
}

.how-step-card:nth-child(4) .how-step-glow {
    background: rgba(99, 102, 241, 0.12);
}

@media (max-width: 1150px) {
    .how-steps-pro {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .how-step-card {
        min-height: 300px;
    }
}

@media (max-width: 680px) {
    .how-pro-section {
        padding: 68px 0;
    }

    .how-header {
        margin-bottom: 34px;
    }

    .how-subtitle {
        margin-top: -20px;
        font-size: 0.98rem;
    }

    .how-steps-pro {
        grid-template-columns: 1fr;
        gap: 18px;
    }

    .how-step-card,
    .how-step-card:nth-child(2),
    .how-step-card:nth-child(3),
    .how-step-card:nth-child(4) {
        min-height: auto;
        padding: 24px;
        transform: translateY(75px) scale(0.92);
    }

    .how-pro-section.is-visible .how-step-card {
        transform: translateY(0) scale(1);
    }
    
    .how-pro-section.resetting .how-step-card,
    .how-pro-section.resetting .how-step-card:nth-child(2),
    .how-pro-section.resetting .how-step-card:nth-child(3),
    .how-pro-section.resetting .how-step-card:nth-child(4) {
        transform: translateY(75px) scale(0.92);
    }

    .how-step-top {
        margin-bottom: 24px;
    }

    .how-step-number {
        width: 58px;
        height: 58px;
        border-radius: 19px;
        font-size: 1.45rem;
    }

    .how-step-content h3 {
        font-size: 1.22rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const section = document.getElementById('howCmlink');
    if (!section) return;

    const numbers = section.querySelectorAll('.how-step-number');
    const cards = section.querySelectorAll('.how-step-card');
    let animationInterval = null;
    let fullAnimationTimeout = null;
    let isCurrentlyAnimating = false;

    // Fonction pour animer les numéros
    function animateNumbers() {
        return new Promise((resolve) => {
            let completedAnimations = 0;
            const totalNumbers = numbers.length;
            
            numbers.forEach(function (numberEl, index) {
                const target = parseInt(numberEl.dataset.number, 10) || 0;

                setTimeout(function () {
                    let current = 0;
                    numberEl.textContent = '0';

                    const interval = setInterval(function () {
                        current++;
                        numberEl.textContent = current;

                        if (current >= target) {
                            numberEl.textContent = target;
                            clearInterval(interval);
                            completedAnimations++;
                            if (completedAnimations === totalNumbers) {
                                resolve();
                            }
                        }
                    }, 200);
                }, index * 350);
            });
        });
    }

    // Fonction pour réinitialiser complètement l'animation
    async function resetAndPlayFullAnimation() {
        if (isCurrentlyAnimating) return;
        
        isCurrentlyAnimating = true;
        
        // Ajouter la classe resetting pour cacher les cartes
        section.classList.add('resetting');
        
        // Attendre un court instant pour que le resetting soit appliqué
        await new Promise(resolve => setTimeout(resolve, 50));
        
        // Enlever la classe is-visible pour désactiver l'animation d'entrée
        section.classList.remove('is-visible');
        
        // Réinitialiser l'affichage des nombres à 0
        numbers.forEach(function (numberEl) {
            numberEl.textContent = '0';
        });
        
        // Attendre que le DOM soit prêt
        await new Promise(resolve => setTimeout(resolve, 100));
        
        // Enlever la classe resetting
        section.classList.remove('resetting');
        
        // Forcer un reflow pour que l'animation reparte correctement
        void section.offsetHeight;
        
        // Ajouter la classe is-visible pour déclencher l'animation des cartes
        section.classList.add('is-visible');
        
        // Attendre la fin de l'animation des cartes
        await new Promise(resolve => setTimeout(resolve, 1500));
        
        // Démarrer l'animation des numéros
        await animateNumbers();
        
        isCurrentlyAnimating = false;
    }

    // Fonction pour jouer l'animation uniquement (sans reset si déjà visible)
    async function playAnimationOnly() {
        if (isCurrentlyAnimating) return;
        
        isCurrentlyAnimating = true;
        
        // Réinitialiser uniquement les numéros
        numbers.forEach(function (numberEl) {
            numberEl.textContent = '0';
        });
        
        // Attendre un petit moment
        await new Promise(resolve => setTimeout(resolve, 100));
        
        // Démarrer l'animation des numéros
        await animateNumbers();
        
        isCurrentlyAnimating = false;
    }

    // Fonction pour démarrer le processus répétitif
    function startRepeatingProcess() {
        if (animationInterval) {
            clearInterval(animationInterval);
        }
        
        // Lancer le processus toutes les 10 secondes avec animation complète
        animationInterval = setInterval(function() {
            // Ne pas lancer si on est en train d'animer
            if (!isCurrentlyAnimating && section.classList.contains('is-visible')) {
                playAnimationOnly();
            }
        }, 10000);
    }

    function stopRepeatingProcess() {
        if (animationInterval) {
            clearInterval(animationInterval);
            animationInterval = null;
        }
        if (fullAnimationTimeout) {
            clearTimeout(fullAnimationTimeout);
            fullAnimationTimeout = null;
        }
    }

    // Observer pour détecter quand la section devient visible
    const observer = new IntersectionObserver(async function (entries) {
        for (const entry of entries) {
            if (entry.isIntersecting) {
                // Arrêter le processus existant
                stopRepeatingProcess();
                
                // Réinitialiser complètement et jouer l'animation
                await resetAndPlayFullAnimation();
                
                // Démarrer le processus répétitif
                startRepeatingProcess();
            } else {
                // Si la section n'est plus visible, arrêter le processus
                stopRepeatingProcess();
            }
        }
    }, {
        threshold: 0.25
    });

    observer.observe(section);
});
</script>