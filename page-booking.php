<?php
/**
 * Template Name: Booking Page
 */
get_template_part( 'parts/header' );

// Read URL parameters
$trip_id    = isset( $_GET['trip_id'] ) ? (int) $_GET['trip_id'] : 0;
$trip_name  = isset( $_GET['trip'] )    ? sanitize_text_field( $_GET['trip'] ) : '';
$date       = isset( $_GET['date'] )    ? sanitize_text_field( $_GET['date'] ) : '';
$end_date   = isset( $_GET['end'] )     ? sanitize_text_field( $_GET['end'] ) : '';
$pax        = isset( $_GET['pax'] )     ? (int) $_GET['pax'] : 1;
$type       = isset( $_GET['type'] )    ? sanitize_text_field( $_GET['type'] ) : 'custom';

$is_departure = $type === 'departure';

// Get trip details if ID provided
$trip_price     = '';
$trip_duration  = '';
$trip_permalink = '';
if ( $trip_id ) {
    $trip_price     = get_post_meta( $trip_id, '_trip_price', true );
    $sale_price     = get_post_meta( $trip_id, '_trip_sale_price', true );
    $trip_duration  = get_post_meta( $trip_id, '_trip_duration', true );
    $trip_permalink = get_permalink( $trip_id );
    if ( $sale_price ) $trip_price = $sale_price;
    if ( ! $trip_name ) $trip_name = get_the_title( $trip_id );
}

// Format dates nicely
$date_formatted     = $date     ? date( 'j F Y', strtotime( $date ) )     : '';
$end_date_formatted = $end_date ? date( 'j F Y', strtotime( $end_date ) ) : '';
?>

<div class="bk-page">

    <!-- Header -->
    <div class="bk-header">
        <div class="bk-header-inner">
            <?php if ( $trip_permalink ) : ?>
            <a href="<?php echo esc_url( $trip_permalink ); ?>" class="bk-back">
                ← Back to trip
            </a>
            <?php endif; ?>
            <h1 class="bk-title">Complete Your Booking</h1>
            <p class="bk-subtitle"><?php echo esc_html( $trip_name ); ?></p>
        </div>
    </div>

    <div class="bk-body">

        <!-- Booking Summary -->
        <div class="bk-summary">
            <h3 class="bk-summary-title">Booking Summary</h3>

            <?php if ( $is_departure ) : ?>
            <div class="bk-dep-tag">
                <span>🗓</span>
                <div>
                    <strong>Joining Group Departure</strong>
                    <span>Fixed dates — shared adventure</span>
                </div>
            </div>
            <?php endif; ?>

            <div class="bk-summary-rows">
                <?php if ( $trip_name ) : ?>
                <div class="bk-summary-row">
                    <span>Trek</span>
                    <span><?php echo esc_html( $trip_name ); ?></span>
                </div>
                <?php endif; ?>

                <div class="bk-summary-row">
                    <span>Departure Date</span>
                    <span class="<?php echo $is_departure ? 'bk-date-fixed' : ''; ?>">
                        <?php echo esc_html( $date_formatted ?: 'Not selected' ); ?>
                        <?php if ( $is_departure ) echo ' 🔒'; ?>
                    </span>
                </div>

                <?php if ( $end_date_formatted ) : ?>
                <div class="bk-summary-row">
                    <span>Return Date</span>
                    <span><?php echo esc_html( $end_date_formatted ); ?></span>
                </div>
                <?php endif; ?>

                <?php if ( $trip_duration ) : ?>
                <div class="bk-summary-row">
                    <span>Duration</span>
                    <span><?php echo esc_html( $trip_duration ); ?></span>
                </div>
                <?php endif; ?>

                <div class="bk-summary-row">
                    <span>Number of People</span>
                    <span><?php echo (int) $pax; ?> <?php echo $pax == 1 ? 'person' : 'people'; ?></span>
                </div>

                <?php if ( $trip_price ) : ?>
                <div class="bk-summary-row bk-summary-total">
                    <span>Price (per person)</span>
                    <span><?php echo esc_html( $trip_price ); ?></span>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Booking Form -->
        <div class="bk-form-wrap">
            <h3 class="bk-form-title">Your Details</h3>

            <form class="bk-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="POST">
                <?php wp_nonce_field( 'tp_booking_submit', 'tp_booking_nonce' ); ?>
                <input type="hidden" name="action"      value="tp_booking">
                <input type="hidden" name="trip_id"     value="<?php echo (int) $trip_id; ?>">
                <input type="hidden" name="trip_name"   value="<?php echo esc_attr( $trip_name ); ?>">
                <input type="hidden" name="date"        value="<?php echo esc_attr( $date ); ?>">
                <input type="hidden" name="end_date"    value="<?php echo esc_attr( $end_date ); ?>">
                <input type="hidden" name="pax"         value="<?php echo (int) $pax; ?>">
                <input type="hidden" name="type"        value="<?php echo esc_attr( $type ); ?>">

                <div class="bk-field">
                    <label>Full Name <span>*</span></label>
                    <input type="text" name="bk_name" placeholder="Your full name" required>
                </div>

                <div class="bk-field-row">
                    <div class="bk-field">
                        <label>Email <span>*</span></label>
                        <input type="email" name="bk_email" placeholder="your@email.com" required>
                    </div>
                    <div class="bk-field">
                        <label>Phone <span>*</span></label>
                        <input type="tel" name="bk_phone" placeholder="+1 000 0000" required>
                    </div>
                </div>

                <div class="bk-field-row">
                    <div class="bk-field">
                        <label>Country</label>
                        <input type="text" name="bk_country" placeholder="Your country">
                    </div>
                    <div class="bk-field">
                        <label>Experience Level</label>
                        <select name="bk_experience">
                            <option>Beginner</option>
                            <option>Intermediate</option>
                            <option>Advanced</option>
                        </select>
                    </div>
                </div>

                <?php if ( $is_departure ) : ?>
                <div class="bk-dep-confirm-box">
                    <label class="bk-checkbox-label">
                        <input type="checkbox" name="bk_dep_confirm" value="1" required>
                        <span>I confirm I am joining the scheduled group departure on
                        <strong><?php echo esc_html( $date_formatted ); ?></strong>
                        and understand these dates are fixed.</span>
                    </label>
                </div>
                <?php endif; ?>

                <div class="bk-field">
                    <label>Special Requirements or Questions</label>
                    <textarea name="bk_message" placeholder="Dietary requirements, medical conditions, questions..." rows="4"></textarea>
                </div>

                <button type="submit" class="bk-btn-submit">
                    Submit Booking Request →
                </button>

                <p class="bk-form-note">
                    🔒 No payment required at this stage. Our team will contact you within 24 hours to confirm availability and arrange payment.
                </p>
            </form>
        </div>

    </div>
</div>

<?php get_template_part( 'parts/footer' ); ?>