<?php get_template_part( 'parts/header' ); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<?php
// ── Gather all meta ──────────────────────────────────
$price      = get_post_meta( get_the_ID(), '_trip_price', true )      ?: 'Contact us';
$sale_price = get_post_meta( get_the_ID(), '_trip_sale_price', true ) ?: '';

// Calculate discount percentage automatically
$discount = '';
if ( $sale_price && $price ) {
    // Strip everything except numbers and dots
    $price_num      = (float) preg_replace( '/[^0-9.]/', '', $price );
    $sale_price_num = (float) preg_replace( '/[^0-9.]/', '', $sale_price );

    if ( $price_num > 0 && $sale_price_num > 0 && $sale_price_num < $price_num ) {
        $discount = round( ( ( $price_num - $sale_price_num ) / $price_num ) * 100 );
    }
}

// Display price is sale price if set, otherwise regular price
$display_price = $sale_price ?: $price;
$duration   = get_post_meta( get_the_ID(), '_trip_duration', true )     ?: '';
$altitude   = get_post_meta( get_the_ID(), '_trip_max_altitude', true ) ?: '';
$group      = get_post_meta( get_the_ID(), '_trip_group_size', true )   ?: '';
$starts     = get_post_meta( get_the_ID(), '_trip_start_end', true )    ?: '';
$season     = get_post_meta( get_the_ID(), '_trip_best_season', true )  ?: '';
$difficulty = get_post_meta( get_the_ID(), '_trip_difficulty', true )   ?: 'Moderate';
$fitness    = get_post_meta( get_the_ID(), '_trip_fitness_desc', true ) ?: '';
$includes   = get_post_meta( get_the_ID(), '_trip_includes', true )     ?: '';
$excludes   = get_post_meta( get_the_ID(), '_trip_excludes', true )     ?: '';
$map_embed  = get_post_meta( get_the_ID(), '_trip_map_embed', true )    ?: '';
$map_image  = get_post_meta( get_the_ID(), '_trip_map_image', true )  ?: '';
$map_credit = get_post_meta( get_the_ID(), '_trip_map_credit', true ) ?: '';
$trip_wa    = get_post_meta( get_the_ID(), '_trip_whatsapp', true )     ?: get_theme_mod( 'desire_whatsapp_number', '+977 9851233710' );
$book_url   = get_post_meta( get_the_ID(), '_trip_book_url', true )     ?: '#inquiry';
$cancel     = get_post_meta( get_the_ID(), '_trip_cancellation', true ) ?: 'Free cancellation up to 30 days';
$trip_badge_1 = get_post_meta( get_the_ID(), '_trip_badge_1', true ) ?: '';
$trip_badge_2 = get_post_meta( get_the_ID(), '_trip_badge_2', true ) ?: '';
$deposit     = get_post_meta( get_the_ID(), '_trip_deposit',     true ) ?: '';
$balance_due = get_post_meta( get_the_ID(), '_trip_balance_due', true ) ?: '30 days before departure';
$price_note  = get_post_meta( get_the_ID(), '_trip_price_note',  true ) ?: '';
$more_details = get_post_meta( get_the_ID(), '_trip_more_details', true ) ?: '';

// Group discount tiers
$tiers = array();
for ( $t = 1; $t <= 4; $t++ ) {
    $t_label    = get_post_meta( get_the_ID(), "_trip_tier_{$t}_label",    true );
    $t_price    = get_post_meta( get_the_ID(), "_trip_tier_{$t}_price",    true );
    $t_discount = get_post_meta( get_the_ID(), "_trip_tier_{$t}_discount", true );
    if ( $t_label || $t_price ) {
        $tiers[] = array(
            'label'    => $t_label,
            'price'    => $t_price,
            'discount' => $t_discount,
        );
    }
}
// Gallery images
$gallery = array();
for ( $g = 1; $g <= 8; $g++ ) {
    $img = get_post_meta( get_the_ID(), "_trip_gallery_{$g}", true );
    if ( $img ) $gallery[] = $img;
}
// Always put featured image first
$featured = get_the_post_thumbnail_url( get_the_ID(), 'full' );
if ( $featured && ! in_array( $featured, $gallery ) ) {
    array_unshift( $gallery, $featured );
}
if ( empty( $gallery ) ) {
    $gallery[] = get_template_directory_uri() . '/images/trip-placeholder.jpg';
}

// Itinerary days
// Itinerary days
$days = array();
for ( $d = 1; $d <= 30; $d++ ) {
    $t = get_post_meta( get_the_ID(), "_trip_day_{$d}_title", true );
    if ( $t ) {
        $days[] = array(
            'title'    => $t,
            'duration' => get_post_meta( get_the_ID(), "_trip_day_{$d}_duration", true ),
            'altitude' => get_post_meta( get_the_ID(), "_trip_day_{$d}_altitude", true ),
            'desc'     => get_post_meta( get_the_ID(), "_trip_day_{$d}_desc", true ),
            'photo'    => get_post_meta( get_the_ID(), "_trip_day_{$d}_photo", true ),
        );
    }
}

// Build altitude data for chart
$altitude_data = array();
foreach ( $days as $idx => $day ) {
    if ( $day['altitude'] ) {
        // Strip everything except numbers
        $alt_num = (int) preg_replace( '/[^0-9]/', '', $day['altitude'] );
        if ( $alt_num > 0 ) {
            $altitude_data[] = array(
                'day'      => $idx + 1,
                'label'    => 'Day ' . ( $idx + 1 ),
                'altitude' => $alt_num,
                'title'    => $day['title'],
            );
        }
    }
}

// FAQs
$faqs = array();
for ( $f = 1; $f <= 20; $f++ ) {
    $q = get_post_meta( get_the_ID(), "_trip_faq_{$f}_q", true );
    $a = get_post_meta( get_the_ID(), "_trip_faq_{$f}_a", true );
    if ( $q && $a ) $faqs[] = array( 'q' => $q, 'a' => $a );
}
// ── Departure dates ──────────────────────────────────
$departures = array();
for ( $d = 1; $d <= 8; $d++ ) {
    $dep_start = get_post_meta( get_the_ID(), "_trip_dep_{$d}_start", true );
    if ( $dep_start ) {
        $departures[] = array(
            'start'  => $dep_start,
            'end'    => get_post_meta( get_the_ID(), "_trip_dep_{$d}_end", true ),
            'spots'  => get_post_meta( get_the_ID(), "_trip_dep_{$d}_spots", true ),
            'price'  => get_post_meta( get_the_ID(), "_trip_dep_{$d}_price", true ),
            'status' => get_post_meta( get_the_ID(), "_trip_dep_{$d}_status", true ) ?: 'available',
        );
    }
}

// Build departure dates array for JavaScript calendar dots
$departure_dates_js = array_map( function( $dep ) {
    return $dep['start'];
}, $departures );

// Difficulty bar width
$diff_widths = array(
    'Easy'                => '20%',
    'Easy-Moderate'       => '35%',
    'Moderate'            => '55%',
    'Moderate-Strenuous'  => '70%',
    'Strenuous'           => '85%',
    'Expert'              => '100%',
);
$diff_width = $diff_widths[ $difficulty ] ?? '55%';

// Difficulty badge color
$diff_colors = array(
    'Easy'               => 'badge-green',
    'Easy-Moderate'      => 'badge-green',
    'Moderate'           => 'badge-amber',
    'Moderate-Strenuous' => 'badge-amber',
    'Strenuous'          => 'badge-red',
    'Expert'             => 'badge-red',
);
$diff_badge = $diff_colors[ $difficulty ] ?? 'badge-amber';
?>

