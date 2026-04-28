document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('adminSidebar');
    const mainContent = document.getElementById('mainContent');
    const topToggleBtn = document.getElementById('toggleSidebar');
    const brandToggle = document.getElementById('sidebarToggle');

    function toggleSidebar() {
        if (!sidebar) return;

        if (window.innerWidth <= 992) {
            sidebar.classList.toggle('show');
        } else {
            sidebar.classList.toggle('collapsed');

            if (mainContent) {
                mainContent.classList.toggle('expanded');
            }
        }
    }

    if (topToggleBtn) {
        topToggleBtn.addEventListener('click', function (e) {
            e.preventDefault();
            toggleSidebar();
        });
    }

    if (brandToggle) {
        brandToggle.addEventListener('click', function (e) {
            e.preventDefault();
            toggleSidebar();
        });
    }

    document.querySelectorAll('.sidebar-dropdown-toggle').forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            const dropdown = button.closest('.sidebar-dropdown');

            if (dropdown) {
                dropdown.classList.toggle('open');
            }
        });
    });
});