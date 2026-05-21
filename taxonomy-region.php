<?php
get_template_part( 'parts/header' );

$current_region = get_queried_object();
$region_slug    = $current_region->slug;
$region_name    = $current_region->name;
$region_desc    = $current_region->description;

$all_trips = get_posts( array(
    'post_type'      => 'trips',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'tax_query'      => array(
        array(
            'taxonomy' => 'region',
            'field'    => 'slug',
            'terms'    => $region_slug,
        ),
    ),
) );
?>

<!-- Hero -->
<div class="arc-hero">
    <div class="arc-hero-inner">
        <p class="arc-hero-kicker">Explore Nepal</p>
        <h1 class="arc-hero-title"><?php echo esc_html( $region_name ); ?></h1>
        <p class="arc-hero-sub">
            <?php if ( $region_desc ) : ?>
                <?php echo esc_html( $region_desc ); ?>
            <?php else : ?>
                <?php echo count( $all_trips ); ?> handpicked adventures in <?php echo esc_html( $region_name ); ?>
            <?php endif; ?>
        </p>
    </div>
</div>

<!-- Breadcrumb back link -->
<div style="background:#fff; padding: 12px 40px; border-bottom: 1px solid #E8E0D0;">
    <a href="<?php echo esc_url( home_url( '/trips' ) ); ?>" style="font-size:13px; color:#0f5a43; text-decoration:none; font-weight:600;">
        ← Back to All Treks
    </a>
</div>

<!-- Trips Grid -->
<div class="arc-body">
    <div class="arc-grid" id="arcGrid">
        <?php if ( ! empty( $all_trips ) ) : ?>
        <?php foreach ( $all_trips as $trip ) :
            $t_id         = $trip->ID;
            $t_price      = get_post_meta( $t_id, '_trip_price',        true ) ?: '';
            $t_sale       = get_post_meta( $t_id, '_trip_sale_price',   true ) ?: '';
            $t_display    = $t_sale ?: $t_price;
            $t_duration   = get_post_meta( $t_id, '_trip_duration',     true ) ?: '';
            $t_difficulty = get_post_meta( $t_id, '_trip_difficulty',   true ) ?: '';
            $t_altitude   = get_post_meta( $t_id, '_trip_max_altitude', true ) ?: '';
            $t_season     = get_post_meta( $t_id, '_trip_best_season',  true ) ?: '';
            $t_group      = get_post_meta( $t_id, '_trip_group_size',   true ) ?: '';
            $t_thumb      = get_the_post_thumbnail_url( $t_id, 'large' )
                            ?: get_template_directory_uri() . '/images/trip-placeholder.jpg';
            $t_link       = get_permalink( $t_id );

            $t_regions     = get_the_terms( $t_id, 'region' );
            $t_region_name = ( $t_regions && ! is_wp_error( $t_regions ) )
                             ? $t_regions[0]->name : '';

            $diff_colors = array(
                'Easy'               => 'badge-green',
                'Easy-Moderate'      => 'badge-green',
                'Moderate'           => 'badge-amber',
                'Moderate-Strenuous' => 'badge-amber',
                'Strenuous'          => 'badge-red',
                'Expert'             => 'badge-red',
            );
            $diff_badge = $diff_colors[ $t_difficulty ] ?? 'badge-amber';

            $t_discount = '';
            if ( $t_sale && $t_price ) {
                $p_num = (float) preg_replace( '/[^0-9.]/', '', $t_price );
                $s_num = (float) preg_replace( '/[^0-9.]/', '', $t_sale );
                if ( $p_num > 0 && $s_num > 0 && $s_num < $p_num ) {
                    $t_discount = round( ( ( $p_num - $s_num ) / $p_num ) * 100 );
                }
            }
        ?>
        <div class="arc-card">
            <a href="<?php echo esc_url( $t_link ); ?>" class="arc-card-img-wrap">
                <div class="arc-card-img" style="background-image: url('<?php echo esc_url( $t_thumb ); ?>')">
                    <?php echo desire_get_trip_badges( $t_id, 'trip-badge--card' ); ?>
                    <?php if ( $t_discount ) : ?>
                    <span class="arc-card-discount"><?php echo (int) $t_discount; ?>% OFF</span>
                    <?php endif; ?>
                </div>
            </a>
            <div class="arc-card-content">
                <?php if ( $t_region_name ) : ?>
                <span class="arc-card-region"><?php echo esc_html( $t_region_name ); ?></span>
                <?php endif; ?>
                <h2 class="arc-card-title">
                    <a href="<?php echo esc_url( $t_link ); ?>"><?php echo esc_html( $trip->post_title ); ?></a>
                </h2>
                <div class="arc-card-chips">
                    <?php if ( $t_duration ) : ?>
                    <span class="arc-chip">📅 <?php echo esc_html( $t_duration ); ?></span>
                    <?php endif; ?>
                    <?php if ( $t_altitude ) : ?>
                    <span class="arc-chip">⛰ <?php echo esc_html( $t_altitude ); ?></span>
                    <?php endif; ?>
                    <?php if ( $t_difficulty ) : ?>
                    <span class="tp-badge <?php echo esc_attr( $diff_badge ); ?> arc-diff-badge">
                        <?php echo esc_html( $t_difficulty ); ?>
                    </span>
                    <?php endif; ?>
                </div>
                <?php if ( $t_season ) : ?>
                <p class="arc-card-season">🌤 Best season: <?php echo esc_html( $t_season ); ?></p>
                <?php endif; ?>
            </div>
            <div class="arc-card-footer">
                <div class="arc-card-price-block">
                    <?php if ( $t_sale && $t_price ) : ?>
                    <span class="arc-card-price-was"><?php echo esc_html( $t_price ); ?></span>
                    <?php endif; ?>
                    <span class="arc-card-price">
                        <?php echo $t_display ? esc_html( $t_display ) : 'Contact Us'; ?>
                    </span>
                    <?php if ( $t_display ) : ?>
                    <span class="arc-card-pp">/ person</span>
                    <?php endif; ?>
                </div>
                <a href="<?php echo esc_url( $t_link ); ?>" class="arc-card-cta">View Trek →</a>
            </div>
        </div>
        <?php endforeach; ?>

        <?php else : ?>
        <div class="arc-no-results">
            <div class="arc-no-results-inner">
                <span class="arc-no-results-icon">🏔</span>
                <h3>No treks found</h3>
                <p>No trips are currently listed for <?php echo esc_html( $region_name ); ?>.</p>
                <a href="<?php echo esc_url( home_url( '/trips' ) ); ?>" class="arc-clear-btn">View All Treks</a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php get_template_part( 'parts/footer' ); ?>