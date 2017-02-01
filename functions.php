<?php
/*
  FOTOSNAP functions
*/

/*-------------------------------------------*\
   Global Settings: email
\*-------------------------------------------*/

add_filter( 'wp_mail_from', 'fs_wp_mail_from' );
function fs_wp_mail_from( $original_email_address ) {
    //Make sure the email is from the same domain 
    //as your website to avoid being marked as spam.
    return 'support@fotosnap.co';
}

add_filter( 'wp_mail_from_name', 'fs_wp_mail_from_name' );
function fs_wp_mail_from_name( $original_email_from ) {
    return 'FotoSnap';
}

function fs_cap_title( $title, $id = null ) {
    return ucwords( strtolower($title) );
}
add_filter( 'the_title', 'fs_cap_title', 10, 2 );

/*-------------------------------------------*\
   Venues + Photographies: custom tax.
\*-------------------------------------------*/

function fs_status_init() {
    register_taxonomy(
        'status',
        array('photographer','venue'), // will assign to custom post types when we register them
        array(
            'show_admin_column' => true,
            'label' => __( 'Booking Status' ),
            'query_var' => 'status',
            'labels' => array(
                'name' => 'Status',
                'singular_name' => 'Status',
                'menu_name' => 'Status',
                'all_items' => 'All Statuses',
                'edit_item' => 'Edit Status',
                'view_item' => 'View Status',
                'update_item' => 'Update Status',
                'add_new_item' => 'Add New Status',
                'new_item_name' => 'New Status Name',
                'search_items' => 'Search Local Statuss',
                'popular_items' => 'Popular Local Statuss',
                'add_or_remove_items' => 'Add or Remove Statuss',
                'choose_from_most_used' => 'Choose from the Most Used Statuss',
                'not_found' => 'No Status tags found.'
                ),
            "rewrite" => false,
            "hierarchical" => true,
        )
    );
}
add_action( 'init', 'fs_status_init' );

/*-------------------------------------------*\
   Referral Codes + Tracking
\*-------------------------------------------*/

// Custom Post Type
add_action("init", "fs_register_referral_post_type"); // Add our custom post type
add_action('init', 'fs_register_referral_menu'); // Add to admin menu

function fs_register_referral_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'referral'), // Main Navigation
        'sidebar-menu' => __('Sidebar Menu', 'referral'), // Sidebar Navigation
        'extra-menu' => __('Extra Menu', 'referral') // Extra Navigation if needed (duplicate as many as you need!)
    ));
}
function fs_register_referral_post_type() {
    register_post_type( "referral",
        array(
            "labels" => array(
                "name" => __( "Referral Codes" ),
                "singular_name" => __( "Referral Code" ),
                "add_new" => __( "Add New" ),
                "add_new_item" => __( "Add New Referral Code" ),
                "edit" => __( "Edit" ),
                "edit_item" => __( "Edit Referral Code" ),
                "new_item" => __( "New Referral Code" ),
                "view" => __( "View Referral Codes" ),
                "view_item" => __( "View Referral Code" ),
                "search_items" => __( "Search Referral Codes" ),
                "not_found" => __( "No Referral Codes Found" ),
                "not_found_in_trash" => __( "No Referral Codes Found in trash" ),
                "parent" => __( "Referral Code" ),
            ),
            "rewrite" => array(
                "slug" => "friends",
                "with_front" => false,
                "pages" => false,
                ),
            'description' => 'Referral codes in Zozi for tracking.',
            'public' => true,
            'exclude_from_search' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'menu_position' => 8,
            'menu_icon' => 'dashicons-star-empty',
            'capability_type' => 'page',
            "has_archive" => false,
            "supports" => array( "title", "editor", "revisions"),
            'can_export' => true,
            )
        );
}

