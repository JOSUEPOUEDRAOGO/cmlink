<footer class="footer-pro" id="footerPro">
    <div class="footer-bg-blur footer-blur-1"></div>
    <div class="footer-bg-blur footer-blur-2"></div>

    <div class="container">

        <div class="footer-top">

            {{-- BRAND --}}
            <div class="footer-brand-block">

                <a href="{{ route('front.home') }}" class="footer-logo">
                    <img src="{{ asset('assets/img/cmclink.png') }}" alt="Cmlink Logo">
                </a>

                <p class="footer-brand-text">
                    {{ $pageContent['footer']['brand_description'] ?? 'La plateforme qui connecte les talents aux meilleures opportunités.' }}
                </p>
            </div>

            {{-- GRID --}}
            <div class="footer-links-grid">

                {{-- ETUDIANTS --}}
                <div class="footer-column">
                    <h4>
                        <i class="bi bi-mortarboard"></i>
                        {{ $pageContent['footer']['student_title'] ?? 'Pour les étudiants' }}
                    </h4>

                    <div class="footer-links">
                        @for ($i = 1; $i <= 4; $i++)
                            @php
                                $text = $pageContent['footer']["student_link_{$i}_text"] ?? null;
                                $url = $pageContent['footer']["student_link_{$i}_url"] ?? '#';
                            @endphp

                            @if (!empty($text))
                                <a href="{{ $url }}">
                                    <i class="bi bi-arrow-right-short"></i>
                                    <span>{{ $text }}</span>
                                </a>
                            @endif
                        @endfor
                    </div>
                </div>

                {{-- ENTREPRISES --}}
                <div class="footer-column">
                    <h4>
                        <i class="bi bi-buildings"></i>
                        {{ $pageContent['footer']['company_title'] ?? 'Pour les entreprises' }}
                    </h4>

                    <div class="footer-links">
                        @for ($i = 1; $i <= 4; $i++)
                            @php
                                $text = $pageContent['footer']["company_link_{$i}_text"] ?? null;
                                $url = $pageContent['footer']["company_link_{$i}_url"] ?? '#';
                            @endphp

                            @if (!empty($text))
                                <a href="{{ $url }}">
                                    <i class="bi bi-arrow-right-short"></i>
                                    <span>{{ $text }}</span>
                                </a>
                            @endif
                        @endfor
                    </div>
                </div>

                {{-- SOCIAL --}}
                <div class="footer-column">
                    <h4>
                        <i class="bi bi-globe"></i>
                        {{ $pageContent['footer']['social_title'] ?? 'Nous suivre' }}
                    </h4>

                    <div class="footer-links">
                        @for ($i = 1; $i <= 4; $i++)
                            @php
                                $text = $pageContent['footer']["social_link_{$i}_text"] ?? null;
                                $url = $pageContent['footer']["social_link_{$i}_url"] ?? '#';
                            @endphp

                            @if (!empty($text))
                                <a href="{{ $url }}" target="_blank">
                                    <i class="bi bi-arrow-up-right"></i>
                                    <span>{{ $text }}</span>
                                </a>
                            @endif
                        @endfor
                    </div>
                </div>

            </div>
        </div>

        {{-- BOTTOM --}}
        <div class="footer-bottom-bar">
            <div class="footer-copyright">
                {{ $pageContent['footer']['copyright'] ?? '© 2025 Cmlink – Tous droits réservés. Simplifiez votre avenir professionnel.' }}
            </div>

            <div class="footer-bottom-links">
                <a href="{{ route('pdc') }}">Confidentialité</a>
                <a href="{{ route('cgu') }}">Conditions</a>
                <a href="{{ route('support') }}">Support</a>
            </div>
        </div>

    </div>
</footer>

