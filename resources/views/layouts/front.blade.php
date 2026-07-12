<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cmlink')</title>

    <meta name="ngrok-skip-browser-warning" content="true">


    <link rel="icon" type="image/x-icon" href="{{ asset('favicon/favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}">



    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    {{-- iziToast --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">



    {{-- CSS Front --}}
    <link rel="stylesheet"
        href="{{ asset('assets/css/front.css') }}?v={{ filemtime(public_path('assets/css/front.css')) }}">
    <link rel="stylesheet"
        href="{{ asset('assets/css/front-header.css') }}?v={{ filemtime(public_path('assets/css/front-header.css')) }}">
</head>

<body>
    @yield('content')

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- iziToast --}}
    <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            /*
            |--------------------------------------------------------------------------
            | Header mobile
            |--------------------------------------------------------------------------
            */

            const header = document.querySelector('.front-header');
            const menuToggle = document.getElementById('frontMenuToggle');
            const navLinks = document.getElementById('frontNavLinks');
            const dropdown = document.querySelector('.nav-dropdown');
            const dropdownBtn = document.querySelector('.nav-dropdown-btn');

            function closeMenu() {
                if (navLinks) {
                    navLinks.classList.remove('show');
                }

                if (menuToggle) {
                    menuToggle.setAttribute('aria-expanded', 'false');
                }
            }

            function closeDropdown() {
                if (dropdown) {
                    dropdown.classList.remove('open');
                }

                if (dropdownBtn) {
                    dropdownBtn.setAttribute('aria-expanded', 'false');
                }
            }

            window.addEventListener('scroll', function() {
                if (!header) return;

                header.classList.toggle('scrolled', window.scrollY > 10);
            });

            if (menuToggle && navLinks) {
                menuToggle.addEventListener('click', function() {
                    const isOpen = navLinks.classList.toggle('show');

                    menuToggle.setAttribute('aria-expanded', String(isOpen));

                    if (!isOpen) {
                        closeDropdown();
                    }
                });
            }

            if (dropdownBtn && dropdown) {
                dropdownBtn.addEventListener('click', function(event) {
                    if (window.innerWidth > 768) return;

                    event.preventDefault();

                    const isOpen = dropdown.classList.toggle('open');

                    dropdownBtn.setAttribute('aria-expanded', String(isOpen));
                });
            }

            document.addEventListener('click', function(event) {
                if (!header) return;

                if (!header.contains(event.target)) {
                    closeMenu();
                    closeDropdown();
                }
            });

            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    closeMenu();
                    closeDropdown();
                }
            });

            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeMenu();
                    closeDropdown();
                }
            });

            /*
            |--------------------------------------------------------------------------
            | iziToast notifications
            |--------------------------------------------------------------------------
            */

            if (typeof iziToast !== 'undefined') {
                iziToast.settings({
                    position: 'topRight',
                    timeout: 5000,
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
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
