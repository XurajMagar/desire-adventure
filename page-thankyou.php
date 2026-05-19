<?php
/**
 * Template Name: Thank You Page
 */
get_template_part( 'parts/header' );

$type         = isset( $_GET['type'] )    ? sanitize_text_field( $_GET['type'] )    : 'enquiry';
$trip         = isset( $_GET['trip'] )    ? sanitize_text_field( urldecode( $_GET['trip'] ) )    : '';
$booking_ref  = isset( $_GET['ref'] )     ? sanitize_text_field( urldecode( $_GET['ref'] ) )     : '';
$payment_type = isset( $_GET['payment'] ) ? sanitize_text_field( $_GET['payment'] ) : 'later';
$deposit      = isset( $_GET['deposit'] ) ? (float) $_GET['deposit'] : 0;
$is_booking   = $type === 'booking';
$is_pay_now   = $payment_type === 'now';
?>

<div class="ty-page">

    <!-- ── HERO ── -->
    <div class="ty-hero">
        <div class="ty-hero-inner">
            <div class="ty-icon">
                <?php if ( $is_booking ) : ?>
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none"
                     stroke="#fff" stroke-width="1.5" stroke-linecap="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <?php else : ?>
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none"
                     stroke="#fff" stroke-width="1.5" stroke-linecap="round">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                    <polyline points="22,6 12,13 2,6"/>
                </svg>
                <?php endif; ?>
            </div>

            <?php if ( $is_booking ) : ?>
            <h1 class="ty-title">Booking Request Received!</h1>
            <p class="ty-subtitle">
                <?php if ( $trip ) : ?>
                    Your booking request for <strong><?php echo esc_html( $trip ); ?></strong> has been received successfully.
                <?php else : ?>
                    Your booking request has been received successfully.
                <?php endif; ?>
            </p>
            <?php else : ?>
            <h1 class="ty-title">Enquiry Received!</h1>
            <p class="ty-subtitle">
                <?php if ( $trip ) : ?>
                    Thank you for your interest in <strong><?php echo esc_html( $trip ); ?></strong>.
                <?php else : ?>
                    Thank you for reaching out to us.
                <?php endif; ?>
            </p>
            <?php endif; ?>
        </div>
    </div>

    <div class="ty-body">

        <?php if ( $is_booking && $booking_ref ) : ?>
        <!-- Booking Reference Card -->
        <div class="ty-ref-card">
            <div class="ty-ref-inner">
                <div class="ty-ref-left">
                    <span class="ty-ref-label">Your Booking Reference</span>
                    <span class="ty-ref-num"><?php echo esc_html( $booking_ref ); ?></span>
                    <span class="ty-ref-note">Save this reference number — you will need it for all communications with us.</span>
                </div>
                <button class="ty-ref-copy" id="tyRefCopy"
                        data-ref="<?php echo esc_attr( $booking_ref ); ?>">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2">
                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                    </svg>
                    <span id="tyRefCopyText">Copy</span>
                </button>
            </div>

            <?php if ( $is_pay_now && $deposit > 0 ) : ?>
            <div class="ty-deposit-notice">
                <span class="ty-deposit-icon">💳</span>
                <div>
                    <strong>Deposit Required: USD <?php echo number_format( $deposit, 2 ); ?></strong>
                    <p>Our team will send you payment details within 24 hours to secure your booking.</p>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- What Happens Next -->
        <div class="ty-steps-card">
            <h2 class="ty-steps-title">What Happens Next?</h2>
            <div class="ty-steps">

                <div class="ty-step">
                    <div class="ty-step-num">1</div>
                    <div class="ty-step-info">
                        <span class="ty-step-name">
                            <?php echo $is_booking ? 'Booking Request Reviewed' : 'Enquiry Reviewed'; ?>
                        </span>
                        <span class="ty-step-desc">
                            Our team reviews your details and checks availability for your preferred dates.
                        </span>
                    </div>
                </div>

                <div class="ty-step">
                    <div class="ty-step-num">2</div>
                    <div class="ty-step-info">
                        <span class="ty-step-name">We Contact You Within 24 Hours</span>
                        <span class="ty-step-desc">
                            Expect an email or WhatsApp message confirming availability and next steps.
                            <?php if ( $booking_ref ) : ?>
                            Please reference <strong><?php echo esc_html( $booking_ref ); ?></strong> in all communications.
                            <?php endif; ?>
                        </span>
                    </div>
                </div>

                <div class="ty-step">
                    <div class="ty-step-num">3</div>
                    <div class="ty-step-info">
                        <span class="ty-step-name">
                            <?php if ( $is_pay_now ) : ?>
                                Pay Deposit — USD <?php echo $deposit > 0 ? number_format( $deposit, 2 ) : '25%'; ?>
                            <?php elseif ( $is_booking ) : ?>
                                Confirm &amp; Arrange Payment
                            <?php else : ?>
                                Customise Your Trip
                            <?php endif; ?>
                        </span>
                        <span class="ty-step-desc">
                            <?php if ( $is_pay_now ) : ?>
                            We will send payment details for your 25% deposit to fully secure your spot.
                            <?php elseif ( $is_booking ) : ?>
                            We will confirm your spot and discuss payment options that work for you.
                            <?php else : ?>
                            We will work with you to customise the itinerary, dates and group size.
                            <?php endif; ?>
                        </span>
                    </div>
                </div>

                <div class="ty-step">
                    <div class="ty-step-num">4</div>
                    <div class="ty-step-info">
                        <span class="ty-step-name">Get Ready to Trek! 🏔</span>
                        <span class="ty-step-desc">
                            We send a complete pre-departure pack with gear list, visa info, 
                            flight details and everything you need to prepare.
                        </span>
                    </div>
                </div>

            </div>
        </div>

        <!-- Confirmation Email Notice -->
        <div class="ty-email-notice">
            <div class="ty-email-icon">✉️</div>
            <div class="ty-email-text">
                <strong>Confirmation email sent!</strong>
                <p>A booking confirmation with your reference number has been sent to your email. Please check your inbox (and spam folder just in case).</p>
            </div>
        </div>

        <!-- Contact Card -->
        <div class="ty-contact-card">
            <h3 class="ty-contact-title">Need an Immediate Answer?</h3>
            <p class="ty-contact-desc">
                Our team is available 7 days a week. Reach us directly on WhatsApp for the fastest response.
            </p>
            <div class="ty-contact-btns">
                <a href="https://wa.me/<?php echo esc_attr( preg_replace( '/\D+/', '', get_theme_mod( 'desire_whatsapp_number', '+9779851233710' ) ) ); ?>?text=<?php echo urlencode( 'Hi, my booking reference is ' . $booking_ref . '. I wanted to follow up on my booking for ' . $trip . '.' ); ?>"
                   class="ty-btn-wa" target="_blank" rel="noopener noreferrer">
                    💬 WhatsApp Us Now
                </a>
                <a href="mailto:<?php echo esc_attr( get_theme_mod( 'desire_ft_email', get_option( 'admin_email' ) ) ); ?>?subject=Booking Reference <?php echo esc_attr( $booking_ref ); ?>"
                   class="ty-btn-email">
                    ✉ Send an Email
                </a>
            </div>
        </div>

        <!-- Explore More -->
        <div class="ty-explore">
            <p class="ty-explore-text">While you wait, explore more treks</p>
            <div class="ty-explore-btns">
                <a href="<?php echo esc_url( home_url( '/trips' ) ); ?>" class="ty-btn-primary">
                    View All Treks →
                </a>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="ty-btn-secondary">
                    Back to Home
                </a>
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var copyBtn = document.getElementById('tyRefCopy');
    if (copyBtn) {
        copyBtn.addEventListener('click', function() {
            var ref    = this.dataset.ref;
            var textEl = document.getElementById('tyRefCopyText');
            if (navigator.clipboard) {
                navigator.clipboard.writeText(ref).then(function() {
                    textEl.textContent = 'Copied!';
                    setTimeout(function() { textEl.textContent = 'Copy'; }, 2000);
                });
            }
        });
    }
});
</script>

<?php get_template_part( 'parts/footer' ); ?>