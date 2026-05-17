<?php get_template_part( 'parts/header' ); ?>

<?php
// Get all blog categories
$blog_cats = get_categories( array(
    'hide_empty' => true,
    'orderby'    => 'name',
    'order'      => 'ASC',
) );

// Current category
$current_cat = get_query_var('cat') ? get_query_var('cat') : 0;

// Current page for pagination
$paged = get_query_var('paged') ? get_query_var('paged') : 1;

// Get posts
$args = array(
    'post_type'      => 'post',
    'posts_per_page' => 9,
    'paged'          => $paged,
);
if ( $current_cat ) {
    $args['cat'] = $current_cat;
}
$blog_query = new WP_Query( $args );
?>

<div class="blog-page">

    <!-- ── HERO ─────────────────────────────── -->
    <div class="blog-hero">
        <div class="blog-hero-inner">
            <p class="blog-hero-kicker">From the Trail</p>
            <h1 class="blog-hero-title">Trekking Tips &amp; Stories</h1>
            <p class="blog-hero-sub">
                Insights, guides and stories from the Himalayas
            </p>
        </div>
    </div>

    <!-- ── CATEGORY FILTER ───────────────────── -->
    <?php if ( ! empty( $blog_cats ) ) : ?>
    <div class="blog-filter-bar">
        <div class="blog-filter-inner">
            <a href="<?php echo esc_url( get_post_type_archive_link('post') ?: home_url('/blog') ); ?>"
               class="blog-filter-btn <?php echo ! $current_cat ? 'is-active' : ''; ?>">
                All Posts
            </a>
            <?php foreach ( $blog_cats as $cat ) : ?>
            <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>"
               class="blog-filter-btn <?php echo $current_cat == $cat->term_id ? 'is-active' : ''; ?>">
                <?php echo esc_html( $cat->name ); ?>
                <span class="blog-filter-count"><?php echo (int) $cat->count; ?></span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- ── POSTS GRID ────────────────────────── -->
    <div class="blog-body">
        <?php if ( $blog_query->have_posts() ) : ?>

        <div class="blog-grid" id="blogGrid">
            <?php
            $post_index = 0;
            while ( $blog_query->have_posts() ) :
                $blog_query->the_post();
                $is_featured = ( $post_index === 0 && $paged === 1 && ! $current_cat );
                $thumb        = get_the_post_thumbnail_url( get_the_ID(), 'large' );
                $cats         = get_the_category();
                $cat_name     = $cats ? $cats[0]->name : '';
                $cat_link     = $cats ? get_category_link( $cats[0]->term_id ) : '#';
                $read_time    = ceil( str_word_count( strip_tags( get_the_content() ) ) / 200 );
                $author_id    = get_the_author_meta('ID');
                $author_name  = get_the_author();
                $author_photo = get_avatar_url( $author_id, array('size' => 40) );
            ?>

            <?php if ( $is_featured ) : ?>
            <!-- Featured Post — big card -->
            <article class="blog-card blog-card-featured">
                <?php if ( $thumb ) : ?>
                <a href="<?php the_permalink(); ?>" class="blog-card-img-wrap">
                    <div class="blog-card-img"
                         style="background-image: url('<?php echo esc_url( $thumb ); ?>')">
                        <?php if ( $cat_name ) : ?>
                        <a href="<?php echo esc_url( $cat_link ); ?>"
                           class="blog-card-cat">
                            <?php echo esc_html( $cat_name ); ?>
                        </a>
                        <?php endif; ?>
                    </div>
                </a>
                <?php endif; ?>
                <div class="blog-card-content">
                    <div class="blog-card-meta">
                        <span><?php echo get_the_date('j M Y'); ?></span>
                        <span class="blog-meta-dot"></span>
                        <span><?php echo (int) $read_time; ?> min read</span>
                    </div>
                    <h2 class="blog-card-title blog-card-title-featured">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h2>
                    <p class="blog-card-excerpt">
                        <?php echo wp_trim_words( get_the_excerpt(), 30 ); ?>
                    </p>
                    <div class="blog-card-author">
                        <img src="<?php echo esc_url( $author_photo ); ?>"
                             alt="<?php echo esc_attr( $author_name ); ?>"
                             class="blog-author-photo">
                        <span><?php echo esc_html( $author_name ); ?></span>
                    </div>
                </div>
            </article>

            <?php else : ?>
            <!-- Regular Post Card -->
            <article class="blog-card">
                <?php if ( $thumb ) : ?>
                <a href="<?php the_permalink(); ?>" class="blog-card-img-wrap">
                    <div class="blog-card-img"
                         style="background-image: url('<?php echo esc_url( $thumb ); ?>')">
                        <?php if ( $cat_name ) : ?>
                        <a href="<?php echo esc_url( $cat_link ); ?>"
                           class="blog-card-cat">
                            <?php echo esc_html( $cat_name ); ?>
                        </a>
                        <?php endif; ?>
                    </div>
                </a>
                <?php endif; ?>
                <div class="blog-card-content">
                    <div class="blog-card-meta">
                        <span><?php echo get_the_date('j M Y'); ?></span>
                        <span class="blog-meta-dot"></span>
                        <span><?php echo (int) $read_time; ?> min read</span>
                    </div>
                    <h2 class="blog-card-title">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h2>
                    <p class="blog-card-excerpt">
                        <?php echo wp_trim_words( get_the_excerpt(), 20 ); ?>
                    </p>
                    <div class="blog-card-footer">
                        <div class="blog-card-author">
                            <img src="<?php echo esc_url( $author_photo ); ?>"
                                 alt="<?php echo esc_attr( $author_name ); ?>"
                                 class="blog-author-photo">
                            <span><?php echo esc_html( $author_name ); ?></span>
                        </div>
                        <a href="<?php the_permalink(); ?>"
                           class="blog-card-read-more">
                            Read →
                        </a>
                    </div>
                </div>
            </article>
            <?php endif; ?>

            <?php
            $post_index++;
            endwhile;
            wp_reset_postdata();
            ?>
        </div>

        <!-- ── PAGINATION ─────────────────────── -->
        <?php if ( $blog_query->max_num_pages > 1 ) : ?>
        <div class="blog-pagination">
            <?php if ( $paged > 1 ) : ?>
            <a href="<?php echo esc_url( get_pagenum_link( $paged - 1 ) ); ?>"
               class="blog-page-btn">
                ← Previous
            </a>
            <?php endif; ?>

            <div class="blog-page-numbers">
                <?php for ( $i = 1; $i <= $blog_query->max_num_pages; $i++ ) : ?>
                <a href="<?php echo esc_url( get_pagenum_link( $i ) ); ?>"
                   class="blog-page-num <?php echo $i === $paged ? 'is-active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
                <?php endfor; ?>
            </div>

            <?php if ( $paged < $blog_query->max_num_pages ) : ?>
            <a href="<?php echo esc_url( get_pagenum_link( $paged + 1 ) ); ?>"
               class="blog-page-btn">
                Next →
            </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php else : ?>
        <!-- No posts -->
        <div class="blog-empty">
            <span class="blog-empty-icon">✍️</span>
            <h3>No posts yet</h3>
            <p>Check back soon — stories from the trail are coming.</p>
            <a href="<?php echo esc_url( home_url('/') ); ?>"
               class="blog-empty-btn">Back to Home</a>
        </div>
        <?php endif; ?>
    </div>

</div>

<?php get_template_part( 'parts/footer' ); ?>