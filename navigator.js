document.addEventListener('DOMContentLoaded', function() {

    const floater = document.getElementById('pageNavFloater');
    const popup = document.getElementById('pageNavPopup');
    const trigger = document.getElementById('pageNavTrigger');
    const navItems = document.querySelectorAll('.page-nav-item');

    if (!floater || !popup || !trigger) return;

    // ============================================
    // 1. OPEN / CLOSE
    // ============================================
    function openNav() {
        popup.classList.add('is-open');
        trigger.classList.add('is-open');
        trigger.setAttribute('aria-expanded', 'true');
    }

    function closeNav() {
        popup.classList.remove('is-open');
        trigger.classList.remove('is-open');
        trigger.setAttribute('aria-expanded', 'false');
    }

    // ============================================
    // 2. DYNAMIC HEIGHT — prevents header overlap
    // ============================================
    function setPopupMaxHeight() {
        if (window.innerWidth > 1024) {
            popup.style.maxHeight = '';
            return;
        }

        const header = document.querySelector('.site-header');
        const headerHeight = header ? header.offsetHeight : 70;
        const triggerRect = trigger.getBoundingClientRect();
        const spaceAbove = triggerRect.top - headerHeight - 20;

        popup.style.maxHeight = Math.max(spaceAbove, 180) + 'px';
    }

    // ============================================
    // 3. TRIGGER CLICK
    // ============================================
    trigger.addEventListener('click', function(e) {
        e.stopPropagation();
        if (popup.classList.contains('is-open')) {
            closeNav();
        } else {
            setPopupMaxHeight();
            openNav();
        }
    });

    // Recalculate on resize
    window.addEventListener('resize', function() {
        if (popup.classList.contains('is-open')) {
            setPopupMaxHeight();
        }
    });

    // Close on outside click
    document.addEventListener('click', function(e) {
        if (!floater.contains(e.target)) closeNav();
    });

    // Close on Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeNav();
    });

    // ============================================
    // 4. SMOOTH SCROLL + CLOSE ON CLICK
    // ============================================
    navItems.forEach(function(item) {
        item.addEventListener('click', function(e) {
            e.preventDefault();

            const targetId = this.getAttribute('data-section');
            const target = document.getElementById(targetId);

            if (target) {
                const header = document.querySelector('.site-header');
                const headerHeight = header ? header.offsetHeight : 0;
                const targetTop = target.getBoundingClientRect().top +
                    window.pageYOffset -
                    headerHeight -
                    20;

                window.scrollTo({ top: targetTop, behavior: 'smooth' });
            }

            closeNav();
        });
    });

    // ============================================
    // 5. HIGHLIGHT ACTIVE SECTION ON SCROLL
    // ============================================
    const sections = document.querySelectorAll([
        '#section-hero',
        '#section-trips',
        '#section-regions',
        '#section-why',
        '#section-packages',
        '#section-reviews',
        '#section-about',
        '#section-faq',
        '#section-blog'
    ].join(','));

    function updateActiveSection() {
        const scrollPos = window.pageYOffset + window.innerHeight / 3;

        sections.forEach(function(section) {
            const top = section.offsetTop;
            const bottom = top + section.offsetHeight;
            const id = section.getAttribute('id');

            if (scrollPos >= top && scrollPos < bottom) {
                navItems.forEach(i => i.classList.remove('is-active'));
                const active = document.querySelector(
                    '.page-nav-item[data-section="' + id + '"]'
                );
                if (active) active.classList.add('is-active');
            }
        });
    }

    let scrollTimer;
    window.addEventListener('scroll', function() {
        if (scrollTimer) return;
        scrollTimer = setTimeout(function() {
            updateActiveSection();
            scrollTimer = null;
        }, 100);
    });

    updateActiveSection();

});