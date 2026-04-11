<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Cmlink Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
</head>
<body>

    @include('layouts.partials.sidebar')

    <div class="main-content" id="mainContent">
        @include('layouts.partials.navbar')

        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>

   <script>
document.addEventListener('DOMContentLoaded', function () {

    const sidebar = document.getElementById('adminSidebar');
    const mainContent = document.getElementById('mainContent');
    const toggleSidebarBtn = document.getElementById('toggleSidebar');

    if (!sidebar || !mainContent || !toggleSidebarBtn) {
        console.log('Un élément manque (sidebar, mainContent ou bouton)');
        return;
    }

    toggleSidebarBtn.addEventListener('click', function () {
        console.log('CLICK OK');

        if (window.innerWidth <= 992) {
            sidebar.classList.toggle('show');
        } else {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        }
    });

});
</script>

</body>
</html>