<!-- ── HERO SLIDESHOW ─────────────────────────── -->
<div class="tp-hero">
    <div class="tp-slides">
        <?php foreach ( $gallery as $idx => $img ) : ?>
        <div class="tp-slide <?php echo $idx === 0 ? 'active' : ''; ?>">
            <div class="tp-slide-bg" style="background-image: url('<?php echo esc_url( $img ); ?>')"></div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Hero Content -->
    <div class="tp-hero-content">
        <nav class="tp-breadcrumb" aria-label="Breadcrumb">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
            <span>/</span>
            <a href="<?php echo esc_url( home_url( '/trips' ) ); ?>">Trips</a>
            <span>/</span>
            <span><?php the_title(); ?></span>
        </nav>
        <!-- Trip Badges on Hero -->
        <?php echo desire_get_trip_badges( get_the_ID(), 'trip-badge--hero' ); ?>
        <?php
        $cats = get_the_terms( get_the_ID(), 'region' );
        if ( $cats && ! is_wp_error( $cats ) ) :
        ?>
        <span class="tp-hero-tag"><?php echo esc_html( $cats[0]->name ); ?></span>
        <?php endif; ?>
        <h1 class="tp-hero-title"><?php the_title(); ?></h1>
    </div>

    <!-- Hero Right Meta -->
    <div class="tp-hero-meta">
        <?php if ( $duration ) : ?>
        <div class="tp-hero-meta-item">
            <span class="tp-meta-label">Duration</span>
            <span class="tp-meta-value"><?php echo esc_html( $duration ); ?></span>
        </div>
        <?php endif; ?>
        <?php if ( $altitude ) : ?>
        <div class="tp-hero-meta-item">
            <span class="tp-meta-label">Max Altitude</span>
            <span class="tp-meta-value"><?php echo esc_html( $altitude ); ?></span>
        </div>
        <?php endif; ?>
        <?php if ( $difficulty ) : ?>
        <div class="tp-hero-meta-item">
            <span class="tp-meta-label">Difficulty</span>
            <span class="tp-meta-value"><?php echo esc_html( $difficulty ); ?></span>
        </div>
        <?php endif; ?>
    </div>
    <!-- PACKING LIST -->

    <!-- Slide Dots -->
    <?php if ( count( $gallery ) > 1 ) : ?>
    <div class="tp-slide-dots" id="tpSlideDots"></div>
    <?php endif; ?>
</div>

<!-- ── THUMBNAIL STRIP ───────────────────────── -->
<?php if ( count( $gallery ) > 1 ) : ?>
<div class="tp-gallery-strip">
    <?php foreach ( $gallery as $idx => $img ) : ?>
    <div class="tp-thumb <?php echo $idx === 0 ? 'active' : ''; ?>"
         data-slide="<?php echo (int) $idx; ?>"
         style="background-image: url('<?php echo esc_url( $img ); ?>')">
        <span class="tp-thumb-label">Photo <?php echo $idx + 1; ?></span>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- ── STICKY SUBNAV ─────────────────────────── -->
<div class="tp-subnav-wrap" id="tpSubnav">
    <nav class="tp-subnav">
        <a class="tp-subnav-link active" href="#tp-overview">Overview</a>
        <?php if ( ! empty( $days ) ) : ?>
        <?php if ( $includes || $excludes ) : ?>
        <a class="tp-subnav-link" href="#tp-includes">Includes</a>
        <?php endif; ?>
        <a class="tp-subnav-link" href="#tp-itinerary">Itinerary</a>
        <?php endif; ?>
        <?php if ( get_post_meta( get_the_ID(), '_trip_pack_1_item', true ) ) : ?>
        <a class="tp-subnav-link" href="#tp-packing">Packing List</a>
        <?php endif; ?>
        <?php if ( count( $gallery ) > 1 ) : ?>
        <a class="tp-subnav-link" href="#tp-gallery">Gallery</a>
        <?php endif; ?>
        <?php if ( $map_embed || $map_image ) : ?>
        <a class="tp-subnav-link" href="#tp-map">Map</a>
        <?php endif; ?>
        <?php if ( ! empty( $faqs ) ) : ?>
        <a class="tp-subnav-link" href="#tp-faq">FAQ</a>
        <?php endif; ?>
        <!-- Print + Download buttons in subnav area -->
        <div class="tp-subnav-actions">
            <button class="tp-subnav-action-btn" id="tpPrintBtn" title="Print Itinerary">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <polyline points="6 9 6 2 18 2 18 9"/>
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                    <rect x="6" y="14" width="12" height="8"/>
                </svg>
                <span>Print</span>
            </button>
            <button class="tp-subnav-action-btn" id="tpDownloadBtn" title="Download Itinerary PDF">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                <span>Download</span>
            </button>
        </div>
        <a class="tp-subnav-cta" href="#tp-inquiry">Book Now</a>
    </nav>
</div>

