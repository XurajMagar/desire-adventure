<!-- Divider: top of Reviews -->
<section class="reviews-section light-theme" id="section-reviews">
    <div class="why-container">

        <!-- 1. Header -->
        <header class="section-header centered-header">
            <h2 class="pkg-main-title"><?php echo esc_html( get_theme_mod( 'desire_rev_title', 'Traveler Reviews' ) ); ?></h2>
            <p class="section-desc"><?php echo esc_html( get_theme_mod( 'desire_rev_subtitle', 'Authentic experiences from travelers who have explored with us.' ) ); ?></p>
            
            <div class="ta-brand-block">
                <?php if ( $logo = get_theme_mod( 'desire_ta_logo' ) ) : ?>
                    <img src="<?php echo esc_url( $logo ); ?>" class="ta-logo-main" alt="TripAdvisor">
                <?php endif; ?>
                
                <a href="<?php echo esc_url( get_theme_mod( 'desire_ta_link', '#' ) ); ?>" target="_blank" rel="noopener noreferrer" class="ta-stats-link">
                    <span class="ta-stars">★★★★★</span> 
                    <span><?php echo esc_html( get_theme_mod( 'desire_ta_count_text', '300 reviews in TripAdvisor' ) ); ?></span>
                </a>
            </div>
        </header>

        <!-- 2. Slider -->
        <div class="slider-wrapper">
            <div class="reviews-grid-four" id="reviewsSlider">
                <?php for ( $i = 1; $i <= 4; $i++ ) :
                    $name      = get_theme_mod( "desire_rev_name_$i" );
                    $full_text = get_theme_mod( "desire_rev_full_$i" );

                    if ( $name || $full_text ) :
                        $avatar = get_theme_mod( "desire_rev_avatar_$i" );
                        $rating = get_theme_mod( "desire_rev_rating_$i", 5 );
                        ?>
                        <div class="ta-card slider-card">
                            <div class="ta-user">
                                <?php if ( $avatar ) : ?>
                                    <img src="<?php echo esc_url( $avatar ); ?>" class="ta-avatar" alt="<?php echo esc_attr( $name ); ?>">
                                <?php endif; ?>
                                <div class="ta-user-info">
                                    <strong><?php echo esc_html( $name ?: 'Traveler' ); ?></strong>
                                    <span>1 contribution</span>
                                </div>
                            </div>

                            <div class="ta-dots" data-rating="<?php echo esc_attr( $rating ); ?>">
                                <span></span><span></span><span></span><span></span><span></span>
                            </div>

                            <p class="ta-excerpt"><?php echo wp_trim_words( $full_text, 25, '...' ); ?></p>
                            <button class="ta-read-more" onclick="openReview(<?php echo (int) $i; ?>)">Read more ⌵</button>

                            <div class="ta-meta">
                                <p>Visited <strong><?php echo esc_html( get_theme_mod( "desire_rev_date_$i", 'April 2026' ) ); ?></strong></p>
                                <p>Traveled <strong><?php echo esc_html( get_theme_mod( "desire_rev_type_$i", 'Solo' ) ); ?></strong></p>
                            </div>
                        </div>
                    <?php endif;
                endfor; ?>
            </div>

            <!-- 3. Mobile Arrows -->
            <div class="slider-nav">
                <button class="nav-btn prev" onclick="moveSlider(-1)" aria-label="Previous">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button class="nav-btn next" onclick="moveSlider(1)" aria-label="Next">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14m-7 7 7-7-7-7"/>
                    </svg>
                </button>
            </div>
        </div>

        <div class="view-all-container">
            <a href="<?php echo esc_url( get_theme_mod( 'desire_rev_all_link', '#' ) ); ?>" class="btn-view-all">
                READ ALL OUR REVIEWS
            </a>
        </div>

    </div>
</section>

<!-- 4. Modals — outside the section, outside the cards -->
<?php for ( $i = 1; $i <= 4; $i++ ) :
    $name      = get_theme_mod( "desire_rev_name_$i" );
    $full_text = get_theme_mod( "desire_rev_full_$i" );

    if ( $name || $full_text ) :
        $avatar = get_theme_mod( "desire_rev_avatar_$i" );
        $rating = get_theme_mod( "desire_rev_rating_$i", 5 );
        ?>
        <dialog id="review-modal-<?php echo (int) $i; ?>" class="review-dialog">
            <div class="modal-inner">
                <button class="close-modal" onclick="closeReview(<?php echo (int) $i; ?>)">&times;</button>
                <div class="modal-header ta-user">
                    <?php if ( $avatar ) : ?>
                        <img src="<?php echo esc_url( $avatar ); ?>" class="ta-avatar" alt="<?php echo esc_attr( $name ); ?>">
                    <?php endif; ?>
                    <div class="ta-user-info">
                        <strong><?php echo esc_html( $name ); ?></strong>
                        <span>1 contribution</span>
                    </div>
                </div>
                <div class="ta-dots" data-rating="<?php echo esc_attr( $rating ); ?>">
                    <span></span><span></span><span></span><span></span><span></span>
                </div>
                <div class="modal-body">
                    <p class="modal-text"><?php echo nl2br( esc_html( $full_text ) ); ?></p>
                    <div class="review-gallery">
                        <?php for ( $g = 1; $g <= 5; $g++ ) :
                            $img = get_theme_mod( "desire_rev_img_{$i}_{$g}" );
                            if ( $img ) : ?>
                                <img src="<?php echo esc_url( $img ); ?>" class="gallery-item" 
                                     onclick="openLightbox('<?php echo esc_url( $img ); ?>')"
                                     alt="<?php echo esc_attr( $name ); ?> review photo <?php echo (int) $g; ?>">
                            <?php endif;
                        endfor; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <p>
                        Visited <strong><?php echo esc_html( get_theme_mod( "desire_rev_date_$i" ) ); ?></strong> 
                        &bull; 
                        Traveled <strong><?php echo esc_html( get_theme_mod( "desire_rev_type_$i" ) ); ?></strong>
                    </p>
                </div>
            </div>
        </dialog>
    <?php endif;
endfor; ?>

<!-- 5. Lightbox -->
<dialog id="lightbox-modal" class="lightbox-dialog" onclick="this.close()">
    <img id="lightbox-img" src="" alt="Full size review image">
</dialog>

<!-- Close button sits outside the dialog, fixed to screen corner -->
<button class="lightbox-close" id="lightbox-close-btn" aria-label="Close lightbox">&times;</button>