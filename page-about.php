<?php
/**
 * Template Name: About Us Page
 */
get_template_part( 'parts/header' );

// Gather Customizer values
$hero_image   = get_theme_mod( 'desire_about_hero_image',   '' );
$hero_kicker  = get_theme_mod( 'desire_about_hero_kicker',  'Our Story' );
$hero_title   = get_theme_mod( 'desire_about_hero_title',   'Born from a passion for the mountains' );
$hero_tagline = get_theme_mod( 'desire_about_hero_tagline', '' );
$cta_title    = get_theme_mod( 'desire_about_cta_title',    'Ready to start your adventure?' );
$cta_desc     = get_theme_mod( 'desire_about_cta_desc',     '' );
$cta_btn1_text = get_theme_mod( 'desire_about_cta_btn1_text', 'View All Treks' );
$cta_btn1_url  = get_theme_mod( 'desire_about_cta_btn1_url',  home_url('/trips') );
$cta_btn2_text = get_theme_mod( 'desire_about_cta_btn2_text', 'Contact Us' );
$cta_btn2_url  = get_theme_mod( 'desire_about_cta_btn2_url',  home_url('/contact') );
?>

<div class="about-page">

    <!-- ══ HERO ══════════════════════════════════ -->
    <section class="ab-hero">
        <div class="ab-hero-inner">

            <!-- Left — Text -->
            <div class="ab-hero-text">
                <p class="ab-kicker"><?php echo esc_html( $hero_kicker ); ?></p>
                <h1 class="ab-hero-title">
                    <?php echo esc_html( $hero_title ); ?>
                </h1>
                <?php if ( $hero_tagline ) : ?>
                <p class="ab-hero-tagline">
                    <?php echo esc_html( $hero_tagline ); ?>
                </p>
                <?php endif; ?>
                <div class="ab-hero-btns">
                    <a href="<?php echo esc_url( $cta_btn1_url ); ?>"
                       class="ab-btn-primary">
                        <?php echo esc_html( $cta_btn1_text ); ?>
                    </a>
                    <a href="<?php echo esc_url( home_url('/contact') ); ?>"
                       class="ab-btn-secondary">
                        Get in Touch
                    </a>
                </div>
            </div>

            <!-- Right — Image -->
            <div class="ab-hero-img-wrap">
                <?php if ( $hero_image ) : ?>
                <img src="<?php echo esc_url( $hero_image ); ?>"
                     alt="<?php echo esc_attr( $hero_title ); ?>"
                     class="ab-hero-img">
                <?php else : ?>
                <div class="ab-hero-img-placeholder">
                    <span>Upload hero image in Customizer → About Us Page</span>
                </div>
                <?php endif; ?>

                <!-- Experience badge -->
                <?php
                $years = get_theme_mod( 'desire_at_years', '15+' );
                $years_label = get_theme_mod( 'desire_at_years_label', 'Years on the trails' );
                ?>
                <div class="ab-hero-badge">
                    <span class="ab-badge-num"><?php echo esc_html( $years ); ?></span>
                    <span class="ab-badge-label"><?php echo esc_html( $years_label ); ?></span>
                </div>
            </div>

        </div>
    </section>

    <!-- ══ STATS BAR ════════════════════════════ -->
    <section class="ab-stats">
        <div class="ab-stats-inner">
            <?php for ( $s = 1; $s <= 4; $s++ ) :
                $num   = get_theme_mod( "desire_about_stat_{$s}_num",   '' );
                $label = get_theme_mod( "desire_about_stat_{$s}_label", '' );
                if ( ! $num ) continue;
            ?>
            <div class="ab-stat-item">
                <span class="ab-stat-num"><?php echo esc_html( $num ); ?></span>
                <span class="ab-stat-label"><?php echo esc_html( $label ); ?></span>
            </div>
            <?php endfor; ?>
        </div>
    </section>

    <!-- ══ OUR STORY — Page Content ════════════ -->
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <?php if ( get_the_content() ) : ?>
    <section class="ab-story">
        <div class="ab-story-inner">
            <div class="ab-story-header">
                <p class="ab-section-kicker">Our Story</p>
                <h2 class="ab-section-title">How It All Began</h2>
            </div>
            <div class="ab-story-content">
                <?php the_content(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
    <?php endwhile; endif; ?>

    <!-- ══ TIMELINE — Milestones ════════════════ -->
    <?php
    $milestones = array();
    for ( $m = 1; $m <= 6; $m++ ) {
        $year  = get_theme_mod( "desire_about_mile_{$m}_year",  '' );
        $title = get_theme_mod( "desire_about_mile_{$m}_title", '' );
        $desc  = get_theme_mod( "desire_about_mile_{$m}_desc",  '' );
        if ( $year || $title ) {
            $milestones[] = compact( 'year', 'title', 'desc' );
        }
    }
    ?>
    <?php if ( ! empty( $milestones ) ) : ?>
    <section class="ab-timeline">
        <div class="ab-timeline-inner">
            <div class="ab-story-header" style="text-align:center">
                <p class="ab-section-kicker">Our Journey</p>
                <h2 class="ab-section-title">Key Milestones</h2>
            </div>
            <div class="ab-timeline-track">
                <?php foreach ( $milestones as $idx => $m ) : ?>
                <div class="ab-timeline-item <?php echo $idx % 2 === 0 ? 'ab-tl-left' : 'ab-tl-right'; ?>">
                    <div class="ab-tl-content">
                        <?php if ( $m['year'] ) : ?>
                        <span class="ab-tl-year"><?php echo esc_html( $m['year'] ); ?></span>
                        <?php endif; ?>
                        <?php if ( $m['title'] ) : ?>
                        <h3 class="ab-tl-title"><?php echo esc_html( $m['title'] ); ?></h3>
                        <?php endif; ?>
                        <?php if ( $m['desc'] ) : ?>
                        <p class="ab-tl-desc"><?php echo esc_html( $m['desc'] ); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="ab-tl-dot"></div>
                </div>
                <?php endforeach; ?>
                <div class="ab-tl-line"></div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ══ OUR VALUES ════════════════════════════ -->
    <section class="ab-values">
        <div class="ab-values-inner">
            <div class="ab-story-header" style="text-align:center">
                <p class="ab-section-kicker">What We Stand For</p>
                <h2 class="ab-section-title">Our Values</h2>
            </div>
            <div class="ab-values-grid">
                <?php for ( $v = 1; $v <= 3; $v++ ) :
                    $icon  = get_theme_mod( "desire_about_val_{$v}_icon",  '' );
                    $title = get_theme_mod( "desire_about_val_{$v}_title", '' );
                    $desc  = get_theme_mod( "desire_about_val_{$v}_desc",  '' );
                    if ( ! $title ) continue;
                ?>
                <div class="ab-value-card">
                    <?php if ( $icon ) : ?>
                    <div class="ab-value-icon"><?php echo esc_html( $icon ); ?></div>
                    <?php endif; ?>
                    <h3 class="ab-value-title"><?php echo esc_html( $title ); ?></h3>
                    <?php if ( $desc ) : ?>
                    <p class="ab-value-desc"><?php echo esc_html( $desc ); ?></p>
                    <?php endif; ?>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>

    <!-- ══ AFFILIATIONS ══════════════════════════ -->
    <?php
    $has_aff = false;
    for ( $i = 1; $i <= 8; $i++ ) {
        if ( get_theme_mod( "desire_aff_logo_{$i}" ) || get_theme_mod( "desire_aff_name_{$i}" ) ) {
            $has_aff = true;
            break;
        }
    }
    ?>
    <?php if ( $has_aff ) : ?>
    <section class="ab-affiliations">
        <div class="ab-aff-inner">
            <p class="ab-aff-label">Affiliated &amp; Certified With</p>
            <div class="ab-aff-grid">
                <?php for ( $i = 1; $i <= 8; $i++ ) :
                    $logo = get_theme_mod( "desire_aff_logo_{$i}", '' );
                    $name = get_theme_mod( "desire_aff_name_{$i}", '' );
                    if ( ! $logo && ! $name ) continue;
                ?>
                <div class="ab-aff-item">
                    <?php if ( $logo ) : ?>
                    <img src="<?php echo esc_url( $logo ); ?>"
                         alt="<?php echo esc_attr( $name ); ?>"
                         class="ab-aff-logo">
                    <?php else : ?>
                    <span class="ab-aff-text"><?php echo esc_html( $name ); ?></span>
                    <?php endif; ?>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ══ CTA ═══════════════════════════════════ -->
    <section class="ab-cta">
        <div class="ab-cta-inner">
            <h2 class="ab-cta-title"><?php echo esc_html( $cta_title ); ?></h2>
            <?php if ( $cta_desc ) : ?>
            <p class="ab-cta-desc"><?php echo esc_html( $cta_desc ); ?></p>
            <?php endif; ?>
            <div class="ab-cta-btns">
                <a href="<?php echo esc_url( $cta_btn1_url ); ?>"
                   class="ab-btn-primary">
                    <?php echo esc_html( $cta_btn1_text ); ?>
                </a>
                <a href="<?php echo esc_url( $cta_btn2_url ); ?>"
                   class="ab-btn-secondary">
                    <?php echo esc_html( $cta_btn2_text ); ?>
                </a>
            </div>
        </div>
    </section>

</div>

<?php get_template_part( 'parts/footer' ); ?>