<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$at_kicker      = get_theme_mod( 'desire_at_kicker', 'Our Story' );
$at_title       = get_theme_mod( 'desire_at_title', 'Born from a passion for the mountains' );
$at_desc        = get_theme_mod( 'desire_at_desc', "We are a team of passionate Nepali guides and trekking experts who have spent years walking these trails. From the high passes of Everest to the sacred lakes of Mustang, we bring you authentic, safe and life-changing Himalayan experiences." );
$at_founder_name  = get_theme_mod( 'desire_at_founder_name', 'Suraj Tamang' );
$at_founder_role  = get_theme_mod( 'desire_at_founder_role', 'Founder & Lead Guide' );
$at_founder_photo = get_theme_mod( 'desire_at_founder_photo' );
$at_team_photo    = get_theme_mod( 'desire_at_team_photo' );
$at_years         = get_theme_mod( 'desire_at_years', '15+' );
$at_years_label   = get_theme_mod( 'desire_at_years_label', 'Years on the trails' );
$at_btn_text      = get_theme_mod( 'desire_at_btn_text', 'Meet Our Team' );
$at_btn_url       = get_theme_mod( 'desire_at_btn_url', '#' );
?>

<section class="about-teaser-section" id="section-about">
    <canvas class="at-snow" aria-hidden="true"></canvas>
    <div class="about-teaser-container">

        <!-- LEFT: Text Content -->
        <div class="at-text-col">
            <p class="at-kicker"><?php echo esc_html( $at_kicker ); ?></p>
            <h2 class="at-title"><?php echo esc_html( $at_title ); ?></h2>
            <p class="at-desc"><?php echo esc_html( $at_desc ); ?></p>

            <!-- Founder Block -->
            <?php if ( $at_founder_name ) : ?>
            <div class="at-founder">
                <?php if ( $at_founder_photo ) : ?>
                    <img src="<?php echo esc_url( $at_founder_photo ); ?>" 
                         alt="<?php echo esc_attr( $at_founder_name ); ?>" 
                         class="at-founder-img">
                <?php else : ?>
                    <div class="at-founder-initials">
                        <?php echo esc_html( strtoupper( substr( $at_founder_name, 0, 1 ) ) ); ?>
                    </div>
                <?php endif; ?>
                <div>
                    <div class="at-founder-name"><?php echo esc_html( $at_founder_name ); ?></div>
                    <div class="at-founder-role"><?php echo esc_html( $at_founder_role ); ?></div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Read More Button -->
            <?php if ( $at_btn_text ) : ?>
            <a href="<?php echo esc_url( $at_btn_url ); ?>" class="btn-about">
                <?php echo esc_html( $at_btn_text ); ?>
            </a>
            <?php endif; ?>
        </div>

        <!-- RIGHT: Photo + Badge -->
        <div class="at-photo-col">
            <div class="at-team-photo">
                <?php if ( $at_team_photo ) : ?>
                    <img src="<?php echo esc_url( $at_team_photo ); ?>" 
                         alt="<?php echo esc_html( get_bloginfo( 'name' ) ); ?> team">
                <?php else : ?>
                    <div class="at-photo-placeholder">Upload your team photo in Customize</div>
                <?php endif; ?>
            </div>

            <!-- Years of Experience Badge -->
            <?php if ( $at_years ) : ?>
            <div class="at-badge">
                <span class="at-badge-num"><?php echo esc_html( $at_years ); ?></span>
                <span class="at-badge-label"><?php echo esc_html( $at_years_label ); ?></span>
            </div>
            <?php endif; ?>
        </div>

    </div>

    <script>
    (function () {
        var section = document.getElementById('section-about');
        var canvas  = section && section.querySelector('.at-snow');
        if (!canvas) return;

        // Respect users who prefer less motion — no animation for them
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

        var ctx = canvas.getContext('2d');
        var flakes = [];
        var COUNT = 45;          // sparse on purpose
        var running = false, raf = null;

        function size() {
            canvas.width  = section.offsetWidth;
            canvas.height = section.offsetHeight;
        }

        function makeFlakes() {
            flakes = [];
            for (var i = 0; i < COUNT; i++) {
                flakes.push({
                    x: Math.random() * canvas.width,
                    y: Math.random() * canvas.height,
                    r: Math.random() * 2 + 0.6,
                    speed: Math.random() * 0.5 + 0.2,
                    drift: Math.random() * 0.5 - 0.25,
                    o: Math.random() * 0.4 + 0.15
                });
            }
        }

        function draw() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            for (var i = 0; i < flakes.length; i++) {
                var f = flakes[i];
                ctx.beginPath();
                ctx.arc(f.x, f.y, f.r, 0, Math.PI * 2);
                ctx.fillStyle = 'rgba(255,255,255,' + f.o + ')';
                ctx.fill();
                f.y += f.speed;
                f.x += f.drift;
                if (f.y > canvas.height) { f.y = -5; f.x = Math.random() * canvas.width; }
                if (f.x > canvas.width) f.x = 0;
                if (f.x < 0) f.x = canvas.width;
            }
            raf = requestAnimationFrame(draw);
        }

        function start() { if (!running) { running = true; draw(); } }
        function stop()  { running = false; if (raf) cancelAnimationFrame(raf); }

        size(); makeFlakes();

        if ('IntersectionObserver' in window) {
            new IntersectionObserver(function (entries) {
                entries[0].isIntersecting ? start() : stop();
            }, { threshold: 0 }).observe(section);
        } else {
            start();
        }

        var t;
        window.addEventListener('resize', function () {
            clearTimeout(t);
            t = setTimeout(function () { size(); makeFlakes(); }, 200);
        });
    })();
    </script>

</section>