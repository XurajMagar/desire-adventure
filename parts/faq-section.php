<?php
$faq_kicker      = get_theme_mod( 'desire_faq_kicker', 'FAQ' );
$faq_title       = get_theme_mod( 'desire_faq_title', 'Questions we get asked a lot' );
$faq_desc        = get_theme_mod( 'desire_faq_desc', "Can't find what you're looking for? Reach out to us directly and our team will get back to you within 24 hours." );
$faq_btn_text    = get_theme_mod( 'desire_faq_btn_text', 'Ask a Question' );
$faq_btn_url     = get_theme_mod( 'desire_faq_btn_url', '#' );

// Check if any questions have been filled in
$has_faqs = false;
for ( $i = 1; $i <= 6; $i++ ) {
    if ( get_theme_mod( "desire_faq_q_{$i}" ) ) {
        $has_faqs = true;
        break;
    }
}

// Don't render section at all if empty
if ( ! $has_faqs ) return;
?>

<section class="faq-section" id="section-faq">
    <div class="faq-container">

        <!-- LEFT: Sticky Header -->
        <div class="faq-left">
            <p class="faq-kicker"><?php echo esc_html( $faq_kicker ); ?></p>
            <h2 class="faq-title"><?php echo esc_html( $faq_title ); ?></h2>
            <p class="faq-desc"><?php echo esc_html( $faq_desc ); ?></p>
            <?php if ( $faq_btn_text ) : ?>
            <a href="<?php echo esc_url( $faq_btn_url ); ?>" class="btn-faq-contact">
                <?php echo esc_html( $faq_btn_text ); ?>
            </a>
            <?php endif; ?>
        </div>

        <!-- RIGHT: Accordion -->
        <ul class="faq-list" role="list">
            <?php for ( $i = 1; $i <= 6; $i++ ) :
                $question = get_theme_mod( "desire_faq_q_{$i}" );
                $answer   = get_theme_mod( "desire_faq_a_{$i}" );

                if ( $question && $answer ) : ?>
                <li class="faq-item">
                    <button 
                        class="faq-question" 
                        aria-expanded="false"
                        aria-controls="faq-answer-<?php echo (int) $i; ?>">
                        <span class="faq-q-text"><?php echo esc_html( $question ); ?></span>
                        <span class="faq-icon" aria-hidden="true">+</span>
                    </button>
                    <div 
                        class="faq-answer" 
                        id="faq-answer-<?php echo (int) $i; ?>"
                        role="region">
                        <p><?php echo esc_html( $answer ); ?></p>
                    </div>
                </li>
                <?php endif;
            endfor; ?>
        </ul>

    </div>
</section>