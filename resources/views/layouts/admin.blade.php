<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Cmlink Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon/favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}">



    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
</head>

<body>

    @include('layouts.partials.sidebar')

    <div class="main-content" id="mainContent">
        @include('layouts.partials.navbar')

        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('assets/js/admin.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

</body>

</html>
