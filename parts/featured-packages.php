<section class="packages-section light-theme" id="section-packages">
    <div class="packages-container">
        <header class="section-header">
            <h4 class="pkg-subtitle"><?php echo esc_html( get_theme_mod( 'desire_pkgs_subtitle', 'EXPLORE NEPAL' ) ); ?></h4>
            <h2 class="pkg-main-title"><?php echo esc_html( get_theme_mod( 'desire_pkgs_title', 'Our Featured Packages' ) ); ?></h2>
        </header>

        <?php
        // Check if any package slots have been filled
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
                        // Safe permalink with fallback
                        $link = get_permalink( $selected_id ) ?: home_url( '/trips' );

                        // Thumbnail with local fallback
                        $image = get_the_post_thumbnail_url( $selected_id, 'medium_large' )
                            ?: get_template_directory_uri() . '/images/trip-placeholder.webp';
                        
                        $price    = get_post_meta( $selected_id, '_trip_price', true )    ?: 'Price TBA';
                        $duration = get_post_meta( $selected_id, '_trip_duration', true ) ?: 'Duration TBA';
                        ?>
                        <div class="pkg-card">
                            <a href="<?php echo esc_url( $link ); ?>">
                                    <div class="pkg-thumb" style="background-image: url('<?php echo esc_url( $image ); ?>');">
                                        <?php echo desire_get_trip_badges( $selected_id, 'trip-badge--card trip-badge--small' ); ?>
                                    </div>
                                <div class="pkg-content">
                                    <span class="pkg-days">
                                        <i class="far fa-calendar-alt"></i> 
                                        <?php echo esc_html( $duration ); ?>
                                    </span>
                                    <h3 class="pkg-card-title"><?php echo esc_html( $trip_post->post_title ); ?></h3>
                                    <div class="pkg-footer">
                                        <span class="price-value"><?php echo esc_html( $price ); ?></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endif; 
                endif;
            endfor; ?>
        </div><!-- .packages-grid -->

        <?php else : ?>
            <p class="no-trips-message">No packages selected yet. Go to Appearance → Customize → Featured Packages to add trips.</p>
        <?php endif; ?>

        <div class="view-all-container">
            <a href="<?php echo esc_url( get_theme_mod( 'desire_view_all_link', home_url( '/trips' ) ) ); ?>" class="btn-view-all">
                <?php echo esc_html( get_theme_mod( 'desire_view_all_text', 'VIEW ALL TREKS' ) ); ?>
            </a>
        </div>
    </div><!-- .packages-container -->
</section>