<!-- ── MAIN BODY ──────────────────────────────── -->
<div class="tp-page-body">

    <!-- ── CONTENT COLUMN ────────────── -->
    <main class="tp-main">

        <!-- OVERVIEW -->
        <section id="tp-overview" class="tp-section">
            <p class="tp-section-label">About This Trek</p>
            <h2 class="tp-section-title"><?php the_title(); ?></h2>
            <!-- Social Share Buttons -->
        <div class="tp-share-bar">
            <span class="tp-share-label">Share:</span>

            <!-- Facebook -->
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( get_permalink() ); ?>"
            class="tp-share-btn tp-share-facebook"
            target="_blank" rel="noopener noreferrer"
            aria-label="Share on Facebook">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
                </svg>
                <span>Facebook</span>
            </a>

            <!-- WhatsApp -->
            <a href="https://wa.me/?text=<?php echo urlencode( get_the_title() . ' — ' . get_permalink() ); ?>"
            class="tp-share-btn tp-share-whatsapp"
            target="_blank" rel="noopener noreferrer"
            aria-label="Share on WhatsApp">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                </svg>
                <span>WhatsApp</span>
            </a>

            <!-- Pinterest -->
            <a href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode( get_permalink() ); ?>&media=<?php echo urlencode( get_the_post_thumbnail_url( get_the_ID(), 'large' ) ); ?>&description=<?php echo urlencode( get_the_title() ); ?>"
            class="tp-share-btn tp-share-pinterest"
            target="_blank" rel="noopener noreferrer"
            aria-label="Share on Pinterest">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C6.477 2 2 6.477 2 12c0 4.236 2.636 7.855 6.356 9.312-.088-.791-.167-2.005.035-2.868.181-.78 1.172-4.97 1.172-4.97s-.299-.598-.299-1.482c0-1.388.806-2.428 1.808-2.428.853 0 1.267.641 1.267 1.408 0 .858-.546 2.141-.828 3.329-.236.995.499 1.806 1.476 1.806 1.772 0 3.137-1.868 3.137-4.568 0-2.386-1.715-4.054-4.165-4.054-2.837 0-4.502 2.128-4.502 4.326 0 .857.33 1.775.741 2.277a.3.3 0 0 1 .069.284c-.076.311-.244.995-.277 1.134-.044.183-.146.222-.335.134-1.249-.581-2.03-2.407-2.03-3.874 0-3.154 2.292-6.052 6.608-6.052 3.469 0 6.165 2.473 6.165 5.776 0 3.447-2.173 6.22-5.19 6.22-1.013 0-1.966-.527-2.292-1.148l-.623 2.378c-.226.869-.835 1.958-1.244 2.621.937.29 1.931.446 2.962.446 5.523 0 10-4.477 10-10S17.523 2 12 2z"/>
                </svg>
                <span>Pinterest</span>
            </a>

            <!-- Copy Link -->
            <button class="tp-share-btn tp-share-copy" id="tpCopyLink"
                    data-url="<?php echo esc_url( get_permalink() ); ?>"
                    aria-label="Copy link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
                    <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
                </svg>
                <span id="tpCopyText">Copy Link</span>
            </button>
        </div>

            <!-- Highlight cards — always visible before description -->
            <div class="tp-highlight-grid">
                <?php if ( $duration ) : ?>
                <div class="tp-highlight-card">
                    <div class="tp-hc-icon">📅</div>
                    <div class="tp-hc-title"><?php echo esc_html( $duration ); ?></div>
                    <div class="tp-hc-desc">Total duration</div>
                </div>
                <?php endif; ?>
                <?php if ( $altitude ) : ?>
                <div class="tp-highlight-card">
                    <div class="tp-hc-icon">⛰️</div>
                    <div class="tp-hc-title"><?php echo esc_html( $altitude ); ?></div>
                    <div class="tp-hc-desc">Maximum altitude</div>
                </div>
                <?php endif; ?>
                <?php if ( $group ) : ?>
                <div class="tp-highlight-card">
                    <div class="tp-hc-icon">👥</div>
                    <div class="tp-hc-title"><?php echo esc_html( $group ); ?></div>
                    <div class="tp-hc-desc">Group size</div>
                </div>
                <?php endif; ?>
                <?php if ( $starts ) : ?>
                <div class="tp-highlight-card">
                    <div class="tp-hc-icon">📍</div>
                    <div class="tp-hc-title"><?php echo esc_html( $starts ); ?></div>
                    <div class="tp-hc-desc">Starts &amp; ends</div>
                </div>
                <?php endif; ?>
                <?php if ( $season ) : ?>
                <div class="tp-highlight-card">
                    <div class="tp-hc-icon">🌤️</div>
                    <div class="tp-hc-title"><?php echo esc_html( $season ); ?></div>
                    <div class="tp-hc-desc">Best season</div>
                </div>
                <?php endif; ?>
                <?php if ( $difficulty ) : ?>
                <div class="tp-highlight-card">
                    <div class="tp-hc-icon">🎯</div>
                    <div class="tp-hc-title"><?php echo esc_html( $difficulty ); ?></div>
                    <div class="tp-hc-desc">Difficulty level</div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Full description below cards -->
            <div class="tp-lead">
                <?php the_content(); ?>
            </div>

        </section>

        <!-- INCLUDES & EXCLUDES -->
        <?php if ( $includes || $excludes ) : ?>
        <section id="tp-includes" class="tp-section">
            <div class="tp-section-divider"></div>
            <p class="tp-section-label">What's covered</p>
            <h2 class="tp-section-title">Includes &amp; Excludes</h2>

            <div class="tp-inc-grid">
                <?php if ( $includes ) : ?>
                <div class="tp-inc-col tp-inc-yes">
                    <h4 class="tp-inc-heading">✓ Included</h4>
                    <ul class="tp-inc-list">
                        <?php foreach ( explode( "\n", $includes ) as $item ) :
                            $item = trim( $item );
                            if ( $item ) : ?>
                            <li><?php echo esc_html( $item ); ?></li>
                        <?php endif; endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
                <?php if ( $excludes ) : ?>
                <div class="tp-inc-col tp-inc-no">
                    <h4 class="tp-inc-heading">✕ Excluded</h4>
                    <ul class="tp-inc-list">
                        <?php foreach ( explode( "\n", $excludes ) as $item ) :
                            $item = trim( $item );
                            if ( $item ) : ?>
                            <li><?php echo esc_html( $item ); ?></li>
                        <?php endif; endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
        </section>
        <?php endif; ?>

        <!-- ITINERARY -->
        <?php if ( ! empty( $days ) ) : ?>
        <section id="tp-itinerary" class="tp-section">
            <div class="tp-section-divider"></div>
            <p class="tp-section-label">Day by Day</p>
            <h2 class="tp-section-title">Full Itinerary</h2>

            <!-- Itinerary controls -->
        <div class="tp-itin-controls">
            <button class="tp-itin-ctrl-btn" id="tpExpandAll">Expand All</button>
            <button class="tp-itin-ctrl-btn" id="tpCollapseAll">Collapse All</button>
        </div>

        <div class="tp-timeline">
            <?php foreach ( $days as $idx => $day ) :
                $day_num = $idx + 1;
                $is_last = $idx === count( $days ) - 1;
                $is_open = $idx === 0; // First day open by default
            ?>
            <div class="tp-day-item tp-day-accordion <?php echo $is_open ? 'is-open' : ''; ?>">
                <div class="tp-day-spine">
                    <div class="tp-day-num"><?php echo $day_num; ?></div>
                    <?php if ( ! $is_last ) : ?>
                    <div class="tp-day-line"></div>
                    <?php endif; ?>
                </div>
                <div class="tp-day-content">
                    <!-- Clickable header -->
                    <button class="tp-day-header tp-day-toggle" aria-expanded="<?php echo $is_open ? 'true' : 'false'; ?>">
                        <div class="tp-day-header-left">
                            <h3 class="tp-day-title"><?php echo esc_html( $day['title'] ); ?></h3>
                            <div class="tp-day-chips-row">
                                <?php if ( $day['duration'] ) : ?>
                                <span class="tp-chip">⏱ <?php echo esc_html( $day['duration'] ); ?></span>
                                <?php endif; ?>
                                <?php if ( $day['altitude'] ) : ?>
                                <span class="tp-chip tp-chip-altitude">⛰ <?php echo esc_html( $day['altitude'] ); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <span class="tp-day-toggle-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                <polyline points="6 9 12 15 18 9"/>
                            </svg>
                        </span>
                    </button>

                    <!-- Collapsible body -->
                    <div class="tp-day-body-wrap">
                        <?php if ( $day['desc'] ) : ?>
                        <div class="tp-day-body">
                            <?php echo wpautop( wp_kses_post( $day['desc'] ) ); ?>
                        </div>
                        <?php endif; ?>
                        <?php if ( $day['photo'] ) : ?>
                        <div class="tp-day-photo">
                            <img src="<?php echo esc_url( $day['photo'] ); ?>"
                                alt="<?php echo esc_html( $day['title'] ); ?>"
                                onclick="openTripLightbox('<?php echo esc_url( $day['photo'] ); ?>')">
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        </section>
        <?php endif; ?>

        <!-- DIFFICULTY -->
        <section id="tp-difficulty" class="tp-section">
            <div class="tp-section-divider"></div>
            <p class="tp-section-label">Physical Preparation</p>
            <h2 class="tp-section-title">Difficulty &amp; Fitness</h2>

            <span class="tp-badge <?php echo esc_attr( $diff_badge ); ?>">
                <?php echo esc_html( $difficulty ); ?>
            </span>

            <div class="tp-diff-bar">
                <div class="tp-diff-fill" style="width: <?php echo esc_attr( $diff_width ); ?>"></div>
            </div>
            <div class="tp-diff-labels">
                <span>Easy</span>
                <span>Moderate</span>
                <span>Strenuous</span>
                <span>Expert</span>
            </div>

            <?php if ( $fitness ) : ?>
            <p class="tp-diff-desc"><?php echo esc_html( $fitness ); ?></p>
            <?php endif; ?>
        </section>
        <!-- Packing List -->
        <?php
        $packing_items = array();
        for ( $p = 1; $p <= 50; $p++ ) {
            $p_item = get_post_meta( get_the_ID(), "_trip_pack_{$p}_item", true );
            if ( $p_item ) {
                $packing_items[] = array(
                    'icon'     => get_post_meta( get_the_ID(), "_trip_pack_{$p}_icon",     true ) ?: '✓',
                    'item'     => $p_item,
                    'note'     => get_post_meta( get_the_ID(), "_trip_pack_{$p}_note",     true ) ?: '',
                    'category' => get_post_meta( get_the_ID(), "_trip_pack_{$p}_category", true ) ?: 'General',
                    'required' => get_post_meta( get_the_ID(), "_trip_pack_{$p}_required", true ) ?: 'required',
                );
            }
        }

        // Group by category
        $grouped = array();
        foreach ( $packing_items as $pack ) {
            $cat = $pack['category'] ?: 'General';
            $grouped[ $cat ][] = $pack;
        }
        ?>

        <?php if ( ! empty( $grouped ) ) : ?>
        <section id="tp-packing" class="tp-section">
            <div class="tp-section-divider"></div>
            <p class="tp-section-label">What to Bring</p>
            <h2 class="tp-section-title">Packing List</h2>
            <p class="tp-diff-desc" style="margin-bottom:28px">
                Everything you need for a comfortable and safe trek.
                Items marked <span class="tp-pack-tag tp-pack-required">Required</span> are essential.
            </p>

            <div class="tp-pack-groups">
                <?php foreach ( $grouped as $category => $items ) : ?>
                <div class="tp-pack-group">
                    <h4 class="tp-pack-cat-title"><?php echo esc_html( $category ); ?></h4>
                    <ul class="tp-pack-list">
                        <?php foreach ( $items as $pack ) : ?>
                        <li class="tp-pack-item">
                            <span class="tp-pack-icon"><?php echo esc_html( $pack['icon'] ); ?></span>
                            <div class="tp-pack-info">
                                <span class="tp-pack-name"><?php echo esc_html( $pack['item'] ); ?></span>
                                <?php if ( $pack['note'] ) : ?>
                                <span class="tp-pack-note"><?php echo esc_html( $pack['note'] ); ?></span>
                                <?php endif; ?>
                            </div>
                            <span class="tp-pack-tag tp-pack-<?php echo esc_attr( $pack['required'] ); ?>">
                                <?php
                                $labels = array(
                                    'required' => 'Required',
                                    'optional' => 'Optional',
                                    'rental'   => 'Can Rent',
                                );
                                echo $labels[ $pack['required'] ] ?? 'Required';
                                ?>
                            </span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>
        <!-- MORE DETAILS -->
        <?php if ( $more_details ) : ?>
        <section id="tp-more-details" class="tp-section">
            <div class="tp-section-divider"></div>
            <p class="tp-section-label">Additional Information</p>
            <h2 class="tp-section-title">More Details</h2>
            <div class="tp-more-details-content">
                <?php echo wp_kses_post( $more_details ); ?>
            </div>
        </section>
        <?php endif; ?>
        <!-- GALLERY -->
        <?php if ( count( $gallery ) > 1 ) : ?>
        <section id="tp-gallery" class="tp-section">
            <div class="tp-section-divider"></div>
            <p class="tp-section-label">On the trail</p>
            <h2 class="tp-section-title">Photo Gallery</h2>

            <div class="tp-gallery-grid">
                <?php foreach ( $gallery as $idx => $img ) : ?>
                <div class="tp-gallery-item <?php echo $idx === 0 ? 'tp-gallery-featured' : ''; ?>"
                     onclick="openTripLightbox('<?php echo esc_url( $img ); ?>')">
                    <img src="<?php echo esc_url( $img ); ?>"
                         alt="<?php the_title(); ?> photo <?php echo $idx + 1; ?>">
                </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

        <!-- MAP -->
        <?php if ( $map_image || $map_embed ) : ?>
        <section id="tp-map" class="tp-section">
            <div class="tp-section-divider"></div>
            <p class="tp-section-label">Trek Route</p>
            <h2 class="tp-section-title">Route Map</h2>

            <?php if ( $map_image ) : ?>
            <!-- Custom image map — professional illustrated style -->
            <div class="tp-map-image-wrap">
                <img src="<?php echo esc_url( $map_image ); ?>"
                    alt="<?php the_title(); ?> route map"
                    class="tp-map-image"
                    onclick="openTripLightbox('<?php echo esc_url( $map_image ); ?>')">
                <div class="tp-map-image-footer">
                    <span class="tp-map-zoom-hint">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                            <line x1="11" y1="8" x2="11" y2="14"/>
                            <line x1="8" y1="11" x2="14" y2="11"/>
                        </svg>
                        Click map to view full size
                    </span>
                    <?php if ( $map_credit ) : ?>
                    <span class="tp-map-credit"><?php echo esc_html( $map_credit ); ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <?php elseif ( $map_embed ) : ?>
            <!-- Fallback: Google Maps embed -->
            <div class="tp-map-wrap">
                <iframe
                    src="<?php echo esc_url( $map_embed ); ?>"
                    width="100%" height="420"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
            <?php endif; ?>

        </section>
        <?php endif; ?>
        <!-- ALTITUDE CHART -->
                    <?php if ( count( $altitude_data ) >= 2 ) : ?>
                    <section id="tp-altitude" class="tp-section">
                        <div class="tp-section-divider"></div>
                        <p class="tp-section-label">Elevation Profile</p>
                        <h2 class="tp-section-title">Altitude Chart</h2>
                        <p class="tp-diff-desc" style="margin-bottom:24px">
                            Elevation profile across <?php echo count( $days ); ?> days.
                            Maximum altitude: <?php
                                $max_alt = max( array_column( $altitude_data, 'altitude' ) );
                                echo number_format( $max_alt );
                            ?>m
                        </p>
                        <div class="tp-altitude-chart-wrap">
                            <canvas id="tpAltitudeChart" class="tp-altitude-canvas"></canvas>
                        </div>
                        <!-- Pass altitude data to JS -->
                        <script>
                        var tpAltitudeData = <?php echo json_encode( $altitude_data ); ?>;
                        </script>
                    </section>
                    <?php endif; ?>

        <!-- FAQ -->
        <?php if ( ! empty( $faqs ) ) : ?>
        <section id="tp-faq" class="tp-section">
            <div class="tp-section-divider"></div>
            <p class="tp-section-label">Common Questions</p>
            <h2 class="tp-section-title">Frequently Asked</h2>

            <div class="tp-accordion">
                <?php foreach ( $faqs as $fidx => $faq ) : ?>
                <div class="tp-acc-item <?php echo $fidx === 0 ? 'open' : ''; ?>">
                    <button class="tp-acc-trigger" aria-expanded="false">
                        <span><?php echo esc_html( $faq['q'] ); ?></span>
                        <span class="tp-acc-icon">+</span>
                    </button>
                    <div class="tp-acc-content">
                        <p><?php echo esc_html( $faq['a'] ); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>
        <!-- DEPARTURE DATES SECTION -->
        <?php if ( ! empty( $departures ) ) : ?>
        <section id="tp-departures" class="tp-section">
            <div class="tp-section-divider"></div>
            <p class="tp-section-label">Scheduled Group Trips</p>
            <h2 class="tp-section-title">Available Departures</h2>
            <p class="tp-dep-intro">Join a scheduled group departure for extra discounts and a shared adventure with fellow trekkers.</p>

            <div class="tp-dep-table-wrap">
                <table class="tp-dep-table">
                    <thead>
                        <tr>
                            <th>Departure Date</th>
                            <th>Return Date</th>
                            <th>Duration</th>
                            <th>Price</th>
                            <th>Availability</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ( $departures as $dep ) :
                            $dep_start_fmt  = date( 'j M Y', strtotime( $dep['start'] ) );
                            $dep_end_fmt    = $dep['end'] ? date( 'j M Y', strtotime( $dep['end'] ) ) : '—';
                            $dep_price_disp = $dep['price'] ?: $display_price;
                            $status         = $dep['status'];

                            $spots_class = array(
                                'available' => 'spots-ok',
                                'limited'   => 'spots-few',
                                'full'      => 'spots-full',
                                'waitlist'  => 'spots-wait',
                            )[ $status ] ?? 'spots-ok';

                            $spots_text = array(
                                'available' => $dep['spots'] ? $dep['spots'] . ' spots left' : 'Available',
                                'limited'   => $dep['spots'] ? 'Only ' . $dep['spots'] . ' left' : 'Limited',
                                'full'      => 'Full',
                                'waitlist'  => 'Waitlist',
                            )[ $status ] ?? 'Available';
                            ?>
                            <tr>
                                <td>
                                    <span class="tp-dep-date"><?php echo esc_html( $dep_start_fmt ); ?></span>
                                </td>
                                <td><?php echo esc_html( $dep_end_fmt ); ?></td>
                                <td><?php echo esc_html( $duration ); ?></td>
                                <td class="tp-dep-price"><?php echo esc_html( $dep_price_disp ); ?></td>
                                <td>
                                    <span class="tp-dep-spots <?php echo esc_attr( $spots_class ); ?>">
                                        <?php echo esc_html( $spots_text ); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ( $status !== 'full' ) : ?>
                                    <button class="tp-btn-join-dep"
                                            data-start="<?php echo esc_attr( $dep['start'] ); ?>"
                                            data-end="<?php echo esc_attr( $dep['end'] ); ?>"
                                            data-start-fmt="<?php echo esc_attr( $dep_start_fmt ); ?>"
                                            data-end-fmt="<?php echo esc_attr( $dep_end_fmt ); ?>"
                                            data-price="<?php echo esc_attr( $dep_price_disp ); ?>">
                                        <?php echo $status === 'waitlist' ? 'Join Waitlist' : 'Join →'; ?>
                                    </button>
                                    <?php else : ?>
                                    <span class="tp-btn-join-dep full">Full</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
        <?php endif; ?>

    </main>

    <!-- ── SIDEBAR ────────────────────── -->
    <aside class="tp-sidebar" id="tp-inquiry">

        <!-- Price + Booking Buttons Card -->
        <div class="tp-booking-card">
            <div class="tp-inquiry-head">
                <h3>Book This Trek</h3>
                <p>Secure your spot today</p>
                <div class="tp-price-row">
                    <span class="tp-price-from">From</span>
                    <span class="tp-price-val"><?php echo esc_html( $display_price ); ?></span>
                    <span class="tp-price-pp">per person</span>
                </div>
                <?php if ( $sale_price && $discount ) : ?>
                <div class="tp-price-original-row">
                    <span class="tp-price-was">Was <?php echo esc_html( $price ); ?></span>
                    <span class="tp-discount-badge"><?php echo (int) $discount; ?>% OFF</span>
                </div>
                <?php endif; ?>
            </div>

            <div class="tp-action-btns">
                <!-- Book Now -->
                <button class="tp-btn-action tp-btn-booknow" id="btnBookNow">
                    <span class="tp-btn-icon">📅</span>
                    <span class="tp-btn-label">Book Now</span>
                </button>

                <!-- Join Departures -->
                <?php if ( ! empty( $departures ) ) : ?>
                <button class="tp-btn-action tp-btn-departure" id="btnJoinDep">
                    <span class="tp-btn-icon">🗓</span>
                    <div class="tp-btn-multi">
                        <span class="tp-btn-label">Join a Departure</span>
                        <span class="tp-btn-sublabel">(Get extra discounts on group departures)</span>
                    </div>
                </button>
                <?php endif; ?>

                <!-- Enquiry -->
                <button class="tp-btn-action tp-btn-enquiry" id="btnEnquiry">
                    <span class="tp-btn-icon">✉</span>
                    <span class="tp-btn-label">Enquiry Now</span>
                </button>

                <!-- WhatsApp -->
                <a href="https://wa.me/<?php echo esc_attr( preg_replace( '/\D+/', '', $trip_wa ) ); ?>?text=<?php echo urlencode( 'Hi, I am interested in ' . get_the_title() ); ?>"
                class="tp-btn-action tp-btn-whatsapp"
                target="_blank" rel="noopener noreferrer">
                    <span class="tp-btn-icon">💬</span>
                    <span class="tp-btn-label">WhatsApp Instead</span>
                </a>
            </div>

            <div class="tp-inquiry-footer">
                🔒 No payment required at this stage<br>
                <?php if ( $cancel ) : ?>
                <?php echo esc_html( $cancel ); ?>
                <?php endif; ?>
            </div>
        </div>

                <!-- Price Breakdown Card -->
        <div class="tp-price-breakdown-card">
            <div class="tp-pbd-header">
                <span class="tp-pbd-title">Price Breakdown</span>
                <?php if ( $price_note ) : ?>
                <span class="tp-pbd-note"><?php echo esc_html( $price_note ); ?></span>
                <?php endif; ?>
            </div>

            <!-- Base price row -->
            <div class="tp-pbd-row tp-pbd-base">
                <span class="tp-pbd-label">Base Price</span>
                <span class="tp-pbd-value">
                    <?php echo esc_html( $display_price ); ?>
                    <span class="tp-pbd-pp">/ person</span>
                </span>
            </div>

            <!-- Group discount tiers -->
            <?php if ( ! empty( $tiers ) ) : ?>
            <div class="tp-pbd-tiers">
                <p class="tp-pbd-tiers-label">Group Discounts</p>
                <?php foreach ( $tiers as $tier ) : ?>
                <div class="tp-pbd-tier-row">
                    <span class="tp-pbd-tier-label">
                        👥 <?php echo esc_html( $tier['label'] ); ?>
                    </span>
                    <div class="tp-pbd-tier-right">
                        <span class="tp-pbd-tier-price">
                            <?php echo esc_html( $tier['price'] ); ?>
                        </span>
                        <?php if ( $tier['discount'] ) : ?>
                        <span class="tp-pbd-tier-discount">
                            <?php echo esc_html( $tier['discount'] ); ?>
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Deposit -->
            <?php if ( $deposit ) : ?>
            <div class="tp-pbd-row tp-pbd-deposit">
                <span class="tp-pbd-label">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                        <line x1="1" y1="10" x2="23" y2="10"/>
                    </svg>
                    Deposit to Confirm
                </span>
                <span class="tp-pbd-value tp-pbd-deposit-val">
                    <?php echo esc_html( $deposit ); ?>
                </span>
            </div>
            <?php endif; ?>

            <!-- Balance due -->
            <div class="tp-pbd-row tp-pbd-balance">
                <span class="tp-pbd-label">Balance Due</span>
                <span class="tp-pbd-value tp-pbd-balance-val">
                    <?php echo esc_html( $balance_due ); ?>
                </span>
            </div>

            <!-- No payment note -->
            <div class="tp-pbd-footer">
                🔒 No payment required to send an enquiry
            </div>
        </div>

    </aside>

