<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Cmlink Admin')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#1e4a76">

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon/favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}">

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Bootstrap --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- Admin CSS --}}
    <link
        rel="stylesheet"
        href="{{ asset('assets/css/admin.css') }}">

    {{-- iziToast --}}
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
</head>

<body>

    {{-- =========================================================
         ADMIN LAYOUT
    ========================================================== --}}
    <div class="admin-layout">

        {{-- =====================================================
             SIDEBAR
        ====================================================== --}}
        @include('layouts.partials.sidebar')


        {{-- =====================================================
             CONTENU PRINCIPAL
        ====================================================== --}}
        <div class="main-content" id="mainContent">

            {{-- TOPBAR / NAVBAR --}}
            @include('layouts.partials.navbar')

            {{-- CONTENU DES PAGES --}}
            <div class="content-wrapper">
                @yield('content')
            </div>

        </div>

    </div>


    {{-- =========================================================
         JAVASCRIPT
    ========================================================== --}}

    {{-- Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Admin JS --}}
    <script src="{{ asset('assets/js/admin.js') }}"></script>

    {{-- iziToast --}}
    <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>


    {{-- =========================================================
         PWA
    ========================================================== --}}
    <script>
        let deferredPrompt;

        if ('serviceWorker' in navigator) {

            window.addEventListener('load', function() {

                navigator.serviceWorker.register('/sw.js')
                    .then(reg => {
                        console.log('SW enregistré:', reg.scope);
                    })
                    .catch(err => {
                        console.log('SW erreur:', err);
                    });

            });
        }

        window.addEventListener('beforeinstallprompt', (e) => {

            e.preventDefault();

            deferredPrompt = e;

            document
                .getElementById('pwa-install-btn')
                ?.classList.remove('d-none');

        });

        window.addEventListener('appinstalled', () => {

            document
                .getElementById('pwa-install-btn')
                ?.classList.add('d-none');

            deferredPrompt = null;

        });

        function installPWA() {

            if (deferredPrompt) {

                deferredPrompt.prompt();

                deferredPrompt.userChoice.then(() => {
                    deferredPrompt = null;
                });

            }

        }
    </script>


    {{-- =========================================================
         IZITOAST
    ========================================================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            if (typeof iziToast === 'undefined') {
                return;
            }

            iziToast.settings({
                position: 'topRight',
                timeout: 5500,
                progressBar: true,
                close: true,
                transitionIn: 'fadeInDown',
                transitionOut: 'fadeOutUp',
                zindex: 99999,
            });


            @if (session('success'))
                iziToast.success({
                    title: 'Succès',
                    message: @json(session('success'))
                });
            @endif


            @if (session('error'))
                iziToast.error({
                    title: 'Erreur',
                    message: @json(session('error'))
                });
            @endif


            @if (session('warning'))
                iziToast.warning({
                    title: 'Attention',
                    message: @json(session('warning'))
                });
            @endif


            @if (session('info'))
                iziToast.info({
                    title: 'Information',
                    message: @json(session('info'))
                });
            @endif


            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    iziToast.error({
                        title: 'Validation',
                        message: @json($error)
                    });
                @endforeach
            @endif

        });
    </script>


    {{-- =========================================================
         CMLINK — HEARTBEAT UTILISATEUR
    ========================================================== --}}
    @auth
        <script>
            (() => {

                const heartbeatUrl = @json(route('heartbeat'));

                const sendHeartbeat = async () => {

                    try {

                        await fetch(heartbeatUrl, {
                            method: 'POST',

                            headers: {
                                'X-CSRF-TOKEN': document
                                    .querySelector(
                                        'meta[name="csrf-token"]'
                                    )
                                    ?.getAttribute('content'),

                                'Accept': 'application/json',

                                'Content-Type': 'application/json',
                            },

                            credentials: 'same-origin',

                            body: JSON.stringify({})
                        });

                    } catch (error) {

                        console.warn(
                            'Heartbeat CMLINK impossible :',
                            error
                        );

                    }

                };


                // Premier signal immédiatement
                sendHeartbeat();


                // Nouveau signal toutes les 30 secondes
                setInterval(
                    sendHeartbeat,
                    30000
                );

            })();
        </script>
    @endauth


    {{-- =========================================================
         SCRIPTS DES PAGES
    ========================================================== --}}
    @stack('scripts')

</body>

</html>
