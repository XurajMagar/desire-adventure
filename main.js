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
    // ============================================
    // TABLE OF CONTENTS — Auto-build from headings
    // ============================================
    var postContent = document.getElementById('postContent');
    var tocNav = document.getElementById('postTocNav');
    var tocNavMobile = document.getElementById('postTocNavMobile');
    var tocMobile = document.getElementById('postTocMobile');
    var tocToggle = document.getElementById('postTocToggle');

    if (postContent && tocNav) {
        var headings = postContent.querySelectorAll('h2, h3');

        if (headings.length > 0) {

            // Build TOC links
            headings.forEach(function(heading, i) {
                // Add ID to heading if missing
                if (!heading.id) {
                    heading.id = 'toc-' + i + '-' + heading.textContent
                        .toLowerCase()
                        .replace(/[^a-z0-9]+/g, '-')
                        .replace(/^-|-$/g, '');
                }

                var link = document.createElement('a');
                link.href = '#' + heading.id;
                link.textContent = heading.textContent;
                link.className = heading.tagName === 'H3' ? 'toc-h3' : '';

                // Smooth scroll
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    var target = document.getElementById(this.getAttribute('href').slice(1));
                    if (target) {
                        var offset = 100;
                        var top = target.getBoundingClientRect().top + window.scrollY - offset;
                        window.scrollTo({ top: top, behavior: 'smooth' });
                    }
                });

                tocNav.appendChild(link);

                // Also add to mobile TOC
                if (tocNavMobile) {
                    var linkMobile = link.cloneNode(true);
                    linkMobile.addEventListener('click', function(e) {
                        e.preventDefault();
                        var target = document.getElementById(this.getAttribute('href').slice(1));
                        if (target) {
                            var offset = 100;
                            var top = target.getBoundingClientRect().top + window.scrollY - offset;
                            window.scrollTo({ top: top, behavior: 'smooth' });
                            // Close mobile TOC after clicking
                            if (tocMobile) tocMobile.classList.remove('is-open');
                        }
                    });
                    tocNavMobile.appendChild(linkMobile);
                }
            });

            // Active state on scroll
            var tocLinks = tocNav.querySelectorAll('a');
            window.addEventListener('scroll', function() {
                var scrollY = window.scrollY + 120;
                var current = '';

                headings.forEach(function(heading) {
                    if (heading.offsetTop <= scrollY) {
                        current = heading.id;
                    }
                });

                tocLinks.forEach(function(link) {
                    link.classList.toggle(
                        'is-active',
                        link.getAttribute('href') === '#' + current
                    );
                });
            }, { passive: true });

        } else {
            // No headings — hide TOC
            var tocSidebar = document.getElementById('postTocSidebar');
            var tocMobileEl = document.getElementById('postTocMobile');
            if (tocSidebar) tocSidebar.style.display = 'none';
            if (tocMobileEl) tocMobileEl.style.display = 'none';
        }
    }

    // Mobile TOC toggle
    if (tocToggle && tocMobile) {
        tocToggle.addEventListener('click', function() {
            tocMobile.classList.toggle('is-open');
        });
    }
    // Scrolled header shadow
    if (header) {
        window.addEventListener('scroll', function() {
            header.classList.toggle('is-scrolled', window.scrollY > 50);
        }, { passive: true });
    }

});