</div><!-- .tp-page-body -->
    <!-- ── TRAVELLER REVIEWS ──────────────────────── -->
    <?php
    $reviews = array();
    for ( $r = 1; $r <= 6; $r++ ) {
        $r_quote = get_post_meta( get_the_ID(), "_trip_review_{$r}_quote", true );
        if ( $r_quote ) {
            $reviews[] = array(
                'name'    => get_post_meta( get_the_ID(), "_trip_review_{$r}_name",    true ),
                'country' => get_post_meta( get_the_ID(), "_trip_review_{$r}_country", true ),
                'rating'  => get_post_meta( get_the_ID(), "_trip_review_{$r}_rating",  true ) ?: '5',
                'quote'   => $r_quote,
                'photo'   => get_post_meta( get_the_ID(), "_trip_review_{$r}_photo",   true ),
                'date'    => get_post_meta( get_the_ID(), "_trip_review_{$r}_date",    true ),
            );
        }
    }
    ?>

    <?php if ( ! empty( $reviews ) ) : ?>
    <section class="tp-reviews-section">
        <div class="tp-reviews-inner">

            <!-- Header -->
            <div class="tp-reviews-header">
                <p class="tp-reviews-kicker">What Travellers Say</p>
                <h2 class="tp-reviews-title">Traveller Reviews</h2>
                <div class="tp-reviews-summary">
                    <a href="mailto:<?php echo esc_attr( get_option('admin_email') ); ?>?subject=My Review: <?php the_title_attribute(); ?>"
                    class="tp-reviews-write-cta">
                        Share Your Experience →
                    </a>
                    <div class="tp-reviews-avg-stars">
                        <?php
                        $avg = array_sum( array_column( $reviews, 'rating' ) ) / count( $reviews );
                        for ( $s = 1; $s <= 5; $s++ ) {
                            echo $s <= round( $avg ) ? '★' : '☆';
                        }
                        ?>
                    </div>
                    <span class="tp-reviews-avg-text">
                        <?php echo number_format( $avg, 1 ); ?> out of 5
                        &nbsp;·&nbsp;
                        <?php echo count( $reviews ); ?> review<?php echo count( $reviews ) > 1 ? 's' : ''; ?>
                    </span>
                </div>
            </div>

            <!-- Review Slider -->
            <div class="tp-reviews-slider">

                <!-- Quotes -->
                <div class="tp-reviews-track" id="tpReviewsTrack">
                    <?php foreach ( $reviews as $idx => $review ) : ?>
                    <div class="tp-review-slide <?php echo $idx === 0 ? 'is-active' : ''; ?>"
                        data-index="<?php echo $idx; ?>">

                        <!-- Stars -->
                        <div class="tp-review-stars">
                            <?php
                            $rating = (int) $review['rating'];
                            for ( $s = 1; $s <= 5; $s++ ) {
                                echo '<span class="' . ( $s <= $rating ? 'tp-star-filled' : 'tp-star-empty' ) . '">★</span>';
                            }
                            ?>
                        </div>

                        <!-- Quote -->
                        <blockquote class="tp-review-quote">
                            "<?php echo esc_html( $review['quote'] ); ?>"
                        </blockquote>

                        <!-- Reviewer -->
                        <div class="tp-reviewer">
                            <?php if ( $review['photo'] ) : ?>
                            <img src="<?php echo esc_url( $review['photo'] ); ?>"
                                alt="<?php echo esc_attr( $review['name'] ); ?>"
                                class="tp-reviewer-photo">
                            <?php else : ?>
                            <div class="tp-reviewer-initials">
                                <?php echo esc_html( strtoupper( substr( $review['name'], 0, 1 ) ) ); ?>
                            </div>
                            <?php endif; ?>
                            <div class="tp-reviewer-info">
                                <span class="tp-reviewer-name">
                                    <?php echo esc_html( $review['name'] ); ?>
                                </span>
                                <span class="tp-reviewer-meta">
                                    <?php if ( $review['country'] ) echo esc_html( $review['country'] ); ?>
                                    <?php if ( $review['country'] && $review['date'] ) echo ' &nbsp;·&nbsp; '; ?>
                                    <?php if ( $review['date'] ) echo esc_html( $review['date'] ); ?>
                                </span>
                            </div>
                        </div>

                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Navigation -->
                <?php if ( count( $reviews ) > 1 ) : ?>
                <div class="tp-reviews-nav">
                    <button class="tp-reviews-prev" id="tpReviewsPrev" aria-label="Previous review">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <polyline points="15 18 9 12 15 6"/>
                        </svg>
                    </button>

                    <div class="tp-reviews-dots" id="tpReviewsDots">
                        <?php foreach ( $reviews as $idx => $review ) : ?>
                        <button class="tp-reviews-dot <?php echo $idx === 0 ? 'is-active' : ''; ?>"
                                data-index="<?php echo $idx; ?>"></button>
                        <?php endforeach; ?>
                    </div>

                    <button class="tp-reviews-next" id="tpReviewsNext" aria-label="Next review">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <polyline points="9 18 15 12 9 6"/>
                        </svg>
                    </button>
                </div>
                <?php endif; ?>

            </div>

        </div>
    </section>
    <?php endif; ?>
