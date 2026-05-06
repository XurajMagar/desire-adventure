<?php
/**
 * Desire Adventure Functions
 */
function desire_adventure_setup() {
    // Unlocks the "Logo" upload in Site Identity
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    // Manages the browser tab title automatically[cite: 3]
    add_theme_support( 'title-tag' );

    // Registers the menu location so you can use the Dashboard[cite: 3]
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'desire-adventure' ),
    ) );
}
add_action( 'after_setup_theme', 'desire_adventure_setup' );

// Create the Theme Settings Page (Customizer Section)[cite: 3]
function desire_adventure_customizer_settings( $wp_customize ) {
    
    // --- SECTION 1: HEADER SETTINGS ---
    $wp_customize->add_section( 'desire_settings_section' , array(
        'title'      => __( 'Desire Adventure Settings', 'desire-adventure' ),
        'priority'   => 30,
    ) );

    // WhatsApp Number Setting
    $wp_customize->add_setting( 'desire_whatsapp_number', array(
        'default'   => '+977 9851233710',
        'transport' => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'desire_whatsapp_control', array(
        'label'      => __( 'WhatsApp Number', 'desire-adventure' ),
        'section'    => 'desire_settings_section',
        'settings'   => 'desire_whatsapp_number',
        'type'       => 'text',
    ) ) );

    // Sticky Header Toggle
    $wp_customize->add_setting( 'desire_sticky_header', array(
        'default'   => true,
        'transport' => 'refresh',
    ) );
    $wp_customize->add_control( 'desire_sticky_control', array(
        'label'    => __( 'Enable Sticky Header', 'desire-adventure' ),
        'section'  => 'desire_settings_section',
        'settings' => 'desire_sticky_header',
        'type'     => 'checkbox',
    ) );

    // Header Background Color
    $wp_customize->add_setting( 'desire_header_bg_color', array(
        'default'   => '#000000',
        'transport' => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_bg_control', array(
        'label'    => __( 'Header Background Color', 'desire-adventure' ),
        'section'  => 'desire_settings_section',
        'settings' => 'desire_header_bg_color',
    ) ) );

    // Header Typography
    $wp_customize->add_setting( 'desire_header_font', array(
        'default'   => 'DM Sans',
        'transport' => 'refresh',
    ) );
    $wp_customize->add_control( 'header_font_control', array(
        'label'    => __( 'Header Font Style', 'desire-adventure' ),
        'section'  => 'desire_settings_section',
        'settings' => 'desire_header_font',
        'type'     => 'select',
        'choices'  => array(
            'DM Sans' => 'Modern Sans-Serif (DM Sans)',
            'Cormorant Garamond' => 'Elegant Serif (Cormorant)',
            'Arial' => 'Classic (Arial)',
        ),
    ) );

    // --- SECTION 2: HERO BANNER SETTINGS ---
    $wp_customize->add_section( 'desire_hero_section' , array(
        'title'      => __( 'Homepage Hero Banner', 'desire-adventure' ),
        'priority'   => 40,
    ) );

    // 1. Hero Background Image
    $wp_customize->add_setting( 'desire_hero_image' );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'hero_image_control', array(
        'label'    => __( 'Banner Image', 'desire-adventure' ),
        'section'  => 'desire_hero_section',
        'settings' => 'desire_hero_image',
    ) ) );

    // 2. Hero Title
    $wp_customize->add_setting( 'desire_hero_title', array( 'default' => 'Discover the Heart of the Himalayas' ) );
    $wp_customize->add_control( 'hero_title_control', array(
        'label'    => __( 'Main Title', 'desire-adventure' ),
        'section'  => 'desire_hero_section',
        'settings' => 'desire_hero_title',
        'type'     => 'textarea',
    ) );

    // 3. Button 1 (Text & Link)
    $wp_customize->add_setting( 'desire_hero_btn1_text', array( 'default' => 'View Packages' ) );
    $wp_customize->add_control( 'hero_btn1_text_control', array(
        'label' => 'Button 1 Text', 'section' => 'desire_hero_section', 'settings' => 'desire_hero_btn1_text',
    ) );
    $wp_customize->add_setting( 'desire_hero_btn1_url', array( 'default' => '#' ) );
    $wp_customize->add_control( 'hero_btn1_url_control', array(
        'label' => 'Button 1 Link (URL)', 'section' => 'desire_hero_section', 'settings' => 'desire_hero_btn1_url',
    ) );

    // 4. Button 2 (Text & Link)
    $wp_customize->add_setting( 'desire_hero_btn2_text', array( 'default' => 'Plan My Trip' ) );
    $wp_customize->add_control( 'hero_btn2_text_control', array(
        'label' => 'Button 2 Text', 'section' => 'desire_hero_section', 'settings' => 'desire_hero_btn2_text',
    ) );
    $wp_customize->add_setting( 'desire_hero_btn2_url', array( 'default' => '#' ) );
    $wp_customize->add_control( 'hero_btn2_url_control', array(
        'label' => 'Button 2 Link (URL)', 'section' => 'desire_hero_section', 'settings' => 'desire_hero_btn2_url',
    ) );
    // --- VIDEO BANNER SETTING ---
    $wp_customize->add_setting( 'desire_hero_video' );
    $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'hero_video_control', array(
        'label'    => __( 'Banner Video (MP4)', 'desire-adventure' ),
        'section'  => 'desire_hero_section',
        'mime_type' => 'video', // This limits the upload to video files
    ) ) );

} // <--- ALL settings must be ABOVE this closing bracket!

add_action( 'customize_register', 'desire_adventure_customizer_settings' );
// for the featured trip section
function desire_adventure_register_trips() {
    $args = array(
        'labels' => array(
            'name' => 'Trips',
            'singular_name' => 'Trip',
        ),
        'public'      => true,
        'has_archive' => true,
        'menu_icon'   => 'dashicons-mountain',
        'supports'    => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'rewrite'     => array('slug' => 'trips'),
        'taxonomies'  => array( 'category' ), // This line is the key!
    );
    register_post_type( 'trips', $args );
}
add_action( 'init', 'desire_adventure_register_trips' );

// Save the data when you hit 'Publish'
// ============================================
// TRIP META BOXES
// ============================================
function desire_adventure_add_trip_meta_boxes() {
    add_meta_box(
        'trip_price_breakdown',
        '💰 Price Breakdown & Group Discounts',
        'desire_trip_price_breakdown_callback',
        'trips',
        'side',
        'high'
    );
    //Trip Badge
    add_meta_box(
        'trip_badges',
        '🏆 Trip Badges',
        'desire_trip_badges_callback',
        'trips',
        'side',
        'high'
    );
    // Basic Details
    add_meta_box(
        'trip_basic_details',
        'Trip Basic Details',
        'desire_trip_basic_callback',
        'trips',
        'side',
        'high'
    );
    // highlight
    add_meta_box(
        'trip_highlights',
        '✨ Trip Highlights',
        'desire_trip_highlights_callback',
        'trips',
        'normal',
        'high'
    );
    //packing list
    add_meta_box(
        'trip_packing',
        '🎒 Packing List',
        'desire_trip_packing_callback',
        'trips',
        'normal',
        'high'
    );
    // Itinerary
    add_meta_box(
        'trip_itinerary',
        'Day by Day Itinerary (up to 20 days)',
        'desire_trip_itinerary_callback',
        'trips',
        'normal',
        'high'
    );
    //accommodation fill up data teahouse
    add_meta_box(
        'trip_accommodation',
        '🏨 Accommodation Details',
        'desire_trip_accommodation_callback',
        'trips',
        'normal',
        'high'
    );
    // Includes & Excludes
    add_meta_box(
        'trip_inc_exc',
        'Includes & Excludes',
        'desire_trip_inc_exc_callback',
        'trips',
        'normal',
        'default'
    );
    // Difficulty & Fitness
    add_meta_box(
        'trip_difficulty',
        'Difficulty & Fitness Level',
        'desire_trip_difficulty_callback',
        'trips',
        'side',
        'default'
    );
    // Gallery
    add_meta_box(
        'trip_gallery',
        'Trip Gallery (up to 8 photos)',
        'desire_trip_gallery_callback',
        'trips',
        'normal',
        'default'
    );
    // Map
    add_meta_box(
        'trip_map',
        'Map Embed',
        'desire_trip_map_callback',
        'trips',
        'normal',
        'default'
    );
    // FAQs
    add_meta_box(
        'trip_faqs',
        'Trip FAQs (up to 6)',
        'desire_trip_faqs_callback',
        'trips',
        'normal',
        'default'
    );
    // Booking Details
    add_meta_box(
        'trip_booking',
        'Booking Details',
        'desire_trip_booking_callback',
        'trips',
        'side',
        'default'
    );
    // Departure Dates
    add_meta_box(
        'trip_departures',
        'Departure Dates (up to 8)',
        'desire_trip_departures_callback',
        'trips',
        'normal',
        'high'
    );
    //Review 
    add_meta_box(
        'trip_reviews',
        '⭐ Traveller Reviews',
        'desire_trip_reviews_callback',
        'trips',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'desire_adventure_add_trip_meta_boxes' );


// --- Callback: Basic Details ---
function desire_trip_basic_callback( $post ) {
    wp_nonce_field( 'save_trip_meta', 'trip_meta_nonce' );
    $price      = get_post_meta( $post->ID, '_trip_price', true );
    $sale_price = get_post_meta( $post->ID, '_trip_sale_price', true ); //
    $duration   = get_post_meta( $post->ID, '_trip_duration', true );
    $altitude   = get_post_meta( $post->ID, '_trip_max_altitude', true );
    $group      = get_post_meta( $post->ID, '_trip_group_size', true );
    $starts     = get_post_meta( $post->ID, '_trip_start_end', true );
    $season     = get_post_meta( $post->ID, '_trip_best_season', true );
    ?>

    <p><strong>Duration (e.g. 14 Days):</strong></p>
    <input type="text" name="trip_duration" value="<?php echo esc_attr( $duration ); ?>" style="width:100%;margin-bottom:10px">

    <p><strong>Max Altitude (e.g. 5,364m):</strong></p>
    <input type="text" name="trip_max_altitude" value="<?php echo esc_attr( $altitude ); ?>" style="width:100%;margin-bottom:10px">

    <p><strong>Group Size (e.g. 2 – 12):</strong></p>
    <input type="text" name="trip_group_size" value="<?php echo esc_attr( $group ); ?>" style="width:100%;margin-bottom:10px">

    <p><strong>Starts / Ends (e.g. Kathmandu):</strong></p>
    <input type="text" name="trip_start_end" value="<?php echo esc_attr( $starts ); ?>" style="width:100%;margin-bottom:10px">

    <p><strong>Best Season (e.g. Mar–May, Sep–Nov):</strong></p>
    <input type="text" name="trip_best_season" value="<?php echo esc_attr( $season ); ?>" style="width:100%;margin-bottom:10px">

    <hr style="margin:15px 0;border:none;border-top:1px solid #ddd">
    <p><strong>💰 Pricing</strong></p>

    <p><strong>Regular Price (e.g. USD 1,500):</strong></p>
    <input type="text" name="trip_price" value="<?php echo esc_attr( $price ); ?>"
           style="width:100%;margin-bottom:10px">

    <p><strong>Sale Price (leave blank if no discount):</strong></p>
    <input type="text" name="trip_sale_price" value="<?php echo esc_attr( $sale_price ); ?>"
           placeholder="e.g. USD 1,200"
           style="width:100%;margin-bottom:10px">

    <p style="font-size:11px;color:#666">
        💡 If Sale Price is set, the discount % is calculated automatically and shown as a badge on the page.
    </p>

    <?php
}

// --- Callback: Itinerary ---
function desire_trip_itinerary_callback( $post ) {
    // Count how many days are already saved
    $saved_days = 0;
    for ( $d = 1; $d <= 30; $d++ ) {
        if ( get_post_meta( $post->ID, "_trip_day_{$d}_title", true ) ) {
            $saved_days = $d;
        }
    }
    // Show at least 1 empty day if none saved
    if ( $saved_days === 0 ) $saved_days = 1;
    ?>
    <p style="color:#666;font-size:12px;margin-bottom:15px">
        Add days one by one. You can add up to 30 days. Each day can have a title, duration, altitude and optional photo.
    </p>

    <div id="tp-days-container">
        <?php for ( $d = 1; $d <= $saved_days; $d++ ) :
            $title    = get_post_meta( $post->ID, "_trip_day_{$d}_title", true );
            $duration = get_post_meta( $post->ID, "_trip_day_{$d}_duration", true );
            $altitude = get_post_meta( $post->ID, "_trip_day_{$d}_altitude", true );
            $desc     = get_post_meta( $post->ID, "_trip_day_{$d}_desc", true );
            $photo    = get_post_meta( $post->ID, "_trip_day_{$d}_photo", true );
            ?>
            <div class="tp-day-row" style="border:1px solid #ddd;border-radius:6px;padding:14px;margin-bottom:12px;background:#fafafa">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px">
                    <strong class="tp-day-label" style="color:#1A2E20">Day <?php echo $d; ?></strong>
                    <?php if ( $d > 1 ) : // Don't allow removing day 1 ?>
                    <button type="button" class="tp-remove-day button" style="color:#c0392b;border-color:#c0392b">Remove</button>
                    <?php endif; ?>
                </div>
                <div style="display:grid;grid-template-columns:1fr 130px 130px;gap:8px;margin-bottom:8px">
                    <input type="text" name="trip_day_<?php echo $d; ?>_title"
                           placeholder="Day title (e.g. Fly to Lukla, Trek to Phakding)"
                           value="<?php echo esc_attr( $title ); ?>" style="width:100%">
                    <input type="text" name="trip_day_<?php echo $d; ?>_duration"
                           placeholder="Duration (e.g. 5-6 hrs)"
                           value="<?php echo esc_attr( $duration ); ?>" style="width:100%">
                    <input type="text" name="trip_day_<?php echo $d; ?>_altitude"
                           placeholder="Altitude (e.g. 3440m)"
                           value="<?php echo esc_attr( $altitude ); ?>" style="width:100%">
                </div>
                <textarea name="trip_day_<?php echo $d; ?>_desc"
                          placeholder="Day description..."
                          rows="2" style="width:100%;margin-bottom:8px"><?php echo esc_textarea( $desc ); ?></textarea>
                <div style="display:flex;align-items:center;gap:8px">
                    <input type="hidden" name="trip_day_<?php echo $d; ?>_photo"
                           class="tp-day-photo-url" value="<?php echo esc_url( $photo ); ?>">
                    <button type="button" class="tp-upload-photo button">📷 Add Photo</button>
                    <span class="tp-photo-preview">
                        <?php if ( $photo ) : ?>
                            <img src="<?php echo esc_url( $photo ); ?>"
                                 style="height:40px;border-radius:4px;vertical-align:middle;margin-right:6px">
                            <a href="#" class="tp-remove-photo" style="color:#c0392b;font-size:11px">Remove</a>
                        <?php endif; ?>
                    </span>
                </div>
            </div>
        <?php endfor; ?>
    </div>

    <button type="button" id="tp-add-day" class="button button-primary" style="margin-top:8px">
        + Add Day <?php echo $saved_days + 1; ?>
    </button>

    <p style="font-size:11px;color:#999;margin-top:8px">
        Maximum 30 days. Use the altitude field to power the automatic altitude chart on the trip page.
    </p>
    <?php
}


// --- Callback: Includes & Excludes ---
function desire_trip_inc_exc_callback( $post ) {
    $includes = get_post_meta( $post->ID, '_trip_includes', true );
    $excludes = get_post_meta( $post->ID, '_trip_excludes', true );
    ?>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">
        <div>
            <p><strong style="color:#1A2E20">✓ Included</strong></p>
            <p style="font-size:11px;color:#666;margin:4px 0 8px">One item per line</p>
            <textarea name="trip_includes" rows="8" style="width:100%"
                      placeholder="All permits and entry fees&#10;Accommodation on trail&#10;All meals during trek&#10;Experienced guide&#10;Porter (1 per 2 guests)"><?php echo esc_textarea( $includes ); ?></textarea>
        </div>
        <div>
            <p><strong style="color:#c0392b">✕ Excluded</strong></p>
            <p style="font-size:11px;color:#666;margin:4px 0 8px">One item per line</p>
            <textarea name="trip_excludes" rows="8" style="width:100%"
                      placeholder="International flights&#10;Travel insurance&#10;Personal trekking gear&#10;Tips for guide and porter"><?php echo esc_textarea( $excludes ); ?></textarea>
        </div>
    </div>
    <?php
}


// --- Callback: Difficulty ---
function desire_trip_difficulty_callback( $post ) {
    $level = get_post_meta( $post->ID, '_trip_difficulty', true );
    $desc  = get_post_meta( $post->ID, '_trip_fitness_desc', true );
    ?>
    <p><strong>Difficulty Level:</strong></p>
    <select name="trip_difficulty" style="width:100%;margin-bottom:10px">
        <?php foreach ( array( 'Easy', 'Easy-Moderate', 'Moderate', 'Moderate-Strenuous', 'Strenuous', 'Expert' ) as $opt ) : ?>
            <option value="<?php echo esc_attr( $opt ); ?>" <?php selected( $level, $opt ); ?>>
                <?php echo esc_html( $opt ); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <p><strong>Fitness Description:</strong></p>
    <textarea name="trip_fitness_desc" rows="4" style="width:100%"
              placeholder="Describe the fitness requirements for this trek..."><?php echo esc_textarea( $desc ); ?></textarea>
    <?php
}


// --- Callback: Gallery ---
function desire_trip_gallery_callback( $post ) {
    ?>
    <p style="color:#666;font-size:12px;margin-bottom:15px">
        Upload images via Media Library first, then paste their URLs below. One URL per box.
    </p>
    <?php
    for ( $g = 1; $g <= 8; $g++ ) :
        $img = get_post_meta( $post->ID, "_trip_gallery_{$g}", true );
        ?>
        <div style="margin-bottom:8px;display:flex;align-items:center;gap:10px">
            <span style="font-size:12px;color:#999;width:55px;flex-shrink:0">Photo <?php echo $g; ?></span>
            <input type="text" name="trip_gallery_<?php echo $g; ?>"
                   placeholder="https://..."
                   value="<?php echo esc_url( $img ); ?>" style="width:100%">
        </div>
    <?php endfor;
}


// --- Callback: Map ---
function desire_trip_map_callback( $post ) {
    $map_img    = get_post_meta( $post->ID, '_trip_map_image', true );
    $map_credit = get_post_meta( $post->ID, '_trip_map_credit', true );
    ?>
    <p style="color:#666;font-size:12px;margin-bottom:15px">
        Upload a custom trek route map image. JPG or PNG recommended. 
        Wide landscape format works best (e.g. 1200×600px).
    </p>

    <div style="margin-bottom:16px">
        <strong style="display:block;margin-bottom:8px">Map Image:</strong>

        <div id="tp-map-preview" style="margin-bottom:10px">
            <?php if ( $map_img ) : ?>
            <div style="position:relative;display:inline-block">
                <img src="<?php echo esc_url( $map_img ); ?>"
                     style="max-width:100%;max-height:300px;border-radius:6px;border:1px solid #ddd;display:block">
                <button type="button" id="tp-map-remove"
                        style="position:absolute;top:6px;right:6px;background:#c0392b;color:#fff;border:none;border-radius:4px;padding:4px 8px;font-size:11px;cursor:pointer">
                    ✕ Remove
                </button>
            </div>
            <?php else : ?>
            <div id="tp-map-placeholder"
                 style="width:100%;height:140px;border:2px dashed #ddd;border-radius:6px;display:flex;align-items:center;justify-content:center;color:#999;font-size:13px;background:#fafafa">
                No map image uploaded yet
            </div>
            <?php endif; ?>
        </div>

        <input type="hidden" name="trip_map_image"
               id="tp-map-image-url"
               value="<?php echo esc_url( $map_img ); ?>">

        <button type="button" id="tp-upload-map" class="button">
            🗺 Upload Map Image
        </button>
    </div>

    <div>
        <strong style="display:block;margin-bottom:6px">Map Credit (optional):</strong>
        <input type="text" name="trip_map_credit"
               value="<?php echo esc_attr( $map_credit ); ?>"
               placeholder="e.g. Map courtesy of Nepal Trekking Routes"
               style="width:100%;padding:6px;border:1px solid #ddd;border-radius:4px;font-size:13px">
        <p style="font-size:11px;color:#999;margin-top:4px">
            Shown as a small caption below the map image.
        </p>
    </div>

    <script>
    jQuery(document).ready(function($) {
        var frame;

        $('#tp-upload-map').on('click', function(e) {
            e.preventDefault();
            if (frame) { frame.open(); return; }
            frame = wp.media({
                title: 'Select Trek Map Image',
                button: { text: 'Use this image' },
                multiple: false,
                library: { type: 'image' }
            });
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                $('#tp-map-image-url').val(attachment.url);
                $('#tp-map-preview').html(
                    '<div style="position:relative;display:inline-block">' +
                    '<img src="' + attachment.url + '" style="max-width:100%;max-height:300px;border-radius:6px;border:1px solid #ddd;display:block">' +
                    '<button type="button" id="tp-map-remove" style="position:absolute;top:6px;right:6px;background:#c0392b;color:#fff;border:none;border-radius:4px;padding:4px 8px;font-size:11px;cursor:pointer">✕ Remove</button>' +
                    '</div>'
                );
                bindRemove();
            });
            frame.open();
        });

        function bindRemove() {
            $('#tp-map-remove').on('click', function() {
                $('#tp-map-image-url').val('');
                $('#tp-map-preview').html(
                    '<div id="tp-map-placeholder" style="width:100%;height:140px;border:2px dashed #ddd;border-radius:6px;display:flex;align-items:center;justify-content:center;color:#999;font-size:13px;background:#fafafa">No map image uploaded yet</div>'
                );
            });
        }
        bindRemove();
    });
    </script>
    <?php
}


