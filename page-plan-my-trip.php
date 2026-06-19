<?php
/*
 * Template Name: Plan My Trip
 */
get_template_part( 'parts/header' );

// Pre-load all trips as JSON for JS filtering
$all_trips = get_posts( array(
    'post_type'      => 'trips',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
) );

$trips_data = array();
foreach ( $all_trips as $trip ) {
    $id         = $trip->ID;
    $regions    = get_the_terms( $id, 'region' );
    $region_name = ( $regions && ! is_wp_error( $regions ) ) ? $regions[0]->name : '';
    $duration   = get_post_meta( $id, '_trip_duration',     true );
    $difficulty = get_post_meta( $id, '_trip_difficulty',   true );
    $price      = get_post_meta( $id, '_trip_sale_price',   true ) ?: get_post_meta( $id, '_trip_price', true );
    $thumb      = get_the_post_thumbnail_url( $id, 'medium' ) ?: get_template_directory_uri() . '/images/trip-placeholder.webp';
    $days_num   = (int) preg_replace( '/[^0-9]/', '', $duration );
    $price_num  = (int) preg_replace( '/[^0-9]/', '', $price );

    $trips_data[] = array(
        'id'         => $id,
        'name'       => $trip->post_title,
        'url'        => get_permalink( $id ),
        'region'     => $region_name,
        'duration'   => $duration,
        'days'       => $days_num,
        'difficulty' => $difficulty,
        'price'      => $price,
        'price_num'  => $price_num,
        'thumb'      => $thumb,
    );
}
?>

