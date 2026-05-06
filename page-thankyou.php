<?php
/**
 * Template Name: Thank You Page
 */
get_template_part( 'parts/header' );

// Detect which action brought them here
$type     = isset( $_GET['type'] ) ? sanitize_text_field( $_GET['type'] ) : 'enquiry';
$trip     = isset( $_GET['trip'] ) ? sanitize_text_field( $_GET['trip'] ) : '';
$is_booking = $type === 'booking';
?>

<div class="ty-page">

    <!-- Hero -->
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
            <h1 class="ty-title">Booking Request Sent!</h1>
            <p class="ty-subtitle">
                <?php if ( $trip ) : ?>
                    Your booking request for <strong><?php echo esc_html( $trip ); ?></strong> has been received.
                <?php else : ?>
                    Your booking request has been received.
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

    <!-- Content -->
    <div class="ty-body">

        <!-- What Happens Next -->
        <div class="ty-steps-card">
            <h2 class="ty-steps-title">What Happens Next?</h2>
            <div class="ty-steps">

                <div class="ty-step">
                    <div class="ty-step-num">1</div>
                    <div class="ty-step-info">
                        <span class="ty-step-name">We Review Your Request</span>
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
                            Expect an email or WhatsApp message from us confirming availability and next steps.
                        </span>
                    </div>
                </div>

                <div class="ty-step">
                    <div class="ty-step-num">3</div>
                    <div class="ty-step-info">
                        <span class="ty-step-name">
                            <?php echo $is_booking ? 'Confirm &amp; Deposit' : 'Customise Your Trip'; ?>
                        </span>
                        <span class="ty-step-desc">
                            <?php if ( $is_booking ) : ?>
                            Once availability is confirmed we will send payment details for the deposit to secure your spot.
                            <?php else : ?>
                            We will work with you to customise the itinerary, dates and group size to perfectly fit your needs.
                            <?php endif; ?>
                        </span>
                    </div>
                </div>

                <div class="ty-step">
                    <div class="ty-step-num">4</div>
                    <div class="ty-step-info">
                        <span class="ty-step-name">Get Ready to Trek!</span>
                        <span class="ty-step-desc">
                            We send a full pre-departure pack with gear list, visa info and what to expect on the trail.
                        </span>
                    </div>
                </div>

            </div>
        </div>

        <!-- Quick Contact -->
        <div class="ty-contact-card">
            <h3 class="ty-contact-title">Need an Immediate Answer?</h3>
            <p class="ty-contact-desc">
                Our team is available 7 days a week. Reach us directly on WhatsApp for the fastest response.
            </p>
            <div class="ty-contact-btns">
                <a href="https://wa.me/<?php echo esc_attr( preg_replace( '/\D+/', '', get_theme_mod( 'desire_whatsapp_number', '+9779851233710' ) ) ); ?>?text=<?php echo urlencode( 'Hi, I just sent an enquiry' . ( $trip ? ' for ' . $trip : '' ) . ' and wanted to follow up.' ); ?>"
                   class="ty-btn-wa" target="_blank" rel="noopener noreferrer">
                    💬 WhatsApp Us Now
                </a>
                <a href="mailto:<?php echo esc_attr( get_theme_mod( 'desire_ft_email', get_option( 'admin_email' ) ) ); ?>"
                   class="ty-btn-email">
                    ✉ Send an Email
                </a>
            </div>
        </div>

        <!-- Back to exploring -->
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

<?php get_template_part( 'parts/footer' ); ?>