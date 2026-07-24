<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
    $hero_video_id  = get_theme_mod('desire_hero_video');
    $hero_video     = $hero_video_id ? wp_get_attachment_url($hero_video_id) : '';
    $hero_video_m_id = get_theme_mod('desire_hero_video_mobile');
    $hero_video_mob  = $hero_video_m_id ? wp_get_attachment_url($hero_video_m_id) : '';
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
    
    <?php if ( $hero_video || $hero_video_mob ) : ?>
        <video autoplay muted loop playsinline
            preload="none"
            poster="<?php echo esc_url($hero_img); ?>"
            class="hero-video"
            data-src-desktop="<?php echo esc_url($hero_video); ?>"
            data-src-mobile="<?php echo esc_url($hero_video_mob); ?>"></video>
        <script>
        (function () {
            var v = document.querySelector('.hero-video');
            if (!v) return;
            var mq = window.matchMedia('(min-width: 1024px)');
            function pick() {
                var want = mq.matches ? v.dataset.srcDesktop : v.dataset.srcMobile;
                if (!want) {
                    // No video for this screen — hide it, let the CSS image show
                    if (v.getAttribute('src')) {
                        v.pause();
                        v.removeAttribute('src');
                        v.load();
                    }
                    v.style.display = 'none';
                    return;
                }
                v.style.display = '';
                if (v.getAttribute('src') === want) return; // already loaded
                v.src = want;
                v.load();
                var p = v.play();
                if (p) { p.catch(function () {}); }
            }
            pick();
            mq.addEventListener('change', pick);
        })();
        </script>
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