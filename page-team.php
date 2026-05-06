<?php
/**
 * Template Name: Our Team Page
 */
get_template_part( 'parts/header' );

// Get all team members ordered by display order
$team_members = get_posts( array(
    'post_type'      => 'team_member',
    'posts_per_page' => 20,
    'post_status'    => 'publish',
    'meta_key'       => '_team_order',
    'orderby'        => 'meta_value_num',
    'order'          => 'ASC',
) );
?>

<div class="team-page">

    <!-- ══ HERO ══════════════════════════════════ -->
    <div class="team-hero">
        <div class="team-hero-inner">
            <p class="team-hero-kicker">The People Behind the Trek</p>
            <h1 class="team-hero-title">Meet Our Team</h1>
            <p class="team-hero-sub">
                Every trek is guided by passionate locals who know these
                trails like the back of their hand.
            </p>
        </div>
    </div>

    <!-- ══ TEAM GRID ══════════════════════════════ -->
    <div class="team-body">
        <?php if ( ! empty( $team_members ) ) : ?>
        <div class="team-grid">
            <?php foreach ( $team_members as $member ) :
                $m_id         = $member->ID;
                $m_role       = get_post_meta( $m_id, '_team_role',       true );
                $m_bio        = get_post_meta( $m_id, '_team_bio',        true );
                $m_experience = get_post_meta( $m_id, '_team_experience', true );
                $m_languages  = get_post_meta( $m_id, '_team_languages',  true );
                $m_treks      = get_post_meta( $m_id, '_team_treks',      true );
                $m_facebook   = get_post_meta( $m_id, '_team_facebook',   true );
                $m_instagram  = get_post_meta( $m_id, '_team_instagram',  true );
                $m_photo      = get_post_meta( $m_id, '_team_photo',      true );

                // Photo — use meta photo first, then featured image
                if ( ! $m_photo ) {
                    $m_photo = get_the_post_thumbnail_url( $m_id, 'medium' ) ?: '';
                }
            ?>
            <div class="team-card">

                <!-- Photo -->
                <div class="team-card-photo-wrap">
                    <?php if ( $m_photo ) : ?>
                    <img src="<?php echo esc_url( $m_photo ); ?>"
                         alt="<?php echo esc_attr( $member->post_title ); ?>"
                         class="team-card-photo">
                    <?php else : ?>
                    <div class="team-card-photo-placeholder">
                        <span><?php echo esc_html( strtoupper( substr( $member->post_title, 0, 2 ) ) ); ?></span>
                    </div>
                    <?php endif; ?>

                    <!-- Social links on hover -->
                    <?php if ( $m_facebook || $m_instagram ) : ?>
                    <div class="team-card-socials">
                        <?php if ( $m_facebook ) : ?>
                        <a href="<?php echo esc_url( $m_facebook ); ?>"
                           target="_blank" rel="noopener noreferrer"
                           class="team-social-btn" aria-label="Facebook">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
                            </svg>
                        </a>
                        <?php endif; ?>
                        <?php if ( $m_instagram ) : ?>
                        <a href="<?php echo esc_url( $m_instagram ); ?>"
                           target="_blank" rel="noopener noreferrer"
                           class="team-social-btn" aria-label="Instagram">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                                <circle cx="12" cy="12" r="4"/>
                                <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/>
                            </svg>
                        </a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Content -->
                <div class="team-card-content">
                    <h2 class="team-card-name">
                        <?php echo esc_html( $member->post_title ); ?>
                    </h2>

                    <?php if ( $m_role ) : ?>
                    <span class="team-card-role">
                        <?php echo esc_html( $m_role ); ?>
                    </span>
                    <?php endif; ?>

                    <?php if ( $m_bio ) : ?>
                    <p class="team-card-bio">
                        <?php echo esc_html( $m_bio ); ?>
                    </p>
                    <?php endif; ?>

                    <!-- Meta chips -->
                    <div class="team-card-chips">
                        <?php if ( $m_experience ) : ?>
                        <span class="team-chip">
                            🏔 <?php echo esc_html( $m_experience ); ?>
                        </span>
                        <?php endif; ?>
                        <?php if ( $m_languages ) : ?>
                        <span class="team-chip">
                            💬 <?php echo esc_html( $m_languages ); ?>
                        </span>
                        <?php endif; ?>
                    </div>

                    <?php if ( $m_treks ) : ?>
                    <p class="team-card-treks">
                        <span class="team-treks-label">Speciality:</span>
                        <?php echo esc_html( $m_treks ); ?>
                    </p>
                    <?php endif; ?>
                </div>

            </div>
            <?php endforeach; ?>
        </div>

        <?php else : ?>
        <div class="team-empty">
            <p>No team members added yet.</p>
            <a href="<?php echo esc_url( admin_url('post-new.php?post_type=team_member') ); ?>"
               class="team-empty-btn">
                Add Team Members →
            </a>
        </div>
        <?php endif; ?>

    </div>

    <!-- ══ CTA ═══════════════════════════════════ -->
    <div class="team-cta">
        <div class="team-cta-inner">
            <h2 class="team-cta-title">Trek with the best guides in Nepal</h2>
            <p class="team-cta-desc">
                Our team is ready to take you on the adventure of a lifetime.
            </p>
            <a href="<?php echo esc_url( home_url('/trips') ); ?>"
               class="team-cta-btn">
                View All Treks →
            </a>
        </div>
    </div>

</div>

<?php get_template_part( 'parts/footer' ); ?>