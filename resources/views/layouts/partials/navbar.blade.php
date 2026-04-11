<nav class="navbar navbar-expand-lg bg-white border-bottom px-4 py-3 shadow-sm">
    <div class="d-flex align-items-center gap-3 w-100">
        <button class="btn btn-light border" id="toggleSidebar" type="button">
            <i class="bi bi-list fs-5"></i>
        </button>

        <div>
            <h5 class="mb-0 fw-bold">@yield('page_title', 'Tableau de bord administrateur')</h5>
            <small class="text-muted">@yield('page_subtitle', "Vue d'ensemble de la plateforme Cmlink")</small>
        </div>
    </div>
</nav>