<main class="pmt-page">

    <!-- Hero -->
    <div class="pmt-hero">
        <div class="pmt-hero-inner">
            <p class="pmt-hero-kicker">Desire Adventures</p>
            <h1 class="pmt-hero-title">Plan Your Perfect Trek</h1>
            <p class="pmt-hero-sub">Answer a few questions — we'll match you to the right adventure in Nepal</p>
        </div>
    </div>

    <!-- Planner -->
    <div class="pmt-wrap">
        <div class="pmt-container">

            <!-- Progress Bar -->
            <div class="pmt-progress" id="pmtProgress">
                <div class="pmt-prog-step active" data-step="0">
                    <div class="pmt-prog-num">1</div>
                    <span class="pmt-prog-label">Region</span>
                </div>
                <div class="pmt-prog-line"></div>
                <div class="pmt-prog-step" data-step="1">
                    <div class="pmt-prog-num">2</div>
                    <span class="pmt-prog-label">Duration</span>
                </div>
                <div class="pmt-prog-line"></div>
                <div class="pmt-prog-step" data-step="2">
                    <div class="pmt-prog-num">3</div>
                    <span class="pmt-prog-label">Fitness</span>
                </div>
                <div class="pmt-prog-line"></div>
                <div class="pmt-prog-step" data-step="3">
                    <div class="pmt-prog-num">4</div>
                    <span class="pmt-prog-label">Group</span>
                </div>
                <div class="pmt-prog-line"></div>
                <div class="pmt-prog-step" data-step="4">
                    <div class="pmt-prog-num">5</div>
                    <span class="pmt-prog-label">Budget</span>
                </div>
                <div class="pmt-prog-line"></div>
                <div class="pmt-prog-step" data-step="5">
                    <div class="pmt-prog-num">6</div>
                    <span class="pmt-prog-label">Results</span>
                </div>
            </div>

            <!-- Step Body -->
            <div class="pmt-body" id="pmtBody">

                <!-- Step 1: Region -->
                <div class="pmt-step" id="pmtStep0">
                    <h2 class="pmt-step-title">Which region calls to you?</h2>
                    <p class="pmt-step-desc">Pick the area of Nepal you want to explore</p>
                    <div class="pmt-option-grid">
                        <div class="pmt-opt" data-field="region" data-value="Everest">
                            <span class="pmt-opt-icon">🏔</span>
                            <div class="pmt-opt-name">Everest Region</div>
                            <div class="pmt-opt-sub">Classic Himalayan views</div>
                        </div>
                        <div class="pmt-opt" data-field="region" data-value="Annapurna">
                            <span class="pmt-opt-icon">🌊</span>
                            <div class="pmt-opt-name">Annapurna</div>
                            <div class="pmt-opt-sub">Diverse landscapes</div>
                        </div>
                        <div class="pmt-opt" data-field="region" data-value="Langtang">
                            <span class="pmt-opt-icon">🌲</span>
                            <div class="pmt-opt-name">Langtang</div>
                            <div class="pmt-opt-sub">Off the beaten path</div>
                        </div>
                        <div class="pmt-opt" data-field="region" data-value="Manaslu">
                            <span class="pmt-opt-icon">🧭</span>
                            <div class="pmt-opt-name">Manaslu</div>
                            <div class="pmt-opt-sub">Remote &amp; wild</div>
                        </div>
                        <div class="pmt-opt" data-field="region" data-value="Kanchenjunga">
                            <span class="pmt-opt-icon">🗺</span>
                            <div class="pmt-opt-name">Kanchenjunga</div>
                            <div class="pmt-opt-sub">Adventure seekers</div>
                        </div>
                        <div class="pmt-opt" data-field="region" data-value="any">
                            <span class="pmt-opt-icon">✨</span>
                            <div class="pmt-opt-name">Not sure yet</div>
                            <div class="pmt-opt-sub">Help me decide</div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Duration -->
                <div class="pmt-step hidden" id="pmtStep1">
                    <h2 class="pmt-step-title">How many days do you have?</h2>
                    <p class="pmt-step-desc">Choose a duration that fits your schedule</p>
                    <div class="pmt-option-grid">
                        <div class="pmt-opt" data-field="duration" data-min="1" data-max="7">
                            <span class="pmt-opt-icon">📅</span>
                            <div class="pmt-opt-name">5–7 days</div>
                            <div class="pmt-opt-sub">Short &amp; sweet</div>
                        </div>
                        <div class="pmt-opt" data-field="duration" data-min="8" data-max="12">
                            <span class="pmt-opt-icon">🗓</span>
                            <div class="pmt-opt-name">8–12 days</div>
                            <div class="pmt-opt-sub">Most popular</div>
                        </div>
                        <div class="pmt-opt" data-field="duration" data-min="13" data-max="18">
                            <span class="pmt-opt-icon">📆</span>
                            <div class="pmt-opt-name">13–18 days</div>
                            <div class="pmt-opt-sub">Full experience</div>
                        </div>
                        <div class="pmt-opt" data-field="duration" data-min="19" data-max="999">
                            <span class="pmt-opt-icon">🏕</span>
                            <div class="pmt-opt-name">18+ days</div>
                            <div class="pmt-opt-sub">Epic expedition</div>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Difficulty -->
                <div class="pmt-step hidden" id="pmtStep2">
                    <h2 class="pmt-step-title">What's your fitness level?</h2>
                    <p class="pmt-step-desc">Be honest — your safety matters most</p>
                    <div class="pmt-option-grid">
                        <div class="pmt-opt" data-field="difficulty" data-value="Easy">
                            <span class="pmt-opt-icon">🚶</span>
                            <div class="pmt-opt-name">Easy</div>
                            <div class="pmt-opt-sub">Gentle trails, flat paths</div>
                        </div>
                        <div class="pmt-opt" data-field="difficulty" data-value="Moderate">
                            <span class="pmt-opt-icon">🥾</span>
                            <div class="pmt-opt-name">Moderate</div>
                            <div class="pmt-opt-sub">Some hills, manageable</div>
                        </div>
                        <div class="pmt-opt" data-field="difficulty" data-value="Strenuous">
                            <span class="pmt-opt-icon">🏃</span>
                            <div class="pmt-opt-name">Strenuous</div>
                            <div class="pmt-opt-sub">Long days, steep climbs</div>
                        </div>
                        <div class="pmt-opt" data-field="difficulty" data-value="Expert">
                            <span class="pmt-opt-icon">🏅</span>
                            <div class="pmt-opt-name">Expert</div>
                            <div class="pmt-opt-sub">High altitude, technical</div>
                        </div>
                    </div>
                </div>

                <!-- Step 4: Group Size -->
                <div class="pmt-step hidden" id="pmtStep3">
                    <h2 class="pmt-step-title">How many people are trekking?</h2>
                    <p class="pmt-step-desc">Group size affects pricing and experience</p>
                    <div class="pmt-range-wrap">
                        <div class="pmt-range-display">
                            <span class="pmt-range-val" id="groupVal">2</span>
                            <span class="pmt-range-unit">people</span>
                        </div>
                        <input type="range" id="groupRange" min="1" max="20" value="2" step="1" class="pmt-range-input">
                        <div class="pmt-range-limits">
                            <span>Solo (1)</span>
                            <span>Large group (20+)</span>
                        </div>
                    </div>
                    <div class="pmt-group-note">
                        <span class="pmt-note-icon">💡</span>
                        <p>Groups of 5+ may qualify for special group discounts. Our team will confirm pricing in the inquiry.</p>
                    </div>
                </div>

                <!-- Step 5: Budget -->
                <div class="pmt-step hidden" id="pmtStep4">
                    <h2 class="pmt-step-title">What's your budget per person?</h2>
                    <p class="pmt-step-desc">Approximate USD — helps us match the right package</p>
                    <div class="pmt-range-wrap">
                        <div class="pmt-range-display">
                            <span class="pmt-range-prefix">USD</span>
                            <span class="pmt-range-val" id="budgetVal">1500</span>
                        </div>
                        <input type="range" id="budgetRange" min="300" max="5000" value="1500" step="100" class="pmt-range-input">
                        <div class="pmt-range-limits">
                            <span>USD 300</span>
                            <span>USD 5,000+</span>
                        </div>
                    </div>
                    <div class="pmt-budget-tiers">
                        <div class="pmt-tier">
                            <span class="pmt-tier-label">Budget</span>
                            <span class="pmt-tier-range">USD 300–800</span>
                        </div>
                        <div class="pmt-tier">
                            <span class="pmt-tier-label">Standard</span>
                            <span class="pmt-tier-range">USD 800–1,800</span>
                        </div>
                        <div class="pmt-tier">
                            <span class="pmt-tier-label">Premium</span>
                            <span class="pmt-tier-range">USD 1,800–3,500</span>
                        </div>
                        <div class="pmt-tier">
                            <span class="pmt-tier-label">Luxury</span>
                            <span class="pmt-tier-range">USD 3,500+</span>
                        </div>
                    </div>
                </div>

                <!-- Step 6: Results + Inquiry -->
                <div class="pmt-step hidden" id="pmtStep5">
                    <h2 class="pmt-step-title">Your matched treks</h2>
                    <p class="pmt-step-desc">Based on your preferences — pick one and send your inquiry</p>

                    <div class="pmt-results" id="pmtResults">
                        <!-- Filled by JS -->
                    </div>

                    <div class="pmt-inquiry-wrap">
                        <h3 class="pmt-inquiry-title">Send your inquiry</h3>
                        <p class="pmt-inquiry-sub">Our team responds within 24 hours</p>

                        <form class="pmt-inquiry-form" id="pmtInquiryForm" method="post" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>">
                            <?php wp_nonce_field( 'pmt_inquiry', 'pmt_nonce' ); ?>
                            <input type="hidden" name="action" value="pmt_inquiry">
                            <input type="hidden" name="pmt_selections" id="pmtSelections">
                            <input type="hidden" name="pmt_matched_trip" id="pmtMatchedTrip">

                            <div class="pmt-field-row">
                                <div class="pmt-field">
                                    <label>Full name <span class="pmt-required">*</span></label>
                                    <input type="text" name="pmt_name" placeholder="Your full name" required>
                                </div>
                                <div class="pmt-field">
                                    <label>Email address <span class="pmt-required">*</span></label>
                                    <input type="email" name="pmt_email" placeholder="your@email.com" required>
                                </div>
                            </div>
                            <div class="pmt-field-row">
                                <div class="pmt-field">
                                    <label>Phone / WhatsApp</label>
                                    <input type="tel" name="pmt_phone" placeholder="+977 ...">
                                </div>
                                <div class="pmt-field">
                                    <label>Preferred start date</label>
                                    <input type="date" name="pmt_date">
                                </div>
                            </div>
                            <div class="pmt-field">
                                <label>Message (optional)</label>
                                <textarea name="pmt_message" placeholder="Any special requests, questions, or requirements..."></textarea>
                            </div>

                            <div class="pmt-summary" id="pmtSummary">
                                <!-- Summary pills filled by JS -->
                            </div>

                            <button type="submit" class="pmt-submit-btn">
                                Send Inquiry →
                            </button>
                            <p class="pmt-form-note">No payment required. We'll confirm availability and send a detailed quote.</p>
                        </form>
                    </div>
                </div>

            </div>

            <!-- Footer Nav -->
            <div class="pmt-footer">
                <button class="pmt-btn-back" id="pmtBack">← Back</button>
                <span class="pmt-step-counter" id="pmtCounter">Step 1 of 6</span>
                <button class="pmt-btn-next" id="pmtNext">Continue →</button>
            </div>

        </div>
    </div>

</main>

<script>
var pmtTrips = <?php echo json_encode( $trips_data ); ?>;
</script>

<?php get_template_part( 'parts/footer' ); ?>