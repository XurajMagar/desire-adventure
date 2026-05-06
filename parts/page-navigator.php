<?php
// Only show on the homepage
if ( ! is_front_page() ) return;
?>

<div class="page-nav-floater" id="pageNavFloater">

    <!-- The Popup Menu -->
    <div class="page-nav-popup" id="pageNavPopup" role="navigation" aria-label="Page sections">
        <p class="page-nav-label">Jump to section</p>

        <a class="page-nav-item" href="#section-hero" data-section="section-hero">
            <span class="page-nav-dot"></span>
            <span class="page-nav-name">Top</span>
            <span class="page-nav-num">01</span>
        </a>

        <?php if ( get_theme_mod('desire_trips_title') || true ) : ?>
        <a class="page-nav-item" href="#section-trips" data-section="section-trips">
            <span class="page-nav-dot"></span>
            <span class="page-nav-name">Featured Trips</span>
            <span class="page-nav-num">02</span>
        </a>
        <?php endif; ?>

        <a class="page-nav-item" href="#section-regions" data-section="section-regions">
            <span class="page-nav-dot"></span>
            <span class="page-nav-name">Regions</span>
            <span class="page-nav-num">03</span>
        </a>

        <a class="page-nav-item" href="#section-why" data-section="section-why">
            <span class="page-nav-dot"></span>
            <span class="page-nav-name">Why Choose Us</span>
            <span class="page-nav-num">04</span>
        </a>

        <a class="page-nav-item" href="#section-packages" data-section="section-packages">
            <span class="page-nav-dot"></span>
            <span class="page-nav-name">Packages</span>
            <span class="page-nav-num">05</span>
        </a>

        <div class="page-nav-divider"></div>

        <a class="page-nav-item" href="#section-reviews" data-section="section-reviews">
            <span class="page-nav-dot"></span>
            <span class="page-nav-name">Reviews</span>
            <span class="page-nav-num">06</span>
        </a>

        <a class="page-nav-item" href="#section-about" data-section="section-about">
            <span class="page-nav-dot"></span>
            <span class="page-nav-name">About Us</span>
            <span class="page-nav-num">07</span>
        </a>

        <a class="page-nav-item" href="#section-faq" data-section="section-faq">
            <span class="page-nav-dot"></span>
            <span class="page-nav-name">FAQ</span>
            <span class="page-nav-num">08</span>
        </a>

        <a class="page-nav-item" href="#section-blog" data-section="section-blog">
            <span class="page-nav-dot"></span>
            <span class="page-nav-name">Blog</span>
            <span class="page-nav-num">09</span>
        </a>

    </div>

    <!-- The Trigger Button -->
    <button class="page-nav-trigger" id="pageNavTrigger" aria-expanded="false" aria-controls="pageNavPopup">
        <div class="page-nav-icon">
            <svg class="icon-menu" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round">
                <line x1="3" y1="6" x2="21" y2="6"/>
                <line x1="3" y1="12" x2="21" y2="12"/>
                <line x1="3" y1="18" x2="21" y2="18"/>
            </svg>
            <svg class="icon-close" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round">
                <line x1="18" y1="6" x2="6" y2="18"/>
                <line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </div>
        <span class="page-nav-trigger-text">Navigate</span>
    </button>

</div>