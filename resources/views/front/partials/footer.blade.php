<footer class="footer">
    <div class="container">
        <div class="footer-grid">

            <div class="footer-col">
                <h4>{{ $pageContent['footer']['brand_title'] ?? 'Cmlink' }}</h4>
                <p class="footer-text">
                    {{ $pageContent['footer']['brand_description'] ?? 'La plateforme qui connecte les talents aux meilleures opportunités.' }}
                </p>
            </div>

            <div class="footer-col">
                <h4>{{ $pageContent['footer']['student_title'] ?? 'Pour les étudiants' }}</h4>

                @for($i = 1; $i <= 4; $i++)
                    @php
                        $text = $pageContent['footer']["student_link_{$i}_text"] ?? null;
                        $url = $pageContent['footer']["student_link_{$i}_url"] ?? '#';
                    @endphp

                    @if(!empty($text))
                        <a href="{{ $url }}">{{ $text }}</a>
                    @endif
                @endfor
            </div>

            <div class="footer-col">
                <h4>{{ $pageContent['footer']['company_title'] ?? 'Pour les entreprises' }}</h4>

                @for($i = 1; $i <= 4; $i++)
                    @php
                        $text = $pageContent['footer']["company_link_{$i}_text"] ?? null;
                        $url = $pageContent['footer']["company_link_{$i}_url"] ?? '#';
                    @endphp

                    @if(!empty($text))
                        <a href="{{ $url }}">{{ $text }}</a>
                    @endif
                @endfor
            </div>

            <div class="footer-col">
                <h4>{{ $pageContent['footer']['social_title'] ?? 'Nous suivre' }}</h4>

                @for($i = 1; $i <= 5; $i++)
                    @php
                        $text = $pageContent['footer']["social_link_{$i}_text"] ?? null;
                        $url = $pageContent['footer']["social_link_{$i}_url"] ?? '#';
                    @endphp

                    @if(!empty($text))
                        <a href="{{ $url }}">{{ $text }}</a>
                    @endif
                @endfor
            </div>

        </div>

        <div class="footer-bottom">
            {{ $pageContent['footer']['copyright'] ?? '© 2025 Cmlink – Tous droits réservés. Simplifiez votre avenir professionnel.' }}
        </div>
    </div>
</footer>
