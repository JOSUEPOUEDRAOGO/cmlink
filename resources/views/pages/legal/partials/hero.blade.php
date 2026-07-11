<section class="legal-hero">

    <div class="container">

        <div class="legal-hero-content">

            <span class="legal-badge">
                Documentation officielle
            </span>

            <h1>
                {{ $page->title }}
            </h1>

            <p>

                Dernière mise à jour :
                {{ $page->updated_at?->format('d/m/Y') }}

            </p>

        </div>

    </div>

</section>
