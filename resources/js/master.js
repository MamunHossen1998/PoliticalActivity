document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.getElementById('sidebar');
    const toggleButton = document.getElementById('sidebarToggle');
    const backdrop = document.getElementById('sidebar-backdrop');
    const body = document.body;

    function toggleSidebar() {
        const isSidebarOpen = sidebar.classList.toggle('show-sidebar');
        body.style.overflowY = isSidebarOpen ? 'hidden' : 'auto';
    }

    if (toggleButton) {
        toggleButton.addEventListener('click', toggleSidebar);
    }

    if (backdrop) {
        backdrop.addEventListener('click', toggleSidebar);
    }

    if (sidebar) {
        sidebar.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 992) {
                    toggleSidebar();
                }
            });
        });
    }

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 992) {
            sidebar?.classList.remove('show-sidebar');
            body.style.overflowY = 'auto';
        }
    });
});

