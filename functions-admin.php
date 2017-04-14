<?php
/* custom admin stuff */

// wp_get_recent_posts( array $args = array(), string $output = ARRAY_A )

if( is_admin() ):

  function fs_display_widget($filename,$args=array()){
    $file = plugin_dir_path( __FILE__ ) . 'admin/' . $filename . '.php';
    if ( file_exists( $file ) ){
      include $file;
    }
  }
  function fs_dash_shoots_widget(){
    $args = wp_get_recent_posts( array('post_type'=>'shoot') );
    var_dump($args);
    fs_display_widget('newest_sessions',$args);
  }
  function fs_dash_galleries_widget(){
    $args = wp_get_recent_posts( array('post_type'=>'ngg_gallery') );
    var_dump($args);
    fs_display_widget('newest_galleries',$args);
  }
  function fs_dash_orders_widget(){
    $args = wp_get_recent_posts( array('post_type'=>'ngg_order') );
    var_dump($args);
    fs_display_widget('newest_orders',$args);
  }

  // don't show useless metaboxes 
  function fs_handle_metaboxes(){

    $args = array('show_ui' => true);
    $types = get_post_types($args,'names');

    // cleanup dashboard boxes
    remove_meta_box( 'dashboard_activity', 'dashboard' , 'normal' ); 

    // add our dashboard boxes
    // add_meta_box('fs_shoot_widget', 'New Client Sessions', 'fs_dash_shoots_widget', 'dashboard', 'side', 'high');
    // add_meta_box('fs_galleries_widget', 'New Galleries', 'fs_dash_galleries_widget', 'dashboard', 'side', 'high');
    // add_meta_box('fs_orders_widget', 'Recent Orders', 'fs_dash_orders_widget', 'dashboard', 'side', 'high');

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
        #dashboard-widgets-wrap #normal-sortables .postbox,
        #dashboard-widgets-wrap #side-sortables .postbox,
        #dashboard-widgets-wrap #side-sortables .postbox,
        #dashboard-widgets-wrap #column3-sortables .postbox,
        #dashboard-widgets-wrap #column4-sortables .postbox,
        #dashboard-widgets-wrap #column5-sortables .postbox { border-radius: 10px; }
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