add_action( 'add_meta_boxes_referral', 'fs_metaBoxReferralAdd', 15 );
function fs_metaBoxReferralAdd( $post ){
    // add_meta_box( $id, $title, $callback, $screen, $context, $priority, $callback_args );
    // screen: 'post','page','dashboard','link','attachment','custom_post_type'
    // context: 'normal', 'advanced', or 'side'
    // priority: 'high', 'core', 'default' or 'low'
   add_meta_box( 'fs_referrals', 'Zozi + Tracking Information', 'fs_metaBoxReferralRender', 'referral', 'normal', 'high' );
   remove_meta_box( 'slugdiv', 'referral', 'normal' ); 
}
function fs_metaBoxReferralRender( $post ){
    $referrer_name = get_post_meta($post->ID,'referrer_name',true);
    $zozi_referral_code = get_post_meta($post->ID,'zozi_referral_code',true);
    include( get_stylesheet_directory()."/admin-referral.php");
}
add_action( 'save_post_referral', 'fs_metaBoxReferralSave', 15 );
function fs_metaBoxReferralSave( $post_id ){
    if( isset($_POST['zozi_referral_code']) ){
        update_post_meta( $post_id, 'zozi_referral_code', trim($_POST['zozi_referral_code']) );
    }
    if( isset($_POST['referrer_name']) ){
        update_post_meta( $post_id, 'referrer_name', trim($_POST['referrer_name']) );
    }
}


/*-------------------------------------------*\
   Photographer Content Type
\*-------------------------------------------*/

// Custom Post Type
add_action("init", "fs_register_photographer_post_type"); // Add our custom post type
add_action('init', 'fs_register_photographer_menu'); // Add to admin menu

function fs_register_photographer_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'photographer'), // Main Navigation
        'sidebar-menu' => __('Sidebar Menu', 'photographer'), // Sidebar Navigation
        'extra-menu' => __('Extra Menu', 'photographer') // Extra Navigation if needed (duplicate as many as you need!)
    ));
}
function fs_register_photographer_post_type() {
    register_post_type( "photographer",
        array(
            "labels" => array(
                "name" => __( "Photographers" ),
                "singular_name" => __( "Photographer" ),
                "add_new" => __( "Add New" ),
                "add_new_item" => __( "Add New Photographer" ),
                "edit" => __( "Edit" ),
                "edit_item" => __( "Edit Photographer" ),
                "new_item" => __( "New Photographer" ),
                "view" => __( "View Photographers" ),
                "view_item" => __( "View Photographer" ),
                "search_items" => __( "Search Photographers" ),
                "not_found" => __( "No Photographers Found" ),
                "not_found_in_trash" => __( "No Photographers Found in trash" ),
                "parent" => __( "Photographer" ),
            ),
            "rewrite" => array(
                "slug" => "photographers",
                "with_front" => true,
                "pages" => true,
                ),
            'description' => 'Photographers setup in Zozi for booking.',
            'public' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'show_ui' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-star-empty',
            'capability_type' => 'post',
            "has_archive" => false,
            "supports" => array( "title", "editor", "revisions","thumbnail"),
            'can_export' => true,
            )
        );
}

function fs_show_child_pages($child_pages,$colw=3){

    while ( $child_pages->have_posts() ) : $child_pages->the_post();
       if( $post->post_name != 'host' && $post->post_name != 'apply' ):
           echo '<div class="col-xs-6 col-sm-'.$colw.' thumb-card">';
           echo '<a href="';
           the_permalink();
           echo '">';
           the_post_thumbnail('thumbnail'); //lists thumbnails
           echo '</a>';
           echo '<br><h4><a href="';
           the_permalink();
           echo '">';
           the_title(); // shows titles
           echo '</a></h4></div>';
       endif;
    endwhile;

}

function fs_show_photographers($status='',$colw=3){
    global $post;
    $id = $post->ID;

    $child_pages_query_args = array(
        'post_type'   => 'photographer',
        'orderby'     => 'date DESC',
        'posts_per_page' => -1
    );
    if( $status ){
        $child_pages_query_args['tax_query'] = array(
            array(
                'taxonomy' => 'status',
                'field' => 'slug',
                'terms' => array ($status)
            )
        );
    }
     
    $child_pages = new WP_Query( $child_pages_query_args );
    fs_show_child_pages($child_pages,$colw);
    wp_reset_postdata(); //remember to reset data
}

/*-------------------------------------------*\
   Venue Content Type
\*-------------------------------------------*/

// Custom Post Type
add_action("init", "fs_register_venue_post_type"); // Add our custom post type
add_action('init', 'fs_register_venue_menu'); // Add to admin menu