<!-- ── RELATED TRIPS ─────────────────────────── -->
<?php
// Get current trip's region
$current_id     = get_the_ID();
$current_region = get_the_terms( $current_id, 'region' );
$related_trips  = array();

// First try: same region
if ( $current_region && ! is_wp_error( $current_region ) ) {
    $region_ids = wp_list_pluck( $current_region, 'term_id' );

    $same_region = get_posts( array(
        'post_type'      => 'trips',
        'posts_per_page' => 3,
        'post__not_in'   => array( $current_id ),
        'orderby'        => 'rand',
        'tax_query'      => array(
            array(
                'taxonomy' => 'region',
                'field'    => 'term_id',
                'terms'    => $region_ids,
            ),
        ),
    ) );

    $related_trips = $same_region;
}

// Fill remaining slots from any other trips
if ( count( $related_trips ) < 3 ) {
    $exclude_ids   = array( $current_id );
    $exclude_ids   = array_merge( $exclude_ids, wp_list_pluck( $related_trips, 'ID' ) );
    $needed        = 3 - count( $related_trips );

    $other_trips = get_posts( array(
        'post_type'      => 'trips',
        'posts_per_page' => $needed,
        'post__not_in'   => $exclude_ids,
        'orderby'        => 'rand',
    ) );

    $related_trips = array_merge( $related_trips, $other_trips );
}
?>

