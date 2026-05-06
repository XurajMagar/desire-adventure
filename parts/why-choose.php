<?php
/**
 * Template part for displaying the "Why Choose Us" section.
 */
$subtitle = get_theme_mod( 'desire_why_subtitle', 'WHY CHOOSE US' );
$title    = get_theme_mod( 'desire_why_main_title', 'Your adventure, guided with heart' );
$desc     = get_theme_mod( 'desire_why_description', "We've been walking these trails for years..." );
?>

<section class="why-choose-section" id="section-why">
    <div class="why-container">
        
        <header class="section-header">
            <h4 class="why-kicker"><?php echo esc_html( $subtitle ); ?></h4>
            <h2 class="why-main-title"><?php echo esc_html( $title ); ?></h2>
            <p class="why-intro"><?php echo esc_html( $desc ); ?></p>
        </header>

        <?php
        // Check if any feature cards have content
        $has_features = false;
        for ( $i = 1; $i <= 6; $i++ ) {
            if ( get_theme_mod( "desire_why_title_{$i}" ) ) {
                $has_features = true;
                break;
            }
        }
        ?>

        <?php if ( $has_features ) : ?>
        <div class="why-grid">
            <?php 
            for ( $i = 1; $i <= 6; $i++ ) {
                $feat_icon  = get_theme_mod( "desire_why_icon_{$i}" );
                $feat_title = get_theme_mod( "desire_why_title_{$i}" );
                $feat_desc  = get_theme_mod( "desire_why_desc_{$i}" );

                if ( $feat_title ) : ?>
                    <div class="why-card">
                        <div class="orange-accent-line"></div>
                        <div class="icon-circle">
                            <i class="<?php echo esc_attr( $feat_icon ); ?>"></i>
                        </div>
                        <h3 class="card-title"><?php echo esc_html( $feat_title ); ?></h3>
                        <p class="card-desc"><?php echo esc_html( $feat_desc ); ?></p>
                    </div>
                <?php endif;
            } 
            ?>
        </div><!-- .why-grid -->
        <?php endif; ?>

        <?php
        // Check if any stats have been filled in
        $has_stats = false;
        for ( $s = 1; $s <= 4; $s++ ) {
            if ( get_theme_mod( "desire_stat_num_{$s}" ) ) {
                $has_stats = true;
                break;
            }
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
                <?php endif; 
            endfor; ?>
        </div><!-- .why-stats-bar -->
        <?php endif; ?>

    </div><!-- .why-container -->
</section>