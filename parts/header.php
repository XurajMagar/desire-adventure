<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
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
<!-- Glass Pill Trigger -->
<div class="header-pill-wrap" id="headerPillWrap">
    <div class="header-glass-pill" id="headerGlassPill">
        <span class="hgp-line"></span>
        <span class="hgp-line"></span>
        <span class="hgp-line"></span>
    </div>
</div>

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
            <!-- WhatsApp help block -->
            <?php
                $wa_num    = get_theme_mod( 'desire_whatsapp_number', '+977 9761840434' );
                $wa_name   = get_theme_mod( 'desire_wa_name', '' );
                $wa_avatar = get_theme_mod( 'desire_wa_avatar' ) ? wp_get_attachment_url( get_theme_mod( 'desire_wa_avatar' ) ) : '';
                ?>
                <a href="https://wa.me/<?php echo esc_attr( preg_replace( '/\D+/', '', $wa_num ) ); ?>"
                class="header-wa-help" target="_blank" rel="noopener noreferrer">
                    <span class="header-wa-text">
                        <span class="header-wa-line1">Need help? Chat on WhatsApp</span>
                        <span class="header-wa-line2">
                            <?php echo esc_html( $wa_num ); ?><?php if ( $wa_name ) : ?> <span class="header-wa-name">(<?php echo esc_html( $wa_name ); ?>)</span><?php endif; ?>
                        </span>
                    </span>
                    <?php if ( $wa_avatar ) : ?>
                        <span class="header-wa-avatar"><img src="<?php echo esc_url( $wa_avatar ); ?>" alt="<?php echo esc_attr( $wa_name ?: 'WhatsApp' ); ?>" loading="lazy"></span>
                    <?php else : ?>
                        <span class="header-wa-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="#25D366"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg></span>
                    <?php endif; ?>
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