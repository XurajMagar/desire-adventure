<?php
/*
 * Template Name: Terms & Conditions
 */
get_template_part('parts/header');
?>

<main class="legal-page">

    <div class="legal-hero">
        <div class="legal-hero-inner">
            <p class="legal-hero-kicker">Legal</p>
            <h1 class="legal-hero-title">Terms &amp; Conditions</h1>
            <p class="legal-hero-sub">Last updated: <?php echo get_the_modified_date('F j, Y'); ?></p>
        </div>
    </div>

    <div class="legal-body">
        <div class="legal-container">
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