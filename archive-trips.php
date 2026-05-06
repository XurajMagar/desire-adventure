<?php get_template_part( 'parts/header' ); ?>

<?php
// Get all trips with all meta
$all_trips = get_posts( array(
    'post_type'      => 'trips',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
) );

// Get all regions for filter
$all_regions = get_terms( array(
    'taxonomy'   => 'region',
    'hide_empty' => true,
) );
?>

<!-- ── ARCHIVE HERO ─────────────────────────── -->
<div class="arc-hero">
    <div class="arc-hero-inner">
        <p class="arc-hero-kicker">Explore Nepal</p>
        <h1 class="arc-hero-title">All Treks &amp; Expeditions</h1>
        <p class="arc-hero-sub">
            <?php echo count( $all_trips ); ?> handpicked adventures —
            find your perfect trek
        </p>
    </div>
</div>

<!-- ── FILTER BAR ───────────────────────────── -->
<div class="arc-filter-wrap" id="arcFilterBar">
    <div class="arc-filter-inner">

        <!-- Results count -->
        <div class="arc-filter-count">
            <span id="arcCount"><?php echo count( $all_trips ); ?></span> trips found
        </div>

        <!-- Filters -->
        <div class="arc-filters">

            <!-- Region -->
            <?php if ( ! empty( $all_regions ) && ! is_wp_error( $all_regions ) ) : ?>
            <div class="arc-filter-group">
                <button class="arc-filter-btn" data-filter="region" data-value="">
                    <span class="arc-filter-label">Region</span>
                    <svg class="arc-filter-arrow" width="12" height="12"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </button>
                <div class="arc-filter-dropdown" data-for="region">
                    <button class="arc-dropdown-item is-active" data-filter="region" data-value="">
                        All Regions
                    </button>
                    <?php foreach ( $all_regions as $region ) : ?>
                    <button class="arc-dropdown-item" data-filter="region"
                            data-value="<?php echo esc_attr( $region->slug ); ?>">
                        <?php echo esc_html( $region->name ); ?>
                        <span class="arc-dropdown-count"><?php echo (int) $region->count; ?></span>
                    </button>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Difficulty -->
            <div class="arc-filter-group">
                <button class="arc-filter-btn" data-filter="difficulty" data-value="">
                    <span class="arc-filter-label">Difficulty</span>
                    <svg class="arc-filter-arrow" width="12" height="12"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </button>
                <div class="arc-filter-dropdown" data-for="difficulty">
                    <button class="arc-dropdown-item is-active" data-filter="difficulty" data-value="">All Levels</button>
                    <button class="arc-dropdown-item" data-filter="difficulty" data-value="Easy">Easy</button>
                    <button class="arc-dropdown-item" data-filter="difficulty" data-value="Easy-Moderate">Easy–Moderate</button>
                    <button class="arc-dropdown-item" data-filter="difficulty" data-value="Moderate">Moderate</button>
                    <button class="arc-dropdown-item" data-filter="difficulty" data-value="Moderate-Strenuous">Moderate–Strenuous</button>
                    <button class="arc-dropdown-item" data-filter="difficulty" data-value="Strenuous">Strenuous</button>
                    <button class="arc-dropdown-item" data-filter="difficulty" data-value="Expert">Expert</button>
                </div>
            </div>

            <!-- Duration -->
            <div class="arc-filter-group">
                <button class="arc-filter-btn" data-filter="duration" data-value="">
                    <span class="arc-filter-label">Duration</span>
                    <svg class="arc-filter-arrow" width="12" height="12"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </button>
                <div class="arc-filter-dropdown" data-for="duration">
                    <button class="arc-dropdown-item is-active" data-filter="duration" data-value="">Any Duration</button>
                    <button class="arc-dropdown-item" data-filter="duration" data-value="short">Under 7 Days</button>
                    <button class="arc-dropdown-item" data-filter="duration" data-value="medium">7 – 14 Days</button>
                    <button class="arc-dropdown-item" data-filter="duration" data-value="long">15+ Days</button>
                </div>
            </div>

            <!-- Sort -->
            <div class="arc-filter-group">
                <button class="arc-filter-btn" data-filter="sort" data-value="default">
                    <span class="arc-filter-label">Sort By</span>
                    <svg class="arc-filter-arrow" width="12" height="12"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </button>
                <div class="arc-filter-dropdown" data-for="sort">
                    <button class="arc-dropdown-item is-active" data-filter="sort" data-value="default">Featured</button>
                    <button class="arc-dropdown-item" data-filter="sort" data-value="price-asc">Price: Low to High</button>
                    <button class="arc-dropdown-item" data-filter="sort" data-value="price-desc">Price: High to Low</button>
                    <button class="arc-dropdown-item" data-filter="sort" data-value="duration-asc">Duration: Shortest</button>
                    <button class="arc-dropdown-item" data-filter="sort" data-value="duration-desc">Duration: Longest</button>
                </div>
            </div>

        </div>

        <!-- Active filters + Clear -->
        <div class="arc-active-filters" id="arcActiveFilters" style="display:none">
            <div class="arc-active-tags" id="arcActiveTags"></div>
            <button class="arc-clear-all" id="arcClearAll">Clear all</button>
        </div>

    </div>
