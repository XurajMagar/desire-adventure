<section class="featured-trips" id="section-trips">
    <div class="container">
        <div class="section-intro">
            <span class="eyebrow"><?php echo esc_html( get_theme_mod( 'desire_trips_eyebrow', 'Expert-Led Expeditions' ) ); ?></span>
            <h2><?php echo esc_html( get_theme_mod( 'desire_trips_title', 'Our Featured Adventures' ) ); ?></h2>
            <p><?php echo esc_html( get_theme_mod( 'desire_trips_desc', 'Hand-picked trekking experiences designed for the modern explorer.' ) ); ?></p>
        </div>

        <div class="trip-grid">
            <?php
            $args = array(
                'post_type'      => 'trips',
                'posts_per_page' => 3,
                'category_name'  => 'featured', 
            );
            
            $trip_query = new WP_Query( $args );

            if ( $trip_query->have_posts() ) :
                while ( $trip_query->have_posts() ) : $trip_query->the_post();

                    // Thumbnail with fallback
                    $thumb_url = get_the_post_thumbnail_url() 
                        ?: get_template_directory_uri() . '/images/trip-placeholder.webp';
                ?>
                    
                    <div class="trip-card">
                        <div class="trip-image" style="background-image: url('<?php echo esc_url( $thumb_url ); ?>');">
                            <div class="trip-tags-container">
                                <?php 
                                $categories = get_the_category();
                                if ( ! empty( $categories ) ) {
                                    foreach ( array_slice( $categories, 0, 3 ) as $cat ) {
                                        $icon = 'dashicons-tag'; 
                                        if ( strtolower( $cat->name ) == 'bestseller' ) $icon = 'dashicons-star-filled';
                                        if ( strtolower( $cat->name ) == 'remote' )     $icon = 'dashicons-location';
                                        
                                        echo '<span class="trip-tag"><span class="dashicons ' . esc_attr( $icon ) . '"></span> ' . esc_html( $cat->name ) . '</span>';
                                    }
                                }
                                ?>
                            </div>
                            <?php echo desire_get_trip_badges( $post->ID, 'trip-badge--card' ); ?>
                        </div>

                        <div class="trip-details">
                            <h3><?php the_title(); ?></h3>
                            
                            <div class="trip-meta-info">
                                <span class="trip-price">
                                    <strong><?php echo esc_html( get_post_meta( get_the_ID(), '_trip_price', true ) ?: 'Price TBA' ); ?></strong>
                                </span>
                                <span class="trip-divider">|</span>
                                <span class="trip-days">
                                    <?php echo esc_html( get_post_meta( get_the_ID(), '_trip_duration', true ) ?: 'Duration TBA' ); ?>
                                </span>
                            </div>

                            <a href="<?php the_permalink(); ?>" class="btn-text">View Full Itinerary →</a>
                        </div>
                    </div>

                <?php endwhile;
                wp_reset_postdata();
            else :
                echo '<p class="no-trips-message">No featured adventures found. Add trips to the "featured" category to see them here!</p>';
            endif; 
            ?>
        </div>
    </div>
</section>