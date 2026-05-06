<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<!-- Mobile Overlay -->
<div class="nav-overlay" id="navOverlay"></div>

<header class="site-header" id="siteHeader">
    <div class="header-container">

        <!-- Logo -->
        <div class="site-logo">
            <?php
            if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
                the_custom_logo();
            } else {
                echo '<a href="' . esc_url( home_url( '/' ) ) . '">'
                   . esc_html( get_bloginfo( 'name' ) ) . '</a>';
            }
            ?>
        </div>

        <!-- Desktop Navigation -->
        <nav class="main-nav" id="mainNav">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'container'      => false,
                'menu_id'        => 'primary-menu',
                'menu_class'     => 'nav-menu',
                'walker'         => new Desire_Nav_Walker(),
            ) );
            ?>
        </nav>

        <!-- Right Side -->
        <div class="header-right">
            <!-- WhatsApp -->
            <a href="https://wa.me/<?php echo esc_attr( preg_replace( '/\D+/', '', get_theme_mod( 'desire_whatsapp_number', '+9779851233710' ) ) ); ?>"
               class="header-wa-btn" target="_blank" rel="noopener noreferrer">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                </svg>
                <span><?php echo esc_html( get_theme_mod( 'desire_whatsapp_number', '+977 9851233710' ) ); ?></span>
            </a>

            <!-- Mobile Hamburger -->
            <button class="nav-hamburger" id="navHamburger" aria-label="Open menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>

    </div>
</header>

<!-- Mobile Drawer -->
<div class="nav-drawer" id="navDrawer">
    <div class="nav-drawer-header">
        <div class="nav-drawer-logo">
            <?php
            if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
                the_custom_logo();
            } else {
                echo '<a href="' . esc_url( home_url( '/' ) ) . '">'
                   . esc_html( get_bloginfo( 'name' ) ) . '</a>';
            }
            ?>
        </div>
        <button class="nav-drawer-close" id="navDrawerClose" aria-label="Close menu">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round">
                <line x1="18" y1="6" x2="6" y2="18"/>
                <line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
    </div>

    <div class="nav-drawer-body">
        <?php
        wp_nav_menu( array(
            'theme_location' => 'primary',
            'container'      => false,
            'menu_id'        => 'mobile-menu',
            'menu_class'     => 'nav-drawer-menu',
        ) );
        ?>
    </div>

    <div class="nav-drawer-footer">
        <a href="https://wa.me/<?php echo esc_attr( preg_replace( '/\D+/', '', get_theme_mod( 'desire_whatsapp_number', '+9779851233710' ) ) ); ?>"
           class="nav-drawer-wa" target="_blank" rel="noopener noreferrer">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
            </svg>
            <?php echo esc_html( get_theme_mod( 'desire_whatsapp_number', '+977 9851233710' ) ); ?>
        </a>
    </div>
</div>