<?php
/*
  FOTOSNAP content types, roles and other configurations
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
add_action( 'init', 'fs_status_init' );


/*-------------------------------------------*\
   Photo Shoot Type: this essentially brings
   together a Zozi booking (and ideally, in the future, 
   our own booking). Created day of shoot (to avoid hassle 
   of managing cancelations) linking customer information
   w/photos from shoot - so they can securely access
   their photos and make a purchase.
\*-------------------------------------------*/

// Custom Post Type
add_action("init", "fs_register_shoot_post_type"); // Add our custom post type
add_action('init', 'fs_register_shoot_menu'); // Add to admin menu

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
                "name" => __( "Client Shoots" ),
                "singular_name" => __( "Client Shoot" ),
                "add_new" => __( "Add New" ),
                "add_new_item" => __( "Add New Shoot" ),
                "edit" => __( "Edit" ),
                "edit_item" => __( "Edit Shoot" ),
                "new_item" => __( "New Shoot" ),
                "view" => __( "View Shoots" ),
                "view_item" => __( "View Shoot" ),
                "search_items" => __( "Search Shoots" ),
                "not_found" => __( "No Shoots Found" ),
                "not_found_in_trash" => __( "No Shoots Found in trash" ),
                "parent" => __( "Client Photo Shoot" ),
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
            'description' => 'Referral codes in Zozi for tracking.',
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
            'menu_icon' => 'dashicons-admin-users',
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
            'menu_icon' => 'dashicons-location',
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
            'posts_per_page'    => 8,
            'post__in'          => $ids,
            'post_status'       => 'any',
            'orderby'           => 'post__in',
        ));
        fs_show_child_pages($child_pages,$colw);
        wp_reset_postdata(); //remember to reset data
    }
}