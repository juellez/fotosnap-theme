<?php
/* custom admin stuff */

if( is_admin() ):

  // don't show useless metaboxes 
  function fs_handle_metaboxes(){

    $args = array('show_ui' => true);
    $types = get_post_types($args,'names');

    // list the metaboxes we know and the only types they should show on
    // this could be extracted out to admin config
    $whitelist = array(
      'expirationdatediv' => array('context'=>'side','allowed'=>'referral'), // expiry box
      'um-admin-access-settings' => array('context'=>'side','allowed'=>'page'), // members access settings
      'martygeocoder' => array('context'=>'normal','allowed'=>'venue')
    );

    // no need to edit below this
    foreach($whitelist as $box => $meta){ // box = metabox id; meta = context & allowed post types
      foreach($types as $t){ // t = post type
        if( $t != $meta['allowed'] ){
          remove_meta_box( $box, $t, $meta['context'] ); 
        }
      }
    }
    /*
    // expiry only needed for referral - expirationdatediv
      remove_meta_box( 'expirationdatediv', 'venue', 'side' ); 
      remove_meta_box( 'expirationdatediv', 'template', 'side' ); 
      remove_meta_box( 'expirationdatediv', 'photographer', 'side' ); 
      remove_meta_box( 'expirationdatediv', 'shoot', 'side' ); 
      remove_meta_box( 'expirationdatediv', 'media', 'side' ); 
      remove_meta_box( 'expirationdatediv', 'post', 'side' ); 
      remove_meta_box( 'expirationdatediv', 'page', 'side' ); 

    // member content only needed for pages - um-admin-access-settings
      remove_meta_box( 'um-admin-access-settings', 'venue', 'side' ); 
      remove_meta_box( 'um-admin-access-settings', 'template', 'side' ); 
      remove_meta_box( 'um-admin-access-settings', 'photographer', 'side' ); 
      remove_meta_box( 'um-admin-access-settings', 'shoot', 'side' ); 
      remove_meta_box( 'um-admin-access-settings', 'media', 'side' ); 
      remove_meta_box( 'um-admin-access-settings', 'post', 'side' ); 
      remove_meta_box( 'um-admin-access-settings', 'referral', 'side' ); 

    // geocoder only needed on locations - martygeocoder
    */
  }
  add_action( 'do_meta_boxes', fs_handle_metaboxes );

endif;



// add_meta_box('um-admin-access-settings', __('Ultimate Member'), array(&$this, 'load_metabox_form'), $post_type, 'side', 'default');