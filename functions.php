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
        array('page'), // will assign to custom post types when we register them
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

function fs_show_venues($status=''){
    $post = get_page_by_path('venues', OBJECT, 'page');
    fs_show_children($status,$post->ID);
}

function fs_show_children($status='',$id=0){

    global $post;
    if( !$id ) $id = $post->ID;
    $child_pages_query_args = array(
        'post_type'   => 'page',
        'post_parent' => $id,
        'orderby'     => 'date DESC',
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

    while ( $child_pages->have_posts() ) : $child_pages->the_post();
       if( $post->post_name != 'host' && $post->post_name != 'apply' ):
           echo '<div class="col-xs-6 col-sm-3 thumb-card">';
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
    wp_reset_postdata(); //remember to reset data
}
add_shortcode('show_child_pages', 'fs_show_children');

/* --------------------
   virtue functions (for portfolio + gallery support)
----------------------- */
/*
define( 'OPTIONS_SLUG', 'virtue_premium' );
define( 'LANGUAGE_SLUG', 'virtue' );
load_theme_textdomain('virtue', get_template_directory() . '/languages');

// require_once locate_template('/themeoptions/framework.php');                // Options framework
// require_once locate_template('/themeoptions/options.php');                  // Options framework
// require_once locate_template('/themeoptions/options/virtue_extension.php'); // Options framework extension
require_once locate_template('/kt_framework/extensions.php');               // Remove options from the admin

// require_once locate_template('/lib/utils.php');                             // Utility functions
require_once locate_template('/lib/init.php');                              // Initial theme setup and constants
require_once locate_template('/lib/sidebar.php');                           // Sidebar class
require_once locate_template('/lib/config.php');                            // Configuration
require_once locate_template('/lib/cleanup.php');                           // Cleanup
// require_once locate_template('/lib/custom-nav.php');                        // Nav Options
// require_once locate_template('/lib/nav.php');                               // Custom nav modifications

require_once locate_template('/lib/metaboxes.php');                         // Custom metaboxes
require_once locate_template('/lib/gallery_metabox.php');                   // Custom Gallery metaboxes
require_once locate_template('/lib/taxonomy-meta-class.php');               // Taxonomy meta boxes
require_once locate_template('/lib/taxonomy-meta.php');                     // Taxonomy meta boxes
require_once locate_template('/lib/comments.php');                          // Custom comments modifications
require_once locate_template('/lib/post-types.php');                        // Post Types
require_once locate_template('/lib/Mobile_Detect.php');                     // Mobile Detect
require_once locate_template('/lib/aq_resizer.php');                        // Resize on the fly
require_once locate_template('/lib/revslider-activate.php');                // Plugin Activation

require_once locate_template('/lib/kad_shortcodes/shortcodes.php');                         // Shortcodes
require_once locate_template('/lib/kad_shortcodes/carousel_shortcodes.php');                // Carousel Shortcodes
require_once locate_template('/lib/kad_shortcodes/custom_carousel_shortcodes.php');         // Carousel Shortcodes
require_once locate_template('/lib/kad_shortcodes/testimonial_shortcodes.php');             // Carousel Shortcodes
require_once locate_template('/lib/kad_shortcodes/testimonial_form_shortcode.php');         // Carousel Shortcodes
require_once locate_template('/lib/kad_shortcodes/blog_shortcodes.php');                    // Blog Shortcodes
require_once locate_template('/lib/kad_shortcodes/image_menu_shortcodes.php');              // image menu Shortcodes
require_once locate_template('/lib/kad_shortcodes/google_map_shortcode.php');               // Map Shortcodes
require_once locate_template('/lib/kad_shortcodes/portfolio_shortcodes.php');               // Portfolio Shortcodes
require_once locate_template('/lib/kad_shortcodes/portfolio_type_shortcodes.php');          // Portfolio Shortcodes
require_once locate_template('/lib/kad_shortcodes/staff_shortcodes.php');                   // Staff Shortcodes
require_once locate_template('/lib/kad_shortcodes/gallery.php');                            // Gallery Shortcode
*/

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
                <a href="#">Terms of Use + Privacy Policy</a> |
                Made with :heart: in Portland, Oregon. |
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