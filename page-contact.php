<?php
/**
 * Template Name: Contact Page
 */
get_template_part( 'parts/header' );

// Gather settings
$address   = get_theme_mod( 'desire_contact_address',  'Thamel, Kathmandu, Nepal' );
$phone     = get_theme_mod( 'desire_contact_phone',    '+977 9851233710' );
$whatsapp  = get_theme_mod( 'desire_contact_whatsapp', '+977 9851233710' );
$email     = get_theme_mod( 'desire_contact_email',    'info@desireadventure.com' );
$hours     = get_theme_mod( 'desire_contact_hours',    'Sunday – Friday: 9:00 AM – 6:00 PM NST' );
$response  = get_theme_mod( 'desire_contact_response', 'We typically respond within 24 hours' );
$map_url   = get_theme_mod( 'desire_contact_map_url',  '' );
$wa_number = preg_replace( '/\D+/', '', $whatsapp );

// Get all trips for dropdown
$all_trips = get_posts( array(
    'post_type'      => 'trips',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'title',
    'order'          => 'ASC',
));
?>

<div class="ct-page">

    <!-- ══ HERO ══════════════════════════════════ -->
    <div class="ct-hero">
        <div class="ct-hero-inner">
            <p class="ct-hero-kicker">We'd Love to Hear From You</p>
            <h1 class="ct-hero-title">Get In Touch</h1>
            <p class="ct-hero-sub">
                Planning a trek? Have questions? Our team is ready to help
                you plan the perfect Himalayan adventure.
            </p>
        </div>
    </div>

    <!-- ══ CONTACT GRID ══════════════════════════ -->
    <div class="ct-body">
        <div class="ct-grid">

            <!-- Left — Form -->
            <div class="ct-form-wrap">
                <div class="ct-form-header">
                    <h2 class="ct-form-title">Send Us a Message</h2>
                    <p class="ct-form-sub">
                        <?php echo esc_html( $response ); ?>
                    </p>
                </div>

                <?php
                // NOTE: When switching to Fluent Forms, replace everything
                // between these comments with your shortcode:
                // echo do_shortcode('[fluentform id="1"]');
                // FLUENT FORMS START
                ?>

                <form method="POST"
                      action="<?php echo esc_url( admin_url('admin-post.php') ); ?>"
                      class="ct-form" id="ctContactForm">

                    <?php wp_nonce_field( 'contact_form_submit', 'contact_nonce' ); ?>
                    <input type="hidden" name="action" value="contact_form">

                    <!-- Name + Email -->
                    <div class="ct-field-row">
                        <div class="ct-field">
                            <label class="ct-label">
                                Full Name <span class="ct-required">*</span>
                            </label>
                            <input type="text" name="ct_name"
                                   class="ct-input" required
                                   placeholder="Your full name">
                        </div>
                        <div class="ct-field">
                            <label class="ct-label">
                                Email Address <span class="ct-required">*</span>
                            </label>
                            <input type="email" name="ct_email"
                                   class="ct-input" required
                                   placeholder="your@email.com">
                        </div>
                    </div>

                    <!-- Phone + Trip Interest -->
                    <div class="ct-field-row">
                        <div class="ct-field">
                            <label class="ct-label">Phone Number</label>
                            <input type="tel" name="ct_phone"
                                   class="ct-input"
                                   placeholder="+977 ...">
                        </div>
                        <div class="ct-field">
                            <label class="ct-label">Trip Interest</label>
                            <select name="ct_trip" class="ct-input ct-select">
                                <option value="">— Select a trek —</option>
                                <?php foreach ( $all_trips as $trip_post ) : ?>
                                <option value="<?php echo esc_attr( $trip_post->post_title ); ?>">
                                    <?php echo esc_html( $trip_post->post_title ); ?>
                                </option>
                                <?php endforeach; ?>
                                <option value="Custom Trek">Custom / Private Trek</option>
                                <option value="Not Sure">Not Sure Yet</option>
                            </select>
                        </div>
                    </div>

                    <!-- Date + Group Size -->
                    <div class="ct-field-row">
                        <div class="ct-field">
                            <label class="ct-label">Preferred Travel Date</label>
                            <input type="date" name="ct_date"
                                   class="ct-input">
                        </div>
                        <div class="ct-field">
                            <label class="ct-label">Group Size</label>
                            <select name="ct_group" class="ct-input ct-select">
                                <option value="">— Select —</option>
                                <option value="Solo (1 person)">Solo (1 person)</option>
                                <option value="2 people">2 people</option>
                                <option value="3–4 people">3–4 people</option>
                                <option value="5–8 people">5–8 people</option>
                                <option value="9+ people">9+ people</option>
                            </select>
                        </div>
                    </div>

                    <!-- Message -->
                    <div class="ct-field">
                        <label class="ct-label">
                            Message <span class="ct-required">*</span>
                        </label>
                        <textarea name="ct_message" class="ct-input ct-textarea"
                                  required rows="5"
                                  placeholder="Tell us about your dream trek — dates, fitness level, any special requirements..."></textarea>
                    </div>

                    <button type="submit" class="ct-submit-btn">
                        Send Message
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <line x1="22" y1="2" x2="11" y2="13"/>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                        </svg>
                    </button>

                    <p class="ct-form-note">
                        🔒 Your information is kept private and never shared with third parties.
                    </p>

                </form>

                <?php // FLUENT FORMS END ?>
            </div>

            <!-- Right — Contact Info -->
            <div class="ct-info-wrap">

                <!-- Quick contact cards -->
                <div class="ct-info-card">
                    <h3 class="ct-info-title">Contact Information</h3>

                    <div class="ct-info-item">
                        <div class="ct-info-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                        </div>
                        <div class="ct-info-text">
                            <span class="ct-info-label">Office Address</span>
                            <span class="ct-info-val">
                                <?php echo nl2br( esc_html( $address ) ); ?>
                            </span>
                        </div>
                    </div>

                    <div class="ct-info-item">
                        <div class="ct-info-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.6a16 16 0 0 0 6.29 6.29l1.56-1.83a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                            </svg>
                        </div>
                        <div class="ct-info-text">
                            <span class="ct-info-label">Phone</span>
                            <a href="tel:<?php echo esc_attr( $phone ); ?>"
                               class="ct-info-val ct-info-link">
                                <?php echo esc_html( $phone ); ?>
                            </a>
                        </div>
                    </div>

                    <div class="ct-info-item">
                        <div class="ct-info-icon" style="background:#25D366;border-color:#25D366">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="white">
                                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                            </svg>
                        </div>
                        <div class="ct-info-text">
                            <span class="ct-info-label">WhatsApp</span>
                            <a href="https://wa.me/<?php echo esc_attr( $wa_number ); ?>?text=Hi, I would like to enquire about a trek"
                               target="_blank" rel="noopener noreferrer"
                               class="ct-info-val ct-info-link">
                                <?php echo esc_html( $whatsapp ); ?>
                            </a>
                        </div>
                    </div>

                    <div class="ct-info-item">
                        <div class="ct-info-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                        </div>
                        <div class="ct-info-text">
                            <span class="ct-info-label">Email</span>
                            <a href="mailto:<?php echo esc_attr( $email ); ?>"
                               class="ct-info-val ct-info-link">
                                <?php echo esc_html( $email ); ?>
                            </a>
                        </div>
                    </div>

                    <div class="ct-info-item ct-info-item--last">
                        <div class="ct-info-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                        </div>
                        <div class="ct-info-text">
                            <span class="ct-info-label">Office Hours</span>
                            <span class="ct-info-val">
                                <?php echo nl2br( esc_html( $hours ) ); ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- WhatsApp CTA -->
                <a href="https://wa.me/<?php echo esc_attr( $wa_number ); ?>?text=Hi, I would like to enquire about a trek"
                   target="_blank" rel="noopener noreferrer"
                   class="ct-wa-btn">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="white">
                        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                    </svg>
                    <div>
                        <span class="ct-wa-title">Chat on WhatsApp</span>
                        <span class="ct-wa-sub">Fastest response — usually within minutes</span>
                    </div>
                </a>

                <!-- Social Links -->
                <div class="ct-socials">
                    <?php
                    $socials = array(
                        'facebook'  => array( 'label' => 'Facebook',  'url' => get_theme_mod('desire_ft_facebook',  '#') ),
                        'instagram' => array( 'label' => 'Instagram', 'url' => get_theme_mod('desire_ft_instagram', '#') ),
                        'youtube'   => array( 'label' => 'YouTube',   'url' => get_theme_mod('desire_ft_youtube',   '#') ),
                    );
                    foreach ( $socials as $key => $s ) :
                        if ( $s['url'] === '#' ) continue;
                    ?>
                    <a href="<?php echo esc_url( $s['url'] ); ?>"
                       target="_blank" rel="noopener noreferrer"
                       class="ct-social-btn"
                       aria-label="<?php echo esc_attr( $s['label'] ); ?>">
                        <?php echo esc_html( ucfirst( $key ) ); ?>
                    </a>
                    <?php endforeach; ?>
                </div>

            </div>

        </div>
    </div>

    <!-- ══ MAP ═══════════════════════════════════ -->
    <?php if ( $map_url ) : ?>
    <div class="ct-map-wrap">
        <iframe
            src="<?php echo esc_url( $map_url ); ?>"
            width="100%"
            height="420"
            style="border:0;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
    <?php endif; ?>

    <!-- ══ FAQ STRIP ══════════════════════════════ -->
    <div class="ct-faq-strip">
        <div class="ct-faq-inner">
            <h2 class="ct-faq-title">Quick Answers</h2>
            <div class="ct-faq-grid">
                <?php for ( $f = 1; $f <= 3; $f++ ) :
                    $fq = get_theme_mod( "desire_contact_faq_{$f}_q", '' );
                    $fa = get_theme_mod( "desire_contact_faq_{$f}_a", '' );
                    if ( ! $fq ) continue;
                ?>
                <div class="ct-faq-item">
                    <h3 class="ct-faq-q">
                        <span class="ct-faq-icon">?</span>
                        <?php echo esc_html( $fq ); ?>
                    </h3>
                    <?php if ( $fa ) : ?>
                    <p class="ct-faq-a"><?php echo esc_html( $fa ); ?></p>
                    <?php endif; ?>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>

</div>

<?php get_template_part( 'parts/footer' ); ?>