<style>
    .footer-pro {
        position: relative;
        overflow: hidden;
        padding: 90px 0 32px;
        background:
            radial-gradient(circle at top left, rgba(30, 74, 118, 0.12), transparent 35%),
            radial-gradient(circle at bottom right, rgba(20, 184, 166, 0.10), transparent 35%),
            linear-gradient(135deg, #07131f 0%, #0c2033 100%);
    }

    .footer-bg-blur {
        position: absolute;
        border-radius: 999px;
        filter: blur(90px);
        opacity: 0.28;
        pointer-events: none;
    }

    .footer-blur-1 {
        width: 280px;
        height: 280px;
        background: #1e4a76;
        top: -80px;
        left: -80px;
    }

    .footer-blur-2 {
        width: 260px;
        height: 260px;
        background: #14b8a6;
        bottom: -100px;
        right: -80px;
    }

    .footer-top {
        position: relative;
        z-index: 2;
        display: grid;
        grid-template-columns: 420px 1fr;
        gap: 70px;
        margin-bottom: 50px;
    }

    .footer-brand-block {
        display: flex;
        flex-direction: column;
    }

    .footer-logo {
        display: inline-flex;
        width: fit-content;
        margin-bottom: 26px;
    }

    .footer-logo img {
        height: 74px;
        width: auto;
        object-fit: contain;
        filter:
            drop-shadow(0 12px 28px rgba(0, 0, 0, 0.35)) drop-shadow(0 0 22px rgba(255, 255, 255, 0.10));
        transition: transform 0.3s ease;
    }

    .footer-logo:hover img {
        transform: translateY(-3px) scale(1.03);
    }

    .footer-brand-text {
        color: rgba(226, 232, 240, 0.82);
        line-height: 1.9;
        font-size: 1rem;
        max-width: 360px;
        margin-bottom: 30px;
    }

    .footer-brand-stats {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
    }

    .footer-stat {
        min-width: 110px;
        padding: 18px 18px;
        border-radius: 22px;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(14px);
        box-shadow:
            0 12px 34px rgba(0, 0, 0, 0.22),
            inset 0 1px 0 rgba(255, 255, 255, 0.08);
    }

    .footer-stat strong {
        display: block;
        color: #ffffff;
        font-size: 1.35rem;
        font-weight: 900;
        margin-bottom: 4px;
    }

    .footer-stat span {
        color: rgba(226, 232, 240, 0.72);
        font-size: 0.88rem;
    }

    .footer-links-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 34px;
    }

    .footer-column h4 {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #ffffff;
        font-size: 1.08rem;
        font-weight: 850;
        margin-bottom: 24px;
    }

    .footer-column h4 i {
        color: #4fd1c5;
    }

    .footer-links {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .footer-links a {
        width: fit-content;
        display: inline-flex;
        align-items: center;
        gap: 9px;
        text-decoration: none;
        color: rgba(226, 232, 240, 0.78);
        font-weight: 550;
        transition:
            transform 0.22s ease,
            color 0.22s ease;
    }

    .footer-links a i {
        font-size: 1rem;
        color: #4fd1c5;
        transition: transform 0.22s ease;
    }

    .footer-links a:hover {
        color: #ffffff;
        transform: translateX(5px);
    }

    .footer-links a:hover i {
        transform: translateX(3px);
    }

    .footer-bottom-bar {
        position: relative;
        z-index: 2;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        padding-top: 24px;
        display: flex;
        justify-content: space-between;
        gap: 20px;
        align-items: center;
        flex-wrap: wrap;
    }

    .footer-copyright {
        color: rgba(226, 232, 240, 0.62);
        font-size: 0.92rem;
        line-height: 1.7;
    }

    .footer-bottom-links {
        display: flex;
        gap: 18px;
        flex-wrap: wrap;
    }

    .footer-bottom-links a {
        color: rgba(226, 232, 240, 0.72);
        text-decoration: none;
        font-size: 0.92rem;
        transition: color 0.22s ease;
    }

    .footer-bottom-links a:hover {
        color: #ffffff;
    }

    @media (max-width: 1100px) {
        .footer-top {
            grid-template-columns: 1fr;
            gap: 50px;
        }

        .footer-links-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 720px) {
        .footer-pro {
            padding: 70px 0 28px;
        }

        .footer-links-grid {
            grid-template-columns: 1fr;
            gap: 34px;
        }

        .footer-logo img {
            height: 62px;
        }

        .footer-brand-text {
            max-width: 100%;
        }

        .footer-brand-stats {
            flex-direction: column;
        }

        .footer-stat {
            width: 100%;
        }

        .footer-bottom-bar {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