function fs_register_venue_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'venue'), // Main Navigation
        'sidebar-menu' => __('Sidebar Menu', 'venue'), // Sidebar Navigation
        'extra-menu' => __('Extra Menu', 'venue') // Extra Navigation if needed (duplicate as many as you need!)
    ));
}
function fs_register_venue_post_type() {
    register_post_type( "venue",
        array(
            "labels" => array(
                "name" => __( "Venues" ),
                "singular_name" => __( "Venue" ),
                "add_new" => __( "Add New" ),
                "add_new_item" => __( "Add New Venue" ),
                "edit" => __( "Edit" ),
                "edit_item" => __( "Edit Venue" ),
                "new_item" => __( "New Venue" ),
                "view" => __( "View Venues" ),
                "view_item" => __( "View Venue" ),
                "search_items" => __( "Search Venues" ),
                "not_found" => __( "No Venues Found" ),
                "not_found_in_trash" => __( "No Venues Found in trash" ),
                "parent" => __( "Venue" ),
            ),
            "rewrite" => array(
                "slug" => "venues",
                "with_front" => true,
                "pages" => true,
                ),
            'description' => 'Venues setup in Zozi for booking.',
            'public' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'show_ui' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-star-empty',
            'capability_type' => 'post',
            "has_archive" => false,
            "supports" => array( "title", "editor", "revisions","thumbnail"),
            'can_export' => true,
            )
        );
}

function fs_show_venues($status='',$colw=3){
    global $post;
    $id = $post->ID;

    $child_pages_query_args = array(
        'post_type'   => 'venue',
        'orderby'     => 'date DESC',
        'posts_per_page' => -1
    );
    if( $status ){
        $child_pages_query_args['tax_query'] = array(
            array(
                'taxonomy' => 'status',
                'field' => 'slug',
                'terms' => array ($status)
            )
        );
    }
     
    $child_pages = new WP_Query( $child_pages_query_args );
    fs_show_child_pages($child_pages,$colw);
    wp_reset_postdata(); //remember to reset data
}

/* --------------------
    get related photographer / venue
    currently sites on top of custom fields "relationship" type
----------------------- */

function fs_show_related_photogs_venues($type,$colw=3) {
    global $post; 
    $ids = get_field('photog_venue_match', $post->ID, false);
    if( $ids ){
        $child_pages = new WP_Query(array(
            'post_type'         => $type,
            'posts_per_page'    => 3,
            'post__in'          => $ids,
            'post_status'       => 'any',
            'orderby'           => 'post__in',
        ));
        fs_show_child_pages($child_pages,$colw);
        wp_reset_postdata(); //remember to reset data
    }
}


/* --------------------
   athena (parent theme)
   overrides
----------------------- */

// enqueue parent theme styles + scripts
function fs_enqueue_styles() {
    $parent_style = 'athena';

    // since this is a child, it won't load the master/parent sheet automatically
    wp_register_style( 'athena-master', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'athena-master' );

    // load ga-tracking and other custom scripts
    wp_register_script( 'fs-scripts', get_stylesheet_directory_uri() . '/scripts.js',
        array('jquery'), '1.0.0', true );
    wp_enqueue_script('fs-scripts');

    // override the athena-customizer
    wp_deregister_script( 'athena-customizer' );
    wp_register_script( 'athena-customizer', get_stylesheet_directory_uri() . '/customizer.js', array ( 'customize-preview' ), ATHENA_VERSION, true );

    // athena is already loading raleway
    // wp_register_style( 'fonts', 'https://fonts.googleapis.com/css?family=Raleway');
    // wp_enqueue_style( 'fonts' );
}
add_action( 'wp_enqueue_scripts', 'fs_enqueue_styles' );

