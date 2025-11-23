// public/js/sidebar.js

document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebar');
    const menuLinks = document.querySelectorAll('.menu-item');
    const topBar = document.getElementById('topLoadingBar');
    
    // Toggle Sidebar Function
    function toggleSidebar() {
        sidebar.classList.toggle('sidebar-collapsed');
        sidebar.classList.toggle('sidebar-expanded');
        
        // Save state to localStorage
        const isExpanded = sidebar.classList.contains('sidebar-expanded');
        localStorage.setItem('sidebarExpanded', isExpanded);
    }
    
    // Toggle Button Click
    if (toggleBtn) {
        toggleBtn.addEventListener('click', toggleSidebar);
    }
    
    // Load saved sidebar state
    function loadSidebarState() {
        const savedState = localStorage.getItem('sidebarExpanded');
        
        // Default to expanded on desktop, collapsed on mobile
        if (savedState !== null) {
            const isExpanded = savedState === 'true';
            if (isExpanded) {
                sidebar.classList.add('sidebar-expanded');
                sidebar.classList.remove('sidebar-collapsed');
            } else {
                sidebar.classList.add('sidebar-collapsed');
                sidebar.classList.remove('sidebar-expanded');
            }
        } else {
            // Auto collapse on mobile
            if (window.innerWidth < 768) {
                sidebar.classList.remove('sidebar-expanded');
                sidebar.classList.add('sidebar-collapsed');
            }
        }
    }
    
    // Loading bar animation for navigation
    function showLoadingBar() {
        topBar.style.width = '0%';
        topBar.classList.remove('complete');
        topBar.classList.add('loading');
        
        setTimeout(() => {
            topBar.classList.remove('loading');
            topBar.classList.add('complete');
            
            setTimeout(() => {
                topBar.classList.remove('complete');
                topBar.style.width = '0%';
            }, 300);
        }, 500);
    }
    
    // Add loading animation to all menu items
    menuLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            showLoadingBar();
        });
    });
    
    // Close sidebar on mobile when clicking outside
    document.addEventListener('click', function(event) {
        if (window.innerWidth < 768) {
            const isClickInsideSidebar = sidebar.contains(event.target);
            const isClickOnToggle = toggleBtn.contains(event.target);
            const isSidebarExpanded = sidebar.classList.contains('sidebar-expanded');
            
            if (!isClickInsideSidebar && !isClickOnToggle && isSidebarExpanded) {
                toggleSidebar();
            }
        }
    });
    
    // Handle window resize
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if (window.innerWidth >= 768) {
                // On desktop, load saved state
                loadSidebarState();
            } else {
                // On mobile, auto collapse
                if (sidebar.classList.contains('sidebar-expanded')) {
                    sidebar.classList.remove('sidebar-expanded');
                    sidebar.classList.add('sidebar-collapsed');
                }
            }
        }, 250);
    });
    
    // Initialize sidebar state
    loadSidebarState();
    
    // Livewire navigation support
    document.addEventListener('livewire:navigated', function() {
        showLoadingBar();
    });
});