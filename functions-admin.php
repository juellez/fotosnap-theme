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

  function fs_admin_footer_text() {
    $footerText = '<div class="quote">';
      $quotes = array(
        "dreams don't work unless you do",
        "creativity takes courage",
        "don't think too much ... you'll create a problem that wasn't there in the first place",
        "decide. commit. succeed.",
        "shark tank? they're docile creatures, really. throw me in with some octopi",
        "smile.",
        "have we told you lately, that we love you?",
      );
    $footerText .= $quotes[ rand(0, sizeof($quotes)) ];
    $footerText .= '</div>';
    return $footerText;
  }
  add_filter( 'admin_footer_text', 'fs_admin_footer_text' );

  function fs_custom_admin_css(){
    echo '
      <style>
        #adminmenu div.wp-menu-name {
          font-size: 14px;
          padding: 8px 10px;
        }
        #wpcontent {
          padding-left: 20px;
        }
        .wrap { margin-top: 20px; }
        #wpadminbar .wp-ui-notification {
          background-color: #1cb6c9;
        }
        #wp-admin-bar-updates, 
        #wp-admin-bar-wp-logo { display: none }
        @media screen and (min-width: 782px){
          #wpbody { padding-top: 32px; }
          #wpwrap #wpadminbar { height: 32px; padding: 0 0 0 0; }
          #wpadminbar #wp-admin-bar-wpfc-toolbar-parent > .ab-empty-item::before {
            content: " * ";
            font-family: Lato;
            font-size: 14px;
            line-height: 32px;
          }
          #wpcontent #wp-admin-bar-root-default>li>a,
          #wpcontent #wpadminbar #wp-admin-bar-wp-logo>.ab-item,
          #wpcontent #wp-admin-bar-top-secondary>li>a
          {
            padding: 0 20px;
          }
        }
      </style>
    ';
  }
  add_action( 'admin_head', 'fs_custom_admin_css');

endif;



// add_meta_box('um-admin-access-settings', __('Ultimate Member'), array(&$this, 'load_metabox_form'), $post_type, 'side', 'default');