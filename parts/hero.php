<?php 
    $hero_video_id  = get_theme_mod('desire_hero_video');
    $hero_video     = $hero_video_id ? wp_get_attachment_url($hero_video_id) : '';
    $hero_img = get_theme_mod('desire_hero_image', get_template_directory_uri() . '/images/hero-fallback.webp');
    $hero_title = get_theme_mod('desire_hero_title', 'Discover the Heart of the Himalayas');
    
    // Button 1 Data
    $btn1_text = get_theme_mod('desire_hero_btn1_text', 'View Packages');
    $btn1_url = get_theme_mod('desire_hero_btn1_url', '#');
    
    // NEW: Button 2 Data
    $btn2_text = get_theme_mod('desire_hero_btn2_text', 'Plan My Trip');
    $btn2_url = get_theme_mod('desire_hero_btn2_url', '#');
?>

<section class="hero-slider" id="section-hero">
    
    <?php if ( $hero_video ) : ?>
        <video autoplay muted loop playsinline class="hero-video">
            <source src="<?php echo esc_url($hero_video); ?>" type="video/mp4">
        </video>
    <?php endif; ?>

    <?php 
        $slide_style = $hero_video 
    ? '' 
    : 'background-image: url(' . esc_url($hero_img) . ');';
        ?>
        <div class="hero-slide" style="<?php echo $slide_style; ?>">
        <div class="hero-content">
            <h1><?php echo nl2br(esc_html($hero_title)); ?></h1>
            
            <div class="hero-btns">
                <!-- Primary Button -->
                <!-- Primary Button -->
                <?php if ( $btn1_text ) : ?>
                <a href="<?php echo esc_url($btn1_url); ?>" class="btn-primary">
                    <?php echo esc_html($btn1_text); ?>
                </a>
                <?php endif; ?>
                
                <!-- NEW: Secondary Button -->
                <?php if ( $btn2_text ) : ?>
                <a href="<?php echo esc_url($btn2_url); ?>" class="btn-secondary">
                    <?php echo esc_html($btn2_text); ?>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>