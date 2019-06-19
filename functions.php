<?php
/*
  FOTOSNAP functions
*/
    die('called');

function wps_change_role_name() {
    global $wp_roles;
    if ( ! isset( $wp_roles ) ) $wp_roles = new WP_Roles();

    $wp_roles->roles['contributor']['name'] = 'Photographer';
    $wp_roles->role_names['contributor'] = 'Photographer';

    $wp_roles->roles['subscriber']['name'] = 'Customer';
    $wp_roles->role_names['subscriber'] = 'Customer';
}
add_action('init', 'wps_change_role_name');

// enqueue parent theme styles + scripts
function fs_enqueue_styles() {
    $parent_style = 'athena';

    // since this is a child, it won't load the master/parent sheet automatically
    wp_enqueue_style( 'athena-master', get_template_directory_uri() . '/style.css' );

    wp_deregister_script( 'athena-customizer' );
    wp_register_script( 'athena-customizer', get_template_directory_uri() . '/customizer.js', array ( 'customize-preview' ), ATHENA_VERSION, true );

    // athena is already loading raleway
    // wp_register_style( 'fonts', 'https://fonts.googleapis.com/css?family=Raleway');
    // wp_enqueue_style( 'fonts' );
}
add_action( 'wp_enqueue_scripts', 'fs_enqueue_styles' );

