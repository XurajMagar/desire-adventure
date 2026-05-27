<?php
$pattern_url = content_url( 'uploads/2026/05/doodle-art.webp' );
?>

<section class="region-slider-section" id="section-regions">
    <div class="rs-bg-pattern" style="background-image: url('<?php echo esc_url( $pattern_url ); ?>');"></div>
    <div class="rs-choose-text">CHOOSE</div>

    <div class="section-intro" style="position: relative; z-index: 2;">
        <span class="eyebrow"><?php echo esc_html( get_theme_mod( 'desire_region_eyebrow', 'Explore Nepal' ) ); ?></span>
        <h2><?php echo esc_html( get_theme_mod( 'desire_region_title', 'Find Your Region' ) ); ?></h2>
    </div>

    <div class="rs-track-wrap" style="position: relative; z-index: 2;">
        <div class="rs-track" id="rsTrack">
            <?php
            $regions = get_terms( array( 'taxonomy' => 'region', 'hide_empty' => true ) );
            if ( ! empty( $regions ) && ! is_wp_error( $regions ) ) :
                foreach ( $regions as $region ) :
                    $image_url = '';
                    if ( function_exists( 'z_taxonomy_image_url' ) ) {
                        $image_url = z_taxonomy_image_url( $region->term_id, 'full', true );
                    }
                    if ( empty( $image_url ) ) {
                        $image_url = get_template_directory_uri() . '/images/region-placeholder.webp';
                    }
                    $region_url = get_term_link( $region );
                    $region_url = ! is_wp_error( $region_url ) ? $region_url : '#';
                    ?>
                    <div class="rs-slide" data-url="<?php echo esc_url( $region_url ); ?>">
                        <div class="rs-slide-bg" style="background-image: url('<?php echo esc_url( $image_url ); ?>')"></div>
                        <div class="rs-overlay">
                            <?php if ( ! empty( $region->description ) ) : ?>
                                <span class="rs-subtitle"><?php echo esc_html( $region->description ); ?></span>
                            <?php endif; ?>
                            <h3 class="rs-name"><?php echo esc_html( $region->name ); ?></h3>
                        </div>
                    </div>
                <?php endforeach;
            endif; ?>
        </div>
    </div>

    <div class="rs-nav" style="position: relative; z-index: 2;">
        <button class="rs-btn" id="rsPrev" aria-label="Previous region">&#8249;</button>
        <button class="rs-btn" id="rsNext" aria-label="Next region">&#8250;</button>
    </div>

</section>