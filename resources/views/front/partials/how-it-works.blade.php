<section>
    <div class="container">
        <h2 class="section-title">
            {{ $pageContent['how']['title'] ?? 'Comment ça marche ?' }}
        </h2>

        <div class="steps">
            @for($i = 1; $i <= 4; $i++)
                <div class="step">
                    <div class="step-number">{{ $i }}</div>

                    <h3>
                        {{ $pageContent['how']["step_{$i}_title"] ?? '' }}
                    </h3>

                    <p>
                        {{ $pageContent['how']["step_{$i}_text"] ?? '' }}
                    </p>
                </div>
            @endfor
        </div>
    </div>
</section>
