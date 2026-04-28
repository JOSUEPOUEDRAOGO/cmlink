<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cmlink')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/front.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/front-header.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/front.css') }}">
</head>

<body>
    @yield('content')


    <script>
document.addEventListener('DOMContentLoaded', function () {
    const menuBtn = document.getElementById('frontMenuToggle');
    const navLinks = document.getElementById('frontNavLinks');
    const dropdownBtn = document.querySelector('.nav-dropdown-btn');

    if (menuBtn && navLinks) {
        menuBtn.addEventListener('click', function () {
            navLinks.classList.toggle('show');
        });
    }

    if (dropdownBtn) {
        dropdownBtn.addEventListener('click', function (e) {
            if (window.innerWidth <= 768) {
                e.preventDefault();
                dropdownBtn.closest('.nav-dropdown').classList.toggle('open');
            }
        });
    }
});
</script>
</body>

</html>