</div>

<!-- ── TRIPS GRID ────────────────────────────── -->
<div class="arc-body">
    <div class="arc-grid" id="arcGrid">
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

            // Region
            $t_regions     = get_the_terms( $t_id, 'region' );
            $t_region_name = ( $t_regions && ! is_wp_error( $t_regions ) )
                             ? $t_regions[0]->name : '';
            $t_region_slug = ( $t_regions && ! is_wp_error( $t_regions ) )
                             ? $t_regions[0]->slug : '';

            // Duration number for filtering
            $t_dur_num = (int) preg_replace( '/[^0-9]/', '', $t_duration );

            // Price number for sorting
            $t_price_num = (float) preg_replace( '/[^0-9.]/', '',
                $t_sale ?: $t_price );

            // Discount
            $t_discount = '';
            if ( $t_sale && $t_price ) {
                $p_num = (float) preg_replace( '/[^0-9.]/', '', $t_price );
                $s_num = (float) preg_replace( '/[^0-9.]/', '', $t_sale );
                if ( $p_num > 0 && $s_num > 0 && $s_num < $p_num ) {
                    $t_discount = round( ( ( $p_num - $s_num ) / $p_num ) * 100 );
                }
            }

            // Difficulty badge
            $diff_colors = array(
                'Easy'               => 'badge-green',
                'Easy-Moderate'      => 'badge-green',
                'Moderate'           => 'badge-amber',
                'Moderate-Strenuous' => 'badge-amber',
                'Strenuous'          => 'badge-red',
                'Expert'             => 'badge-red',
            );
            $diff_badge = $diff_colors[ $t_difficulty ] ?? 'badge-amber';
        ?>
        <div class="arc-card"
             data-region="<?php echo esc_attr( $t_region_slug ); ?>"
             data-difficulty="<?php echo esc_attr( $t_difficulty ); ?>"
             data-duration-num="<?php echo (int) $t_dur_num; ?>"
             data-price-num="<?php echo (float) $t_price_num; ?>">

            <!-- Image -->
            <a href="<?php echo esc_url( $t_link ); ?>" class="arc-card-img-wrap">
                <div class="arc-card-img"
                     style="background-image: url('<?php echo esc_url( $t_thumb ); ?>')">
                    <!-- Badges -->
                    <?php echo desire_get_trip_badges( $t_id, 'trip-badge--card' ); ?>
                    <!-- Discount -->
                    <?php if ( $t_discount ) : ?>
                    <span class="arc-card-discount"><?php echo (int) $t_discount; ?>% OFF</span>
                    <?php endif; ?>
                </div>
            </a>

            <!-- Content -->
            <div class="arc-card-content">

                <!-- Region tag -->
                <?php if ( $t_region_name ) : ?>
                <span class="arc-card-region"><?php echo esc_html( $t_region_name ); ?></span>
                <?php endif; ?>

                <!-- Title -->
                <h2 class="arc-card-title">
                    <a href="<?php echo esc_url( $t_link ); ?>">
                        <?php echo esc_html( $trip->post_title ); ?>
                    </a>
                </h2>

                <!-- Meta chips -->
                <div class="arc-card-chips">
                    <?php if ( $t_duration ) : ?>
                    <span class="arc-chip">📅 <?php echo esc_html( $t_duration ); ?></span>
                    <?php endif; ?>
                    <?php if ( $t_altitude ) : ?>
                    <span class="arc-chip">⛰ <?php echo esc_html( $t_altitude ); ?></span>
                    <?php endif; ?>
                    <?php if ( $t_group ) : ?>
                    <span class="arc-chip">👥 <?php echo esc_html( $t_group ); ?></span>
                    <?php endif; ?>
                    <?php if ( $t_difficulty ) : ?>
                    <span class="tp-badge <?php echo esc_attr( $diff_badge ); ?> arc-diff-badge">
                        <?php echo esc_html( $t_difficulty ); ?>
                    </span>
                    <?php endif; ?>
                </div>

                <?php if ( $t_season ) : ?>
                <p class="arc-card-season">
                    🌤 Best season: <?php echo esc_html( $t_season ); ?>
                </p>
                <?php endif; ?>

            </div>

            <!-- Footer -->
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
                <a href="<?php echo esc_url( $t_link ); ?>" class="arc-card-cta">
                    View Trek →
                </a>
            </div>

        </div>
        <?php endforeach; ?>
    </div>

    <!-- No results message -->
    <div class="arc-no-results" id="arcNoResults" style="display:none">
        <div class="arc-no-results-inner">
            <span class="arc-no-results-icon">🏔</span>
            <h3>No treks found</h3>
            <p>Try adjusting your filters to find more options.</p>
            <button class="arc-clear-btn" id="arcClearBtn">Clear All Filters</button>
        </div>
    </div>

</div>

<?php get_template_part( 'parts/footer' ); ?>