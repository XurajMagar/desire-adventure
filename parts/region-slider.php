<section class="region-slider-section" id="section-regions">
    <div class="container-fluid">
        <div class="section-intro">
            <span class="eyebrow"><?php echo esc_html( get_theme_mod( 'desire_region_eyebrow', 'Explore Nepal' ) ); ?></span>
            <h2><?php echo esc_html( get_theme_mod( 'desire_region_title', 'Find Your Region' ) ); ?></h2>
        </div>

        <div class="swiper regionSwiper">
            <div class="swiper-wrapper">
                <?php
                // Get all terms from the 'region' taxonomy
                $regions = get_terms(array(
                    'taxonomy' => 'region',
                    'hide_empty' => true,
                ));

                if (!empty($regions) && !is_wp_error($regions)) :
                    foreach ($regions as $region) : 
                            // Reset image URL for each loop iteration
                            $image_url = '';

                                if ( function_exists( 'z_taxonomy_image_url' ) ) {
                                    $image_url = z_taxonomy_image_url( $region->term_id, 'full', true );
                                }

                            // 2. Fallback: If no image is uploaded, use a high-res mountain shot
                            // This ensures your slider isn't empty while you are testing
                            if ( empty( $image_url ) ) {
                                $image_url = get_template_directory_uri() . '/images/region-placeholder.webp';
                            }
                        ?>
                    <div class="swiper-slide">
                        <?php 
                            $region_url = get_term_link( $region );
                            $region_url = ! is_wp_error( $region_url ) ? $region_url : '#';
                            ?>
                            <a href="<?php echo esc_url( $region_url ); ?>" class="region-card">
                            <!-- Add a fallback color and ensure the URL is printed -->
                            <div class="region-image" style="background-color: #333; background-image: url('<?php echo esc_url($image_url); ?>');">
                            </div>
                            
                            <div class="region-overlay">
                                <?php if ( ! empty( $region->description ) ) : ?>
                                    <span class="region-subtitle"><?php echo esc_html( $region->description ); ?></span>
                                <?php endif; ?>
                                <h3 class="region-title"><?php echo esc_html($region->name); ?></h3>
                            </div>
                        </a>
                    </div>
                <?php 
                    endforeach; 
                endif; 
                ?>
            </div>
            
            <!-- Custom Buttons styled like the screenshot -->
            <div class="slider-controls-wrapper">
                <div class="swiper-button-prev-custom">
                    <span>&#10094;</span> <!-- Universal Left Arrow -->
                </div>
                <div class="swiper-button-next-custom">
                    <span>&#10095;</span> <!-- Universal Right Arrow -->
                </div>
            </div>
        </div>
    </div>
</section>