// --- Callback: FAQs ---
function desire_trip_faqs_callback( $post ) {
    ?>
    <p style="color:#666;font-size:12px;margin-bottom:15px">Leave blank to hide that FAQ.</p>
    <?php
    for ( $f = 1; $f <= 6; $f++ ) :
        $q = get_post_meta( $post->ID, "_trip_faq_{$f}_q", true );
        $a = get_post_meta( $post->ID, "_trip_faq_{$f}_a", true );
        ?>
        <div style="border:1px solid #ddd;border-radius:6px;padding:12px;margin-bottom:10px;background:#fafafa">
            <strong style="color:#666;font-size:12px">FAQ <?php echo $f; ?></strong>
            <input type="text" name="trip_faq_<?php echo $f; ?>_q"
                   placeholder="Question..."
                   value="<?php echo esc_attr( $q ); ?>" style="width:100%;margin:8px 0">
            <textarea name="trip_faq_<?php echo $f; ?>_a"
                      placeholder="Answer..."
                      rows="2" style="width:100%"><?php echo esc_textarea( $a ); ?></textarea>
        </div>
    <?php endfor;
}


// --- Callback: Booking Details ---
function desire_trip_booking_callback( $post ) {
    $wa       = get_post_meta( $post->ID, '_trip_whatsapp', true );
    $cancel   = get_post_meta( $post->ID, '_trip_cancellation', true );
    $book_url = get_post_meta( $post->ID, '_trip_book_url', true );
    ?>
    <p><strong>WhatsApp Number:</strong></p>
    <p style="font-size:11px;color:#666;margin-bottom:4px">Leave blank to use the global number from Settings</p>
    <input type="text" name="trip_whatsapp"
           value="<?php echo esc_attr( $wa ); ?>"
           placeholder="+977 9851233710"
           style="width:100%;margin-bottom:10px">

    <p><strong>Book Now URL (optional):</strong></p>
    <p style="font-size:11px;color:#666;margin-bottom:4px">Leave blank to use the enquiry form</p>
    <input type="text" name="trip_book_url"
           value="<?php echo esc_attr( $book_url ); ?>"
           placeholder="https://..."
           style="width:100%;margin-bottom:10px">

    <p><strong>Cancellation Policy:</strong></p>
    <input type="text" name="trip_cancellation"
           value="<?php echo esc_attr( $cancel ); ?>"
           placeholder="e.g. Free cancellation up to 30 days"
           style="width:100%">
    <?php
}


