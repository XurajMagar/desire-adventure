<?php
/*
 * Template Name: Legal Documents
 */
get_template_part('parts/header');
?>

<main class="legal-page">

    <div class="legal-hero">
        <div class="legal-hero-inner">
            <p class="legal-hero-kicker">Legal</p>
            <h1 class="legal-hero-title">Legal Documents</h1>
            <p class="legal-hero-sub">Last updated: <?php echo get_the_modified_date('F j, Y'); ?></p>
        </div>
    </div>

    <div class="legal-body">
        <div class="legal-container">

            <!-- Quick links to other legal pages -->
            <div class="legal-doc-links">
                <a href="<?php echo esc_url( home_url('/terms-and-conditions') ); ?>" class="legal-doc-card">
                    <span class="legal-doc-icon">📋</span>
                    <span class="legal-doc-title">Terms &amp; Conditions</span>
                    <span class="legal-doc-arrow">→</span>
                </a>
                <a href="<?php echo esc_url( home_url('/privacy-policy') ); ?>" class="legal-doc-card">
                    <span class="legal-doc-icon">🔒</span>
                    <span class="legal-doc-title">Privacy Policy</span>
                    <span class="legal-doc-arrow">→</span>
                </a>
            </div>

            <div class="legal-content">
                <?php
                while ( have_posts() ) :
                    the_post();
                    the_content();
                endwhile;
                ?>
            </div>
        </div>
    </div>

</main>

<?php get_template_part('parts/footer'); ?>