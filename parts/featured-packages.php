 <?php
$bg_color_above = '#F5F0E8';
$bg_color_below = '#141414';
?>

<!-- Top rolling hills divider -->
<div style="background: <?php echo $bg_color_above; ?>; line-height: 0; margin-bottom: -1px;">
    <svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="display:block; width:100%;">
        <path d="M0,60 L0,38 C120,18 240,52 400,32 C560,12 680,48 840,28 C1000,8 1160,44 1320,24 L1440,18 L1440,60 Z" fill="#0f5a43"/>
    </svg>
</div>

<section class="packages-section" id="section-packages">
    <div class="packages-container">

        <header class="pkg-section-header">
            <div class="pkg-eyebrow-wrap">
                <span class="pkg-eyebrow-line"></span>
                <h4 class="pkg-subtitle"><?php echo esc_html( get_theme_mod( 'desire_pkgs_subtitle', 'EXPLORE NEPAL' ) ); ?></h4>
                <span class="pkg-eyebrow-line"></span>
            </div>
            <h2 class="pkg-main-title"><?php echo esc_html( get_theme_mod( 'desire_pkgs_title', 'Our Featured Packages' ) ); ?></h2>
        </header>

        <?php
        $has_packages = false;
        for ( $i = 1; $i <= 10; $i++ ) {
            if ( get_theme_mod( "desire_pkg_id_{$i}" ) ) {
                $has_packages = true;
                break;
            }
        }
        ?>

        <?php if ( $has_packages ) : ?>
        <div class="packages-grid">
            <?php
            for ( $i = 1; $i <= 10; $i++ ) :
                $selected_id = get_theme_mod( "desire_pkg_id_{$i}" );
                if ( ! empty( $selected_id ) ) :
                    $trip_post = get_post( $selected_id );
                    if ( $trip_post && $trip_post->post_status === 'publish' ) :
                        $link     = get_permalink( $selected_id ) ?: home_url( '/trips' );
                        $image    = get_the_post_thumbnail_url( $selected_id, 'medium_large' ) ?: get_template_directory_uri() . '/images/trip-placeholder.webp';
                        $regular_price = get_post_meta( $selected_id, '_trip_price', true );
                        $sale_price    = get_post_meta( $selected_id, '_trip_sale_price', true );
                        $price         = $sale_price ?: ( $regular_price ?: 'Price TBA' );
                        $duration = get_post_meta( $selected_id, '_trip_duration', true ) ?: 'Duration TBA';
                        ?>
                        <div class="pkg-card">
                            <a href="<?php echo esc_url( $link ); ?>">
                                <div class="pkg-thumb" style="background-image: url('<?php echo esc_url( $image ); ?>');">
                                    <?php echo desire_get_trip_badges( $selected_id, 'trip-badge--card trip-badge--small' ); ?>
                                    <div class="pkg-thumb-overlay"></div>
                                </div>
                                <div class="pkg-content">
                                    <span class="pkg-days">
                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                        <?php echo esc_html( $duration ); ?>
                                    </span>
                                    <h3 class="pkg-card-title"><?php echo esc_html( $trip_post->post_title ); ?></h3>
                                    <div class="pkg-footer">
                                        <span class="price-value"><?php echo esc_html( $price ); ?></span>
                                        <span class="pkg-arrow">→</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endif;
                endif;
            endfor; ?>
        </div>

        <?php else : ?>
            <p class="no-trips-message" style="color:rgba(255,255,255,0.5);">No packages selected yet. Go to Appearance → Customize → Featured Packages to add trips.</p>
        <?php endif; ?>

        <div class="view-all-container">
            <a href="<?php echo esc_url( get_theme_mod( 'desire_view_all_link', home_url( '/trips' ) ) ); ?>" class="btn-view-all">
                <?php echo esc_html( get_theme_mod( 'desire_view_all_text', 'VIEW ALL TREKS' ) ); ?>
            </a>
        </div>

    </div>
</section>

<!-- Bottom rolling hills divider -->
<div style="background: <?php echo $bg_color_below; ?>; line-height: 0; margin-top: -1px;">
    <svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="display:block; width:100%;">
        <path d="M0,0 L0,28 C120,48 240,14 400,34 C560,54 680,18 840,38 C1000,58 1160,22 1320,42 L1440,36 L1440,0 Z" fill="#0f5a43"/>
    </svg>
</div>