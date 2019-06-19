<?php
/*
  FOTOSNAP content types, roles and other configurations
  2019: removing venues, photographers & shoots (moved to shoot proof)
*/


/*-----------------------------------------------*\
   Custom User Roles: Photographers + Customers
   Use "members" plugin to view/manage capabilities
   This is for the naming of the roles only
\*-----------------------------------------------*/

function wps_change_role_name() {
    global $wp_roles;
    if ( ! isset( $wp_roles ) ) $wp_roles = new WP_Roles();

    $wp_roles->roles['contributor']['name'] = 'Photographer';
    $wp_roles->role_names['contributor'] = 'Photographer';

    $wp_roles->roles['subscriber']['name'] = 'Customer';
    $wp_roles->role_names['subscriber'] = 'Customer';
}
add_action('init', 'wps_change_role_name');

/*-------------------------------------------*\
   Global Settings: email
\*-------------------------------------------*/

add_filter( 'wp_mail_from', 'fs_wp_mail_from' );
function fs_wp_mail_from( $original_email_address ) {
    //Make sure the email is from the same domain 
    //as your website to avoid being marked as spam.
    return 'hello@fotosnap.co';
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
// add_action( 'init', 'fs_status_init' );


/*-------------------------------------------*\
   Photo Shoot Type (Client Session): this essentially brings
   together a Zozi booking (and ideally, in the future, 
   our own booking). Created day of shoot (to avoid hassle 
   of managing cancelations) linking customer information
   w/photos from shoot - so they can securely access
   their photos and make a purchase.
\*-------------------------------------------*/

// Custom Post Type
// add_action("init", "fs_register_shoot_post_type"); // Add our custom post type
// add_action('init', 'fs_register_shoot_menu'); // Add to admin menu

function fs_register_shoot_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'venue'), // Main Navigation
        'sidebar-menu' => __('Sidebar Menu', 'venue'), // Sidebar Navigation
        'extra-menu' => __('Extra Menu', 'venue') // Extra Navigation if needed (duplicate as many as you need!)
    ));
}
function fs_register_shoot_post_type() {
    register_post_type( "shoot",
        array(
            "labels" => array(
                "name" => __( "Client Sessions" ),
                "singular_name" => __( "Client Session" ),
                "add_new" => __( "Add New" ),
                "add_new_item" => __( "Add New Session" ),
                "edit" => __( "Edit" ),
                "edit_item" => __( "Edit Session" ),
                "new_item" => __( "New Session" ),
                "view" => __( "View Sessions" ),
                "view_item" => __( "View Session" ),
                "search_items" => __( "Search Sessions" ),
                "not_found" => __( "No Sessions Found" ),
                "not_found_in_trash" => __( "No Sessions Found in trash" ),
                "parent" => __( "Client Photo Sessions" ),
            ),
            "rewrite" => array(
                "slug" => "gallery",
                "with_front" => true,
                "pages" => true,
                ),
            'description' => 'Booked photo session that was shot or is to be shot today.',
            'public' => true,
            'exclude_from_search' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-camera',
            'capability_type' => 'post',
            "has_archive" => false,
            "supports" => array("title", "editor", "revisions"),
            'can_export' => true,
            )
        );
}

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
            'description' => 'Referral codes in Zozi/Peek for tracking.',
            'public' => true,
            'exclude_from_search' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'menu_position' => 8,
            'menu_icon' => 'dashicons-tickets',
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
   add_meta_box( 'fs_referrals', 'Zozi/Peek + Tracking Information', 'fs_metaBoxReferralRender', 'referral', 'normal', 'high' );
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

function fs_hookPeekCode() {
    ?>
        <script type="text/javascript">
          (function(config) {
            window._peekConfig = config || {};
            var idPrefix = 'peek-book-button';
            var id = idPrefix+'-js'; if (document.getElementById(id)) return;
            var head = document.getElementsByTagName('head')[0];
            var el = document.createElement('script'); el.id = id;
            var date = new Date; var stamp = date.getMonth()+"-"+date.getDate();
            var basePath = "https://js.peek.com";
            el.src = basePath + "/widget_button.js?ts="+stamp;
            head.appendChild(el); id = idPrefix+'-css'; el = document.createElement('link'); el.id = id;
            el.href = basePath + "/widget_button.css?ts="+stamp;
            el.rel="stylesheet"; el.type="text/css"; head.appendChild(el);
          })({key: 'c74c5080-8031-4867-bc34-66878fb89340'});
        </script>
    <?php
}
// add_action('wp_head', 'fs_hookPeekCode');

function fs_show_child_pages($child_pages,$colw=3){
    global $post;
    while ( $child_pages->have_posts() ) : $child_pages->the_post();
       if( $post && $post->post_name != 'host' && $post->post_name != 'apply' ):
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

/*-------------------------------------------*\
   Email Templates Type
\*-------------------------------------------*/

// Custom Post Type
add_action("init", "fs_register_template_post_type"); // Add our custom post type
add_action('init', 'fs_register_template_menu'); // Add to admin menu

function fs_register_template_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'venue'), // Main Navigation
        'sidebar-menu' => __('Sidebar Menu', 'venue'), // Sidebar Navigation
        'extra-menu' => __('Extra Menu', 'venue') // Extra Navigation if needed (duplicate as many as you need!)
    ));
}
function fs_register_template_post_type() {
    register_post_type( "template",
        array(
            "labels" => array(
                "name" => __( "Email Templates" ),
                "singular_name" => __( "Email Template" ),
                "add_new" => __( "Add New" ),
                "add_new_item" => __( "Add New Template" ),
                "edit" => __( "Edit" ),
                "edit_item" => __( "Edit Template" ),
                "new_item" => __( "New Template" ),
                "view" => __( "View Templates" ),
                "view_item" => __( "View Template" ),
                "search_items" => __( "Search Templates" ),
                "not_found" => __( "No Templates Found" ),
                "not_found_in_trash" => __( "No Templates Found in trash" ),
                "parent" => __( "Client Photo Templates" ),
            ),
            "rewrite" => false,
            'description' => 'Email templates for automated messaging and customer service',
            'public' => false,
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'show_ui' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-email-alt',
            'capability_type' => 'post',
            "has_archive" => false,
            "supports" => array("title", "editor", "revisions"),
            'can_export' => true,
            )
        );
}
