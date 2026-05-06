<?php
$ft_about     = get_theme_mod( 'desire_ft_about', 'We guide passionate trekkers through the world\'s most breathtaking Himalayan landscapes. Every trail, every summit — experienced with heart.' );
$ft_tagline   = get_theme_mod( 'desire_ft_tagline', 'Nepal\'s Premier Trekking Agency' );
$ft_email     = get_theme_mod( 'desire_ft_email', 'info@desireadventure.com' );
$ft_phone     = get_theme_mod( 'desire_ft_phone', '+977 9851233710' );
$ft_address   = get_theme_mod( 'desire_ft_address', 'Thamel, Kathmandu, Nepal' );
$ft_fb        = get_theme_mod( 'desire_ft_facebook', '#' );
$ft_ig        = get_theme_mod( 'desire_ft_instagram', '#' );
$ft_yt        = get_theme_mod( 'desire_ft_youtube', '#' );
$ft_tk        = get_theme_mod( 'desire_ft_tiktok', '#' );
$ft_privacy   = get_theme_mod( 'desire_ft_privacy_url', '#' );
$ft_terms     = get_theme_mod( 'desire_ft_terms_url', '#' );
$ft_copyright = get_theme_mod( 'desire_ft_copyright', '© ' . date('Y') . ' Desire Adventure. All rights reserved.' );
?>

<footer class="site-footer">
    <div class="ft-main">

        <!-- Column 1: Logo + About + Social -->
        <div class="ft-col ft-col-brand">
            <div class="ft-logo-wrap">
                <?php if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) :
                    the_custom_logo();
                else : ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="ft-logo-text">
                        <?php echo esc_html( get_bloginfo( 'name' ) ); ?>
                    </a>
                <?php endif; ?>
            </div>

            <?php if ( $ft_tagline ) : ?>
                <p class="ft-tagline"><?php echo esc_html( $ft_tagline ); ?></p>
            <?php endif; ?>

            <?php if ( $ft_about ) : ?>
                <p class="ft-about"><?php echo esc_html( $ft_about ); ?></p>
            <?php endif; ?>

            <!-- Social Icons -->
            <div class="ft-socials">
                <?php if ( $ft_fb && $ft_fb !== '#' ) : ?>
                <a href="<?php echo esc_url( $ft_fb ); ?>" target="_blank" rel="noopener noreferrer" class="ft-social-btn" aria-label="Facebook">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                </a>
                <?php endif; ?>

                <?php if ( $ft_ig && $ft_ig !== '#' ) : ?>
                <a href="<?php echo esc_url( $ft_ig ); ?>" target="_blank" rel="noopener noreferrer" class="ft-social-btn" aria-label="Instagram">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg>
                </a>
                <?php endif; ?>

                <?php if ( $ft_yt && $ft_yt !== '#' ) : ?>
                <a href="<?php echo esc_url( $ft_yt ); ?>" target="_blank" rel="noopener noreferrer" class="ft-social-btn" aria-label="YouTube">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 0 0-1.95 1.96A29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58A2.78 2.78 0 0 0 3.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 0 0 1.95-1.95A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="#0d0d0d"/></svg>
                </a>
                <?php endif; ?>

                <?php if ( $ft_tk && $ft_tk !== '#' ) : ?>
                <a href="<?php echo esc_url( $ft_tk ); ?>" target="_blank" rel="noopener noreferrer" class="ft-social-btn" aria-label="TikTok">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.33-6.34V8.69a8.16 8.16 0 0 0 4.77 1.52V6.75a4.85 4.85 0 0 1-1-.06z"/></svg>
                </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Column 2: Quick Links -->
        <div class="ft-col">
            <h4 class="ft-col-title">Quick Links</h4>
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'ft-links',
                'depth'          => 1,
                'fallback_cb'    => function() {
                    // Fallback if no menu assigned
                    echo '<ul class="ft-links">';
                    echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">Home</a></li>';
                    echo '<li><a href="' . esc_url( home_url( '/about' ) ) . '">About Us</a></li>';
                    echo '<li><a href="' . esc_url( home_url( '/trips' ) ) . '">All Treks</a></li>';
                    echo '<li><a href="' . esc_url( home_url( '/blog' ) ) . '">Blog</a></li>';
                    echo '<li><a href="' . esc_url( home_url( '/contact' ) ) . '">Contact</a></li>';
                    echo '</ul>';
                },
            ) );
            ?>
        </div>

        <!-- Column 3: Popular Treks (latest 5 trip posts) -->
        <div class="ft-col">
            <h4 class="ft-col-title">Popular Treks</h4>
            <?php
            $footer_trips = get_posts( array(
                'post_type'      => 'trips',
                'posts_per_page' => 5,
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC',
            ) );

            if ( $footer_trips ) :
            ?>
            <ul class="ft-links">
                <?php foreach ( $footer_trips as $trip ) : ?>
                    <li>
                        <a href="<?php echo esc_url( get_permalink( $trip->ID ) ); ?>">
                            <?php echo esc_html( $trip->post_title ); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>

        <!-- Column 4: Contact -->
        <div class="ft-col">
            <h4 class="ft-col-title">Contact Us</h4>

            <?php if ( $ft_address ) : ?>
            <div class="ft-contact-item">
                <div class="ft-contact-icon">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                </div>
                <div class="ft-contact-text">
                    <strong>Address</strong>
                    <?php echo esc_html( $ft_address ); ?>
                </div>
            </div>
            <?php endif; ?>

            <?php if ( $ft_phone ) : ?>
            <div class="ft-contact-item">
                <div class="ft-contact-icon">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13 19.79 19.79 0 0 1 1.61 4.38 2 2 0 0 1 3.59 2.18h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.08 6.08l1.79-1.79a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                </div>
                <div class="ft-contact-text">
                    <strong>Phone / WhatsApp</strong>
                    <a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $ft_phone ) ); ?>">
                        <?php echo esc_html( $ft_phone ); ?>
                    </a>
                </div>
            </div>
            <?php endif; ?>

            <?php if ( $ft_email ) : ?>
            <div class="ft-contact-item">
                <div class="ft-contact-icon">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                </div>
                <div class="ft-contact-text">
                    <strong>Email</strong>
                    <a href="mailto:<?php echo esc_attr( $ft_email ); ?>">
                        <?php echo esc_html( $ft_email ); ?>
                    </a>
                </div>
            </div>
            <?php endif; ?>
        </div>

    </div>

    <!-- Divider -->
    <div class="ft-divider-line"></div>

    <!-- Bottom Bar -->
    <div class="ft-bottom">
        <p class="ft-copyright"><?php echo esc_html( $ft_copyright ); ?></p>
        <div class="ft-nepal-badge">
            <span>🇳🇵</span>
            <span>Local Travel Agency of Nepal</span>
        </div>
        <div class="ft-legal-links">
            <?php if ( $ft_privacy ) : ?>
                <a href="<?php echo esc_url( $ft_privacy ); ?>">Privacy Policy</a>
            <?php endif; ?>
            <?php if ( $ft_terms ) : ?>
                <a href="<?php echo esc_url( $ft_terms ); ?>">Terms of Service</a>
            <?php endif; ?>
        </div>
    </div>

</footer>

<?php wp_footer(); ?>
</body>
</html>