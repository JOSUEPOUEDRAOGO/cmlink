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
                    @php
                        $benefit = $pageContent['audience']["student_benefit_{$i}"] ?? null;
                    @endphp

                    @if(!empty($benefit))
                        <li>✓ {{ $benefit }}</li>
                    @endif
                @endfor
            </ul>

            <div class="audience-actions">
                @guest
                    <a href="{{ route('register', ['type' => 'etudiant']) }}" class="btn-primary">
                        {{ $pageContent['audience']['student_button'] ?? "S'inscrire en tant qu'étudiant" }}
                    </a>
                @else
                    @if(auth()->user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}" class="btn-primary">
                            Aller au dashboard admin
                        </a>
                    @else
                        <a href="{{ route('front.offres.index') }}" class="btn-primary">
                            Voir les offres
                        </a>
                    @endif
                @endguest
            </div>

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
                    @php
                        $benefit = $pageContent['audience']["company_benefit_{$i}"] ?? null;
                    @endphp

                    @if(!empty($benefit))
                        <li>✓ {{ $benefit }}</li>
                    @endif
                @endfor
            </ul>

            <div class="audience-actions">
                @guest
                    <a href="{{ route('register', ['type' => 'entreprise']) }}" class="btn-outline">
                        {{ $pageContent['audience']['company_button'] ?? "Rejoindre en tant qu'entreprise →" }}
                    </a>
                @else
                    @if(auth()->user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}" class="btn-outline">
                            Aller au dashboard admin →
                        </a>
                    @else
                        <a href="{{ route('front.offres.index') }}" class="btn-outline">
                            Découvrir la plateforme →
                        </a>
                    @endif
                @endguest
            </div>

            <div class="stats">
                <div class="stat-item">
                    <div class="stat-number">{{ $stats['etudiants'] }}+</div>
                    <div>profils talents</div>
                </div>
            </div>
        </div>
    </div>
</section>
