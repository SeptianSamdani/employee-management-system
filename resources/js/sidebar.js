document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebar');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('sidebar-collapsed');
        sidebar.classList.toggle('sidebar-expanded');

        // Simpan state ke localStorage
        const isExpanded = sidebar.classList.contains('sidebar-expanded');
        localStorage.setItem('sidebarExpanded', isExpanded);
    });

    // Load saved state
    const savedState = localStorage.getItem('sidebarExpanded');
    if (savedState !== null) {
        if (savedState === 'true') {
            sidebar.classList.add('sidebar-expanded');
        } else {
            sidebar.classList.add('sidebar-collapsed');
        }
    } else {
        // Default: expanded desktop, collapsed mobile
        if (window.innerWidth < 768) {
            sidebar.classList.add('sidebar-collapsed');
        } else {
            sidebar.classList.add('sidebar-expanded');
        }
    }
});