<?php if ( ! empty( $related_trips ) ) :
    // Get region name for the subtitle
    $region_name = ( $current_region && ! is_wp_error( $current_region ) )
        ? $current_region[0]->name
        : 'Nepal';
?>
<section class="tp-related-section">
    <div class="tp-related-inner">

        <div class="tp-related-header">
            <div>
                <p class="tp-related-kicker">Explore More</p>
                <h2 class="tp-related-title">You Might Also Like</h2>
                <p class="tp-related-sub">More treks in <?php echo esc_html( $region_name ); ?></p>
            </div>
            <a href="<?php echo esc_url( home_url( '/trips' ) ); ?>"
               class="tp-related-view-all">
                View All Treks →
            </a>
        </div>

        <div class="tp-related-grid">
            <?php foreach ( $related_trips as $trip ) :
                $t_id         = $trip->ID;
                $t_price      = get_post_meta( $t_id, '_trip_price', true )      ?: '';
                $t_sale       = get_post_meta( $t_id, '_trip_sale_price', true ) ?: '';
                $t_display    = $t_sale ?: $t_price;
                $t_duration   = get_post_meta( $t_id, '_trip_duration', true )   ?: '';
                $t_difficulty = get_post_meta( $t_id, '_trip_difficulty', true ) ?: '';
                $t_altitude   = get_post_meta( $t_id, '_trip_max_altitude', true ) ?: '';
                $t_thumb      = get_the_post_thumbnail_url( $t_id, 'large' );
                $t_link       = get_permalink( $t_id );
                $t_region     = get_the_terms( $t_id, 'region' );
                $t_region_name = ( $t_region && ! is_wp_error( $t_region ) )
                    ? $t_region[0]->name : '';

                // Difficulty badge color
                $t_diff_colors = array(
                    'Easy'               => 'badge-green',
                    'Easy-Moderate'      => 'badge-green',
                    'Moderate'           => 'badge-amber',
                    'Moderate-Strenuous' => 'badge-amber',
                    'Strenuous'          => 'badge-red',
                    'Expert'             => 'badge-red',
                );
                $t_badge = $t_diff_colors[ $t_difficulty ] ?? 'badge-amber';

                // Discount
                $t_discount = '';
                if ( $t_sale && $t_price ) {
                    $p_num = (float) preg_replace( '/[^0-9.]/', '', $t_price );
                    $s_num = (float) preg_replace( '/[^0-9.]/', '', $t_sale );
                    if ( $p_num > 0 && $s_num > 0 && $s_num < $p_num ) {
                        $t_discount = round( ( ( $p_num - $s_num ) / $p_num ) * 100 );
                    }
                }
            ?>
            <a href="<?php echo esc_url( $t_link ); ?>" class="tp-related-card">

                <!-- Image -->
                <div class="tp-related-img"
                     style="background-image: url('<?php echo esc_url( $t_thumb ?: get_template_directory_uri() . '/images/trip-placeholder.jpg' ); ?>')">
                    <?php if ( $t_region_name ) : ?>
                    <span class="tp-related-region-tag"><?php echo esc_html( $t_region_name ); ?></span>
                    <?php endif; ?>
                    <!-- Badges on related trip cards -->
                    <?php echo desire_get_trip_badges( $t_id, 'trip-badge--card' ); ?>
                    <?php if ( $t_discount ) : ?>
                    <span class="tp-related-discount-badge"><?php echo (int) $t_discount; ?>% OFF</span>
                    <?php endif; ?>
                </div>

                <!-- Content -->
                <div class="tp-related-content">
                    <h3 class="tp-related-name"><?php echo esc_html( $trip->post_title ); ?></h3>

                    <div class="tp-related-chips">
                        <?php if ( $t_duration ) : ?>
                        <span class="tp-chip">📅 <?php echo esc_html( $t_duration ); ?></span>
                        <?php endif; ?>
                        <?php if ( $t_altitude ) : ?>
                        <span class="tp-chip">⛰ <?php echo esc_html( $t_altitude ); ?></span>
                        <?php endif; ?>
                        <?php if ( $t_difficulty ) : ?>
                        <span class="tp-badge <?php echo esc_attr( $t_badge ); ?>">
                            <?php echo esc_html( $t_difficulty ); ?>
                        </span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Footer -->
                <div class="tp-related-footer">
                    <div class="tp-related-price-block">
                        <?php if ( $t_sale && $t_price ) : ?>
                        <span class="tp-related-price-was"><?php echo esc_html( $t_price ); ?></span>
                        <?php endif; ?>
                        <span class="tp-related-price">
                            <?php echo $t_display ? esc_html( $t_display ) : 'Contact Us'; ?>
                        </span>
                        <?php if ( $t_display ) : ?>
                        <span class="tp-related-pp">/ person</span>
                        <?php endif; ?>
                    </div>
                    <span class="tp-related-cta">View Trip →</span>
                </div>

            </a>
            <?php endforeach; ?>
        </div>

    </div>