// --- Save ALL meta fields ---
function desire_save_trip_meta( $post_id ) {
    // Security checks
    if ( ! isset( $_POST['trip_meta_nonce'] ) ||
         ! wp_verify_nonce( $_POST['trip_meta_nonce'], 'save_trip_meta' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // --- Basic text fields ---
    $basic_fields = array(
        'trip_price'        => '_trip_price',
        'trip_sale_price'   => '_trip_sale_price',
        'trip_duration'     => '_trip_duration',
        'trip_max_altitude' => '_trip_max_altitude',
        'trip_group_size'   => '_trip_group_size',
        'trip_start_end'    => '_trip_start_end',
        'trip_best_season'  => '_trip_best_season',
        'trip_difficulty'   => '_trip_difficulty',
        'trip_whatsapp'     => '_trip_whatsapp',
        'trip_book_url'     => '_trip_book_url',
        'trip_cancellation' => '_trip_cancellation',
    );

    foreach ( $basic_fields as $post_key => $meta_key ) {
        if ( isset( $_POST[ $post_key ] ) ) {
            update_post_meta(
                $post_id,
                $meta_key,
                sanitize_text_field( $_POST[ $post_key ] )
            );
        }
    }

    // --- Textarea fields ---
    $textarea_fields = array(
        'trip_includes'    => '_trip_includes',
        'trip_excludes'    => '_trip_excludes',
        'trip_fitness_desc' => '_trip_fitness_desc',
    );

    foreach ( $textarea_fields as $post_key => $meta_key ) {
        if ( isset( $_POST[ $post_key ] ) ) {
            update_post_meta(
                $post_id,
                $meta_key,
                sanitize_textarea_field( $_POST[ $post_key ] )
            );
        }
    }

    // --- Map embed URL ---
    if ( isset( $_POST['trip_map_embed'] ) ) {
        update_post_meta(
            $post_id,
            '_trip_map_embed',
            esc_url_raw( $_POST['trip_map_embed'] )
        );
    }
    if ( isset( $_POST['trip_map_image'] ) ) {
        update_post_meta( $post_id, '_trip_map_image',
            esc_url_raw( $_POST['trip_map_image'] ) );
    }
    if ( isset( $_POST['trip_map_credit'] ) ) {
        update_post_meta( $post_id, '_trip_map_credit',
            sanitize_text_field( $_POST['trip_map_credit'] ) );
    }

    // --- Itinerary days (updated to 30 days with altitude + photo) ---
        for ( $d = 1; $d <= 30; $d++ ) {
            if ( isset( $_POST["trip_day_{$d}_title"] ) ) {
                update_post_meta( $post_id, "_trip_day_{$d}_title",
                    sanitize_text_field( $_POST["trip_day_{$d}_title"] ) );
            }
            if ( isset( $_POST["trip_day_{$d}_duration"] ) ) {
                update_post_meta( $post_id, "_trip_day_{$d}_duration",
                    sanitize_text_field( $_POST["trip_day_{$d}_duration"] ) );
            }
            if ( isset( $_POST["trip_day_{$d}_altitude"] ) ) {
                update_post_meta( $post_id, "_trip_day_{$d}_altitude",
                    sanitize_text_field( $_POST["trip_day_{$d}_altitude"] ) );
            }
            if ( isset( $_POST["trip_day_{$d}_desc"] ) ) {
                update_post_meta( $post_id, "_trip_day_{$d}_desc",
                    sanitize_textarea_field( $_POST["trip_day_{$d}_desc"] ) );
            }
            if ( isset( $_POST["trip_day_{$d}_photo"] ) ) {
                update_post_meta( $post_id, "_trip_day_{$d}_photo",
                    esc_url_raw( $_POST["trip_day_{$d}_photo"] ) );
            }
        }

        // --- Gallery: 8 photos ---
        for ( $g = 1; $g <= 8; $g++ ) {
            if ( isset( $_POST["trip_gallery_{$g}"] ) ) {
                update_post_meta(
                    $post_id,
                    "_trip_gallery_{$g}",
                    esc_url_raw( $_POST["trip_gallery_{$g}"] )
                );
            }
        }

        // --- FAQs: 6 pairs ---
        for ( $f = 1; $f <= 6; $f++ ) {
            if ( isset( $_POST["trip_faq_{$f}_q"] ) ) {
                update_post_meta(
                    $post_id,
                    "_trip_faq_{$f}_q",
                    sanitize_text_field( $_POST["trip_faq_{$f}_q"] )
                );
            }
            if ( isset( $_POST["trip_faq_{$f}_a"] ) ) {
                update_post_meta(
                    $post_id,
                    "_trip_faq_{$f}_a",
                    sanitize_textarea_field( $_POST["trip_faq_{$f}_a"] )
                );
            }
        }
        // --- Departure dates: 8 slots ---
        for ( $d = 1; $d <= 8; $d++ ) {
            $dep_fields = array(
                "trip_dep_{$d}_start"  => "_trip_dep_{$d}_start",
                "trip_dep_{$d}_end"    => "_trip_dep_{$d}_end",
                "trip_dep_{$d}_spots"  => "_trip_dep_{$d}_spots",
                "trip_dep_{$d}_price"  => "_trip_dep_{$d}_price",
                "trip_dep_{$d}_status" => "_trip_dep_{$d}_status",
            );
            foreach ( $dep_fields as $post_key => $meta_key ) {
                if ( isset( $_POST[ $post_key ] ) ) {
                    update_post_meta( $post_id, $meta_key,
                        sanitize_text_field( $_POST[ $post_key ] ) );
                }
            }
        }
        // --- Accommodation (up to 15) ---
        for ( $a = 1; $a <= 15; $a++ ) {
            $acc_fields = array(
                "trip_acc_{$a}_icon"   => "_trip_acc_{$a}_icon",
                "trip_acc_{$a}_place"  => "_trip_acc_{$a}_place",
                "trip_acc_{$a}_type"   => "_trip_acc_{$a}_type",
                "trip_acc_{$a}_nights" => "_trip_acc_{$a}_nights",
            );
            foreach ( $acc_fields as $post_key => $meta_key ) {
                if ( isset( $_POST[ $post_key ] ) && $_POST[ $post_key ] !== '' ) {
                    update_post_meta( $post_id, $meta_key,
                        sanitize_text_field( $_POST[ $post_key ] ) );
                } else {
                    delete_post_meta( $post_id, $meta_key );
                }
            }
        }
        // --- Packing List (up to 50 items) ---
        for ( $p = 1; $p <= 50; $p++ ) {
            $pack_fields = array(
                "trip_pack_{$p}_icon"     => "_trip_pack_{$p}_icon",
                "trip_pack_{$p}_item"     => "_trip_pack_{$p}_item",
                "trip_pack_{$p}_note"     => "_trip_pack_{$p}_note",
                "trip_pack_{$p}_category" => "_trip_pack_{$p}_category",
                "trip_pack_{$p}_required" => "_trip_pack_{$p}_required",
            );
            foreach ( $pack_fields as $post_key => $meta_key ) {
                if ( isset( $_POST[ $post_key ] ) && $_POST[ $post_key ] !== '' ) {
                    update_post_meta( $post_id, $meta_key,
                        sanitize_text_field( $_POST[ $post_key ] ) );
                } else {
                    delete_post_meta( $post_id, $meta_key );
                }
            }
        }
        // --- Trip Highlights (up to 20) ---
        for ( $h = 1; $h <= 20; $h++ ) {
            if ( isset( $_POST["trip_highlight_{$h}_icon"] ) ) {
                update_post_meta( $post_id, "_trip_highlight_{$h}_icon",
                    sanitize_text_field( $_POST["trip_highlight_{$h}_icon"] ) );
            } else {
                delete_post_meta( $post_id, "_trip_highlight_{$h}_icon" );
            }
            if ( isset( $_POST["trip_highlight_{$h}_text"] ) ) {
                update_post_meta( $post_id, "_trip_highlight_{$h}_text",
                    sanitize_text_field( $_POST["trip_highlight_{$h}_text"] ) );
            } else {
                delete_post_meta( $post_id, "_trip_highlight_{$h}_text" );
            }
        }
        for ( $r = 1; $r <= 6; $r++ ) {
            // Text fields
            $text_fields = array( 'name', 'country', 'rating', 'date' );
            foreach ( $text_fields as $field ) {
                $key = "trip_review_{$r}_{$field}";
                if ( isset( $_POST[ $key ] ) ) {
                    update_post_meta( $post_id,
                        "_trip_review_{$r}_{$field}",
                        sanitize_text_field( $_POST[ $key ] )
                    );
                }
            }
            // --- Price Breakdown ---
        $price_breakdown_fields = array(
            'trip_deposit'     => '_trip_deposit',
            'trip_balance_due' => '_trip_balance_due',
            'trip_price_note'  => '_trip_price_note',
        );
        foreach ( $price_breakdown_fields as $post_key => $meta_key ) {
            if ( isset( $_POST[ $post_key ] ) ) {
                update_post_meta( $post_id, $meta_key,
                    sanitize_text_field( $_POST[ $post_key ] ) );
            }
        }

        // Group discount tiers
        for ( $t = 1; $t <= 4; $t++ ) {
            foreach ( array( 'label', 'price', 'discount' ) as $field ) {
                $key = "trip_tier_{$t}_{$field}";
                if ( isset( $_POST[ $key ] ) ) {
                    update_post_meta( $post_id, "_{$key}",
                        sanitize_text_field( $_POST[ $key ] ) );
                }
            }
        }
        // Quote — textarea
        if ( isset( $_POST["trip_review_{$r}_quote"] ) ) {
            update_post_meta( $post_id,
                "_trip_review_{$r}_quote",
                sanitize_textarea_field( $_POST["trip_review_{$r}_quote"] )
            );
        }
        // --- Trip Badges ---
        if ( isset( $_POST['trip_badge_1'] ) ) {
            update_post_meta( $post_id, '_trip_badge_1',
                sanitize_text_field( $_POST['trip_badge_1'] ) );
        }
        if ( isset( $_POST['trip_badge_2'] ) ) {
            update_post_meta( $post_id, '_trip_badge_2',
                sanitize_text_field( $_POST['trip_badge_2'] ) );
        }
        // Photo — URL
        if ( isset( $_POST["trip_review_{$r}_photo"] ) ) {
            update_post_meta( $post_id,
                "_trip_review_{$r}_photo",
                esc_url_raw( $_POST["trip_review_{$r}_photo"] )
            );
        }
    }
}
add_action( 'save_post', 'desire_save_trip_meta' );
//region tags for the website
function desire_register_regions_taxonomy() {
    register_taxonomy('region', 'trips', array(
        'label'        => __('Regions'),
        'rewrite'      => array('slug' => 'region'),
        'hierarchical' => true, // Makes it behave like a category
        'show_in_rest' => true,
    ));
}
add_action('init', 'desire_register_regions_taxonomy');
//region swiper card
function desire_adventure_assets() {
       // Never load front-end assets in the WordPress admin
    if ( is_admin() ) return;
    // Booking system JS — single trip pages only
    if ( is_singular( 'trips' ) ) {
        wp_enqueue_script(
            'booking-system-js',
            get_template_directory_uri() . '/booking-system.js',
            array(),
            null,
            true
        );
    }

    // 1. Google Fonts
    wp_enqueue_style(
        'desire-google-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600&family=DM+Sans:wght@700&display=swap',
        array(),
        null
    );

    // 2. Main stylesheet
    wp_enqueue_style( 'desire-main-style', get_stylesheet_uri(), array(), '1.0.' . filemtime( get_stylesheet_directory() . '/style.css' ) );

    // 3. Font Awesome
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css' );

    // 4. Dashicons
    wp_enqueue_style( 'dashicons' );

    // 5. Swiper CSS
    wp_enqueue_style( 'swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css' );

    // 6. Swiper JS
    wp_enqueue_script( 'swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), null, true );

    // 7. Main JS
    wp_enqueue_script( 'main-js', get_template_directory_uri() . '/main.js', array( 'swiper-js' ), null, true );

    // 8. Reviews JS
    wp_enqueue_script( 'reviews-js', get_template_directory_uri() . '/reviews.js', array(), null, true );

    // 9. FAQ JS
    wp_enqueue_script( 'faq-js', get_template_directory_uri() . '/faq.js', array(), null, true );

    // 10. Navigator JS — homepage only
    if ( is_front_page() ) {
        wp_enqueue_script( 'navigator-js', get_template_directory_uri() . '/navigator.js', array(), null, true );
    }

    // 11. Trip page JS — single trip pages only
    if ( is_singular( 'trips' ) ) {
        wp_enqueue_script( 'trip-page-js', get_template_directory_uri() . '/trip-page.js', array(), null, true );
    }
    // Archive trips JS
    if ( is_post_type_archive( 'trips' ) || is_page_template( 'archive-trips.php' ) ) {
        wp_enqueue_script(
            'archive-trips-js',
            get_template_directory_uri() . '/archive-trips.js',
            array(),
            null,
            true
        );
    }
}
add_action( 'wp_enqueue_scripts', 'desire_adventure_assets' );

// why us section functions
function desire_register_why_section( $wp_customize ) {

    // 1. Create the Panel (optional, but keeps it organized)
    $wp_customize->add_section('desire_why_choose_section', array(
        'title'    => __('Why Choose Us Section', 'desire-adventure'),
        'priority' => 50, // Puts it after the Region Slider
    ));

    // 2. Main Section Header Settings
    // Subtitle ("WHY CHOOSE US")
    $wp_customize->add_setting('desire_why_subtitle', array(
        'default'   => __('WHY CHOOSE US', 'desire-adventure'),
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('desire_why_subtitle_control', array(
        'label'    => __('Section Subtitle', 'desire-adventure'),
        'section'  => 'desire_why_choose_section',
        'settings' => 'desire_why_subtitle',
        'type'     => 'text',
    ));

    // Main Title
    $wp_customize->add_setting('desire_why_main_title', array(
        'default'   => __('Your adventure, guided with heart', 'desire-adventure'),
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('desire_why_main_title_control', array(
        'label'    => __('Section Title', 'desire-adventure'),
        'section'  => 'desire_why_choose_section',
        'settings' => 'desire_why_main_title',
        'type'     => 'text',
    ));

    // Description
    $wp_customize->add_setting('desire_why_description', array(
        'default'   => __('We’ve been walking these trails for years...', 'desire-adventure'),
        'transport' => 'refresh',
        'sanitize_callback' => 'wp_kses_post', // Allows basic HTML like line breaks
    ));
    $wp_customize->add_control('desire_why_description_control', array(
        'label'    => __('Section Description', 'desire-adventure'),
        'section'  => 'desire_why_choose_section',
        'settings' => 'desire_why_description',
        'type'     => 'textarea',
    ));

    // 3. Register Feature Boxes (Creating fields for up to 6 boxes for flexibility)
    for ( $i = 1; $i <= 6; $i++ ) {

        // Settings for "Delete" logic: If the title is empty, the box disappears.

        // Icon (Font Awesome class)
        $wp_customize->add_setting("desire_why_icon_{$i}", array(
            'default'   => '', // Start empty. Use e.g., 'fas fa-map-marked'
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("desire_why_icon_control_{$i}", array(
            'label'    => sprintf(__('Feature %d Icon (FA class)', 'desire-adventure'), $i),
            'section'  => 'desire_why_choose_section',
            'settings' => "desire_why_icon_{$i}",
            'type'     => 'text',
            'description' => __('Enter a FontAwesome class, e.g., "fas fa-users" or "fas fa-heartbeat"', 'desire-adventure'),
        ));

        // Title
        $wp_customize->add_setting("desire_why_title_{$i}", array(
            'default'   => '',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("desire_why_title_control_{$i}", array(
            'label'    => sprintf(__('Feature %d Title', 'desire-adventure'), $i),
            'section'  => 'desire_why_choose_section',
            'settings' => "desire_why_title_{$i}",
            'type'     => 'text',
        ));

        // Description
        $wp_customize->add_setting("desire_why_desc_{$i}", array(
            'default'   => '',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("desire_why_desc_control_{$i}", array(
            'label'    => sprintf(__('Feature %d Description', 'desire-adventure'), $i),
            'section'  => 'desire_why_choose_section',
            'settings' => "desire_why_desc_{$i}",
            'type'     => 'textarea',
        ));
    }

    // 4. Register Stats Bar Settings (Bottom Section)
    // To keep this digestible, I'm providing fields for the first stat. Repeat for 2-4.
    
    // --- Register 4 Stats (Numbers and Labels) ---
    for ( $s = 1; $s <= 4; $s++ ) {
        
        // Stat Number (e.g., 15 yrs)
        $wp_customize->add_setting("desire_stat_num_{$s}", array(
            'default'   => '',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("desire_stat_num_control_{$s}", array(
            'label'    => sprintf(__('Stat %d Number', 'desire-adventure'), $s),
            'section'  => 'desire_why_choose_section',
            'settings' => "desire_stat_num_{$s}",
            'type'     => 'text',
        ));

        // Stat Label (e.g., ON THE TRAILS)
        $wp_customize->add_setting("desire_stat_label_{$s}", array(
            'default'   => '',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("desire_stat_label_control_{$s}", array(
            'label'    => sprintf(__('Stat %d Label', 'desire-adventure'), $s),
            'section'  => 'desire_why_choose_section',
            'settings' => "desire_stat_label_{$s}",
            'type'     => 'text',
        ));
    }

    // Repeat steps for desire_stat_num_2, 3, 4 and labels...
}
add_action( 'customize_register', 'desire_register_why_section' );  
// font awesome funciton installed
// Register package for the website with 10 slots
function desire_register_packages_section( $wp_customize ) {

    // ✅ STEP 1: Create the section FIRST before adding anything to it
    $wp_customize->add_section( 'desire_featured_packages', array(
        'title'    => __( 'Featured Packages', 'desire-adventure' ),
        'priority' => 60,
    ));

    // ✅ STEP 2: Featured Trips text settings
    $wp_customize->add_setting( 'desire_trips_eyebrow', array(
        'default'           => 'Expert-Led Expeditions',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'desire_trips_eyebrow_ctrl', array(
        'label'    => 'Featured Trips Eyebrow Text',
        'section'  => 'desire_featured_packages',
        'settings' => 'desire_trips_eyebrow',
    ));

    $wp_customize->add_setting( 'desire_trips_title', array(
        'default'           => 'Our Featured Adventures',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'desire_trips_title_ctrl', array(
        'label'    => 'Featured Trips Title',
        'section'  => 'desire_featured_packages',
        'settings' => 'desire_trips_title',
    ));

    $wp_customize->add_setting( 'desire_trips_desc', array(
        'default'           => 'Hand-picked trekking experiences designed for the modern explorer.',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'desire_trips_desc_ctrl', array(
        'label'    => 'Featured Trips Description',
        'section'  => 'desire_featured_packages',
        'settings' => 'desire_trips_desc',
        'type'     => 'textarea',
    ));

    // ✅ STEP 3: Featured Packages section heading
    $wp_customize->add_setting( 'desire_pkgs_subtitle', array(
        'default'           => 'EXPLORE NEPAL',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'desire_pkgs_subtitle_ctrl', array(
        'label'    => 'Packages Subheading',
        'section'  => 'desire_featured_packages',
        'settings' => 'desire_pkgs_subtitle',
    ));

    $wp_customize->add_setting( 'desire_pkgs_title', array(
        'default'           => 'Our Featured Packages',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'desire_pkgs_title_ctrl', array(
        'label'    => 'Packages Main Title',
        'section'  => 'desire_featured_packages',
        'settings' => 'desire_pkgs_title',
    ));

    // ✅ STEP 4: View All button
    $wp_customize->add_setting( 'desire_view_all_text', array(
        'default'           => 'VIEW ALL TREKS',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'desire_view_all_text_ctrl', array(
        'label'    => 'Button Text',
        'section'  => 'desire_featured_packages',
        'settings' => 'desire_view_all_text',
    ));

    $wp_customize->add_setting( 'desire_view_all_link', array(
        'default'           => home_url( '/trips' ),
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control( 'desire_view_all_link_ctrl', array(
        'label'    => 'Button URL',
        'section'  => 'desire_featured_packages',
        'settings' => 'desire_view_all_link',
        'type'     => 'url',
    ));

    // ✅ STEP 5: Package slot dropdowns (10 slots)
    $trips = get_posts( array(
        'post_type'      => 'trips',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
    ));

    $trip_choices = array( '' => '-- Select a Trip --' );
    foreach ( $trips as $trip ) {
        $trip_choices[ $trip->ID ] = $trip->post_title;
    }

    for ( $i = 1; $i <= 10; $i++ ) {
        $wp_customize->add_setting( "desire_pkg_id_{$i}", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control( "desire_pkg_id_ctrl_{$i}", array(
            'label'   => "Package Slot $i",
            'section' => 'desire_featured_packages',
            'settings' => "desire_pkg_id_{$i}",
            'type'    => 'select',
            'choices' => $trip_choices,
        ));
    }
}
add_action( 'customize_register', 'desire_register_packages_section' );
// section for reviews in website
function desire_register_reviews_section( $wp_customize ) {
    $wp_customize->add_section('desire_reviews_section', array(
        'title'    => __('Traveler Reviews', 'desire-adventure'),
        'priority' => 70,
    ));

    // --- 1. Global Header Controls ---
    $wp_customize->add_setting('desire_rev_title', array('default' => 'Traveler Reviews', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('desire_rev_title_ctrl', array('label' => 'Main Title', 'section' => 'desire_reviews_section', 'settings' => 'desire_rev_title'));

    $wp_customize->add_setting('desire_rev_subtitle', array('default' => 'Authentic experiences from travelers who have explored with us.', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('desire_rev_subtitle_ctrl', array('label' => 'Subtitle', 'section' => 'desire_reviews_section', 'settings' => 'desire_rev_subtitle', 'type' => 'textarea'));

    $wp_customize->add_setting('desire_ta_logo');
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'desire_ta_logo_ctrl', array('label' => 'TripAdvisor Logo', 'section' => 'desire_reviews_section', 'settings' => 'desire_ta_logo')));
    $wp_customize->add_setting( 'desire_ta_link', array(
    'default'           => '#',
    'sanitize_callback' => 'esc_url_raw',) );
    $wp_customize->add_control( 'desire_ta_link_ctrl', array(
    'label'    => 'TripAdvis    or Profile URL',
    'section'  => 'desire_reviews_section',
    'settings' => 'desire_ta_link',
    'type'     => 'url',) );
    $wp_customize->add_setting('desire_ta_count_text', array('default' => '300 reviews in TripAdvisor', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('desire_ta_count_text_ctrl', array('label' => 'Review Count Text', 'section' => 'desire_reviews_section', 'settings' => 'desire_ta_count_text'));

    $wp_customize->add_setting('desire_rev_all_link', array('default' => '#', 'sanitize_callback' => 'esc_url_raw'));
    $wp_customize->add_control('desire_rev_all_link_ctrl', array('label' => 'Read All Reviews URL', 'section' => 'desire_reviews_section', 'settings' => 'desire_rev_all_link', 'type' => 'url'));

    // --- 2. Review Slots (Nested Loop) ---
    for ( $i = 1; $i <= 4; $i++ ) {
        // Individual Reviewer Info
        $wp_customize->add_setting("desire_rev_avatar_$i");
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "desire_rev_avatar_ctrl_$i", array('label' => "Avatar $i", 'section' => 'desire_reviews_section', 'settings' => "desire_rev_avatar_$i")));

        $wp_customize->add_setting("desire_rev_name_$i", array('sanitize_callback' => 'sanitize_text_field'));
        $wp_customize->add_control("desire_rev_name_ctrl_$i", array('label' => "Name $i", 'section' => 'desire_reviews_section', 'settings' => "desire_rev_name_$i"));

        $wp_customize->add_setting("desire_rev_rating_$i", array('default' => '5'));
        $wp_customize->add_control("desire_rev_rating_ctrl_$i", array('label' => "Rating $i", 'section' => 'desire_reviews_section', 'settings' => "desire_rev_rating_$i", 'type' => 'select', 'choices' => array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5')));

        $wp_customize->add_setting("desire_rev_date_$i", array('sanitize_callback' => 'sanitize_text_field'));
        $wp_customize->add_control("desire_rev_date_ctrl_$i", array('label' => "Date $i", 'section' => 'desire_reviews_section', 'settings' => "desire_rev_date_$i"));

        $wp_customize->add_setting("desire_rev_type_$i", array('sanitize_callback' => 'sanitize_text_field'));
        $wp_customize->add_control("desire_rev_type_ctrl_$i", array('label' => "Type $i", 'section' => 'desire_reviews_section', 'settings' => "desire_rev_type_$i"));

        $wp_customize->add_setting("desire_rev_full_$i", array('sanitize_callback' => 'sanitize_textarea_field'));
        $wp_customize->add_control("desire_rev_full_ctrl_$i", array('label' => "Full Review $i", 'section' => 'desire_reviews_section', 'settings' => "desire_rev_full_$i", 'type' => 'textarea'));

        // NESTED: Gallery Images for this specific review slot ($i)
        for ( $g = 1; $g <= 5; $g++ ) {
            $wp_customize->add_setting("desire_rev_img_{$i}_{$g}");
            $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "desire_rev_img_ctrl_{$i}_{$g}", array(
                'label'    => "Review $i - Gallery Image $g",
                'section'  => 'desire_reviews_section',
                'settings' => "desire_rev_img_{$i}_{$g}",
            )));
        }
    }
}
add_action( 'customize_register', 'desire_register_reviews_section' );
function desire_adventure_dynamic_css() {
    $header_bg   = get_theme_mod( 'desire_header_bg_color', '#000000' );
    $header_font = get_theme_mod( 'desire_header_font', 'DM Sans' );
    $is_admin_bar = is_admin_bar_showing();
    $admin_offset = $is_admin_bar ? '32px' : '0px';
    ?>
    <style>
        /* Base header style — all pages */
        .site-header {
            background-color: <?php echo esc_attr( $header_bg ); ?>;
            font-family: '<?php echo esc_attr( $header_font ); ?>', sans-serif;
        }

        <?php if ( is_singular( 'trips' ) ) : ?>
        /* Single trip page — header scrolls away naturally */
        /* This overrides the homepage fixed position */
        .site-header,
        body.home .site-header {
            position: relative !important;
            top: auto !important;
            box-shadow: none !important;
        }

        /* Remove the body padding that was added for the fixed header */
        body,
        body.home {
            padding-top: 0 !important;
        }
        <?php endif; ?>
    </style>
    <?php
}
add_action( 'wp_head', 'desire_adventure_dynamic_css' );
// region section starts from
function desire_register_region_section( $wp_customize ) {

    // Create the section in the Customizer panel
    $wp_customize->add_section( 'desire_region_section', array(
        'title'    => __( 'Region Slider', 'desire-adventure' ),
        'priority' => 55, // Appears between Why Choose Us and Featured Packages
    ));

    // Eyebrow text (small text above the title)
    $wp_customize->add_setting( 'desire_region_eyebrow', array(
        'default'           => 'Explore Nepal',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'desire_region_eyebrow_ctrl', array(
        'label'    => __( 'Eyebrow Text (small text above title)', 'desire-adventure' ),
        'section'  => 'desire_region_section',
        'settings' => 'desire_region_eyebrow',
        'type'     => 'text',
    ));

    // Main title
    $wp_customize->add_setting( 'desire_region_title', array(
        'default'           => 'Find Your Region',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'desire_region_title_ctrl', array(
        'label'    => __( 'Main Title', 'desire-adventure' ),
        'section'  => 'desire_region_section',
        'settings' => 'desire_region_title',
        'type'     => 'text',
    ));
}
add_action( 'customize_register', 'desire_register_region_section' );
// about-teaser section
function desire_register_about_teaser( $wp_customize ) {

    // Create the section
    $wp_customize->add_section( 'desire_about_teaser', array(
        'title'    => __( 'About Us Teaser', 'desire-adventure' ),
        'priority' => 45, // Appears between Hero and Featured Trips
    ));

    // Kicker text
    $wp_customize->add_setting( 'desire_at_kicker', array(
        'default'           => 'Our Story',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'desire_at_kicker_ctrl', array(
        'label'   => __( 'Kicker (small text above title)', 'desire-adventure' ),
        'section' => 'desire_about_teaser',
        'settings' => 'desire_at_kicker',
    ));

    // Main title
    $wp_customize->add_setting( 'desire_at_title', array(
        'default'           => 'Born from a passion for the mountains',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'desire_at_title_ctrl', array(
        'label'   => __( 'Main Title', 'desire-adventure' ),
        'section' => 'desire_about_teaser',
        'settings' => 'desire_at_title',
        'type'    => 'textarea',
    ));

    // Description
    $wp_customize->add_setting( 'desire_at_desc', array(
        'default'           => 'We are a team of passionate Nepali guides and trekking experts who have spent years walking these trails.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control( 'desire_at_desc_ctrl', array(
        'label'   => __( 'Description', 'desire-adventure' ),
        'section' => 'desire_about_teaser',
        'settings' => 'desire_at_desc',
        'type'    => 'textarea',
    ));

    // Founder name
    $wp_customize->add_setting( 'desire_at_founder_name', array(
        'default'           => 'Suraj Tamang',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'desire_at_founder_name_ctrl', array(
        'label'   => __( 'Founder Name', 'desire-adventure' ),
        'section' => 'desire_about_teaser',
        'settings' => 'desire_at_founder_name',
    ));

    // Founder role
    $wp_customize->add_setting( 'desire_at_founder_role', array(
        'default'           => 'Founder & Lead Guide',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'desire_at_founder_role_ctrl', array(
        'label'   => __( 'Founder Role / Title', 'desire-adventure' ),
        'section' => 'desire_about_teaser',
        'settings' => 'desire_at_founder_role',
    ));

    // Founder photo
    $wp_customize->add_setting( 'desire_at_founder_photo' );
    $wp_customize->add_control( new WP_Customize_Image_Control(
        $wp_customize, 'desire_at_founder_photo_ctrl', array(
            'label'   => __( 'Founder Photo', 'desire-adventure' ),
            'section' => 'desire_about_teaser',
            'settings' => 'desire_at_founder_photo',
        )
    ));

    // Team photo
    $wp_customize->add_setting( 'desire_at_team_photo' );
    $wp_customize->add_control( new WP_Customize_Image_Control(
        $wp_customize, 'desire_at_team_photo_ctrl', array(
            'label'   => __( 'Team Photo (right side)', 'desire-adventure' ),
            'section' => 'desire_about_teaser',
            'settings' => 'desire_at_team_photo',
        )
    ));

    // Years of experience
    $wp_customize->add_setting( 'desire_at_years', array(
        'default'           => '15+',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'desire_at_years_ctrl', array(
        'label'   => __( 'Experience Badge — Number (e.g. 15+)', 'desire-adventure' ),
        'section' => 'desire_about_teaser',
        'settings' => 'desire_at_years',
    ));

    // Years label
    $wp_customize->add_setting( 'desire_at_years_label', array(
        'default'           => 'Years on the trails',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'desire_at_years_label_ctrl', array(
        'label'   => __( 'Experience Badge — Label', 'desire-adventure' ),
        'section' => 'desire_about_teaser',
        'settings' => 'desire_at_years_label',
    ));

    // Button text
    $wp_customize->add_setting( 'desire_at_btn_text', array(
        'default'           => 'Meet Our Team',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'desire_at_btn_text_ctrl', array(
        'label'   => __( 'Button Text', 'desire-adventure' ),
        'section' => 'desire_about_teaser',
        'settings' => 'desire_at_btn_text',
    ));

    // Button URL
    $wp_customize->add_setting( 'desire_at_btn_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control( 'desire_at_btn_url_ctrl', array(
        'label'   => __( 'Button URL', 'desire-adventure' ),
        'section' => 'desire_about_teaser',
        'settings' => 'desire_at_btn_url',
        'type'    => 'url',
    ));
}
add_action( 'customize_register', 'desire_register_about_teaser' );
// faq section for the website
function desire_register_faq_section( $wp_customize ) {

    // Create the section
    $wp_customize->add_section( 'desire_faq_section', array(
        'title'    => __( 'FAQ Section', 'desire-adventure' ),
        'priority' => 75, // After Reviews
    ));

    // Kicker
    $wp_customize->add_setting( 'desire_faq_kicker', array(
        'default'           => 'FAQ',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'desire_faq_kicker_ctrl', array(
        'label'    => __( 'Kicker (small label above title)', 'desire-adventure' ),
        'section'  => 'desire_faq_section',
        'settings' => 'desire_faq_kicker',
    ));

    // Title
    $wp_customize->add_setting( 'desire_faq_title', array(
        'default'           => 'Questions we get asked a lot',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'desire_faq_title_ctrl', array(
        'label'    => __( 'Main Title', 'desire-adventure' ),
        'section'  => 'desire_faq_section',
        'settings' => 'desire_faq_title',
        'type'     => 'textarea',
    ));

    // Description
    $wp_customize->add_setting( 'desire_faq_desc', array(
        'default'           => "Can't find what you're looking for? Reach out and we'll get back to you within 24 hours.",
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control( 'desire_faq_desc_ctrl', array(
        'label'    => __( 'Description', 'desire-adventure' ),
        'section'  => 'desire_faq_section',
        'settings' => 'desire_faq_desc',
        'type'     => 'textarea',
    ));

    // Button text
    $wp_customize->add_setting( 'desire_faq_btn_text', array(
        'default'           => 'Ask a Question',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'desire_faq_btn_ctrl', array(
        'label'    => __( 'Button Text', 'desire-adventure' ),
        'section'  => 'desire_faq_section',
        'settings' => 'desire_faq_btn_text',
    ));

    // Button URL
    $wp_customize->add_setting( 'desire_faq_btn_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control( 'desire_faq_btn_url_ctrl', array(
        'label'    => __( 'Button URL', 'desire-adventure' ),
        'section'  => 'desire_faq_section',
        'settings' => 'desire_faq_btn_url',
        'type'     => 'url',
    ));

    // 6 Question + Answer pairs
    for ( $i = 1; $i <= 6; $i++ ) {

        // Question
        $wp_customize->add_setting( "desire_faq_q_{$i}", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control( "desire_faq_q_ctrl_{$i}", array(
            'label'    => sprintf( __( 'Question %d', 'desire-adventure' ), $i ),
            'section'  => 'desire_faq_section',
            'settings' => "desire_faq_q_{$i}",
            'type'     => 'text',
        ));

        // Answer
        $wp_customize->add_setting( "desire_faq_a_{$i}", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_textarea_field',
        ));
        $wp_customize->add_control( "desire_faq_a_ctrl_{$i}", array(
            'label'    => sprintf( __( 'Answer %d', 'desire-adventure' ), $i ),
            'section'  => 'desire_faq_section',
            'settings' => "desire_faq_a_{$i}",
            'type'     => 'textarea',
        ));
    }
}
add_action( 'customize_register', 'desire_register_faq_section' );
// blog section
function desire_register_blog_preview( $wp_customize ) {

    $wp_customize->add_section( 'desire_blog_preview', array(
        'title'    => __( 'Blog Preview Section', 'desire-adventure' ),
        'priority' => 72,
    ));

    // Kicker
    $wp_customize->add_setting( 'desire_bp_kicker', array(
        'default'           => 'From the Trail',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'desire_bp_kicker_ctrl', array(
        'label'    => __( 'Kicker (small text above title)', 'desire-adventure' ),
        'section'  => 'desire_blog_preview',
        'settings' => 'desire_bp_kicker',
    ));

    // Title
    $wp_customize->add_setting( 'desire_bp_title', array(
        'default'           => 'Trekking Tips & Stories',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'desire_bp_title_ctrl', array(
        'label'    => __( 'Section Title', 'desire-adventure' ),
        'section'  => 'desire_blog_preview',
        'settings' => 'desire_bp_title',
    ));

    // Button text
    $wp_customize->add_setting( 'desire_bp_btn_text', array(
        'default'           => 'View All Articles',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'desire_bp_btn_text_ctrl', array(
        'label'    => __( 'Button Text', 'desire-adventure' ),
        'section'  => 'desire_blog_preview',
        'settings' => 'desire_bp_btn_text',
    ));

    // Button URL
    $wp_customize->add_setting( 'desire_bp_btn_url', array(
        'default'           => home_url( '/blog' ),
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control( 'desire_bp_btn_url_ctrl', array(
        'label'    => __( 'Button URL', 'desire-adventure' ),
        'section'  => 'desire_blog_preview',
        'settings' => 'desire_bp_btn_url',
        'type'     => 'url',
    ));
}
add_action( 'customize_register', 'desire_register_blog_preview' );
// affilation link section
function desire_register_affiliations( $wp_customize ) {

    $wp_customize->add_section( 'desire_affiliations', array(
        'title'    => __( 'Affiliations & Partners', 'desire-adventure' ),
        'priority' => 35, // Near the top — appears early in Customizer
    ));

    // Section label
    $wp_customize->add_setting( 'desire_aff_label', array(
        'default'           => 'Affiliated & Certified With',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'desire_aff_label_ctrl', array(
        'label'    => __( 'Section Label', 'desire-adventure' ),
        'section'  => 'desire_affiliations',
        'settings' => 'desire_aff_label',
    ));

    // 8 logo slots — each has an image upload + a text name fallback
    for ( $i = 1; $i <= 8; $i++ ) {

        // Logo image upload
        $wp_customize->add_setting( "desire_aff_logo_{$i}" );
        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                "desire_aff_logo_ctrl_{$i}",
                array(
                    'label'       => sprintf( __( 'Partner %d — Logo Image', 'desire-adventure' ), $i ),
                    'description' => __( 'Upload a PNG with transparent background for best results', 'desire-adventure' ),
                    'section'     => 'desire_affiliations',
                    'settings'    => "desire_aff_logo_{$i}",
                )
            )
        );

        // Text name fallback
        $wp_customize->add_setting( "desire_aff_name_{$i}", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control( "desire_aff_name_ctrl_{$i}", array(
            'label'       => sprintf( __( 'Partner %d — Name (shown if no logo uploaded)', 'desire-adventure' ), $i ),
            'section'     => 'desire_affiliations',
            'settings'    => "desire_aff_name_{$i}",
            'type'        => 'text',
        ));
    }
}
add_action( 'customize_register', 'desire_register_affiliations' );
// footer section
function desire_register_footer_settings( $wp_customize ) {

    $wp_customize->add_section( 'desire_footer_section', array(
        'title'    => __( 'Footer Settings', 'desire-adventure' ),
        'priority' => 80,
    ));

    // Tagline
    $wp_customize->add_setting( 'desire_ft_tagline', array(
        'default'           => "Nepal's Premier Trekking Agency",
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'desire_ft_tagline_ctrl', array(
        'label'   => __( 'Tagline (under logo)', 'desire-adventure' ),
        'section' => 'desire_footer_section',
        'settings' => 'desire_ft_tagline',
    ));

    // About text
    $wp_customize->add_setting( 'desire_ft_about', array(
        'default'           => 'We guide passionate trekkers through the world\'s most breathtaking Himalayan landscapes.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control( 'desire_ft_about_ctrl', array(
        'label'   => __( 'About Text', 'desire-adventure' ),
        'section' => 'desire_footer_section',
        'settings' => 'desire_ft_about',
        'type'    => 'textarea',
    ));

    // Contact details
    $wp_customize->add_setting( 'desire_ft_address', array(
        'default'           => 'Thamel, Kathmandu, Nepal',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'desire_ft_address_ctrl', array(
        'label'   => __( 'Address', 'desire-adventure' ),
        'section' => 'desire_footer_section',
        'settings' => 'desire_ft_address',
    ));

    $wp_customize->add_setting( 'desire_ft_phone', array(
        'default'           => '+977 9851233710',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'desire_ft_phone_ctrl', array(
        'label'   => __( 'Phone / WhatsApp', 'desire-adventure' ),
        'section' => 'desire_footer_section',
        'settings' => 'desire_ft_phone',
    ));

    $wp_customize->add_setting( 'desire_ft_email', array(
        'default'           => 'info@desireadventure.com',
        'sanitize_callback' => 'sanitize_email',
    ));
    $wp_customize->add_control( 'desire_ft_email_ctrl', array(
        'label'   => __( 'Email Address', 'desire-adventure' ),
        'section' => 'desire_footer_section',
        'settings' => 'desire_ft_email',
    ));

    // Social links
    foreach ( array(
        'facebook'  => 'Facebook URL',
        'instagram' => 'Instagram URL',
        'youtube'   => 'YouTube URL',
        'tiktok'    => 'TikTok URL',
    ) as $key => $label ) {
        $wp_customize->add_setting( "desire_ft_{$key}", array(
            'default'           => '#',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control( "desire_ft_{$key}_ctrl", array(
            'label'   => __( $label, 'desire-adventure' ),
            'section' => 'desire_footer_section',
            'settings' => "desire_ft_{$key}",
            'type'    => 'url',
        ));
    }

    // Legal links
    $wp_customize->add_setting( 'desire_ft_privacy_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control( 'desire_ft_privacy_ctrl', array(
        'label'   => __( 'Privacy Policy URL', 'desire-adventure' ),
        'section' => 'desire_footer_section',
        'settings' => 'desire_ft_privacy_url',
        'type'    => 'url',
    ));

    $wp_customize->add_setting( 'desire_ft_terms_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control( 'desire_ft_terms_ctrl', array(
        'label'   => __( 'Terms of Service URL', 'desire-adventure' ),
        'section' => 'desire_footer_section',
        'settings' => 'desire_ft_terms_url',
        'type'    => 'url',
    ));

    // Copyright text
    $wp_customize->add_setting( 'desire_ft_copyright', array(
        'default'           => '© ' . date('Y') . ' Desire Adventure. All rights reserved.',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'desire_ft_copyright_ctrl', array(
        'label'   => __( 'Copyright Text', 'desire-adventure' ),
        'section' => 'desire_footer_section',
        'settings' => 'desire_ft_copyright',
    ));
}
add_action( 'customize_register', 'desire_register_footer_settings' );
// section for the single-trip page
function desire_handle_trip_enquiry() {
    // Verify nonce
    if ( ! isset( $_POST['tp_enquiry_nonce'] ) ||
         ! wp_verify_nonce( $_POST['tp_enquiry_nonce'], 'tp_enquiry_submit' ) ) {
        wp_die( 'Security check failed.' );
    }

    $name      = sanitize_text_field( $_POST['tp_name'] ?? '' );
    $email     = sanitize_email( $_POST['tp_email'] ?? '' );
    $phone     = sanitize_text_field( $_POST['tp_phone'] ?? '' );
    $group     = sanitize_text_field( $_POST['tp_group'] ?? '' );
    $exp       = sanitize_text_field( $_POST['tp_experience'] ?? '' );
    $message   = sanitize_textarea_field( $_POST['tp_message'] ?? '' );
    $trip      = sanitize_text_field( $_POST['trip_name'] ?? '' );

    $to      = get_option( 'admin_email' );
    $subject = "New Trek Enquiry: {$trip}";
    $body    = "New enquiry from your website:\n\n";
    $body   .= "Trip: {$trip}\n";
    $body   .= "Name: {$name}\n";
    $body   .= "Email: {$email}\n";
    $body   .= "Phone: {$phone}\n";
    $body   .= "Group Size: {$group}\n";
    $body   .= "Experience: {$exp}\n";
    $body   .= "Message: {$message}\n";

    $headers = array( 'Content-Type: text/plain; charset=UTF-8' );
    if ( $email ) {
        $headers[] = "Reply-To: {$name} <{$email}>";
    }

    wp_mail( $to, $subject, $body, $headers );

    // Redirect back with success message
    $trip_name = sanitize_text_field( $_POST['trip_name'] ?? '' );
    wp_safe_redirect( add_query_arg(
        array( 'type' => 'enquiry', 'trip' => urlencode( $trip_name ) ),
        home_url( '/thank-you/' )
    ) );
    exit;
}
add_action( 'admin_post_tp_enquiry', 'desire_handle_trip_enquiry' );
add_action( 'admin_post_nopriv_tp_enquiry', 'desire_handle_trip_enquiry' );
// --- Callback: Departure Dates ---
function desire_trip_departures_callback( $post ) {
    ?>
    <p style="color:#666;font-size:12px;margin-bottom:15px">
        Add your scheduled group departure dates. Leave blank to hide. 
        Status updates automatically based on spots remaining.
    </p>
    <table style="width:100%;border-collapse:collapse">
        <thead>
            <tr style="background:#1A2E20;color:#fff">
                <th style="padding:8px 12px;text-align:left;font-size:12px;width:40px">#</th>
                <th style="padding:8px 12px;text-align:left;font-size:12px">Departure Date</th>
                <th style="padding:8px 12px;text-align:left;font-size:12px">Return Date</th>
                <th style="padding:8px 12px;text-align:left;font-size:12px">Spots Available</th>
                <th style="padding:8px 12px;text-align:left;font-size:12px">Price Override</th>
                <th style="padding:8px 12px;text-align:left;font-size:12px">Status</th>
            </tr>
        </thead>
        <tbody>
        <?php for ( $d = 1; $d <= 8; $d++ ) :
            $dep_start  = get_post_meta( $post->ID, "_trip_dep_{$d}_start", true );
            $dep_end    = get_post_meta( $post->ID, "_trip_dep_{$d}_end", true );
            $dep_spots  = get_post_meta( $post->ID, "_trip_dep_{$d}_spots", true );
            $dep_price  = get_post_meta( $post->ID, "_trip_dep_{$d}_price", true );
            $dep_status = get_post_meta( $post->ID, "_trip_dep_{$d}_status", true );
            $bg = $d % 2 === 0 ? '#f9f9f9' : '#fff';
            ?>
            <tr style="background:<?php echo $bg; ?>">
                <td style="padding:10px 12px;font-weight:700;color:#999;font-size:13px"><?php echo $d; ?></td>
                <td style="padding:8px 10px">
                    <input type="date" name="trip_dep_<?php echo $d; ?>_start"
                           value="<?php echo esc_attr( $dep_start ); ?>"
                           style="width:100%;padding:6px;border:1px solid #ddd;border-radius:4px;font-size:13px">
                </td>
                <td style="padding:8px 10px">
                    <input type="date" name="trip_dep_<?php echo $d; ?>_end"
                           value="<?php echo esc_attr( $dep_end ); ?>"
                           style="width:100%;padding:6px;border:1px solid #ddd;border-radius:4px;font-size:13px">
                </td>
                <td style="padding:8px 10px">
                    <input type="number" name="trip_dep_<?php echo $d; ?>_spots"
                           value="<?php echo esc_attr( $dep_spots ); ?>"
                           placeholder="e.g. 12" min="0"
                           style="width:80px;padding:6px;border:1px solid #ddd;border-radius:4px;font-size:13px">
                </td>
                <td style="padding:8px 10px">
                    <input type="text" name="trip_dep_<?php echo $d; ?>_price"
                           value="<?php echo esc_attr( $dep_price ); ?>"
                           placeholder="e.g. USD 850"
                           style="width:100%;padding:6px;border:1px solid #ddd;border-radius:4px;font-size:13px">
                </td>
                <td style="padding:8px 10px">
                    <select name="trip_dep_<?php echo $d; ?>_status"
                            style="width:100%;padding:6px;border:1px solid #ddd;border-radius:4px;font-size:13px">
                        <option value="available" <?php selected( $dep_status, 'available' ); ?>>Available</option>
                        <option value="limited"   <?php selected( $dep_status, 'limited' ); ?>>Limited</option>
                        <option value="full"      <?php selected( $dep_status, 'full' ); ?>>Full</option>
                        <option value="waitlist"  <?php selected( $dep_status, 'waitlist' ); ?>>Waitlist</option>
                    </select>
                </td>
            </tr>
        <?php endfor; ?>
        </tbody>
    </table>
    <?php
}
// Handle booking form submission
function desire_handle_trip_booking() {
    if ( ! isset( $_POST['tp_booking_nonce'] ) ||
         ! wp_verify_nonce( $_POST['tp_booking_nonce'], 'tp_booking_submit' ) ) {
        wp_die( 'Security check failed.' );
    }

    $name      = sanitize_text_field( $_POST['bk_name']       ?? '' );
    $email     = sanitize_email(      $_POST['bk_email']      ?? '' );
    $phone     = sanitize_text_field( $_POST['bk_phone']      ?? '' );
    $country   = sanitize_text_field( $_POST['bk_country']    ?? '' );
    $exp       = sanitize_text_field( $_POST['bk_experience'] ?? '' );
    $message   = sanitize_textarea_field( $_POST['bk_message'] ?? '' );
    $trip_name = sanitize_text_field( $_POST['trip_name']     ?? '' );
    $date      = sanitize_text_field( $_POST['date']          ?? '' );
    $end_date  = sanitize_text_field( $_POST['end_date']      ?? '' );
    $pax       = (int) ( $_POST['pax']  ?? 1 );
    $type      = sanitize_text_field( $_POST['type'] ?? 'custom' );

    $to      = get_option( 'admin_email' );
    $subject = 'New Booking Request: ' . $trip_name;
    $body    = "New booking request from your website:\n\n";
    $body   .= "Type: " . ( $type === 'departure' ? 'Group Departure' : 'Custom Date' ) . "\n";
    $body   .= "Trip: $trip_name\n";
    $body   .= "Departure Date: $date\n";
    if ( $end_date ) $body .= "Return Date: $end_date\n";
    $body   .= "People: $pax\n\n";
    $body   .= "Name: $name\n";
    $body   .= "Email: $email\n";
    $body   .= "Phone: $phone\n";
    $body   .= "Country: $country\n";
    $body   .= "Experience: $exp\n";
    $body   .= "Message: $message\n";

    $headers = array( 'Content-Type: text/plain; charset=UTF-8' );
    if ( $email ) $headers[] = "Reply-To: {$name} <{$email}>";

    wp_mail( $to, $subject, $body, $headers );

    // Redirect to thank you
        wp_safe_redirect( add_query_arg(
        array( 'type' => 'booking', 'trip' => urlencode( $trip_name ) ),
        home_url( '/thank-you/' )
    ) );
    exit;
}
add_action( 'admin_post_tp_booking',        'desire_handle_trip_booking' );
add_action( 'admin_post_nopriv_tp_booking', 'desire_handle_trip_booking' );
// register admin js
function desire_adventure_admin_scripts( $hook ) {
    global $post;
    // Only load on trip edit/new screens
    if ( ( $hook === 'post.php' || $hook === 'post-new.php' ) &&
         isset( $post ) && $post->post_type === 'trips' ) {
        wp_enqueue_media(); // WordPress media uploader
        wp_enqueue_script(
            'desire-admin-itinerary',
            get_template_directory_uri() . '/admin-itinerary.js',
            array( 'jquery' ),
            null,
            true
        );
    }
    wp_enqueue_style( 'dashicons' );
}
add_action( 'admin_enqueue_scripts', 'desire_adventure_admin_scripts' );
// highlight function
function desire_trip_highlights_callback( $post ) {
    $saved_count = 0;
    for ( $h = 1; $h <= 20; $h++ ) {
        if ( get_post_meta( $post->ID, "_trip_highlight_{$h}_text", true ) ) {
            $saved_count = $h;
        }
    }
    if ( $saved_count === 0 ) $saved_count = 3; // show 3 empty by default
    ?>
    <p style="color:#666;font-size:12px;margin-bottom:12px">
        Add your key trip highlights. Use <strong>[trip_highlights]</strong> anywhere in the content editor to display them.
        Each highlight can have an emoji icon and a short text.
    </p>

    <div id="tp-highlights-container">
        <?php for ( $h = 1; $h <= $saved_count; $h++ ) :
            $h_icon = get_post_meta( $post->ID, "_trip_highlight_{$h}_icon", true ) ?: '';
            $h_text = get_post_meta( $post->ID, "_trip_highlight_{$h}_text", true ) ?: '';
        ?>
        <div class="tp-highlight-row" style="display:flex;align-items:center;gap:8px;margin-bottom:8px">
            <input type="text"
                   name="trip_highlight_<?php echo $h; ?>_icon"
                   value="<?php echo esc_attr( $h_icon ); ?>"
                   placeholder="🏔"
                   style="width:54px;padding:7px;border:1px solid #ddd;border-radius:4px;font-size:18px;text-align:center">
            <input type="text"
                   name="trip_highlight_<?php echo $h; ?>_text"
                   value="<?php echo esc_attr( $h_text ); ?>"
                   placeholder="e.g. Stunning views of Mt. Everest"
                   style="flex:1;padding:7px 10px;border:1px solid #ddd;border-radius:4px;font-size:13px">
            <?php if ( $h > 1 ) : ?>
            <button type="button" class="tp-remove-highlight button"
                    style="color:#c0392b;border-color:#c0392b;flex-shrink:0">✕</button>
            <?php else : ?>
            <div style="width:60px"></div>
            <?php endif; ?>
        </div>
        <?php endfor; ?>
    </div>

    <button type="button" id="tp-add-highlight" class="button button-primary" style="margin-top:8px">
        + Add Highlight
    </button>

    <p style="font-size:11px;color:#999;margin-top:8px">
        Tip: Use emojis as icons — 🏔 ⛺ 🌄 🦅 🗺 🧗 🌿 🏕 ❄️ 🎯
    </p>

    <script>
    jQuery(document).ready(function($) {
        var maxHighlights = 20;

        function getCount() {
            return $('.tp-highlight-row').length;
        }

        function updateAddButton() {
            var count = getCount();
            if (count >= maxHighlights) {
                $('#tp-add-highlight').prop('disabled', true).text('Maximum ' + maxHighlights + ' highlights');
            } else {
                $('#tp-add-highlight').prop('disabled', false).text('+ Add Highlight');
            }
        }

        function updateNames() {
            $('.tp-highlight-row').each(function(i) {
                var idx = i + 1;
                $(this).find('input[name*="_icon"]').attr('name', 'trip_highlight_' + idx + '_icon');
                $(this).find('input[name*="_text"]').attr('name', 'trip_highlight_' + idx + '_text');
            });
        }

        $('#tp-add-highlight').on('click', function() {
            if (getCount() >= maxHighlights) return;
            var newIdx = getCount() + 1;
            var row = $(
                '<div class="tp-highlight-row" style="display:flex;align-items:center;gap:8px;margin-bottom:8px">' +
                '<input type="text" name="trip_highlight_' + newIdx + '_icon" placeholder="🏔" style="width:54px;padding:7px;border:1px solid #ddd;border-radius:4px;font-size:18px;text-align:center">' +
                '<input type="text" name="trip_highlight_' + newIdx + '_text" placeholder="e.g. Stunning views of Mt. Everest" style="flex:1;padding:7px 10px;border:1px solid #ddd;border-radius:4px;font-size:13px">' +
                '<button type="button" class="tp-remove-highlight button" style="color:#c0392b;border-color:#c0392b;flex-shrink:0">✕</button>' +
                '</div>'
            );
            $('#tp-highlights-container').append(row);
            updateAddButton();
        });

        $(document).on('click', '.tp-remove-highlight', function() {
            $(this).closest('.tp-highlight-row').remove();
            updateNames();
            updateAddButton();
        });

        updateAddButton();
    });
    </script>
    <?php
}
//for shortcode
// ── Trip Highlights Shortcode ─────────────────
function desire_trip_highlights_shortcode() {
    if ( ! is_singular( 'trips' ) ) return '';

    $highlights = array();
    for ( $h = 1; $h <= 20; $h++ ) {
        $text = get_post_meta( get_the_ID(), "_trip_highlight_{$h}_text", true );
        if ( $text ) {
            $highlights[] = array(
                'icon' => get_post_meta( get_the_ID(), "_trip_highlight_{$h}_icon", true ) ?: '✓',
                'text' => $text,
            );
        }
    }

    if ( empty( $highlights ) ) return '';

    $html  = '<div class="tp-highlights-block">';
    $html .= '<div class="tp-highlights-label">Trip Highlights</div>';
    $html .= '<ul class="tp-highlights-list">';

    foreach ( $highlights as $item ) {
        $html .= '<li class="tp-highlights-item">';
        $html .= '<span class="tp-highlights-icon">' . esc_html( $item['icon'] ) . '</span>';
        $html .= '<span class="tp-highlights-text">' . esc_html( $item['text'] ) . '</span>';
        $html .= '</li>';
    }

    $html .= '</ul>';
    $html .= '</div>';

    return $html;
}
add_shortcode( 'trip_highlights', 'desire_trip_highlights_shortcode' );
// accommodation callback for teahouse, lodge etc
function desire_trip_accommodation_callback( $post ) {
    $saved_count = 0;
    for ( $a = 1; $a <= 15; $a++ ) {
        if ( get_post_meta( $post->ID, "_trip_acc_{$a}_place", true ) ) {
            $saved_count = $a;
        }
    }
    if ( $saved_count === 0 ) $saved_count = 3;
    ?>
    <p style="color:#666;font-size:12px;margin-bottom:12px">
        Add accommodation details for each stop. Use <strong>[trip_accommodation]</strong>
        anywhere in the content editor to display this section.
    </p>

    <table style="width:100%;border-collapse:collapse;margin-bottom:12px">
        <thead>
            <tr style="background:#1A2E20;color:#fff">
                <th style="padding:8px 12px;text-align:left;font-size:12px;width:36px">#</th>
                <th style="padding:8px 12px;text-align:left;font-size:12px">Icon</th>
                <th style="padding:8px 12px;text-align:left;font-size:12px">Place / Location</th>
                <th style="padding:8px 12px;text-align:left;font-size:12px">Accommodation Type</th>
                <th style="padding:8px 12px;text-align:left;font-size:12px">Nights</th>
                <th style="padding:8px 12px;width:50px"></th>
            </tr>
        </thead>
        <tbody id="tp-acc-container">
            <?php for ( $a = 1; $a <= $saved_count; $a++ ) :
                $a_icon   = get_post_meta( $post->ID, "_trip_acc_{$a}_icon",  true ) ?: '';
                $a_place  = get_post_meta( $post->ID, "_trip_acc_{$a}_place", true ) ?: '';
                $a_type   = get_post_meta( $post->ID, "_trip_acc_{$a}_type",  true ) ?: '';
                $a_nights = get_post_meta( $post->ID, "_trip_acc_{$a}_nights",true ) ?: '';
                $bg = $a % 2 === 0 ? '#f9f9f9' : '#fff';
            ?>
            <tr class="tp-acc-row" style="background:<?php echo $bg; ?>">
                <td style="padding:8px 12px;color:#999;font-size:13px;font-weight:700"><?php echo $a; ?></td>
                <td style="padding:6px 8px">
                    <input type="text"
                           name="trip_acc_<?php echo $a; ?>_icon"
                           value="<?php echo esc_attr( $a_icon ); ?>"
                           placeholder="🏨"
                           style="width:46px;padding:6px;border:1px solid #ddd;border-radius:4px;font-size:16px;text-align:center">
                </td>
                <td style="padding:6px 8px">
                    <input type="text"
                           name="trip_acc_<?php echo $a; ?>_place"
                           value="<?php echo esc_attr( $a_place ); ?>"
                           placeholder="e.g. Kathmandu"
                           style="width:100%;padding:6px 8px;border:1px solid #ddd;border-radius:4px;font-size:13px">
                </td>
                <td style="padding:6px 8px">
                    <input type="text"
                           name="trip_acc_<?php echo $a; ?>_type"
                           value="<?php echo esc_attr( $a_type ); ?>"
                           placeholder="e.g. 3-star Hotel / Teahouse"
                           style="width:100%;padding:6px 8px;border:1px solid #ddd;border-radius:4px;font-size:13px">
                </td>
                <td style="padding:6px 8px">
                    <input type="text"
                           name="trip_acc_<?php echo $a; ?>_nights"
                           value="<?php echo esc_attr( $a_nights ); ?>"
                           placeholder="e.g. 2 nights"
                           style="width:90px;padding:6px 8px;border:1px solid #ddd;border-radius:4px;font-size:13px">
                </td>
                <td style="padding:6px 8px;text-align:center">
                    <?php if ( $a > 1 ) : ?>
                    <button type="button" class="tp-remove-acc button"
                            style="color:#c0392b;border-color:#c0392b;padding:4px 8px">✕</button>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endfor; ?>
        </tbody>
    </table>

    <button type="button" id="tp-add-acc" class="button button-primary">
        + Add Accommodation
    </button>

    <p style="font-size:11px;color:#999;margin-top:8px">
        Useful icons: 🏨 🏩 🏕 🛖 ⛺ 🏔 🏠 🌿
    </p>

    <script>
    jQuery(document).ready(function($) {
        var maxAcc = 15;

        function getCount() {
            return $('.tp-acc-row').length;
        }

        function updateNames() {
            $('.tp-acc-row').each(function(i) {
                var idx = i + 1;
                $(this).find('td:first').text(idx);
                $(this).find('input[name*="_icon"]').attr('name',   'trip_acc_' + idx + '_icon');
                $(this).find('input[name*="_place"]').attr('name',  'trip_acc_' + idx + '_place');
                $(this).find('input[name*="_type"]').attr('name',   'trip_acc_' + idx + '_type');
                $(this).find('input[name*="_nights"]').attr('name', 'trip_acc_' + idx + '_nights');
                $(this).css('background', idx % 2 === 0 ? '#f9f9f9' : '#fff');
            });
        }

        function updateButton() {
            var count = getCount();
            $('#tp-add-acc').prop('disabled', count >= maxAcc)
                .text(count >= maxAcc ? 'Maximum reached' : '+ Add Accommodation');
        }

        $('#tp-add-acc').on('click', function() {
            if (getCount() >= maxAcc) return;
            var idx = getCount() + 1;
            var row = $(
                '<tr class="tp-acc-row">' +
                '<td style="padding:8px 12px;color:#999;font-size:13px;font-weight:700">' + idx + '</td>' +
                '<td style="padding:6px 8px"><input type="text" name="trip_acc_' + idx + '_icon" placeholder="🏨" style="width:46px;padding:6px;border:1px solid #ddd;border-radius:4px;font-size:16px;text-align:center"></td>' +
                '<td style="padding:6px 8px"><input type="text" name="trip_acc_' + idx + '_place" placeholder="e.g. Namche Bazaar" style="width:100%;padding:6px 8px;border:1px solid #ddd;border-radius:4px;font-size:13px"></td>' +
                '<td style="padding:6px 8px"><input type="text" name="trip_acc_' + idx + '_type" placeholder="e.g. Teahouse" style="width:100%;padding:6px 8px;border:1px solid #ddd;border-radius:4px;font-size:13px"></td>' +
                '<td style="padding:6px 8px"><input type="text" name="trip_acc_' + idx + '_nights" placeholder="e.g. 1 night" style="width:90px;padding:6px 8px;border:1px solid #ddd;border-radius:4px;font-size:13px"></td>' +
                '<td style="padding:6px 8px;text-align:center"><button type="button" class="tp-remove-acc button" style="color:#c0392b;border-color:#c0392b;padding:4px 8px">✕</button></td>' +
                '</tr>'
            );
            $('#tp-acc-container').append(row);
            updateButton();
        });

        $(document).on('click', '.tp-remove-acc', function() {
            $(this).closest('.tp-acc-row').remove();
            updateNames();
            updateButton();
        });

        updateButton();
    });
    </script>
    <?php
}
// ── Trip Accommodation Shortcode ──────────────
function desire_trip_accommodation_shortcode() {
    if ( ! is_singular( 'trips' ) ) return '';

    $accommodations = array();
    for ( $a = 1; $a <= 15; $a++ ) {
        $place = get_post_meta( get_the_ID(), "_trip_acc_{$a}_place", true );
        if ( $place ) {
            $accommodations[] = array(
                'icon'   => get_post_meta( get_the_ID(), "_trip_acc_{$a}_icon",   true ) ?: '🏨',
                'place'  => $place,
                'type'   => get_post_meta( get_the_ID(), "_trip_acc_{$a}_type",   true ) ?: '',
                'nights' => get_post_meta( get_the_ID(), "_trip_acc_{$a}_nights", true ) ?: '',
            );
        }
    }

    if ( empty( $accommodations ) ) return '';

    $html  = '<div class="tp-acc-block">';
    $html .= '<div class="tp-acc-block-label">Accommodation</div>';
    $html .= '<div class="tp-acc-block-grid">';

    foreach ( $accommodations as $acc ) {
        $html .= '<div class="tp-acc-block-item">';
        $html .= '<span class="tp-acc-block-icon">' . esc_html( $acc['icon'] ) . '</span>';
        $html .= '<div class="tp-acc-block-info">';
        $html .= '<span class="tp-acc-block-place">' . esc_html( $acc['place'] ) . '</span>';
        if ( $acc['type'] ) {
            $html .= '<span class="tp-acc-block-type">' . esc_html( $acc['type'] ) . '</span>';
        }
        $html .= '</div>';
        if ( $acc['nights'] ) {
            $html .= '<span class="tp-acc-block-nights">' . esc_html( $acc['nights'] ) . '</span>';
        }
        $html .= '</div>';
    }

    $html .= '</div>';
    $html .= '</div>';

    return $html;
}
add_shortcode( 'trip_accommodation', 'desire_trip_accommodation_shortcode' );
//packing list callback
function desire_trip_packing_callback( $post ) {
    $saved_count = 0;
    for ( $p = 1; $p <= 50; $p++ ) {
        if ( get_post_meta( $post->ID, "_trip_pack_{$p}_item", true ) ) {
            $saved_count = $p;
        }
    }
    if ( $saved_count === 0 ) $saved_count = 5;
    ?>
    <p style="color:#666;font-size:12px;margin-bottom:12px">
        Add packing list items grouped by category. Each item can have an icon and optional note.
    </p>

    <div id="tp-pack-container">
        <?php for ( $p = 1; $p <= $saved_count; $p++ ) :
            $p_icon     = get_post_meta( $post->ID, "_trip_pack_{$p}_icon",     true ) ?: '';
            $p_item     = get_post_meta( $post->ID, "_trip_pack_{$p}_item",     true ) ?: '';
            $p_note     = get_post_meta( $post->ID, "_trip_pack_{$p}_note",     true ) ?: '';
            $p_category = get_post_meta( $post->ID, "_trip_pack_{$p}_category", true ) ?: '';
            $p_required = get_post_meta( $post->ID, "_trip_pack_{$p}_required", true ) ?: 'required';
            $bg = $p % 2 === 0 ? '#f9f9f9' : '#fff';
        ?>
        <div class="tp-pack-row" style="background:<?php echo $bg; ?>;border:1px solid #eee;border-radius:6px;padding:10px 14px;margin-bottom:6px">
            <div style="display:grid;grid-template-columns:46px 1fr 1fr 130px 90px 44px;gap:8px;align-items:center">

                <!-- Icon -->
                <input type="text"
                       name="trip_pack_<?php echo $p; ?>_icon"
                       value="<?php echo esc_attr( $p_icon ); ?>"
                       placeholder="🎒"
                       style="width:46px;padding:6px;border:1px solid #ddd;border-radius:4px;font-size:16px;text-align:center">

                <!-- Item name -->
                <input type="text"
                       name="trip_pack_<?php echo $p; ?>_item"
                       value="<?php echo esc_attr( $p_item ); ?>"
                       placeholder="e.g. Down jacket"
                       style="width:100%;padding:6px 8px;border:1px solid #ddd;border-radius:4px;font-size:13px">

                <!-- Note -->
                <input type="text"
                       name="trip_pack_<?php echo $p; ?>_note"
                       value="<?php echo esc_attr( $p_note ); ?>"
                       placeholder="Optional note (e.g. -20°C rated)"
                       style="width:100%;padding:6px 8px;border:1px solid #ddd;border-radius:4px;font-size:13px;color:#888">

                <!-- Category -->
                <input type="text"
                       name="trip_pack_<?php echo $p; ?>_category"
                       value="<?php echo esc_attr( $p_category ); ?>"
                       placeholder="Category"
                       style="width:100%;padding:6px 8px;border:1px solid #ddd;border-radius:4px;font-size:13px">

                <!-- Required / Optional -->
                <select name="trip_pack_<?php echo $p; ?>_required"
                        style="width:100%;padding:6px;border:1px solid #ddd;border-radius:4px;font-size:12px">
                    <option value="required"  <?php selected( $p_required, 'required' ); ?>>Required</option>
                    <option value="optional"  <?php selected( $p_required, 'optional' ); ?>>Optional</option>
                    <option value="rental"    <?php selected( $p_required, 'rental' ); ?>>Can Rent</option>
                </select>

                <!-- Remove -->
                <?php if ( $p > 1 ) : ?>
                <button type="button" class="tp-remove-pack button"
                        style="color:#c0392b;border-color:#c0392b;padding:4px 6px">✕</button>
                <?php else : ?>
                <div></div>
                <?php endif; ?>
            </div>
        </div>
        <?php endfor; ?>
    </div>

    <div style="display:flex;align-items:center;gap:12px;margin-top:10px">
        <button type="button" id="tp-add-pack" class="button button-primary">
            + Add Item
        </button>
        <span style="font-size:11px;color:#999">
            Icons: 🧥 👟 🎒 🏔 💊 📷 🔦 🧴 🧣 🥾 🕶 💧 🗺 🧤
        </span>
    </div>

    <div style="margin-top:12px;padding:10px 14px;background:#f0f7f0;border-radius:6px;font-size:12px;color:#555">
        <strong>Categories tip:</strong> Group items under categories like
        <em>Clothing, Footwear, Gear, Medical, Documents, Electronics</em> —
        items with the same category will be grouped together on the trip page.
    </div>

    <script>
    jQuery(document).ready(function($) {
        var maxPack = 50;

        function getCount() {
            return $('.tp-pack-row').length;
        }

        function updateNames() {
            $('.tp-pack-row').each(function(i) {
                var idx = i + 1;
                $(this).find('input[name*="_icon"]').attr('name',     'trip_pack_' + idx + '_icon');
                $(this).find('input[name*="_item"]').attr('name',     'trip_pack_' + idx + '_item');
                $(this).find('input[name*="_note"]').attr('name',     'trip_pack_' + idx + '_note');
                $(this).find('input[name*="_category"]').attr('name', 'trip_pack_' + idx + '_category');
                $(this).find('select[name*="_required"]').attr('name','trip_pack_' + idx + '_required');
                $(this).css('background', idx % 2 === 0 ? '#f9f9f9' : '#fff');
            });
        }

        function updateButton() {
            var count = getCount();
            $('#tp-add-pack').prop('disabled', count >= maxPack)
                .text(count >= maxPack ? 'Maximum 50 items' : '+ Add Item');
        }

        $('#tp-add-pack').on('click', function() {
            if (getCount() >= maxPack) return;
            var idx = getCount() + 1;
            var row = $(
                '<div class="tp-pack-row" style="background:#fff;border:1px solid #eee;border-radius:6px;padding:10px 14px;margin-bottom:6px">' +
                '<div style="display:grid;grid-template-columns:46px 1fr 1fr 130px 90px 44px;gap:8px;align-items:center">' +
                '<input type="text" name="trip_pack_' + idx + '_icon" placeholder="🎒" style="width:46px;padding:6px;border:1px solid #ddd;border-radius:4px;font-size:16px;text-align:center">' +
                '<input type="text" name="trip_pack_' + idx + '_item" placeholder="e.g. Down jacket" style="width:100%;padding:6px 8px;border:1px solid #ddd;border-radius:4px;font-size:13px">' +
                '<input type="text" name="trip_pack_' + idx + '_note" placeholder="Optional note" style="width:100%;padding:6px 8px;border:1px solid #ddd;border-radius:4px;font-size:13px;color:#888">' +
                '<input type="text" name="trip_pack_' + idx + '_category" placeholder="Category" style="width:100%;padding:6px 8px;border:1px solid #ddd;border-radius:4px;font-size:13px">' +
                '<select name="trip_pack_' + idx + '_required" style="width:100%;padding:6px;border:1px solid #ddd;border-radius:4px;font-size:12px">' +
                '<option value="required">Required</option>' +
                '<option value="optional">Optional</option>' +
                '<option value="rental">Can Rent</option>' +
                '</select>' +
                '<button type="button" class="tp-remove-pack button" style="color:#c0392b;border-color:#c0392b;padding:4px 6px">✕</button>' +
                '</div></div>'
            );
            $('#tp-pack-container').append(row);
            updateButton();
        });

        $(document).on('click', '.tp-remove-pack', function() {
            $(this).closest('.tp-pack-row').remove();
            updateNames();
            updateButton();
        });

        updateButton();
    });
    </script>
    <?php
}
function desire_trip_reviews_callback( $post ) {
    ?>
    <p style="color:#666;font-size:12px;margin-bottom:15px">
        Add up to 6 traveller reviews for this trip. These appear as large quotes on the trip page.
    </p>

    <?php for ( $r = 1; $r <= 6; $r++ ) :
        $r_name    = get_post_meta( $post->ID, "_trip_review_{$r}_name",    true );
        $r_country = get_post_meta( $post->ID, "_trip_review_{$r}_country", true );
        $r_rating  = get_post_meta( $post->ID, "_trip_review_{$r}_rating",  true ) ?: '5';
        $r_quote   = get_post_meta( $post->ID, "_trip_review_{$r}_quote",   true );
        $r_photo   = get_post_meta( $post->ID, "_trip_review_{$r}_photo",   true );
        $r_date    = get_post_meta( $post->ID, "_trip_review_{$r}_date",    true );
        $bg = $r % 2 === 0 ? '#f9f9f9' : '#fff';
    ?>
    <div style="border:1px solid #ddd;border-radius:8px;padding:16px;margin-bottom:12px;background:<?php echo $bg; ?>">
        <strong style="color:#1A2E20;font-size:13px">Review <?php echo $r; ?></strong>
        <div style="display:grid;grid-template-columns:1fr 1fr 120px;gap:10px;margin-top:10px">
            <div>
                <label style="font-size:11px;color:#666;display:block;margin-bottom:4px">Reviewer Name</label>
                <input type="text" name="trip_review_<?php echo $r; ?>_name"
                       value="<?php echo esc_attr( $r_name ); ?>"
                       placeholder="e.g. Sarah M."
                       style="width:100%;padding:6px 8px;border:1px solid #ddd;border-radius:4px;font-size:13px">
            </div>
            <div>
                <label style="font-size:11px;color:#666;display:block;margin-bottom:4px">Country (with flag emoji)</label>
                <input type="text" name="trip_review_<?php echo $r; ?>_country"
                       value="<?php echo esc_attr( $r_country ); ?>"
                       placeholder="e.g. 🇬🇧 United Kingdom"
                       style="width:100%;padding:6px 8px;border:1px solid #ddd;border-radius:4px;font-size:13px">
            </div>
            <div>
                <label style="font-size:11px;color:#666;display:block;margin-bottom:4px">Star Rating</label>
                <select name="trip_review_<?php echo $r; ?>_rating"
                        style="width:100%;padding:6px;border:1px solid #ddd;border-radius:4px;font-size:13px">
                    <?php for ( $s = 5; $s >= 1; $s-- ) : ?>
                    <option value="<?php echo $s; ?>" <?php selected( $r_rating, $s ); ?>>
                        <?php echo str_repeat( '★', $s ) . str_repeat( '☆', 5 - $s ); ?> <?php echo $s; ?>/5
                    </option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>
        <div style="margin-top:10px">
            <label style="font-size:11px;color:#666;display:block;margin-bottom:4px">Review Quote</label>
            <textarea name="trip_review_<?php echo $r; ?>_quote"
                      rows="3" placeholder="Write the review quote here..."
                      style="width:100%;padding:6px 8px;border:1px solid #ddd;border-radius:4px;font-size:13px"><?php echo esc_textarea( $r_quote ); ?></textarea>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:10px;align-items:end">
            <div>
                <label style="font-size:11px;color:#666;display:block;margin-bottom:4px">Date / Month Year</label>
                <input type="text" name="trip_review_<?php echo $r; ?>_date"
                       value="<?php echo esc_attr( $r_date ); ?>"
                       placeholder="e.g. October 2024"
                       style="width:100%;padding:6px 8px;border:1px solid #ddd;border-radius:4px;font-size:13px">
            </div>
            <div>
                <label style="font-size:11px;color:#666;display:block;margin-bottom:4px">Reviewer Photo (optional)</label>
                <div style="display:flex;align-items:center;gap:8px">
                    <input type="hidden" name="trip_review_<?php echo $r; ?>_photo"
                           id="tp-review-photo-<?php echo $r; ?>"
                           value="<?php echo esc_url( $r_photo ); ?>">
                    <button type="button" class="tp-upload-review-photo button"
                            data-target="tp-review-photo-<?php echo $r; ?>"
                            data-preview="tp-review-preview-<?php echo $r; ?>">
                        📷 Upload Photo
                    </button>
                    <span id="tp-review-preview-<?php echo $r; ?>">
                        <?php if ( $r_photo ) : ?>
                        <img src="<?php echo esc_url( $r_photo ); ?>"
                             style="height:36px;width:36px;border-radius:50%;object-fit:cover;border:2px solid #C17F3A">
                        <?php endif; ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <?php endfor; ?>

    <script>
    jQuery(document).ready(function($) {
        $(document).on('click', '.tp-upload-review-photo', function(e) {
            e.preventDefault();
            var btn        = $(this);
            var targetId   = btn.data('target');
            var previewId  = btn.data('preview');

            var frame = wp.media({
                title:    'Select Reviewer Photo',
                button:   { text: 'Use this photo' },
                multiple: false,
                library:  { type: 'image' }
            });

            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                $('#' + targetId).val(attachment.url);
                $('#' + previewId).html(
                    '<img src="' + attachment.url + '" style="height:36px;width:36px;border-radius:50%;object-fit:cover;border:2px solid #C17F3A">'
                );
            });

            frame.open();
        });
    });
    </script>
    <?php
}
function desire_trip_badges_callback( $post ) {
    $badge_1 = get_post_meta( $post->ID, '_trip_badge_1', true ) ?: '';
    $badge_2 = get_post_meta( $post->ID, '_trip_badge_2', true ) ?: '';

    $badge_options = array(
        ''                => '— No Badge —',
        'best-seller'     => '🏆 Best Seller',
        'most-popular'    => '🔥 Most Popular',
        'top-rated'       => '⭐ Top Rated',
        'new'             => '🆕 New',
        'limited-spots'   => '⚡ Limited Spots',
        'best-value'      => '💰 Best Value',
        'challenging'     => '🎯 Challenging',
        'eco-friendly'    => '🌿 Eco Friendly',
        'family-friendly' => '👨‍👩‍👧 Family Friendly',
        'winter-trek'     => '❄️ Winter Trek',
    );
    ?>
    <p style="color:#666;font-size:12px;margin-bottom:12px">
        Select up to 2 badges. They appear on the hero and all trip cards.
    </p>

    <p style="font-size:11px;font-weight:700;color:#1A2E20;margin-bottom:4px">Badge 1:</p>
    <select name="trip_badge_1" style="width:100%;padding:6px;border:1px solid #ddd;border-radius:4px;font-size:13px;margin-bottom:12px">
        <?php foreach ( $badge_options as $val => $label ) : ?>
        <option value="<?php echo esc_attr( $val ); ?>" <?php selected( $badge_1, $val ); ?>>
            <?php echo esc_html( $label ); ?>
        </option>
        <?php endforeach; ?>
    </select>

    <p style="font-size:11px;font-weight:700;color:#1A2E20;margin-bottom:4px">Badge 2:</p>
    <select name="trip_badge_2" style="width:100%;padding:6px;border:1px solid #ddd;border-radius:4px;font-size:13px;margin-bottom:12px">
        <?php foreach ( $badge_options as $val => $label ) : ?>
        <option value="<?php echo esc_attr( $val ); ?>" <?php selected( $badge_2, $val ); ?>>
            <?php echo esc_html( $label ); ?>
        </option>
        <?php endforeach; ?>
    </select>

    <p style="font-size:11px;color:#999">
        Tip: Use <strong>Best Seller</strong> + <strong>Top Rated</strong> together for your flagship trip.
    </p>
    <?php
}
// ── Trip Badge Helper ─────────────────────────
function desire_get_trip_badges( $post_id, $class = '' ) {
    $badge_1 = get_post_meta( $post_id, '_trip_badge_1', true ) ?: '';
    $badge_2 = get_post_meta( $post_id, '_trip_badge_2', true ) ?: '';

    $badge_map = array(
        'best-seller'     => array( 'label' => 'Best Seller',     'icon' => '🏆', 'style' => 'gold' ),
        'most-popular'    => array( 'label' => 'Most Popular',    'icon' => '🔥', 'style' => 'orange' ),
        'top-rated'       => array( 'label' => 'Top Rated',       'icon' => '⭐', 'style' => 'green' ),
        'new'             => array( 'label' => 'New',             'icon' => '🆕', 'style' => 'blue' ),
        'limited-spots'   => array( 'label' => 'Limited Spots',   'icon' => '⚡', 'style' => 'red' ),
        'best-value'      => array( 'label' => 'Best Value',      'icon' => '💰', 'style' => 'teal' ),
        'challenging'     => array( 'label' => 'Challenging',     'icon' => '🎯', 'style' => 'darkred' ),
        'eco-friendly'    => array( 'label' => 'Eco Friendly',    'icon' => '🌿', 'style' => 'forest' ),
        'family-friendly' => array( 'label' => 'Family Friendly', 'icon' => '👨‍👩‍👧', 'style' => 'purple' ),
        'winter-trek'     => array( 'label' => 'Winter Trek',     'icon' => '❄️', 'style' => 'ice' ),
    );

    $html = '';
    foreach ( array( $badge_1, $badge_2 ) as $badge ) {
        if ( $badge && isset( $badge_map[ $badge ] ) ) {
            $b     = $badge_map[ $badge ];
            $html .= '<span class="trip-badge trip-badge--' . esc_attr( $b['style'] ) . ' ' . esc_attr( $class ) . '">';
            $html .= '<span class="trip-badge-icon">' . $b['icon'] . '</span>';
            $html .= '<span class="trip-badge-label">' . esc_html( $b['label'] ) . '</span>';
            $html .= '</span>';
        }
    }

    if ( ! $html ) return '';

    return '<div class="trip-badges-wrap">' . $html . '</div>';
}
function desire_trip_price_breakdown_callback( $post ) {
    $deposit      = get_post_meta( $post->ID, '_trip_deposit',      true ) ?: '';
    $balance_due  = get_post_meta( $post->ID, '_trip_balance_due',  true ) ?: '30 days before departure';
    $price_note   = get_post_meta( $post->ID, '_trip_price_note',   true ) ?: '';

    // Group discount tiers — up to 4
    $tiers = array();
    for ( $t = 1; $t <= 4; $t++ ) {
        $tiers[] = array(
            'label'    => get_post_meta( $post->ID, "_trip_tier_{$t}_label",    true ) ?: '',
            'price'    => get_post_meta( $post->ID, "_trip_tier_{$t}_price",    true ) ?: '',
            'discount' => get_post_meta( $post->ID, "_trip_tier_{$t}_discount", true ) ?: '',
        );
    }
    ?>
    <p style="font-size:11px;color:#666;margin-bottom:14px">
        Configure how price changes based on group size. Leave tiers blank to hide them.
    </p>

    <!-- Deposit -->
    <p style="font-weight:700;font-size:12px;color:#1A2E20;margin-bottom:4px">Deposit to Confirm:</p>
    <input type="text" name="trip_deposit"
           value="<?php echo esc_attr( $deposit ); ?>"
           placeholder="e.g. USD 200 per person"
           style="width:100%;padding:6px 8px;border:1px solid #ddd;border-radius:4px;font-size:13px;margin-bottom:12px">

    <!-- Balance Due -->
    <p style="font-weight:700;font-size:12px;color:#1A2E20;margin-bottom:4px">Balance Due:</p>
    <input type="text" name="trip_balance_due"
           value="<?php echo esc_attr( $balance_due ); ?>"
           placeholder="e.g. 30 days before departure"
           style="width:100%;padding:6px 8px;border:1px solid #ddd;border-radius:4px;font-size:13px;margin-bottom:12px">

    <!-- Price Note -->
    <p style="font-weight:700;font-size:12px;color:#1A2E20;margin-bottom:4px">Price Note (optional):</p>
    <input type="text" name="trip_price_note"
           value="<?php echo esc_attr( $price_note ); ?>"
           placeholder="e.g. Price includes all permits and meals"
           style="width:100%;padding:6px 8px;border:1px solid #ddd;border-radius:4px;font-size:13px;margin-bottom:16px">

    <!-- Group Discount Tiers -->
    <p style="font-weight:700;font-size:12px;color:#1A2E20;margin-bottom:8px">
        Group Discount Tiers:
    </p>
    <table style="width:100%;border-collapse:collapse;margin-bottom:8px">
        <thead>
            <tr style="background:#1A2E20;color:#fff">
                <th style="padding:6px 8px;font-size:11px;text-align:left">Group Size</th>
                <th style="padding:6px 8px;font-size:11px;text-align:left">Price/Person</th>
                <th style="padding:6px 8px;font-size:11px;text-align:left">Discount</th>
            </tr>
        </thead>
        <tbody>
            <?php for ( $t = 1; $t <= 4; $t++ ) : ?>
            <tr style="background:<?php echo $t % 2 === 0 ? '#f9f9f9' : '#fff'; ?>">
                <td style="padding:5px 6px">
                    <input type="text"
                           name="trip_tier_<?php echo $t; ?>_label"
                           value="<?php echo esc_attr( $tiers[$t-1]['label'] ); ?>"
                           placeholder="e.g. 2–4 people"
                           style="width:100%;padding:4px 6px;border:1px solid #ddd;border-radius:3px;font-size:12px">
                </td>
                <td style="padding:5px 6px">
                    <input type="text"
                           name="trip_tier_<?php echo $t; ?>_price"
                           value="<?php echo esc_attr( $tiers[$t-1]['price'] ); ?>"
                           placeholder="e.g. USD 900"
                           style="width:100%;padding:4px 6px;border:1px solid #ddd;border-radius:3px;font-size:12px">
                </td>
                <td style="padding:5px 6px">
                    <input type="text"
                           name="trip_tier_<?php echo $t; ?>_discount"
                           value="<?php echo esc_attr( $tiers[$t-1]['discount'] ); ?>"
                           placeholder="e.g. 10% off"
                           style="width:100%;padding:4px 6px;border:1px solid #ddd;border-radius:3px;font-size:12px">
                </td>
            </tr>
            <?php endfor; ?>
        </tbody>
    </table>
    <p style="font-size:11px;color:#999">
        Leave rows blank to hide them. Example: 2–4 people → USD 900 → Base price
    </p>
    <?php
}
function desire_register_about_page( $wp_customize ) {

    $wp_customize->add_section( 'desire_about_page', array(
        'title'    => __( 'About Us Page', 'desire-adventure' ),
        'priority' => 42,
    ));

    // ── HERO ─────────────────────────────────────
    $wp_customize->add_setting( 'desire_about_hero_image' );
    $wp_customize->add_control( new WP_Customize_Image_Control(
        $wp_customize, 'desire_about_hero_image_ctrl', array(
            'label'   => 'Hero Image (right side)',
            'section' => 'desire_about_page',
            'settings' => 'desire_about_hero_image',
        )
    ));

    $wp_customize->add_setting( 'desire_about_hero_kicker', array(
        'default'           => 'Our Story',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'desire_about_hero_kicker_ctrl', array(
        'label'   => 'Hero Kicker (small text)',
        'section' => 'desire_about_page',
        'settings' => 'desire_about_hero_kicker',
    ));

    $wp_customize->add_setting( 'desire_about_hero_title', array(
        'default'           => 'Born from a passion for the mountains',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'desire_about_hero_title_ctrl', array(
        'label'   => 'Hero Title',
        'section' => 'desire_about_page',
        'settings' => 'desire_about_hero_title',
        'type'    => 'textarea',
    ));

    $wp_customize->add_setting( 'desire_about_hero_tagline', array(
        'default'           => 'We are a team of passionate Nepali guides who have spent years walking these trails.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control( 'desire_about_hero_tagline_ctrl', array(
        'label'   => 'Hero Tagline',
        'section' => 'desire_about_page',
        'settings' => 'desire_about_hero_tagline',
        'type'    => 'textarea',
    ));

    // ── TIMELINE MILESTONES (up to 6) ────────────
    for ( $m = 1; $m <= 6; $m++ ) {
        $wp_customize->add_setting( "desire_about_mile_{$m}_year", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control( "desire_about_mile_{$m}_year_ctrl", array(
            'label'   => "Milestone {$m} — Year",
            'section' => 'desire_about_page',
            'settings' => "desire_about_mile_{$m}_year",
        ));

        $wp_customize->add_setting( "desire_about_mile_{$m}_title", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control( "desire_about_mile_{$m}_title_ctrl", array(
            'label'   => "Milestone {$m} — Title",
            'section' => 'desire_about_page',
            'settings' => "desire_about_mile_{$m}_title",
        ));

        $wp_customize->add_setting( "desire_about_mile_{$m}_desc", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_textarea_field',
        ));
        $wp_customize->add_control( "desire_about_mile_{$m}_desc_ctrl", array(
            'label'   => "Milestone {$m} — Description",
            'section' => 'desire_about_page',
            'settings' => "desire_about_mile_{$m}_desc",
            'type'    => 'textarea',
        ));
    }

    // ── VALUES (3 blocks) ─────────────────────────
    $value_defaults = array(
        1 => array( 'icon' => '🛡', 'title' => 'Safety First',     'desc' => 'Every decision on the trail is guided by the safety of our trekkers.' ),
        2 => array( 'icon' => '🌿', 'title' => 'Sustainability',   'desc' => 'We trek responsibly — minimising our footprint on Nepal\'s fragile ecosystems.' ),
        3 => array( 'icon' => '🤝', 'title' => 'Authenticity',     'desc' => 'Real experiences with real locals — no tourist traps, just genuine Nepal.' ),
    );

    for ( $v = 1; $v <= 3; $v++ ) {
        $wp_customize->add_setting( "desire_about_val_{$v}_icon", array(
            'default'           => $value_defaults[$v]['icon'],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control( "desire_about_val_{$v}_icon_ctrl", array(
            'label'   => "Value {$v} — Icon (emoji)",
            'section' => 'desire_about_page',
            'settings' => "desire_about_val_{$v}_icon",
        ));

        $wp_customize->add_setting( "desire_about_val_{$v}_title", array(
            'default'           => $value_defaults[$v]['title'],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control( "desire_about_val_{$v}_title_ctrl", array(
            'label'   => "Value {$v} — Title",
            'section' => 'desire_about_page',
            'settings' => "desire_about_val_{$v}_title",
        ));

        $wp_customize->add_setting( "desire_about_val_{$v}_desc", array(
            'default'           => $value_defaults[$v]['desc'],
            'sanitize_callback' => 'sanitize_textarea_field',
        ));
        $wp_customize->add_control( "desire_about_val_{$v}_desc_ctrl", array(
            'label'   => "Value {$v} — Description",
            'section' => 'desire_about_page',
            'settings' => "desire_about_val_{$v}_desc",
            'type'    => 'textarea',
        ));
    }

    // ── STATS (4 numbers) ─────────────────────────
    $stat_defaults = array(
        1 => array( 'num' => '15+',  'label' => 'Years of Experience' ),
        2 => array( 'num' => '500+', 'label' => 'Treks Completed' ),
        3 => array( 'num' => '2000+','label' => 'Happy Trekkers' ),
        4 => array( 'num' => '30+',  'label' => 'Countries Represented' ),
    );

    for ( $s = 1; $s <= 4; $s++ ) {
        $wp_customize->add_setting( "desire_about_stat_{$s}_num", array(
            'default'           => $stat_defaults[$s]['num'],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control( "desire_about_stat_{$s}_num_ctrl", array(
            'label'   => "Stat {$s} — Number",
            'section' => 'desire_about_page',
            'settings' => "desire_about_stat_{$s}_num",
        ));

        $wp_customize->add_setting( "desire_about_stat_{$s}_label", array(
            'default'           => $stat_defaults[$s]['label'],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control( "desire_about_stat_{$s}_label_ctrl", array(
            'label'   => "Stat {$s} — Label",
            'section' => 'desire_about_page',
            'settings' => "desire_about_stat_{$s}_label",
        ));
    }

    // ── CTA ──────────────────────────────────────
    $wp_customize->add_setting( 'desire_about_cta_title', array(
        'default'           => 'Ready to start your adventure?',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'desire_about_cta_title_ctrl', array(
        'label'   => 'CTA Title',
        'section' => 'desire_about_page',
        'settings' => 'desire_about_cta_title',
    ));

    $wp_customize->add_setting( 'desire_about_cta_desc', array(
        'default'           => 'Browse our handpicked treks and find your perfect Himalayan adventure.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control( 'desire_about_cta_desc_ctrl', array(
        'label'   => 'CTA Description',
        'section' => 'desire_about_page',
        'settings' => 'desire_about_cta_desc',
        'type'    => 'textarea',
    ));

    $wp_customize->add_setting( 'desire_about_cta_btn1_text', array(
        'default'           => 'View All Treks',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'desire_about_cta_btn1_text_ctrl', array(
        'label'   => 'CTA Button 1 Text',
        'section' => 'desire_about_page',
        'settings' => 'desire_about_cta_btn1_text',
    ));

    $wp_customize->add_setting( 'desire_about_cta_btn1_url', array(
        'default'           => '/trips',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control( 'desire_about_cta_btn1_url_ctrl', array(
        'label'   => 'CTA Button 1 URL',
        'section' => 'desire_about_page',
        'settings' => 'desire_about_cta_btn1_url',
        'type'    => 'url',
    ));

    $wp_customize->add_setting( 'desire_about_cta_btn2_text', array(
        'default'           => 'Contact Us',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'desire_about_cta_btn2_text_ctrl', array(
        'label'   => 'CTA Button 2 Text',
        'section' => 'desire_about_page',
        'settings' => 'desire_about_cta_btn2_text',
    ));

    $wp_customize->add_setting( 'desire_about_cta_btn2_url', array(
        'default'           => '/contact',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control( 'desire_about_cta_btn2_url_ctrl', array(
        'label'   => 'CTA Button 2 URL',
        'section' => 'desire_about_page',
        'settings' => 'desire_about_cta_btn2_url',
        'type'    => 'url',
    ));
}
add_action( 'customize_register', 'desire_register_about_page' );
//team members section
function desire_register_team_post_type() {
    register_post_type( 'team_member', array(
        'labels' => array(
            'name'          => 'Team Members',
            'singular_name' => 'Team Member',
            'add_new_item'  => 'Add New Team Member',
            'edit_item'     => 'Edit Team Member',
        ),
        'public'       => false,
        'show_ui'      => true,
        'show_in_menu' => true,
        'menu_icon'    => 'dashicons-groups',
        'supports'     => array( 'title', 'thumbnail' ),
        'rewrite'      => false,
    ));
}
add_action( 'init', 'desire_register_team_post_type' );
function desire_add_team_meta_boxes() {
    add_meta_box(
        'team_member_details',
        'Team Member Details',
        'desire_team_member_callback',
        'team_member',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'desire_add_team_meta_boxes' );

function desire_team_member_callback( $post ) {
    wp_nonce_field( 'save_team_member', 'team_member_nonce' );

    $role       = get_post_meta( $post->ID, '_team_role',       true );
    $bio        = get_post_meta( $post->ID, '_team_bio',        true );
    $experience = get_post_meta( $post->ID, '_team_experience', true );
    $languages  = get_post_meta( $post->ID, '_team_languages',  true );
    $treks      = get_post_meta( $post->ID, '_team_treks',      true );
    $facebook   = get_post_meta( $post->ID, '_team_facebook',   true );
    $instagram  = get_post_meta( $post->ID, '_team_instagram',  true );
    $photo      = get_post_meta( $post->ID, '_team_photo',      true );
    $order      = get_post_meta( $post->ID, '_team_order',      true ) ?: '0';
    ?>
    <p style="color:#666;font-size:12px;margin-bottom:16px">
        Fill in the details for this team member. 
        Use the <strong>Featured Image</strong> to set their photo,
        or upload one below.
    </p>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px">

        <div>
            <label style="font-size:11px;font-weight:700;color:#1A2E20;display:block;margin-bottom:4px">
                Role / Position
            </label>
            <input type="text" name="team_role"
                   value="<?php echo esc_attr( $role ); ?>"
                   placeholder="e.g. Lead Trek Guide"
                   style="width:100%;padding:7px 10px;border:1px solid #ddd;border-radius:4px;font-size:13px">
        </div>

        <div>
            <label style="font-size:11px;font-weight:700;color:#1A2E20;display:block;margin-bottom:4px">
                Years of Experience
            </label>
            <input type="text" name="team_experience"
                   value="<?php echo esc_attr( $experience ); ?>"
                   placeholder="e.g. 12 years"
                   style="width:100%;padding:7px 10px;border:1px solid #ddd;border-radius:4px;font-size:13px">
        </div>

        <div>
            <label style="font-size:11px;font-weight:700;color:#1A2E20;display:block;margin-bottom:4px">
                Languages Spoken
            </label>
            <input type="text" name="team_languages"
                   value="<?php echo esc_attr( $languages ); ?>"
                   placeholder="e.g. Nepali, English, Hindi"
                   style="width:100%;padding:7px 10px;border:1px solid #ddd;border-radius:4px;font-size:13px">
        </div>

        <div>
            <label style="font-size:11px;font-weight:700;color:#1A2E20;display:block;margin-bottom:4px">
                Notable Treks / Speciality
            </label>
            <input type="text" name="team_treks"
                   value="<?php echo esc_attr( $treks ); ?>"
                   placeholder="e.g. Everest Base Camp, Annapurna Circuit"
                   style="width:100%;padding:7px 10px;border:1px solid #ddd;border-radius:4px;font-size:13px">
        </div>

    </div>

    <div style="margin-bottom:16px">
        <label style="font-size:11px;font-weight:700;color:#1A2E20;display:block;margin-bottom:4px">
            Short Bio
        </label>
        <textarea name="team_bio" rows="4"
                  placeholder="Write a short bio for this team member..."
                  style="width:100%;padding:7px 10px;border:1px solid #ddd;border-radius:4px;font-size:13px;resize:vertical"><?php echo esc_textarea( $bio ); ?></textarea>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px">
        <div>
            <label style="font-size:11px;font-weight:700;color:#1A2E20;display:block;margin-bottom:4px">
                Facebook URL (optional)
            </label>
            <input type="url" name="team_facebook"
                   value="<?php echo esc_url( $facebook ); ?>"
                   placeholder="https://facebook.com/..."
                   style="width:100%;padding:7px 10px;border:1px solid #ddd;border-radius:4px;font-size:13px">
        </div>
        <div>
            <label style="font-size:11px;font-weight:700;color:#1A2E20;display:block;margin-bottom:4px">
                Instagram URL (optional)
            </label>
            <input type="url" name="team_instagram"
                   value="<?php echo esc_url( $instagram ); ?>"
                   placeholder="https://instagram.com/..."
                   style="width:100%;padding:7px 10px;border:1px solid #ddd;border-radius:4px;font-size:13px">
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px">
        <div>
            <label style="font-size:11px;font-weight:700;color:#1A2E20;display:block;margin-bottom:4px">
                Display Order (lower = first)
            </label>
            <input type="number" name="team_order"
                   value="<?php echo esc_attr( $order ); ?>"
                   min="0" max="99"
                   style="width:100%;padding:7px 10px;border:1px solid #ddd;border-radius:4px;font-size:13px">
            <p style="font-size:11px;color:#999;margin-top:4px">
                e.g. Founder = 0, Lead Guide = 1, etc.
            </p>
        </div>
        <div>
            <label style="font-size:11px;font-weight:700;color:#1A2E20;display:block;margin-bottom:4px">
                Photo (alternative to Featured Image)
            </label>
            <div style="display:flex;align-items:center;gap:8px">
                <input type="hidden" name="team_photo"
                       id="team-photo-url"
                       value="<?php echo esc_url( $photo ); ?>">
                <button type="button" id="team-upload-photo" class="button">
                    📷 Upload Photo
                </button>
                <span id="team-photo-preview">
                    <?php if ( $photo ) : ?>
                    <img src="<?php echo esc_url( $photo ); ?>"
                         style="height:44px;width:44px;border-radius:50%;object-fit:cover;border:2px solid #C17F3A">
                    <?php endif; ?>
                </span>
            </div>
        </div>
    </div>

    <div style="background:#f0f7f0;border-radius:6px;padding:12px 14px;font-size:12px;color:#555">
        <strong>Tip:</strong> Set the <strong>Display Order</strong> to control who appears first.
        Founder should be 0, other members 1, 2, 3 etc.
        You can add up to 20 team members total.
    </div>

    <script>
    jQuery(document).ready(function($) {
        var frame;
        $('#team-upload-photo').on('click', function(e) {
            e.preventDefault();
            if (frame) { frame.open(); return; }
            frame = wp.media({
                title:    'Select Team Member Photo',
                button:   { text: 'Use this photo' },
                multiple: false,
                library:  { type: 'image' }
            });
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                $('#team-photo-url').val(attachment.url);
                $('#team-photo-preview').html(
                    '<img src="' + attachment.url + '" style="height:44px;width:44px;border-radius:50%;object-fit:cover;border:2px solid #C17F3A">'
                );
            });
            frame.open();
        });
    });
    </script>
    <?php
}
function desire_save_team_member( $post_id ) {
    if ( ! isset( $_POST['team_member_nonce'] ) ||
         ! wp_verify_nonce( $_POST['team_member_nonce'], 'save_team_member' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

    $text_fields = array(
        'team_role', 'team_experience', 'team_languages',
        'team_treks', 'team_order',
    );
    foreach ( $text_fields as $field ) {
        if ( isset( $_POST[ $field ] ) ) {
            update_post_meta( $post_id, "_{$field}",
                sanitize_text_field( $_POST[ $field ] ) );
        }
    }

    if ( isset( $_POST['team_bio'] ) ) {
        update_post_meta( $post_id, '_team_bio',
            sanitize_textarea_field( $_POST['team_bio'] ) );
    }

    $url_fields = array( 'team_facebook', 'team_instagram', 'team_photo' );
    foreach ( $url_fields as $field ) {
        if ( isset( $_POST[ $field ] ) ) {
            update_post_meta( $post_id, "_{$field}",
                esc_url_raw( $_POST[ $field ] ) );
        }
    }
}
add_action( 'save_post_team_member', 'desire_save_team_member' );
// Contact Page Setting Function
function desire_register_contact_page( $wp_customize ) {

    $wp_customize->add_section( 'desire_contact_page', array(
        'title'    => __( 'Contact Page', 'desire-adventure' ),
        'priority' => 43,
    ));

    // Office Address
    $wp_customize->add_setting( 'desire_contact_address', array(
        'default'           => 'Thamel, Kathmandu, Nepal',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control( 'desire_contact_address_ctrl', array(
        'label'   => 'Office Address',
        'section' => 'desire_contact_page',
        'settings' => 'desire_contact_address',
        'type'    => 'textarea',
    ));

    // Phone
    $wp_customize->add_setting( 'desire_contact_phone', array(
        'default'           => '+977 9851233710',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'desire_contact_phone_ctrl', array(
        'label'   => 'Phone Number',
        'section' => 'desire_contact_page',
        'settings' => 'desire_contact_phone',
    ));

    // WhatsApp
    $wp_customize->add_setting( 'desire_contact_whatsapp', array(
        'default'           => '+977 9851233710',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'desire_contact_whatsapp_ctrl', array(
        'label'   => 'WhatsApp Number',
        'section' => 'desire_contact_page',
        'settings' => 'desire_contact_whatsapp',
    ));

    // Email
    $wp_customize->add_setting( 'desire_contact_email', array(
        'default'           => 'info@desireadventure.com',
        'sanitize_callback' => 'sanitize_email',
    ));
    $wp_customize->add_control( 'desire_contact_email_ctrl', array(
        'label'   => 'Email Address',
        'section' => 'desire_contact_page',
        'settings' => 'desire_contact_email',
    ));

    // Office Hours
    $wp_customize->add_setting( 'desire_contact_hours', array(
        'default'           => 'Sunday – Friday: 9:00 AM – 6:00 PM NST',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control( 'desire_contact_hours_ctrl', array(
        'label'   => 'Office Hours',
        'section' => 'desire_contact_page',
        'settings' => 'desire_contact_hours',
        'type'    => 'textarea',
    ));

    // Response Time
    $wp_customize->add_setting( 'desire_contact_response', array(
        'default'           => 'We typically respond within 24 hours',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'desire_contact_response_ctrl', array(
        'label'   => 'Response Time Note',
        'section' => 'desire_contact_page',
        'settings' => 'desire_contact_response',
    ));

    // Google Maps Embed URL
    $wp_customize->add_setting( 'desire_contact_map_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control( 'desire_contact_map_url_ctrl', array(
        'label'       => 'Google Maps Embed URL',
        'description' => 'Go to Google Maps → Share → Embed a map → copy the src URL only',
        'section'     => 'desire_contact_page',
        'settings'    => 'desire_contact_map_url',
        'type'        => 'url',
    ));

    // FAQ 1
    for ( $f = 1; $f <= 3; $f++ ) {
        $faq_defaults = array(
            1 => array( 'q' => 'How quickly do you respond?',
                        'a' => 'We respond to all enquiries within 24 hours. For urgent queries reach us directly on WhatsApp for an instant reply.' ),
            2 => array( 'q' => 'Can I customise a trek itinerary?',
                        'a' => 'Absolutely — all our treks can be customised to match your dates, fitness level and interests. Just mention it in your message.' ),
            3 => array( 'q' => 'Do you offer group discounts?',
                        'a' => 'Yes — groups of 4 or more receive discounted rates. The more people, the better the price per person.' ),
        );

        $wp_customize->add_setting( "desire_contact_faq_{$f}_q", array(
            'default'           => $faq_defaults[$f]['q'],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control( "desire_contact_faq_{$f}_q_ctrl", array(
            'label'   => "FAQ {$f} — Question",
            'section' => 'desire_contact_page',
            'settings' => "desire_contact_faq_{$f}_q",
        ));

        $wp_customize->add_setting( "desire_contact_faq_{$f}_a", array(
            'default'           => $faq_defaults[$f]['a'],
            'sanitize_callback' => 'sanitize_textarea_field',
        ));
        $wp_customize->add_control( "desire_contact_faq_{$f}_a_ctrl", array(
            'label'   => "FAQ {$f} — Answer",
            'section' => 'desire_contact_page',
            'settings' => "desire_contact_faq_{$f}_a",
            'type'    => 'textarea',
        ));
    }
}
add_action( 'customize_register', 'desire_register_contact_page' );
function desire_handle_contact_form() {
    if ( ! isset( $_POST['contact_nonce'] ) ||
         ! wp_verify_nonce( $_POST['contact_nonce'], 'contact_form_submit' ) ) {
        wp_die( 'Security check failed.' );
    }

    $name       = sanitize_text_field( $_POST['ct_name']     ?? '' );
    $email      = sanitize_email(      $_POST['ct_email']    ?? '' );
    $phone      = sanitize_text_field( $_POST['ct_phone']    ?? '' );
    $trip       = sanitize_text_field( $_POST['ct_trip']     ?? '' );
    $date       = sanitize_text_field( $_POST['ct_date']     ?? '' );
    $group      = sanitize_text_field( $_POST['ct_group']    ?? '' );
    $message    = sanitize_textarea_field( $_POST['ct_message'] ?? '' );

    $to      = get_theme_mod( 'desire_contact_email', get_option('admin_email') );
    $subject = 'New Contact Enquiry' . ( $trip ? ': ' . $trip : '' );

    $body  = "New enquiry from your contact page:\n\n";
    $body .= "Name:           {$name}\n";
    $body .= "Email:          {$email}\n";
    $body .= "Phone:          {$phone}\n";
    if ( $trip )    $body .= "Trip Interest:  {$trip}\n";
    if ( $date )    $body .= "Travel Date:    {$date}\n";
    if ( $group )   $body .= "Group Size:     {$group}\n";
    $body .= "\nMessage:\n{$message}\n";

    $headers = array( 'Content-Type: text/plain; charset=UTF-8' );
    if ( $email ) {
        $headers[] = "Reply-To: {$name} <{$email}>";
    }

    wp_mail( $to, $subject, $body, $headers );

    wp_safe_redirect( add_query_arg(
        array( 'type' => 'enquiry', 'trip' => urlencode( $trip ?: 'General Enquiry' ) ),
        home_url( '/thank-you/' )
    ));
    exit;
}
add_action( 'admin_post_contact_form',        'desire_handle_contact_form' );
add_action( 'admin_post_nopriv_contact_form', 'desire_handle_contact_form' );
//for the dropdown menu
// ── Custom Nav Walker for dropdown support ────
class Desire_Nav_Walker extends Walker_Nav_Menu {

    public function start_lvl( &$output, $depth = 0, $args = null ) {
        $output .= '<ul class="nav-dropdown">';
    }

    public function end_lvl( &$output, $depth = 0, $args = null ) {
        $output .= '</ul>';
    }

    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $has_children = in_array( 'menu-item-has-children', $item->classes );
        $classes      = $has_children ? 'nav-item nav-item--has-children' : 'nav-item';

        $output .= '<li class="' . esc_attr( $classes ) . '">';

        $atts           = array();
        $atts['href']   = ! empty( $item->url ) ? $item->url : '#';
        $atts['class']  = $depth === 0 ? 'nav-link' : 'nav-dropdown-link';
        if ( $item->target ) $atts['target'] = $item->target;

        $atts_str = '';
        foreach ( $atts as $attr => $val ) {
            $atts_str .= ' ' . $attr . '="' . esc_attr( $val ) . '"';
        }

        $title = apply_filters( 'the_title', $item->title, $item->ID );

        $output .= '<a' . $atts_str . '>';
        $output .= esc_html( $title );
        if ( $has_children && $depth === 0 ) {
            $output .= '<svg class="nav-chevron" width="12" height="12" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>';
        }
        $output .= '</a>';
    }

    public function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= '</li>';
    }
}