// override some athena/parent theme displays
function fs_render_homepage() { ?>

    <div id="athena-jumbotron">

        <div id="athena-slider" class="hero">

            <div id="slide1" data-thumb="<?php echo esc_url( get_theme_mod('featured_image1', get_template_directory_uri() . '/inc/images/athena.jpg' ) ); ?>" data-src="<?php echo esc_url( get_theme_mod( 'featured_image1', get_template_directory_uri() . '/inc/images/athena.jpg' ) ); ?>">

                <div class="overlay">
                    <div class="row">
                        
                        <div class="col-sm-6 col-sm-offset-6 parallax">
                            <h2 class="header-text animated slideInDown slide1-header"><?php echo esc_attr( get_theme_mod( 'featured_image1_title', __( 'Good-bye Selfie. Hello FotoSnap.', 'athena' )  ) ); ?></h2>
                            
                            <?php if( get_theme_mod( 'slide1_button1_text', 'True' ) ) : ?>
                            <a href="<?php echo esc_url( get_theme_mod( 'slide1_button1_url', '#') ); ?>"
                               class="athena-button primary large animated flipInX slide1_button1 delay3">
                                <?php echo esc_attr( get_theme_mod( 'slide1_button1_text', __( 'View Features', 'athena' )  ) ); ?>
                            </a>
                            <?php endif; ?>

                            <?php if( get_theme_mod( 'slide1_button2_text', 'True' ) ) : ?>
                            <a href="<?php echo esc_url( get_theme_mod( 'slide1_button2_url', '#') ); ?>"
                               class="athena-button default large animated flipInX slide1_button2 delay3">
                                <?php echo esc_attr( get_theme_mod( 'slide1_button2_text', __( 'Learn More', 'athena' )  ) ); ?>
                            </a>
                            <?php endif; ?>
                            
                        </div>

                    </div>
                </div>                    

            </div>                

            <div id="slide2" data-thumb="<?php echo esc_url(get_theme_mod('featured_image2', get_template_directory_uri() . '/inc/images/athena2.jpg')); ?>" data-src="<?php echo esc_url(get_theme_mod('featured_image2', get_template_directory_uri() . '/inc/images/athena2.jpg')); ?>">

                <div class="overlay">
                    
                    <div class="row">
                        
                        <div class="col-sm-6 col-sm-offset-6 parallax">
                            <h2 class="header-text animated slideInDown slide2-header"><?php echo esc_attr( get_theme_mod( 'featured_image2_title', __( 'Good-bye Selfie. Hello FotoSnap.', 'athena' )  ) ); ?></h2>
                            
                            <?php if( get_theme_mod( 'slide2_button1_text', 'True' ) ) : ?>
                            <a href="<?php echo esc_url( get_theme_mod( 'slide2_button1_url', '#') ); ?>"
                               class="athena-button primary large animated flipInX slide2_button1 delay3">
                                <?php echo esc_attr( get_theme_mod( 'slide2_button1_text', __( 'View Features', 'athena' )  ) ); ?>
                            </a>
                            <?php endif; ?>

                            <?php if( get_theme_mod( 'slide2_button2_text', 'True' ) ) : ?>
                            <a href="<?php echo esc_url( get_theme_mod( 'slide2_button2_url', '#') ); ?>"
                               class="athena-button default large animated flipInX slide2_button2 delay3">
                                <?php echo esc_attr( get_theme_mod( 'slide2_button2_text', __( 'Learn More', 'athena' )  ) ); ?>
                            </a>
                            <?php endif; ?>
                            
                        </div>

                    </div>
                </div>                    
            </div>                

            <div id="slide3" data-thumb="<?php echo esc_url(get_theme_mod('featured_image3', get_template_directory_uri() . '/inc/images/athena2.jpg')); ?>" data-src="<?php echo esc_url(get_theme_mod('featured_image3', get_template_directory_uri() . '/inc/images/athena2.jpg')); ?>">

                <div class="overlay">
                    
                    <div class="row">
                        
                        <div class="col-sm-6 parallax">
                            <h2 class="header-text animated slideInDown slide3-header"><?php echo esc_attr( get_theme_mod( 'featured_image3_title', __( 'Good-bye Selfie. Hello FotoSnap.', 'athena' )  ) ); ?></h2>
                            
                            <?php if( get_theme_mod( 'slide3_button1_text', 'True' ) ) : ?>
                            <a href="<?php echo esc_url( get_theme_mod( 'slide3_button1_url', '#') ); ?>"
                               class="athena-button primary large animated flipInX slide3_button1 delay3">
                                <?php echo esc_attr( get_theme_mod( 'slide3_button1_text', __( 'View Features', 'athena' )  ) ); ?>
                            </a>
                            <?php endif; ?>

                            <?php if( get_theme_mod( 'slide3_button2_text', 'True' ) ) : ?>
                            <a href="<?php echo esc_url( get_theme_mod( 'slide3_button2_url', '#') ); ?>"
                               class="athena-button default large animated flipInX slide3_button2 delay3">
                                <?php echo esc_attr( get_theme_mod( 'slide3_button2_text', __( 'Learn More', 'athena' )  ) ); ?>
                            </a>
                            <?php endif; ?>
                            
                        </div>

                    </div>
                </div>                    
            </div>                

            <div id="slide4" data-thumb="<?php echo esc_url(get_theme_mod('featured_image4', get_template_directory_uri() . '/inc/images/athena2.jpg')); ?>" data-src="<?php echo esc_url(get_theme_mod('featured_image4', get_template_directory_uri() . '/inc/images/athena2.jpg')); ?>">

                <div class="overlay">
                    
                    <div class="row">
                        
                        <div class="col-sm-6 col-sm-offset-6 parallax">
                            <h2 class="header-text animated slideInDown slide4-header"><?php echo esc_attr( get_theme_mod( 'featured_image4_title', __( 'Good-bye Selfie. Hello FotoSnap.', 'athena' )  ) ); ?></h2>
                            
                            <?php if( get_theme_mod( 'slide4_button1_text', 'True' ) ) : ?>
                            <a href="<?php echo esc_url( get_theme_mod( 'slide4_button1_url', '#') ); ?>"
                               class="athena-button primary large animated flipInX slide4_button1 delay3">
                                <?php echo esc_attr( get_theme_mod( 'slide4_button1_text', __( 'View Features', 'athena' )  ) ); ?>
                            </a>
                            <?php endif; ?>

                            <?php if( get_theme_mod( 'slide4_button2_text', 'True' ) ) : ?>
                            <a href="<?php echo esc_url( get_theme_mod( 'slide4_button2_url', '#') ); ?>"
                               class="athena-button default large animated flipInX slide4_button2 delay3">
                                <?php echo esc_attr( get_theme_mod( 'slide4_button2_text', __( 'Learn More', 'athena' )  ) ); ?>
                            </a>
                            <?php endif; ?>
                            
                        </div>

                    </div>
                </div>                    
            </div>                

        </div>
        
        <?php if( get_theme_mod( 'overlay_bool', 'on' ) == 'on' ) : ?>
        <div id="athena-overlay-trigger">

            <div class="overlay-widget">
                <div class="row">
                    <?php if (is_active_sidebar('sidebar-overlay')) : ?>
                        <?php dynamic_sidebar('sidebar-overlay'); ?>
                    <?php endif; ?>
                </div>
            </div>

            <span class="<?php echo esc_attr( get_theme_mod( 'overlay_icon', 'fa fa-plus' ) ); ?> animated rotateIn delay3"></span>
            
        </div>

        <div class="slider-bottom">
            <div>
                <span class="fa fa-chevron-down scroll-down animated slideInUp delay-long"></span>
            </div>
        </div>
        <?php endif; ?>
        
    </div>

    <div class="clear"></div>

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
    
    <div class="athena-footer" class="parallax-window" data-parallax="scroll" data-image-src="<?php echo esc_attr( get_theme_mod('footer_background_image', get_template_directory_uri() . '/inc/images/footer.jpg' ) ); ?>">
        <div>
            <div class="row">
                <?php get_sidebar('footer'); ?>
            </div>            
        </div>

        
    </div>
    
    <div class="clear"></div>
    
    <div class="site-info">
        
        <div class="row">
            
            <div class="athena-copyright">
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

            <?php $menu = wp_nav_menu( array ( 
                'theme_location'    => 'footer', 
                'menu_id'           => 'footer-menu', 
                'menu_class'        => 'athena-footer-nav' ,

                ) ); ?>
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
}
add_action( 'wp_loaded', 'fs_child_remove_parent_function' );
add_action( 'athena_homepage', 'fs_render_homepage', 15 );
add_action( 'athena_footer', 'fs_render_footer' );