</section>
<?php endif; ?>
<?php wp_reset_postdata(); ?>
<!-- ── BOOK NOW POPUP ─────────────────────── -->
<div class="tp-popup-overlay" id="popupBookNow">
    <div class="tp-popup">
        <div class="tp-popup-head">
            <h3>Choose Your Date</h3>
            <button class="tp-popup-close" data-popup="popupBookNow">&times;</button>
        </div>
        <div class="tp-popup-body">
            <span class="tp-popup-label">Select Departure Date</span>
            <div class="tp-calendar" id="calBookNow"></div>
            <p class="tp-cal-legend">
                <span class="tp-cal-dot-sample"></span> Dots indicate scheduled group departure dates
            </p>

            <span class="tp-popup-label">Number of People</span>
            <div class="tp-pax-selector">
                <button class="tp-pax-btn" data-action="minus" data-target="paxBookNow">−</button>
                <div class="tp-pax-display">
                    <span class="tp-pax-val" id="paxBookNow">2</span>
                    <span class="tp-pax-unit">people</span>
                </div>
                <button class="tp-pax-btn" data-action="plus" data-target="paxBookNow">+</button>
            </div>
            <p class="tp-pax-note">Maximum 10 people per booking</p>

            <div class="tp-group-note">
                <span>💡</span>
                <div>
                    Groups of 5+ get special discounts.
                    <a href="https://wa.me/<?php echo esc_attr( preg_replace( '/\D+/', '', $trip_wa ) ); ?>" target="_blank">WhatsApp us</a>
                    for a custom group quote.
                </div>
            </div>

            <button class="tp-btn-continue" id="btnContinueBook">
                Continue to Book →
            </button>
        </div>
    </div>
</div>

<!-- ── JOIN DEPARTURE POPUP ──────────────────── -->
<div class="tp-popup-overlay" id="popupJoinDep">
    <div class="tp-popup">
        <div class="tp-popup-head">
            <h3>Join This Departure</h3>
            <button class="tp-popup-close" data-popup="popupJoinDep">&times;</button>
        </div>
        <div class="tp-popup-body">
            <div class="tp-dep-confirm-badge" id="depConfirmBadge">
                <span class="tp-dep-confirm-icon">✅</span>
                <div>
                    <div class="tp-dep-confirm-title" id="depConfirmTitle">Joining departure</div>
                    <div class="tp-dep-confirm-sub">Fixed group departure dates</div>
                </div>
            </div>

            <div class="tp-dep-price-badge" id="depPriceBadge" style="display:none">
                <span>🏷</span>
                <div>
                    <div class="tp-dep-price-title" id="depPriceTitle"></div>
                    <div class="tp-dep-price-sub">Special departure price</div>
                </div>
            </div>

            <span class="tp-popup-label">Number of People</span>
            <div class="tp-pax-selector">
                <button class="tp-pax-btn" data-action="minus" data-target="paxJoinDep">−</button>
                <div class="tp-pax-display">
                    <span class="tp-pax-val" id="paxJoinDep">2</span>
                    <span class="tp-pax-unit">people</span>
                </div>
                <button class="tp-pax-btn" data-action="plus" data-target="paxJoinDep">+</button>
            </div>

            <label class="tp-dep-checkbox-wrap">
                <input type="checkbox" id="joinDepConfirm">
                <span>I confirm I want to join this scheduled group departure and understand the dates are fixed.</span>
            </label>

            <button class="tp-btn-continue" id="btnContinueJoin">
                Continue to Book →
            </button>
        </div>
    </div>
</div>

<!-- ── ENQUIRY POPUP ──────────────────────────── -->
<div class="tp-popup-overlay" id="popupEnquiry">
    <div class="tp-popup">
        <div class="tp-popup-head">
            <h3>Send an Enquiry</h3>
            <button class="tp-popup-close" data-popup="popupEnquiry">&times;</button>
        </div>
        <div class="tp-popup-body">
            <form class="tp-enquiry-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="POST">
                <?php wp_nonce_field( 'tp_enquiry_submit', 'tp_enquiry_nonce' ); ?>
                <input type="hidden" name="action" value="tp_enquiry">
                <input type="hidden" name="trip_name" value="<?php the_title_attribute(); ?>">

                <div class="tp-field">
                    <label>Full Name</label>
                    <input type="text" name="tp_name" placeholder="Your full name" required>
                </div>
                <div class="tp-field-row">
                    <div class="tp-field">
                        <label>Email</label>
                        <input type="email" name="tp_email" placeholder="your@email.com" required>
                    </div>
                    <div class="tp-field">
                        <label>Phone</label>
                        <input type="tel" name="tp_phone" placeholder="+1 000 0000">
                    </div>
                </div>
                <div class="tp-field">
                    <label>Message</label>
                    <textarea name="tp_message" placeholder="Any questions or special requirements..." rows="4"></textarea>
                </div>
                <button type="submit" class="tp-btn-continue">Send Enquiry →</button>
            </form>
        </div>
    </div>
