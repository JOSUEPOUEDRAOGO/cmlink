<section>
    <div class="container two-col">

        {{-- Bloc étudiants --}}
        <div class="card-block">
            <h2 class="block-title">
                {{ $pageContent['audience']['student_title'] ?? '🎓 Pour les étudiants et jeunes diplômés' }}
            </h2>

            <p class="block-text">
                {{ $pageContent['audience']['student_text'] ?? 'Trouvez des stages et premiers emplois adaptés à votre niveau et vos ambitions.' }}
            </p>

            <ul class="benefit-list">
                @for($i = 1; $i <= 3; $i++)
                    <li>
                        ✓ {{ $pageContent['audience']["student_benefit_{$i}"] ?? '' }}
                    </li>
                @endfor
            </ul>

            <a href="{{ route('register') }}" class="btn-primary">
                {{ $pageContent['audience']['student_button'] ?? "S'inscrire en tant qu'étudiant" }}
            </a>

            <div class="stats">
                <div class="stat-item">
                    <div class="stat-number">{{ $stats['offres'] }}+</div>
                    <div>offres</div>
                </div>

                <div class="stat-item">
                    <div class="stat-number">{{ $stats['entreprises'] }}+</div>
                    <div>entreprises</div>
                </div>
            </div>
        </div>

        {{-- Bloc entreprises --}}
        <div class="card-block">
            <h2 class="block-title">
                {{ $pageContent['audience']['company_title'] ?? '🏢 Pour les entreprises' }}
            </h2>

            <p class="block-text">
                {{ $pageContent['audience']['company_text'] ?? 'Trouvez les meilleurs talents étudiants et jeunes diplômés adaptés à vos besoins.' }}
            </p>

            <ul class="benefit-list">
                @for($i = 1; $i <= 3; $i++)
                    <li>
                        ✓ {{ $pageContent['audience']["company_benefit_{$i}"] ?? '' }}
                    </li>
                @endfor
            </ul>

            <a href="{{ route('register') }}" class="btn-outline">
                {{ $pageContent['audience']['company_button'] ?? "Rejoindre en tant qu'entreprise →" }}
            </a>

            <div class="stats">
                <div class="stat-item">
                    <div class="stat-number">{{ $stats['etudiants'] }}+</div>
                    <div>profils talents</div>
                </div>
            </div>
        </div>

    </div>
</section>
