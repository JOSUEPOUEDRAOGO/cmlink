<section id="pourquoi-cmlink" class="why-section">
    <div class="container">
        <h2 class="section-title typewriter-title" id="whyTypewriter"
            data-text="{{ $pageContent['why']['title'] ?? 'Pourquoi choisir Cmlink ?' }}">
        </h2>

        <div class="features-grid-3d">
            @for($i = 1; $i <= 4; $i++)
                @php
                    $title = $pageContent['why']["card_{$i}_title"] ?? '';
                    $text = $pageContent['why']["card_{$i}_text"] ?? '';
                    $backTitle = $pageContent['why']["card_{$i}_back_title"] ?? $title;
                    $backText = $pageContent['why']["card_{$i}_back_text"] ?? $text;
                @endphp

                <div class="feature-card-3d" tabindex="0">
                    <div class="feature-card-inner">
                        <div class="feature-card-face feature-card-front">
                            <div class="feature-card-number">0{{ $i }}</div>
                            <h3>{{ $title }}</h3>
                            <p>{{ $text }}</p>
                            <span class="flip-hint">Voir plus ↻</span>
                        </div>

                        <div class="feature-card-face feature-card-back">
                            <div class="feature-card-number">0{{ $i }}</div>
                            <h3>{{ $backTitle }}</h3>
                            <p>{{ $backText }}</p>
                            <span class="flip-hint">Retour ↺</span>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</section>

<style>
.why-section {
    padding: 80px 0;
    overflow: hidden;
}

.typewriter-title {
    min-height: 58px;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 2px;
}

.typewriter-title::after {
    content: "";
    width: 10px;
    height: 10px;
    background: #1e4a76;
    border-radius: 50%;
    display: inline-block;
    animation: cursorPulse 0.8s infinite;
    margin-left: 6px;
}

@keyframes cursorPulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.25; transform: scale(0.8); }
}

.features-grid-3d {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 22px;
    align-items: stretch;
    perspective: 1400px;
}

.feature-card-3d {
    min-height: 310px;
    perspective: 1200px;
    cursor: pointer;
    outline: none;
}

.feature-card-inner {
    position: relative;
    width: 100%;
    height: 100%;
    min-height: 310px;
    transition: transform 0.8s cubic-bezier(.2,.75,.25,1);
    transform-style: preserve-3d;
}

.feature-card-3d:hover .feature-card-inner,
.feature-card-3d:focus .feature-card-inner,
.feature-card-3d.is-flipped .feature-card-inner {
    transform: rotateY(180deg);
}

.feature-card-face {
    position: absolute;
    inset: 0;
    backface-visibility: hidden;
    border-radius: 28px;
    padding: 26px 22px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: 0 18px 45px rgba(15, 23, 42, 0.12);
    border: 1px solid rgba(255,255,255,0.7);
}

.feature-card-front {
    background: linear-gradient(145deg, #ffffff, #eef5ff);
    color: #0c2e44;
}

.feature-card-back {
    transform: rotateY(180deg);
    background: linear-gradient(145deg, #0b2e7a, #1e4a76);
    color: #ffffff;
}

.feature-card-number {
    width: 46px;
    height: 46px;
    border-radius: 16px;
    background: rgba(30, 74, 118, 0.1);
    color: #1e4a76;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
}

.feature-card-back .feature-card-number {
    background: rgba(255,255,255,0.16);
    color: #ffffff;
}

.feature-card-face h3 {
    font-size: 1.28rem;
    line-height: 1.25;
    font-weight: 800;
    margin: 18px 0 12px;
}

.feature-card-face p {
    color: inherit;
    opacity: 0.88;
    font-size: 0.96rem;
    line-height: 1.6;
    margin: 0;
}

.flip-hint {
    margin-top: 18px;
    font-size: 0.85rem;
    font-weight: 700;
    opacity: 0.8;
}

@media (max-width: 1100px) {
    .features-grid-3d {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 640px) {
    .why-section {
        padding: 60px 0;
    }

    .features-grid-3d {
        grid-template-columns: 1fr;
        gap: 18px;
    }

    .feature-card-3d,
    .feature-card-inner {
        min-height: 290px;
    }

    .typewriter-title {
        min-height: 48px;
        text-align: center;
    }

    .feature-card-3d:hover .feature-card-inner {
        transform: none;
    }

    .feature-card-3d.is-flipped .feature-card-inner,
    .feature-card-3d:focus .feature-card-inner {
        transform: rotateY(180deg);
    }
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | TYPEWRITER LOOP
    |--------------------------------------------------------------------------
    */

    const title = document.getElementById('whyTypewriter');

    if (title) {

        const text = title.dataset.text || '';
        let index = 0;

        function startTyping() {

            title.textContent = '';
            index = 0;

            function typeWriter() {

                if (index <= text.length) {

                    title.textContent = text.substring(0, index);

                    index++;

                    setTimeout(typeWriter, 55);

                } else {

                    // attendre 10 secondes puis recommencer
                    setTimeout(startTyping, 10000);
                }
            }

            typeWriter();
        }

        startTyping();
    }

    /*
    |--------------------------------------------------------------------------
    | 3D CARDS FLIP
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('.feature-card-3d').forEach(function (card) {

        card.addEventListener('click', function () {
            card.classList.toggle('is-flipped');
        });

        card.addEventListener('keydown', function (event) {

            if (event.key === 'Enter' || event.key === ' ') {

                event.preventDefault();

                card.classList.toggle('is-flipped');
            }
        });

    });

});
</script>