</div>

    <!-- ── MOBILE BOOKING FLOATER ─────────────────── -->
    <div class="tp-mobile-floater" id="tpMobileFloater">

        <!-- Expanded Options Panel -->
        <div class="tp-floater-panel" id="tpFloaterPanel">
            <p class="tp-floater-panel-label">What would you like to do?</p>

            <button class="tp-floater-option" id="mBtnBookNow">
                <span>📅</span>
                <div>
                    <span class="tp-fo-title">Book Now</span>
                    <span class="tp-fo-sub">Choose your date and people</span>
                </div>
            </button>

            <?php if ( ! empty( $departures ) ) : ?>
            <button class="tp-floater-option" id="mBtnJoinDep">
                <span>🗓</span>
                <div>
                    <span class="tp-fo-title">Join a Departure</span>
                    <span class="tp-fo-sub">Get group discounts</span>
                </div>
            </button>
            <?php endif; ?>

            <button class="tp-floater-option" id="mBtnEnquiry">
                <span>✉</span>
                <div>
                    <span class="tp-fo-title">Enquiry Now</span>
                    <span class="tp-fo-sub">Ask us anything</span>
                </div>
            </button>

            <a href="https://wa.me/<?php echo esc_attr( preg_replace( '/\D+/', '', $trip_wa ) ); ?>"
            class="tp-floater-option tp-fo-wa" target="_blank" rel="noopener noreferrer">
                <span>💬</span>
                <div>
                    <span class="tp-fo-title">WhatsApp Instead</span>
                    <span class="tp-fo-sub">Chat with us directly</span>
                </div>
            </a>
        </div>

        <!-- Trigger Button -->
        <div class="tp-floater-bottom">
            <div class="tp-floater-price-block">
                <span class="tp-floater-from">From</span>
                <span class="tp-floater-price"><?php echo esc_html( $display_price ); ?></span>
                <?php if ( $discount ) : ?>
                <span class="tp-mobile-discount"><?php echo (int) $discount; ?>% OFF</span>
                <?php endif; ?>
            </div>
            <button class="tp-floater-trigger" id="tpFloaterTrigger" aria-expanded="false">
                <div class="tp-floater-icon">
                    <svg class="icon-menu" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round">
                        <line x1="3" y1="6" x2="21" y2="6"/>
                        <line x1="3" y1="12" x2="21" y2="12"/>
                        <line x1="3" y1="18" x2="21" y2="18"/>
                    </svg>
                    <svg class="icon-close" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </div>
                <span class="tp-floater-trigger-text">Book</span>
            </button>
        </div>
    </div>

    <!-- ── PASS TRIP DATA TO JAVASCRIPT ──────────── -->
    <script>
    var tpTripData = {
        tripId:       <?php echo get_the_ID(); ?>,
        tripName:     <?php echo json_encode( get_the_title() ); ?>,
        price:        <?php echo json_encode( $display_price ); ?>,
        duration:     <?php echo json_encode( $duration ); ?>,
        bookingPage:  <?php echo json_encode( home_url( '/booking/' ) ); ?>,
        departures:   <?php echo json_encode( $departure_dates_js ); ?>
    };
    </script>

<!-- ── GALLERY LIGHTBOX ───────────────────────── -->
<dialog id="tp-lightbox" class="tp-lightbox" onclick="this.close()">
    <img id="tp-lightbox-img" src="" alt="Trip photo">
</dialog>
<button class="tp-lightbox-close" id="tp-lightbox-close" onclick="document.getElementById('tp-lightbox').close()">&times;</button>
    <!-- ── PRINT / PDF TEMPLATE ─────────────────── -->
    <div id="tp-print-template" style="display:none">
        <div class="tp-print-doc">

            <!-- Print Header -->
            <div class="tp-print-header">
                <div class="tp-print-logo">
                    <?php
                    $custom_logo = get_theme_mod( 'custom_logo' );
                    if ( $custom_logo ) {
                        echo wp_get_attachment_image( $custom_logo, 'medium' );
                    } else {
                        echo '<span class="tp-print-logo-text">' . get_bloginfo( 'name' ) . '</span>';
                    }
                    ?>
                </div>
                <div class="tp-print-trip-meta">
                    <h1 class="tp-print-title"><?php the_title(); ?></h1>
                    <div class="tp-print-meta-row">
                        <?php if ( $duration )   echo '<span>📅 ' . esc_html( $duration ) . '</span>'; ?>
                        <?php if ( $altitude )   echo '<span>⛰ ' . esc_html( $altitude ) . '</span>'; ?>
                        <?php if ( $difficulty ) echo '<span>🎯 ' . esc_html( $difficulty ) . '</span>'; ?>
                        <?php if ( $starts )     echo '<span>📍 ' . esc_html( $starts ) . '</span>'; ?>
                        <?php if ( $season )     echo '<span>🌤 ' . esc_html( $season ) . '</span>'; ?>
                    </div>
                </div>
            </div>

            <!-- Price Block -->
            <?php if ( $display_price ) : ?>
            <div class="tp-print-price-block">
                <span class="tp-print-price-label">From</span>
                <span class="tp-print-price-val"><?php echo esc_html( $display_price ); ?></span>
                <span class="tp-print-price-pp">per person</span>
                <?php if ( $discount ) : ?>
                <span class="tp-print-discount"><?php echo (int) $discount; ?>% OFF</span>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <!-- Overview -->
            <div class="tp-print-section">
                <h2 class="tp-print-section-title">Overview</h2>
                <div class="tp-print-content">
                    <?php the_content(); ?>
                </div>
            </div>

            <!-- Itinerary -->
            <?php if ( ! empty( $days ) ) : ?>
            <div class="tp-print-section tp-print-page-break">
                <h2 class="tp-print-section-title">Day by Day Itinerary</h2>
                <?php foreach ( $days as $idx => $day ) :
                    $day_num = $idx + 1;
                ?>
                <div class="tp-print-day">
                    <div class="tp-print-day-num">Day <?php echo $day_num; ?></div>
                    <div class="tp-print-day-body">
                        <h4 class="tp-print-day-title"><?php echo esc_html( $day['title'] ); ?></h4>
                        <div class="tp-print-day-chips">
                            <?php if ( $day['duration'] ) echo '<span>' . esc_html( $day['duration'] ) . '</span>'; ?>
                            <?php if ( $day['altitude'] ) echo '<span>' . esc_html( $day['altitude'] ) . '</span>'; ?>
                        </div>
                        <?php if ( $day['desc'] ) : ?>
                        <p class="tp-print-day-desc"><?php echo esc_html( $day['desc'] ); ?></p>
                        <?php endif; ?>
                        <!-- Day photo — only in PDF download, hidden for print -->
                        <?php if ( $day['photo'] ) : ?>
                        <img src="<?php echo esc_url( $day['photo'] ); ?>"
                            class="tp-print-day-photo tp-pdf-only"
                            alt="Day <?php echo $day_num; ?>">
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Includes & Excludes -->
            <?php if ( $includes || $excludes ) : ?>
            <div class="tp-print-section tp-print-page-break">
                <h2 class="tp-print-section-title">Includes &amp; Excludes</h2>
                <div class="tp-print-inc-grid">
                    <?php if ( $includes ) : ?>
                    <div class="tp-print-inc-col">
                        <h4 style="color:#1A2E20;margin-bottom:8px">✓ Included</h4>
                        <ul>
                            <?php foreach ( explode( "\n", $includes ) as $item ) :
                                $item = trim( $item );
                                if ( $item ) echo '<li>' . esc_html( $item ) . '</li>';
                            endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    <?php if ( $excludes ) : ?>
                    <div class="tp-print-inc-col">
                        <h4 style="color:#c0392b;margin-bottom:8px">✕ Excluded</h4>
                        <ul>
                            <?php foreach ( explode( "\n", $excludes ) as $item ) :
                                $item = trim( $item );
                                if ( $item ) echo '<li>' . esc_html( $item ) . '</li>';
                            endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Print Footer -->
            <div class="tp-print-footer">
                <p><?php echo get_bloginfo( 'name' ); ?> &nbsp;·&nbsp;
                <?php echo get_bloginfo( 'url' ); ?> &nbsp;·&nbsp;
                <?php echo esc_html( get_theme_mod( 'desire_ft_phone', '+977 9851233710' ) ); ?> &nbsp;·&nbsp;
                <?php echo esc_html( get_theme_mod( 'desire_ft_email', 'info@desireadventure.com' ) ); ?>
                </p>
                <p style="margin-top:4px;color:#999;font-size:10px">
                    Generated on <?php echo date( 'j F Y' ); ?>
                </p>
            </div>

        </div>
    </div>
<?php endwhile; endif; ?>
<?php get_template_part( 'parts/footer' ); ?>