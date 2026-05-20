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
            slideToClickedSlide: true,
            coverflowEffect: {
                rotate: 0,
                stretch: 80,
                depth: 200,
                modifier: 1,
                slideShadows: false,
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                    coverflowEffect: { stretch: 0, depth: 0, modifier: 0 }
                },
                480: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                    coverflowEffect: { stretch: 0, depth: 0, modifier: 0 }
                },
                640: {
                    slidesPerView: 1.8,
                    spaceBetween: 0,
                    coverflowEffect: { stretch: 60, depth: 150, modifier: 1 }
                },
                768: {
                    slidesPerView: 1.8,
                    spaceBetween: 0,
                    coverflowEffect: { stretch: 80, depth: 180, modifier: 1 }
                },
                992: {
                    slidesPerView: 'auto',
                    spaceBetween: 0,
                    coverflowEffect: { stretch: 150, depth: 200, modifier: 1 }
                },
                1200: {
                    slidesPerView: 'auto',
                    spaceBetween: 0,
                    coverflowEffect: { stretch: 250, depth: 200, modifier: 1 }
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
    if (hamburger) {
        hamburger.addEventListener('click', function() {
            if (drawer.classList.contains('is-open')) {
                closeDrawer();
            } else {
                openDrawer();
                setTimeout(initMobileAccordion, 150);
            }
        });
    }

    if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
    if (overlay) overlay.addEventListener('click', closeDrawer);

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDrawer();
    });

    // ============================================
    // MOBILE SUBMENU ACCORDION
    // ============================================
    var accordionReady = false;

    function initMobileAccordion() {
        if (accordionReady) return; // Only run once
        accordionReady = true;

        var allParents = document.querySelectorAll('#navDrawer .menu-item-has-children');

        allParents.forEach(function(parent) {
            var link = parent.querySelector(':scope > a');
            if (!link) return;

            // Add arrow only if not already added
            if (!link.querySelector('.mob-arrow')) {
                var arrow = document.createElement('span');
                arrow.className = 'mob-arrow';
                arrow.textContent = '›';
                arrow.style.cssText = 'margin-left:auto;transition:transform 0.3s;display:inline-block;color:#C17F3A;font-size:18px;padding-left:8px;flex-shrink:0;';
                link.style.display = 'flex';
                link.style.justifyContent = 'space-between';
                link.style.alignItems = 'center';
                link.appendChild(arrow);
            }

            link.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                var submenu = parent.querySelector(':scope > .sub-menu');
                if (!submenu) return;

                var isOpen = parent.classList.contains('mob-open');

                // Close siblings at same level
                var siblings = parent.parentElement.querySelectorAll(':scope > .menu-item-has-children');
                siblings.forEach(function(sib) {
                    if (sib !== parent) {
                        sib.classList.remove('mob-open');
                        var sibSub = sib.querySelector(':scope > .sub-menu');
                        if (sibSub) sibSub.style.maxHeight = '0';
                        var sibArrow = sib.querySelector(':scope > a .mob-arrow');
                        if (sibArrow) sibArrow.style.transform = 'rotate(0deg)';
                    }
                });

                // Toggle current
                if (isOpen) {
                    parent.classList.remove('mob-open');
                    submenu.style.maxHeight = '0';
                    link.querySelector('.mob-arrow').style.transform = 'rotate(0deg)';
                } else {
                    parent.classList.add('mob-open');
                    submenu.style.maxHeight = submenu.scrollHeight + 500 + 'px';
                    link.querySelector('.mob-arrow').style.transform = 'rotate(90deg)';
                }
            });
        });
    }

    // Single hamburger click handler
    // Also run on load in case drawer is already open
    initMobileAccordion();
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
    // ============================================
    // GLASS PILL HOVER HEADER
    // ============================================
    var pillWrap = document.getElementById('headerPillWrap');
    var glassPill = document.getElementById('headerGlassPill');

    if (pillWrap && header) {
        // Show header on pill hover
        glassPill.addEventListener('mouseenter', function() {
            header.classList.add('is-revealed');
            pillWrap.classList.add('is-hidden');
        });

        // Hide header when mouse leaves header
        header.addEventListener('mouseleave', function() {
            header.classList.remove('is-revealed');
            pillWrap.classList.remove('is-hidden');
        });

        // Keep header visible when mouse moves from pill to header
        header.addEventListener('mouseenter', function() {
            header.classList.add('is-revealed');
            pillWrap.classList.add('is-hidden');
        });
    }

    // Scrolled header shadow

});