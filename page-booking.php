<?php
/**
 * Template Name: Booking Page
 */
get_template_part( 'parts/header' );

// Read URL parameters
$trip_id   = isset( $_GET['trip_id'] ) ? (int) $_GET['trip_id']                        : 0;
$trip_name = isset( $_GET['trip'] )    ? sanitize_text_field( $_GET['trip'] )           : '';
$date      = isset( $_GET['date'] )    ? sanitize_text_field( $_GET['date'] )           : '';
$end_date  = isset( $_GET['end'] )     ? sanitize_text_field( $_GET['end'] )            : '';
$pax       = isset( $_GET['pax'] )     ? (int) $_GET['pax']                             : 1;
$type      = isset( $_GET['type'] )    ? sanitize_text_field( $_GET['type'] )           : 'custom';

$is_departure = $type === 'departure';

// Format dates for display
$date_display       = $date     ? date( 'j M Y', strtotime( $date ) )     : '';
$end_display        = $end_date ? date( 'j M Y', strtotime( $end_date ) ) : '';
$date_formatted     = $date     ? date( 'j F Y', strtotime( $date ) )     : '';
$end_date_formatted = $end_date ? date( 'j F Y', strtotime( $end_date ) ) : '';

// Get trip details from meta
$trip_price    = '';
$duration      = '';
$trip_permalink = '';

if ( $trip_id ) {
    $regular_price  = get_post_meta( $trip_id, '_trip_price',      true );
    $sale_price     = get_post_meta( $trip_id, '_trip_sale_price', true );
    $trip_price     = $sale_price ?: $regular_price;
    $duration       = get_post_meta( $trip_id, '_trip_duration',   true );
    $trip_permalink = get_permalink( $trip_id );
    if ( ! $trip_name ) $trip_name = get_the_title( $trip_id );
}

// Calculate amounts
$price_num   = (float) preg_replace( '/[^0-9.]/', '', $trip_price );
$deposit_amt = $price_num > 0 ? round( $price_num * 0.25, 2 ) : 0;
$total_amt   = $price_num * $pax;

