document.addEventListener('DOMContentLoaded', function() {

    // ============================================
    // 1. MOBILE MENU TOGGLE (old — keep for safety)
    // ============================================
    const toggle = document.querySelector('.menu-toggle');
    const menu = document.querySelector('.nav-menu');

    if (toggle && menu) {
        toggle.addEventListener('click', function() {
            menu.classList.toggle('is-active');
            toggle.classList.toggle('open');
            const isExpanded = menu.classList.contains('is-active');
            toggle.setAttribute('aria-expanded', isExpanded);
        });
    }

    // ============================================
    // 2. REGION SLIDER (Swiper)
    // ============================================
    if (document.querySelector('.regionSwiper') && typeof Swiper !== 'undefined') {
        new Swiper('.regionSwiper', {
            effect: 'coverflow',
            centeredSlides: true,
            loop: true,
            coverflowEffect: {
                rotate: 0,
                stretch: 80,
                depth: 200,
                modifier: 1,
                slideShadows: false,
            },
            breakpoints: {
                320: {
                    slidesPerView: 1.2,
                    coverflowEffect: { stretch: 10 }
                },
                768: {
                    slidesPerView: 'auto',
                    coverflowEffect: { stretch: 100 }
                },
                1200: {
                    slidesPerView: 'auto',
                    coverflowEffect: { stretch: 250 }
                }
            },
            navigation: {
                nextEl: '.swiper-button-next-custom',
                prevEl: '.swiper-button-prev-custom',
            }
        });
    }

    // ============================================
    // 3. NEW NAVIGATION — Drawer + Dropdown
    // ============================================
    var hamburger = document.getElementById('navHamburger');
    var drawer = document.getElementById('navDrawer');
    var overlay = document.getElementById('navOverlay');
    var closeBtn = document.getElementById('navDrawerClose');
    var header = document.getElementById('siteHeader');

    function openDrawer() {
        if (!drawer) return;
        drawer.classList.add('is-open');
        if (overlay) overlay.classList.add('is-open');
        if (hamburger) hamburger.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }

    function closeDrawer() {
        if (!drawer) return;
        drawer.classList.remove('is-open');
        if (overlay) overlay.classList.remove('is-open');
        if (hamburger) hamburger.classList.remove('is-open');
        document.body.style.overflow = '';
    }

    if (hamburger) hamburger.addEventListener('click', openDrawer);
    if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
    if (overlay) overlay.addEventListener('click', closeDrawer);

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDrawer();
    });

    // Mobile submenu accordion
    var drawerParents = document.querySelectorAll(
        '.nav-drawer-menu .menu-item-has-children > a'
    );

    drawerParents.forEach(function(link) {
        link.addEventListener('click', function(e) {
            var parent = this.parentElement;
            var isOpen = parent.classList.contains('is-open');

            // Close all others
            document.querySelectorAll(
                '.nav-drawer-menu .menu-item-has-children'
            ).forEach(function(item) {
                item.classList.remove('is-open');
            });

            // Toggle clicked one
            if (!isOpen) {
                parent.classList.add('is-open');
                e.preventDefault();
            }
        });
    });

    // Scrolled header shadow
    if (header) {
        window.addEventListener('scroll', function() {
            header.classList.toggle('is-scrolled', window.scrollY > 50);
        }, { passive: true });
    }

});