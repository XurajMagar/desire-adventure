<?php
$bg_image = get_theme_mod( 'desire_trips_bg_image', '' );
?>

<section class="featured-trips" id="section-trips"
    <?php if ( $bg_image ) : ?>
    style="background-image: url('<?php echo esc_url( $bg_image ); ?>');"
    <?php endif; ?>>
    <div class="ft-word-grid" aria-hidden="true"></div>
    <div class="ft-overlay"></div>

    <div class="ft-inner">
        <div class="ft-section-intro">
            <span class="eyebrow"><?php echo esc_html( get_theme_mod( 'desire_trips_eyebrow', 'Expert-Led Expeditions' ) ); ?></span>
            <h2><?php echo esc_html( get_theme_mod( 'desire_trips_title', 'Our Featured Adventures' ) ); ?></h2>
            <p><?php echo esc_html( get_theme_mod( 'desire_trips_desc', 'Hand-picked trekking experiences designed for the modern explorer.' ) ); ?></p>
        </div>

        <?php
        $trip_query = new WP_Query( array(
            'post_type'      => 'trips',
            'posts_per_page' => 4,
            'category_name'  => 'featured',
        ) );

        if ( $trip_query->have_posts() ) :
            $trip_index = 0;
        ?>
        <div class="ft-magazine-grid">
            <?php while ( $trip_query->have_posts() ) : $trip_query->the_post();
                $thumb_url  = get_the_post_thumbnail_url() ?: get_template_directory_uri() . '/images/trip-placeholder.webp';
                $price      = get_post_meta( get_the_ID(), '_trip_price',      true ) ?: 'Contact Us';
                $duration   = get_post_meta( get_the_ID(), '_trip_duration',   true ) ?: '';
                $difficulty = get_post_meta( get_the_ID(), '_trip_difficulty', true ) ?: '';
                $is_big     = ( $trip_index === 0 );
            ?>
            <div class="ft-card <?php echo $is_big ? 'ft-card-big' : 'ft-card-small'; ?>">
                <a href="<?php the_permalink(); ?>" class="ft-card-inner"
                   style="background-image: url('<?php echo esc_url( $thumb_url ); ?>')">
                    <div class="ft-card-overlay"></div>
                    <?php echo desire_get_trip_badges( get_the_ID(), 'trip-badge--card' ); ?>
                    <div class="ft-card-content">
                        <?php if ( $difficulty ) : ?>
                        <span class="ft-card-tag"><?php echo esc_html( $difficulty ); ?></span>
                        <?php endif; ?>
                        <h3 class="ft-card-title"><?php the_title(); ?></h3>
                        <div class="ft-card-meta">
                            <span class="ft-card-price"><?php echo esc_html( $price ); ?></span>
                            <?php if ( $duration ) : ?>
                            <span class="ft-card-sep">·</span>
                            <span class="ft-card-duration"><?php echo esc_html( $duration ); ?></span>
                            <?php endif; ?>
                        </div>
                        <span class="ft-card-cta">View Itinerary →</span>
                    </div>
                </a>
            </div>
            <?php
                $trip_index++;
            endwhile;
            wp_reset_postdata();
            ?>
        </div>

        <?php else : ?>
        <p class="no-trips-message">No featured adventures found. Add trips to the "featured" category.</p>
        <?php endif; ?>
    </div>
</section>