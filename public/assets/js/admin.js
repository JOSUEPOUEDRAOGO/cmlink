document.addEventListener('DOMContentLoaded', function () {

    const sidebar = document.getElementById('adminSidebar');
    const topToggleBtn = document.getElementById('toggleSidebar');
    const brandToggle = document.getElementById('sidebarToggle');

    if (!sidebar) {
        return;
    }


    /* =====================================================
       TOGGLE SIDEBAR
       ===================================================== */

    function toggleSidebar() {

        /*
         * MOBILE
         */
        if (window.innerWidth <= 992) {

            sidebar.classList.toggle('show');

            return;
        }


        /*
         * DESKTOP
         */
        sidebar.classList.toggle('collapsed');


        const collapsed =
            sidebar.classList.contains('collapsed');


        localStorage.setItem(
            'cmlink_sidebar_collapsed',
            collapsed ? '1' : '0'
        );

    }


    /* =====================================================
       BOUTON TOPBAR
       ===================================================== */

    if (topToggleBtn) {

        topToggleBtn.addEventListener('click', function (event) {

            event.preventDefault();

            toggleSidebar();

        });

    }


    /* =====================================================
       LOGO SIDEBAR
       ===================================================== */

    if (brandToggle) {

        brandToggle.addEventListener('click', function (event) {

            event.preventDefault();

            toggleSidebar();

        });

    }


    /* =====================================================
       RESTAURER L'ÉTAT DESKTOP
       ===================================================== */

    if (window.innerWidth > 992) {

        const savedState =
            localStorage.getItem(
                'cmlink_sidebar_collapsed'
            );

        if (savedState === '1') {

            sidebar.classList.add('collapsed');

        }

    }


    /* =====================================================
       DROPDOWNS
       ===================================================== */

    document
        .querySelectorAll('.sidebar-dropdown-toggle')
        .forEach(function (button) {

            button.addEventListener('click', function (event) {

                event.preventDefault();
                event.stopPropagation();

                const dropdown =
                    button.closest('.sidebar-dropdown');


                if (!dropdown) {
                    return;
                }


                /*
                 * Si sidebar réduit :
                 * on le réouvre automatiquement.
                 */

                if (
                    window.innerWidth > 992 &&
                    sidebar.classList.contains('collapsed')
                ) {

                    sidebar.classList.remove('collapsed');

                    localStorage.setItem(
                        'cmlink_sidebar_collapsed',
                        '0'
                    );

                }


                dropdown.classList.toggle('open');

            });

        });


    /* =====================================================
       RESIZE
       ===================================================== */

    window.addEventListener('resize', function () {

        /*
         * Retour desktop
         */

        if (window.innerWidth > 992) {

            sidebar.classList.remove('show');


            const savedState =
                localStorage.getItem(
                    'cmlink_sidebar_collapsed'
                );


            if (savedState === '1') {

                sidebar.classList.add('collapsed');

            } else {

                sidebar.classList.remove('collapsed');

            }

        }


        /*
         * Passage mobile
         */

        else {

            sidebar.classList.remove('collapsed');

        }

    });

});