// override some athena/parent theme displays
function fs_render_homepage() { ?>

    <?php if( get_theme_mod('callout_bool', 'on' ) == 'on' ) : ?>

    <div id="athena-featured">

        <div class="col-sm-4 featured-box featured-box1" data-target="<?php echo esc_url( get_theme_mod( 'callout1_href', '#' ) ); ?>">

            <div class="reveal animated fadeInUp reveal">

                <div class="athena-icon">
                    <span class="<?php echo esc_attr(get_theme_mod('callout1_icon', __('fa fa-laptop', 'athena'))); ?>"></span>
                </div>

                <h3 class="athena-title"><?php echo esc_attr(get_theme_mod('callout1_title', __('Responsive', 'athena'))); ?></h3>

                <p class="athena-desc"><?php echo esc_attr(get_theme_mod('callout1_text', __('Athena looks amazing on desktop and mobile devices.', 'athena'))); ?></p>

            </div>

        </div>

        <div class="col-sm-4 featured-box featured-box2" data-target="<?php echo esc_url( get_theme_mod( 'callout2_href', '#' ) ); ?>">

            <div class="reveal animated fadeInUp delay1">

                <div class="athena-icon">
                    <span class="<?php echo esc_attr(get_theme_mod('callout2_icon', __('fa fa-magic', 'athena'))); ?>"></span>
                </div>

                <h3 class="athena-title"><?php echo esc_attr(get_theme_mod('callout2_title', __('Customizable', 'athena'))); ?></h3>

                <p class="athena-desc"><?php echo esc_attr(get_theme_mod('callout2_text', __('Athena is easy to use and customize without having to touch code', 'athena'))); ?></p>

            </div>

        </div>

        <div class="col-sm-4 featured-box featured-box3" data-target="<?php echo esc_url( get_theme_mod( 'callout3_href', '#' ) ); ?>">

            <div class="reveal animated fadeInUp delay2">

                <div class="athena-icon">
                    <span class="<?php echo esc_attr(get_theme_mod('callout3_icon', __('fa fa-shopping-cart', 'athena'))); ?>"></span>
                </div>

                <h3 class="athena-title"><?php echo esc_attr(get_theme_mod('callout3_title', __('WooCommerce', 'athena'))); ?></h3>

                <p class="athena-desc"><?php echo esc_attr(get_theme_mod('callout3_text', __('Athena supports WooCommerce to build an online shopping site', 'athena'))); ?></p>

            </div>
        </div>

    </div>
  <?php endif; ?>
    
   
    
    <?php get_sidebar('homepage'); ?>

    
    <?php
}


function fs_render_footer(){ ?>
        
    <div class="clear"></div>
    
    <div class="site-info">
        
        <div class="row">
            
            <div class="athena-copyright">
                <!-- <a href="#">Terms of Use + Privacy Policy</a> | -->
                Made with &hearts; in Portland, Oregon |
                Credits |
                <?php echo esc_attr( get_theme_mod( 'copyright_text', __( 'Copyright Company Name 2015', 'athena' ) ) ); ?>
            </div>
            
            <div id="authica-social">
                
                <?php if( get_theme_mod( 'facebook_url', 'http://facebook.com' ) != '' ) : ?>
                <a href="<?php echo esc_url( get_theme_mod( 'facebook_url', 'http://facebook.com' ) ); ?>" target="_BLANK" class="athena-facebook">
                    <span class="fa fa-facebook"></span>
                </a>
                <?php endif; ?>
                
                
                <?php if( get_theme_mod( 'gplus_url', 'http://gplus.com' ) != '' ) : ?>
                <a href="<?php echo esc_url( get_theme_mod( 'gplus_url', 'http://gplus.com' ) ); ?>" target="_BLANK" class="athena-gplus">
                    <span class="fa fa-google-plus"></span>
                </a>
                <?php endif; ?>
                
                <?php if( get_theme_mod( 'instagram_url', 'http://instagram.com' ) != '' ) : ?>
                <a href="<?php echo esc_url( get_theme_mod( 'instagram_url', 'http://instagram.com' ) ); ?>" target="_BLANK" class="athena-instagram">
                    <span class="fa fa-instagram"></span>
                </a>
                <?php endif; ?>
                
                <?php if( get_theme_mod( 'linkedin_url', 'http://linkedin.com' ) != '' ) : ?>
                <a href="<?php echo esc_url( get_theme_mod( 'linkedin_url', 'http://linkedin.com' ) ); ?>" target="_BLANK" class="athena-linkedin">
                    <span class="fa fa-linkedin"></span>
                </a>
                <?php endif; ?>
                
                <a href="http://www.yelp.com/biz/fotosnap-portland" target="_BLANK" class="athena-yelp">
                    <span class="fa fa-yelp"></span>
                </a>
                
                <?php if( get_theme_mod( 'pinterest_url', 'http://pinterest.com' ) != '' ) : ?>
                <a href="<?php echo esc_url( get_theme_mod( 'pinterest_url', 'http://pinterest.com' ) ); ?>" target="_BLANK" class="athena-pinterest">
                    <span class="fa fa-pinterest"></span>
                </a>
                <?php endif; ?>
                
                <?php if( get_theme_mod( 'twitter_url', 'http://twitter.com' ) ) : ?>
                <a href="<?php echo esc_url( get_theme_mod( 'twitter_url', 'http://twitter.com' ) ); ?>" target="_BLANK" class="athena-twitter">
                    <span class="fa fa-twitter"></span>
                </a>
                <?php endif; ?>
                
            </div>

            <br>            
            
        </div>
        
        <div class="scroll-top alignright">
            <span class="fa fa-chevron-up"></span>
        </div>
        

        
    </div><!-- .site-info -->
    
    
<?php }
add_action( 'athena_footer', 'fs_render_footer' );


