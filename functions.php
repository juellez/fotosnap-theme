<?php
/*
  FOTOSNAP THEME FUNCTIONS
*/

// if you ever need to re-theme, move these function includes into the new theme
include('functions-fotosnap.php');
include('functions-photo-orders.php');


/* --------------------
    remove some dashboard
    widgets
----------------------- */

function remove_dashboard_widgets() {
    global $wp_meta_boxes;
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']); // Removes QuickPress
    // unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']); // Incoming Links
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']); // Removes Right Now
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']); // Removes Plugins
    // unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']); // Removes Recent Drafts
    // unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']); // Removes Recent Comments
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']); // Removes the WordPress Developer Blog
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']); // Removes the WordPress Blog Updates

    // some plugin boxes
    unset($wp_meta_boxes['dashboard']['side']['high']['redux_dashboard_widget']); 
    unset($wp_meta_boxes['dashboard']['normal']['core']['photocrati_admin_dashboard_widget']); 

    // var_dump($wp_meta_boxes);
}
add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );

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

/* cleanup some plugin conflicts
 * 1. ultimate member
 */
function remove_um_scripts() {
    $block = false;
    $uri = $_SERVER['REQUEST_URI'];
    if( stristr($uri, "venues") ) $block = true;
    if( $block ){
        if( class_exists('UM_Enqueue') ){
            global $ultimatemember;
            // and we're NOT in a profile page
            $priority = apply_filters( 'um_core_enqueue_priority', 100 );
            remove_action('wp_enqueue_scripts', array($ultimatemember->styles, 'wp_enqueue_scripts'), $priority);
        }
        if( class_exists('UM_Gallery') ){
            remove_action( 'wp_enqueue_scripts', array(um_gallery(), 'add_scripts') );
        }
    }
}
add_action( 'init', 'remove_um_scripts', 1000 ); // run AFTER any UM scripts


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