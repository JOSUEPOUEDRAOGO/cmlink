<section id="pourquoi-cmlink">
    <div class="container">
        <h2 class="section-title">
            {{ $pageContent['why']['title'] ?? 'Pourquoi choisir Cmlink ?' }}
        </h2>

        <div class="features-grid">
            @for($i = 1; $i <= 4; $i++)
                <div class="feature-card">
                    <h3>
                        {{ $pageContent['why']["card_{$i}_title"] ?? '' }}
                    </h3>

                    <p>
                        {{ $pageContent['why']["card_{$i}_text"] ?? '' }}
                    </p>
                </div>
            @endfor
        </div>
    </div>
</section>