/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function fs_customize_register( $wp_customize ) {

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


    $wp_customize->add_setting( 'slide3_button1_text', array (
        'default'               => __( 'View Features', 'athena' ),
        'transport'             => 'postMessage',
        'sanitize_callback'     => 'athena_text_sanitize'
    ) );
    
    $wp_customize->add_control( 'slide3_button1_text', array(
        'type'                  => 'text',
        'section'               => 'slide3',
        'label'                 => __( 'Button #1 Text', 'athena' ),
        'description'           => __( 'The text for the button, leave blank to hide', 'athena' ),
    ) );

    $wp_customize->add_setting( 'slide3_button1_url', array (
        'default'               => '',
        'transport'             => 'postMessage',
        'sanitize_callback'     => 'esc_url_raw'
    ) );
    
    $wp_customize->add_control( 'slide3_button1_url', array(
        'type'                  => 'text',
        'section'               => 'slide3',
        'label'                 => __( 'Button #1 URL', 'athena' ),
    ) );
   

    $wp_customize->add_setting( 'slide3_button2_text', array (
        'default'               => __( 'Learn More', 'athena' ),
        'transport'             => 'postMessage',
        'sanitize_callback'     => 'athena_text_sanitize'
    ) );
    
    $wp_customize->add_control( 'slide3_button2_text', array(
        'type'                  => 'text',
        'section'               => 'slide3',
        'label'                 => __( 'Button #2 Text', 'athena' ),
        'description'           => __( 'The text for the button, leave blank to hide', 'athena' ),
    ) );

    $wp_customize->add_setting( 'slide3_button2_url', array (
        'default'               => '',
        'transport'             => 'postMessage',
        'sanitize_callback'     => 'esc_url_raw'
    ) );
    
    $wp_customize->add_control( 'slide3_button2_url', array(
        'type'                  => 'text',
        'section'               => 'slide3',
        'label'                 => __( 'Button #2 URL', 'athena' ),
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


    $wp_customize->add_setting( 'slide4_button1_text', array (
        'default'               => __( 'View Features', 'athena' ),
        'transport'             => 'postMessage',
        'sanitize_callback'     => 'athena_text_sanitize'
    ) );
    
    $wp_customize->add_control( 'slide4_button1_text', array(
        'type'                  => 'text',
        'section'               => 'slide4',
        'label'                 => __( 'Button #1 Text', 'athena' ),
        'description'           => __( 'The text for the button, leave blank to hide', 'athena' ),
    ) );

    $wp_customize->add_setting( 'slide4_button1_url', array (
        'default'               => '',
        'transport'             => 'postMessage',
        'sanitize_callback'     => 'esc_url_raw'
    ) );
    
    $wp_customize->add_control( 'slide4_button1_url', array(
        'type'                  => 'text',
        'section'               => 'slide4',
        'label'                 => __( 'Button #1 URL', 'athena' ),
    ) );
   

    $wp_customize->add_setting( 'slide4_button2_text', array (
        'default'               => __( 'Learn More', 'athena' ),
        'transport'             => 'postMessage',
        'sanitize_callback'     => 'athena_text_sanitize'
    ) );
    
    $wp_customize->add_control( 'slide4_button2_text', array(
        'type'                  => 'text',
        'section'               => 'slide4',
        'label'                 => __( 'Button #2 Text', 'athena' ),
        'description'           => __( 'The text for the button, leave blank to hide', 'athena' ),
    ) );

    $wp_customize->add_setting( 'slide4_button2_url', array (
        'default'               => '',
        'transport'             => 'postMessage',
        'sanitize_callback'     => 'esc_url_raw'
    ) );
    
    $wp_customize->add_control( 'slide4_button2_url', array(
        'type'                  => 'text',
        'section'               => 'slide4',
        'label'                 => __( 'Button #2 URL', 'athena' ),
    ) );
    
    $wp_customize->get_setting( 'featured_image3' )->transport      = 'postMessage';
    $wp_customize->get_setting( 'featured_image4' )->transport      = 'postMessage';
    
}

add_action( 'customize_register', 'fs_customize_register' );

?>