// have to remove these after themes are loaded
// https://code.tutsplus.com/tutorials/a-guide-to-overriding-parent-theme-functions-in-your-child-theme--cms-22623
function fs_child_remove_parent_function() {
  remove_action( 'athena_homepage', 'athena_render_homepage' );
  remove_action( 'athena_footer', 'athena_render_footer' );
  // remove_action( 'customize_register', 'athena_customize_register' );
}
add_action( 'wp_loaded', 'fs_child_remove_parent_function' );
add_action( 'athena_homepage', 'fs_render_homepage', 15 );
add_action( 'athena_footer', 'fs_render_footer' );


/**
 * Add additional sliders (not using just yet)
 */
/*
function fs_customize_register( $wp_customize ) {

    $wp_customize->remove_panel( 'slider' );

    // *********************************************
    // ****************** Slider *****************
    // *********************************************
    $wp_customize->add_section( 'slide3', array (
        'title'                 => __( 'Slide #3', 'athena' ),
        'description'           => __( 'Use the settings below to upload your images, set main callout text and button text & URLs', 'athena' ),
        'panel'                 => 'slider',
    ) );
    
    $wp_customize->add_section( 'slide4', array (
        'title'                 => __( 'Slide #4', 'athena' ),
        'description'           => __( 'Use the settings below to upload your images, set main callout text and button text & URLs', 'athena' ),
        'panel'                 => 'slider',
    ) );

    
    // 3rd slide
    $wp_customize->add_setting( 'featured_image3', array (
        'default'               => get_template_directory_uri() . '/inc/images/athena.jpg',
        'transport'             => 'postMessage',
        'sanitize_callback'     => 'esc_url_raw'
    ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'image_control6', array (
        'label' =>              __( 'Background Image', 'athena' ),
        'section'               => 'slide3',
        'mime_type'             => 'image',
        'settings'              => 'featured_image3',
        'description'           => __( 'Select the image file that you would like to use as the featured images', 'athena' ),        
    ) ) );

    $wp_customize->add_setting( 'featured_image3_title', array (
        'default'               => __( 'Good-bye Selfie. Hello FotoSnap', 'athena' ),
        'transport'             => 'postMessage',
        'sanitize_callback'     => 'athena_text_sanitize'

    ) );
    
    $wp_customize->add_control( 'featured_image3_title', array(
        'type'                  => 'text',
        'section'               => 'slide3',
        'label'                 => __( 'Header Text', 'athena' ),
        'description'           => __( 'The main heading text, leave blank to hide', 'athena' ),
    ) );
    
    // 4th slide
    $wp_customize->add_setting( 'featured_image4', array (
        'default'               => get_template_directory_uri() . '/inc/images/athena.jpg',
        'transport'             => 'postMessage',
        'sanitize_callback'     => 'esc_url_raw'
    ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'image_control7', array (
        'label' =>              __( 'Background Image', 'athena' ),
        'section'               => 'slide4',
        'mime_type'             => 'image',
        'settings'              => 'featured_image4',
        'description'           => __( 'Select the image file that you would like to use as the featured images', 'athena' ),        
    ) ) );

    $wp_customize->add_setting( 'featured_image4_title', array (
        'default'               => __( 'Good-bye Selfie. Hello FotoSnap', 'athena' ),
        'transport'             => 'postMessage',
        'sanitize_callback'     => 'athena_text_sanitize'

    ) );
    
    $wp_customize->add_control( 'featured_image4_title', array(
        'type'                  => 'text',
        'section'               => 'slide4',
        'label'                 => __( 'Header Text', 'athena' ),
        'description'           => __( 'The main heading text, leave blank to hide', 'athena' ),
    ) );

    $wp_customize->get_setting( 'featured_image3' )->transport      = 'postMessage';
    $wp_customize->get_setting( 'featured_image4' )->transport      = 'postMessage';
}
*/
?>