<?php
/**
 * Default page template.
 * Used by any Page set to the "Default template" that has no more specific
 * page-{slug}.php file.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

get_template_part( 'parts/header' );
?>

<main class="page-default">
    <?php while ( have_posts() ) : the_post(); ?>

        <header class="page-default-header">
            <div class="page-default-inner">
                <h1 class="page-default-title"><?php the_title(); ?></h1>
            </div>
        </header>

        <div class="page-default-content">
            <div class="page-default-inner">
                <?php
                the_content();

                wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'desire-adventure' ),
                    'after'  => '</div>',
                ) );
                ?>
            </div>
        </div>

    <?php endwhile; ?>
</main>

<?php get_template_part( 'parts/footer' ); ?>