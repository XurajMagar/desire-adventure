<?php
$aff_label = get_theme_mod( 'desire_aff_label', 'Affiliated & Certified With' );

// Collect all logos that have been uploaded
$logos = array();
for ( $i = 1; $i <= 8; $i++ ) {
    $logo_url  = get_theme_mod( "desire_aff_logo_{$i}" );
    $logo_name = get_theme_mod( "desire_aff_name_{$i}" );
    if ( $logo_url || $logo_name ) {
        $logos[] = array(
            'url'  => $logo_url,
            'name' => $logo_name,
        );
    }
}

// Don't render if no logos added yet
if ( empty( $logos ) ) return;
?>

<section class="affiliations-section">

    <p class="aff-label"><?php echo esc_html( $aff_label ); ?></p>

    <div class="aff-track-wrapper">
        <div class="aff-track">

            <?php
            // Print logos TWICE — this is what creates the seamless infinite loop
            // The second copy picks up exactly where the first ends
            for ( $pass = 0; $pass < 2; $pass++ ) :
                foreach ( $logos as $logo ) : ?>
                    <div class="aff-logo-item">
                        <?php if ( $logo['url'] ) : ?>
                            <img src="<?php echo esc_url( $logo['url'] ); ?>"
                                 alt="<?php echo esc_attr( $logo['name'] ?: 'Partner logo' ); ?>">
                        <?php elseif ( $logo['name'] ) : ?>
                            <span class="aff-logo-text"><?php echo esc_html( $logo['name'] ); ?></span>
                        <?php endif; ?>
                    </div>
                <?php endforeach;
            endfor;
            ?>

        </div>
    </div>

</section>