<?php
$subtitle = get_theme_mod( 'desire_why_subtitle', 'WHY CHOOSE US' );
$title    = get_theme_mod( 'desire_why_main_title', 'Your Adventure, Guided With Heart' );
$desc     = get_theme_mod( 'desire_why_description', "We've been walking these trails for years..." );
?>

<section class="why-choose-section" id="section-why">
    <div class="why-container">

        <!-- Header -->
        <header class="why-header">
            <div class="why-kicker-wrap">
                <span class="why-kicker-line"></span>
                <h4 class="why-kicker"><?php echo esc_html( $subtitle ); ?></h4>
                <span class="why-kicker-line"></span>
            </div>
            <h2 class="why-main-title"><?php echo esc_html( $title ); ?></h2>
            <p class="why-intro"><?php echo esc_html( $desc ); ?></p>
        </header>

        <!-- Card Slider -->
        <?php
        $has_features = false;
        for ( $i = 1; $i <= 6; $i++ ) {
            if ( get_theme_mod( "desire_why_title_{$i}" ) ) { $has_features = true; break; }
        }
        ?>

        <?php if ( $has_features ) : ?>
        <div class="why-slider-wrap">
            <div class="why-cards-viewport">
                <div class="why-cards-track" id="whyCardsTrack">
                    <?php for ( $i = 1; $i <= 6; $i++ ) :
                        $feat_icon  = get_theme_mod( "desire_why_icon_{$i}", 'ti ti-mountain' );
                        $feat_title = get_theme_mod( "desire_why_title_{$i}" );
                        $feat_desc  = get_theme_mod( "desire_why_desc_{$i}" );
                        if ( $feat_title ) : ?>
                        <div class="why-card">
                            <div class="why-card-accent"></div>
                            <div class="why-card-icon">
                                <i class="<?php echo esc_attr( $feat_icon ); ?>"></i>
                            </div>
                            <h3 class="why-card-title"><?php echo esc_html( $feat_title ); ?></h3>
                            <p class="why-card-desc"><?php echo esc_html( $feat_desc ); ?></p>
                        </div>
                    <?php endif; endfor; ?>
                </div>
            </div>

            <!-- Navigation -->
            <div class="why-nav">
                <button class="why-nav-btn" id="whyPrev" aria-label="Previous">&#8249;</button>
                <div class="why-dots" id="whyDots">
                </div>
                <button class="why-nav-btn" id="whyNext" aria-label="Next">&#8250;</button>
            </div>
        </div>
        <?php endif; ?>

        <!-- Stats Bar -->
        <?php
        $has_stats = false;
        for ( $s = 1; $s <= 4; $s++ ) {
            if ( get_theme_mod( "desire_stat_num_{$s}" ) ) { $has_stats = true; break; }
        }
        ?>

        <?php if ( $has_stats ) : ?>
        <div class="why-stats-bar">
            <?php for ( $s = 1; $s <= 4; $s++ ) :
                $num = get_theme_mod( "desire_stat_num_{$s}" );
                $lbl = get_theme_mod( "desire_stat_label_{$s}" );
                if ( ! empty( $num ) ) : ?>
                <div class="stat-item">
                    <span class="stat-number"><?php echo esc_html( $num ); ?></span>
                    <span class="stat-label"><?php echo esc_html( $lbl ); ?></span>
                </div>
            <?php endif; endfor; ?>
        </div>
        <?php endif; ?>

    </div>
</section>
<!-- Divider: Why Choose Us → Reviews -->
<!-- Divider: Why Choose Us → Reviews -->
<div style="background: #FDFBF8 ; line-height: 0;">
    <svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="display:block; width:100%;">
        <path d="M0,0 L0,28 C120,48 240,14 400,34 C560,54 680,18 840,38 C1000,58 1160,22 1320,42 L1440,36 L1440,0 Z" fill="#141414"/>
    </svg>
</div>