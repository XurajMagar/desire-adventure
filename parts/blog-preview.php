<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$bp_kicker   = get_theme_mod( 'desire_bp_kicker', 'From the Trail' );
$bp_title    = get_theme_mod( 'desire_bp_title', 'Trekking Tips & Stories' );
$bp_btn_text = get_theme_mod( 'desire_bp_btn_text', 'View All Articles' );
$bp_btn_url  = get_theme_mod( 'desire_bp_btn_url', home_url( '/blog' ) );

// Query latest 3 published posts
$blog_query = new WP_Query( array(
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
) );

// Don't render section if no posts exist yet
if ( ! $blog_query->have_posts() ) return;
?>

<section class="blog-preview-section" id="section-blog">
    <div class="blog-preview-container">

        <!-- Header Row -->
        <div class="bp-header">
            <div class="bp-header-text">
                <p class="bp-kicker"><?php echo esc_html( $bp_kicker ); ?></p>
                <h2 class="bp-title"><?php echo esc_html( $bp_title ); ?></h2>
            </div>
            <?php if ( $bp_btn_text ) : ?>
            <a href="<?php echo esc_url( $bp_btn_url ); ?>" class="btn-blog-all">
                <?php echo esc_html( $bp_btn_text ); ?>
            </a>
            <?php endif; ?>
        </div>

        <!-- Cards Grid -->
        <div class="bp-grid">
            <?php
            while ( $blog_query->have_posts() ) :
                $blog_query->the_post();

                $thumb_url = get_the_post_thumbnail_url( get_the_ID(), 'large' )
                    ?: get_template_directory_uri() . '/images/trip-placeholder.webp';

                // Calculate read time (avg 200 words per minute)
                $word_count = str_word_count( wp_strip_all_tags( get_the_content() ) );
                $read_time  = max( 1, round( $word_count / 200 ) );

                // Get first category
                $cats     = get_the_category();
                $cat_name = ! empty( $cats ) ? $cats[0]->name : '';
                ?>
                <a href="<?php the_permalink(); ?>" class="bp-card">
                    <div class="bp-thumb" style="background-image: url('<?php echo esc_url( $thumb_url ); ?>');"></div>
                    <div class="bp-content">
                        <?php if ( $cat_name ) : ?>
                            <span class="bp-cat"><?php echo esc_html( $cat_name ); ?></span>
                        <?php endif; ?>
                        <h3 class="bp-post-title"><?php the_title(); ?></h3>
                        <p class="bp-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 18, '…' ); ?></p>
                        <div class="bp-meta">
                            <span><?php echo get_the_date(); ?></span>
                            <span class="bp-meta-dot"></span>
                            <span><?php echo (int) $read_time; ?> min read</span>
                        </div>
                    </div>
                </a>
                <?php
            endwhile;
            wp_reset_postdata();
            ?>
        </div>

    </div>
</section>