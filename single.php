<?php get_template_part( 'parts/header' ); ?>

<?php
if ( have_posts() ) :
while ( have_posts() ) : the_post();

$thumb       = get_the_post_thumbnail_url( get_the_ID(), 'full' );
$cats        = get_the_category();
$cat_name    = $cats ? $cats[0]->name : '';
$cat_link    = $cats ? get_category_link( $cats[0]->term_id ) : '#';
$read_time   = ceil( str_word_count( strip_tags( get_the_content() ) ) / 200 );
$author_id   = get_the_author_meta('ID');
$author_name = get_the_author();
$author_bio  = get_the_author_meta('description');
$author_photo = get_avatar_url( $author_id, array('size' => 80) );

// Related posts — same category
$related = array();
if ( $cats ) {
    $related = get_posts( array(
        'category'       => $cats[0]->term_id,
        'posts_per_page' => 3,
        'post__not_in'   => array( get_the_ID() ),
        'orderby'        => 'rand',
    ));
}
?>

<div class="post-page">

    <!-- ── HERO ─────────────────────────────── -->
    <div class="post-hero" <?php if ( $thumb ) : ?>
         style="background-image: url('<?php echo esc_url( $thumb ); ?>')"
         <?php endif; ?>>
        <div class="post-hero-overlay">
            <div class="post-hero-inner">
                <!-- Breadcrumb -->
                <nav class="post-breadcrumb">
                    <a href="<?php echo esc_url( home_url('/') ); ?>">Home</a>
                    <span>/</span>
                    <a href="<?php echo esc_url( home_url('/blog') ); ?>">Blog</a>
                    <?php if ( $cat_name ) : ?>
                    <span>/</span>
                    <a href="<?php echo esc_url( $cat_link ); ?>"><?php echo esc_html( $cat_name ); ?></a>
                    <?php endif; ?>
                </nav>

                <?php if ( $cat_name ) : ?>
                <a href="<?php echo esc_url( $cat_link ); ?>"
                   class="post-cat-badge">
                    <?php echo esc_html( $cat_name ); ?>
                </a>
                <?php endif; ?>

                <h1 class="post-hero-title"><?php the_title(); ?></h1>

                <div class="post-hero-meta">
                    <img src="<?php echo esc_url( $author_photo ); ?>"
                         alt="<?php echo esc_attr( $author_name ); ?>"
                         class="post-hero-avatar">
                    <div class="post-hero-meta-text">
                        <span class="post-hero-author"><?php echo esc_html( $author_name ); ?></span>
                        <span class="post-hero-date">
                            <?php echo get_the_date('j F Y'); ?>
                            &nbsp;·&nbsp;
                            <?php echo (int) $read_time; ?> min read
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ── CONTENT AREA ─────────────────────── -->
    <div class="post-body">
        <div class="post-grid">

            <!-- TOC Sidebar — Desktop -->
            <aside class="post-toc-sidebar" id="postTocSidebar">
                <div class="post-toc-card" id="postTocCard">
                    <h3 class="post-toc-title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <line x1="8" y1="6" x2="21" y2="6"/>
                            <line x1="8" y1="12" x2="21" y2="12"/>
                            <line x1="8" y1="18" x2="21" y2="18"/>
                            <line x1="3" y1="6" x2="3.01" y2="6"/>
                            <line x1="3" y1="12" x2="3.01" y2="12"/>
                            <line x1="3" y1="18" x2="3.01" y2="18"/>
                        </svg>
                        Table of Contents
                    </h3>
                    <nav class="post-toc-nav" id="postTocNav">
                        <!-- Built by JS -->
                    </nav>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="post-main">

                <!-- Mobile TOC — collapsible -->
                <div class="post-toc-mobile" id="postTocMobile">
                    <button class="post-toc-mobile-toggle" id="postTocToggle">
                        <span class="post-toc-mobile-icon">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                <line x1="8" y1="6" x2="21" y2="6"/>
                                <line x1="8" y1="12" x2="21" y2="12"/>
                                <line x1="8" y1="18" x2="21" y2="18"/>
                                <line x1="3" y1="6" x2="3.01" y2="6"/>
                                <line x1="3" y1="12" x2="3.01" y2="12"/>
                                <line x1="3" y1="18" x2="3.01" y2="18"/>
                            </svg>
                            Table of Contents
                        </span>
                        <svg class="post-toc-chevron" width="16" height="16"
                            viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </button>
                    <div class="post-toc-mobile-body" id="postTocMobileBody">
                        <nav class="post-toc-nav" id="postTocNavMobile">
                            <!-- Built by JS -->
                        </nav>
                    </div>
                </div>

                <div class="post-content" id="postContent">
                    <?php the_content(); ?>
                </div>

                <!-- Tags -->
                <?php $tags = get_the_tags(); if ( $tags ) : ?>
                <div class="post-tags">
                    <span class="post-tags-label">Tags:</span>
                    <?php foreach ( $tags as $tag ) : ?>
                    <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>"
                    class="post-tag">
                        <?php echo esc_html( $tag->name ); ?>
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- Share Bar -->
                <div class="post-share-bar">
                    <span class="post-share-label">Share this article:</span>
                    <div class="post-share-btns">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( get_permalink() ); ?>"
                        target="_blank" rel="noopener noreferrer"
                        class="post-share-btn post-share-fb">Facebook</a>
                        <a href="https://wa.me/?text=<?php echo urlencode( get_the_title() . ' — ' . get_permalink() ); ?>"
                        target="_blank" rel="noopener noreferrer"
                        class="post-share-btn post-share-wa">WhatsApp</a>
                        <a href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode( get_permalink() ); ?>&media=<?php echo urlencode( $thumb ); ?>&description=<?php echo urlencode( get_the_title() ); ?>"
                        target="_blank" rel="noopener noreferrer"
                        class="post-share-btn post-share-pin">Pinterest</a>
                    </div>
                </div>

                <!-- Author Box -->
                <div class="post-author-box">
                    <img src="<?php echo esc_url( $author_photo ); ?>"
                        alt="<?php echo esc_attr( $author_name ); ?>"
                        class="post-author-img">
                    <div class="post-author-info">
                        <span class="post-author-label">Written by</span>
                        <span class="post-author-name"><?php echo esc_html( $author_name ); ?></span>
                        <?php if ( $author_bio ) : ?>
                        <p class="post-author-bio"><?php echo esc_html( $author_bio ); ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Comments -->
                <?php comments_template(); ?>

            </main>

            <!-- Right Sidebar -->
            <aside class="post-sidebar">
                <div class="post-sidebar-card">
                    <h3 class="post-sidebar-title">Categories</h3>
                    <ul class="post-sidebar-cats">
                        <?php
                        $all_cats = get_categories( array( 'hide_empty' => true ) );
                        foreach ( $all_cats as $c ) :
                        ?>
                        <li>
                            <a href="<?php echo esc_url( get_category_link( $c->term_id ) ); ?>"
                            class="post-sidebar-cat-link <?php echo ( $cats && $cats[0]->term_id == $c->term_id ) ? 'is-active' : ''; ?>">
                                <?php echo esc_html( $c->name ); ?>
                                <span class="post-sidebar-cat-count"><?php echo (int) $c->count; ?></span>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="post-sidebar-card">
                    <h3 class="post-sidebar-title">Recent Posts</h3>
                    <?php
                    $recent = get_posts( array(
                        'posts_per_page' => 4,
                        'post__not_in'   => array( get_the_ID() ),
                    ));
                    foreach ( $recent as $rp ) :
                        $rp_thumb = get_the_post_thumbnail_url( $rp->ID, 'thumbnail' );
                    ?>
                    <a href="<?php echo esc_url( get_permalink( $rp->ID ) ); ?>"
                    class="post-recent-item">
                        <?php if ( $rp_thumb ) : ?>
                        <div class="post-recent-img"
                            style="background-image: url('<?php echo esc_url( $rp_thumb ); ?>')">
                        </div>
                        <?php endif; ?>
                        <div class="post-recent-info">
                            <span class="post-recent-title"><?php echo esc_html( $rp->post_title ); ?></span>
                            <span class="post-recent-date"><?php echo get_the_date( 'j M Y', $rp->ID ); ?></span>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>

                <div class="post-sidebar-cta">
                    <p class="post-sidebar-cta-kicker">Ready to Trek?</p>
                    <h3 class="post-sidebar-cta-title">Plan your Nepal adventure today</h3>
                    <a href="<?php echo esc_url( home_url('/trips') ); ?>"
                    class="post-sidebar-cta-btn">View All Treks →</a>
                </div>
            </aside>

        </div>
    </div>

    <!-- ── RELATED POSTS ─────────────────────── -->
    <?php if ( ! empty( $related ) ) : ?>
    <div class="post-related">
        <div class="post-related-inner">
            <h2 class="post-related-title">You Might Also Like</h2>
            <div class="post-related-grid">
                <?php foreach ( $related as $rp ) :
                    $rp_thumb    = get_the_post_thumbnail_url( $rp->ID, 'large' );
                    $rp_cats     = get_the_category( $rp->ID );
                    $rp_cat_name = $rp_cats ? $rp_cats[0]->name : '';
                    $rp_time     = ceil( str_word_count( strip_tags( $rp->post_content ) ) / 200 );
                ?>
                <a href="<?php echo esc_url( get_permalink( $rp->ID ) ); ?>"
                   class="post-related-card">
                    <div class="post-related-img"
                         style="background-image: url('<?php echo esc_url( $rp_thumb ?: get_template_directory_uri() . '/images/trip-placeholder.jpg' ); ?>')">
                        <?php if ( $rp_cat_name ) : ?>
                        <span class="blog-card-cat"><?php echo esc_html( $rp_cat_name ); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="post-related-content">
                        <h3 class="post-related-card-title">
                            <?php echo esc_html( $rp->post_title ); ?>
                        </h3>
                        <span class="post-related-meta">
                            <?php echo get_the_date( 'j M Y', $rp->ID ); ?>
                            &nbsp;·&nbsp;
                            <?php echo (int) $rp_time; ?> min read
                        </span>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

</div>

<?php
endwhile;
endif;
?>

<?php get_template_part( 'parts/footer' ); ?>