// Generate booking reference
$trek_code   = strtoupper( substr( preg_replace( '/[^a-zA-Z]/', '', $trip_name ), 0, 3 ) );
$date_code   = $date ? date( 'Ymd', strtotime( $date ) ) : date( 'Ymd' );
$unique_num  = str_pad( rand( 1, 999 ), 3, '0', STR_PAD_LEFT );
$booking_ref = $trek_code . '-' . $date_code . '-' . $unique_num;
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

        <div class="bk-summary">
            <h2 class="bk-summary-title">Booking Summary</h2>

            <!-- Booking Reference -->
            <div class="bk-ref-badge">
                <span class="bk-ref-label">Booking Reference</span>
                <span class="bk-ref-num"><?php echo esc_html( $booking_ref ); ?></span>
            </div>

            <?php if ( $is_departure && $date_display ) : ?>
            <div class="bk-dep-tag">
                <span>🗓</span>
                <div>
                    <strong>Group Departure</strong>
                    <span><?php echo esc_html( $date_display ); ?><?php echo $end_display ? ' – ' . esc_html( $end_display ) : ''; ?></span>
                </div>
            </div>
            <?php endif; ?>

            <div class="bk-summary-row">
                <span>Trek</span>
                <span><?php echo esc_html( $trip_name ); ?></span>
            </div>

            <div class="bk-summary-row">
                <span>Departure Date</span>
                <span class="<?php echo $is_departure ? 'bk-date-fixed' : ''; ?>">
                    <?php echo esc_html( $date_display ); ?>
                </span>
            </div>

            <div class="bk-summary-row">
                <span>Duration</span>
                <span><?php echo esc_html( $duration ); ?></span>
            </div>

            <div class="bk-summary-row">
                <span>Number of People</span>
                <span><?php echo (int) $pax; ?> people</span>
            </div>

            <div class="bk-summary-row">
                <span>Price (per person)</span>
                <span style="color:#C17F3A;font-weight:700"><?php echo esc_html( $trip_price ); ?></span>
            </div>

            <?php if ( $total_amt > 0 ) : ?>
            <div class="bk-summary-row bk-summary-total">
                <span>Total Amount</span>
                <span>USD <?php echo number_format( $total_amt, 0 ); ?></span>
            </div>
            <?php endif; ?>

            <?php if ( $deposit_amt > 0 ) : ?>
            <div class="bk-summary-row bk-deposit-row">
                <span>
                    Deposit to Confirm (25%)
                    <small style="display:block;font-size:10px;color:#aaa;margin-top:2px">Per person only</small>
                </span>
            </div>
            <?php endif; ?>

            <!-- Hidden field to pass booking ref -->
            <input type="hidden" id="bk_booking_ref" value="<?php echo esc_attr( $booking_ref ); ?>">
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
                <!-- Payment Option -->
                <div class="bk-payment-option">
                    <p class="bk-payment-label">How would you like to proceed?</p>

                    <label class="bk-payment-choice <?php echo ( isset($_POST['bk_payment']) && $_POST['bk_payment'] === 'later' ) ? 'is-selected' : 'is-selected'; ?>" id="bkChoiceLater">
                        <input type="radio" name="bk_payment" value="later" checked>
                        <div class="bk-payment-choice-inner">
                            <span class="bk-payment-icon">📋</span>
                            <div class="bk-payment-info">
                                <span class="bk-payment-title">Book Now, Pay Later</span>
                                <span class="bk-payment-sub">
                                    Send enquiry and our team will contact you within 24 hours with payment details.
                                </span>
                            </div>
                        </div>
                    </label>

                    <label class="bk-payment-choice" id="bkChoiceNow">
                        <input type="radio" name="bk_payment" value="now">
                        <div class="bk-payment-choice-inner">
                            <span class="bk-payment-icon">💳</span>
                            <div class="bk-payment-info">
                                <span class="bk-payment-title">
                                    Pay 25% Deposit to Confirm
                                    <?php if ( $deposit_amt > 0 ) : ?>
                                    <span class="bk-payment-amount">USD <?php echo number_format( $deposit_amt, 2 ); ?></span>
                                    <?php endif; ?>
                                </span>
                                <span class="bk-payment-sub">
                                    Secure your spot immediately by paying the deposit online.
                                </span>
                            </div>
                        </div>
                    </label>

                    <!-- Pay Now notice -->
                    <div class="bk-pay-now-notice" id="bkPayNowNotice" style="display:none">
                        <div class="bk-pay-notice-inner">
                            <span>🚧</span>
                            <div>
                                <strong>Online payment coming soon!</strong>
                                <p>Our payment gateway is being set up. Your booking will be submitted as an enquiry and we will send you payment details via WhatsApp or email within 24 hours.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pass booking ref and payment type to handler -->
                <input type="hidden" name="bk_booking_ref" id="bkBookingRefInput" value="">
                <input type="hidden" name="bk_payment_type" id="bkPaymentTypeInput" value="later">
                <button type="submit" class="bk-btn-submit">
                    Submit Booking Request →
                </button>

                <p class="bk-form-note">
                    🔒 No payment required at this stage. Our team will contact you within 24 hours to confirm availability and arrange payment.
                </p>
                <input type="hidden" name="trip_price" value="<?php echo esc_attr( get_post_meta( $trip_id, '_trip_sale_price', true ) ?: get_post_meta( $trip_id, '_trip_price', true ) ); ?>">
            </form>
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                var choiceLater = document.getElementById('bkChoiceLater');
                var choiceNow   = document.getElementById('bkChoiceNow');
                var payNotice   = document.getElementById('bkPayNowNotice');
                var payTypeInput = document.getElementById('bkPaymentTypeInput');
                var refInput    = document.getElementById('bkBookingRefInput');
                var bookingRef  = document.getElementById('bk_booking_ref');

                // Set booking ref
                if (refInput && bookingRef) {
                    refInput.value = bookingRef.value;
                }

                var radios = document.querySelectorAll('input[name="bk_payment"]');
                radios.forEach(function(radio) {
                    radio.addEventListener('change', function() {
                        // Update selected state
                        document.querySelectorAll('.bk-payment-choice').forEach(function(el) {
                            el.classList.remove('is-selected');
                        });
                        this.closest('.bk-payment-choice').classList.add('is-selected');

                        // Show/hide pay now notice
                        if (this.value === 'now') {
                            payNotice.style.display = 'block';
                            payTypeInput.value = 'now';
                        } else {
                            payNotice.style.display = 'none';
                            payTypeInput.value = 'later';
                        }
                    });
                });
            });
            </script>
        </div>

    </div>
</div>

<?php get_template_part( 'parts/footer' ); ?>