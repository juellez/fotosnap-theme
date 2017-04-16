<?php
/*
  Photo handling and orders, extending NextGen Gallery Pro.
  If we switch from using that, these functions need adjusted/removed.
  FUN TIDBIT: All of NGG's data is serialized in the DB using their proprietary encode/decode: Ngg_Serializable
*/

/* ----------------------------
    GALLERY MANAGEMENT
----------------------------- */

// customize the next gen gallery admin: called by apply_filters('ngg_manage_gallery_columns', $columns)
// add_action( 'ngg_manage_gallery_columns', 'fs_ngg_manage_gallery_columns' );
function fs_ngg_manage_gallery_columns($columns){
      // $picturelist = $nggdb->get_gallery($act_gid, $ngg->options['galSort'], $ngg->options['galSortDir'], false, 50, $start);      
      // $gallery_columns['thumbnail'] = __('Thumbnail', 'nggallery');
      return $columns;
}

/* ---------------------------------
    PHOTO SHOOTS (BOOKINGS)

    emails used:
      email_photos_ready_reminder
      email_photos_ready
---------------------------------- */

add_filter('manage_shoot_posts_columns', 'fs_manage_shoot_columns', 11);
function fs_manage_shoot_columns($columns)
{
  // $columns['post_password'] = "Password";
  $columns['attached_gallery'] = "Photo Gallery / Password";
  $columns['fs_send_email'] = "Send Email";
  $columns['fs_customer'] = "Customer";
  $columns['fs_order'] = "Order(s)";
  return $columns;
}

// manage_edit-post_staff_columns

add_action('manage_shoot_posts_custom_column', 'fs_output_shoot_column', 9, 2);
function fs_output_shoot_column($column_name, $post_id)
{
    global $post;

    $lookup = fs_get_galleries_orders_meta();
    $sessions = $lookup['sessions'];

    switch ($column_name) {
        case 'post_password':
          echo $post->post_password;
          break;

        case 'fs_order':
          if( !empty($sessions[ $post_id ]->order) ){
            $order = $sessions[ $post_id ]->order;
            if( !empty($order->order_date) ){
              echo "{$order->order_date}<br>";
            }
            if( !empty($order->total) ){
              echo "items: {$order->number_images}<br>";
            }
            if( !empty($order->total) ){
              echo "total: {$order->total}";
            }
          }
          break;

        case 'attached_gallery':
          if( $gallery = get_field('photo_gallery', $post_id) ){
            $gid = $gallery[0]['ngg_id'];
            //Array ( [0] => Array ( [ngg_id] => 9 [ngg_form] => gallery ) )
            // get the track list 
            global $nggdb;
            $ngg_gallery = $nggdb->find_gallery($gid);
            //  stdClass Object ( [gid] => 9 [name] => 2017-feb-cupbar-annsanderson [slug] => 2017-Feb-CupBar-AnnSanderson [path] => /wp-content/gallery/2017-feb-cupbar-annsanderson [title] => 2017-Feb-CupBar-AnnSanderson [galdesc] => [pageid] => 0 [previewpic] => 0 [author] => 3 [extras_post_id] => 1506 [pricelist_id] => 0 [id_field] => gid [__defaults_set] => 1 )

            echo "<a href=\"/wp-admin/admin.php?page=nggallery-manage-gallery&mode=edit&gid={$gid}\">{$ngg_gallery->title}</a>";
            echo "<br>access code: ".$post->post_password;
          }
          break;

        case 'fs_customer':
          $first = get_field('customer_name', $post_id);
          $last = get_field('customer_last_name', $post_id);
          $email = get_field('customer_email_address', $post_id);
          echo "{$first} {$last} &lt;{$email}&gt;";
          break;

        case 'fs_send_email':
          $gallery = get_permalink($post);
          $password = $post->post_password;
          $to = get_field('customer_email_address', $post_id);
          // cache this shit
          $cache_key = 'fs-shoot-emails-col-'.$post_id;
          $content = get_transient($cache_key);
          // if not set, fetch a value & cache it
          if( true || $content === false ){
            $emails         = array(
                'email_photos_ready' =>'Ready <span class="dashicons dashicons-email-alt"></span>', //'Photos Ready Email', 
                'email_photos_ready_reminder' => 'Reminder <span class="dashicons dashicons-email-alt"></span>', //'Photos Ready Reminder'
              );
            $email_actions  = array('email_photos_ready' =>array(),        'email_photos_ready_reminder' => array());
            $history = fs_get_shoot_email_history($post_id);

            foreach($emails as $k => $l){
             $email_actions[$k][] = "<a href=\"/wp-admin/tools.php?page=sefa_email&event={$k}&id={$post_id}&to=[to]&gallery=[gallery]&password=[password]\">Send {$l}</a>";
            }
            foreach($history as $r){
              $on = mysql2date( 'm/d/y g:ia', $r->timestamp );
              $email_actions[$r->activity][] = "\_ {$on} "; // to {$r->meta['to']}
            }
            foreach($email_actions as $k => $rows){
              $email_actions[$k] = implode("<br>", $rows);
            }
            $content = implode("<br>", $email_actions);
            set_transient( $cache_key, $content, 28800 );
          }
          $content = str_replace("[to]", $to, $content);
          $content = str_replace("[password]", $password, $content);
          $content = str_replace("[gallery]", $gallery, $content);
          echo $content;
          break;
    }
}

// log the email, attached to the shoot record
add_action('fs_sefa_email_sent', 'fs_log_shoot_email',10,1);
function fs_log_shoot_email($args){
  $fs_shoot_id = isset( $_POST['fs_shoot_id'] ) ? trim($_POST['fs_shoot_id']) : 0;
  $action = isset( $_POST['fslog_event'] ) ? trim($_POST['fslog_event']) : 'email_photos_ready';

  // clear transients pulling this activity - see fs_output_shoot_column
  $cache_key = 'fs-shoot-emails-col-'.$fs_shoot_id;
  delete_transient( $cashe_key );

  if( $fs_shoot_id && function_exists('fslog_log_post_event') ){
    $meta = array(
      'to' => $args['to'],
      'subject' => $args['subject']
    );
    return fslog_log_post_event( $fs_shoot_id, $action, $meta);
  }
  return false;
}

// fetch the email history, attached to the shoot record
// email_photos_ready | email_photos_ready_reminder
function fs_get_shoot_email_history($shootID){
  if( function_exists('fslog_get_post_events') ){
    return fslog_get_post_events($shootID, array('email_photos_ready','email_photos_ready_reminder') );
  }
  return false;
}

// add fs_shoot_id to our sefa email form, so we can log it on success
add_action('fs_sefa_email_form', 'fs_add_shoot_email_tracking');
function fs_add_shoot_email_tracking(){
  $default_id = 0;
  $event = 'email_photos_ready';
  if( !empty($_GET['id']) ) $default_id = $_GET['id'];
  if( !empty($_GET['event']) ) $event = $_GET['event'];
  echo '<input type="hidden" name="fs_shoot_id" value="'.$default_id.'" />';
  echo '<input type="hidden" name="fslog_event" value="'.$event.'" />';
}


function fs_get_gallery_sessions_extended_q($all_or_linked='linked'){

  $q = "
  SELECT p.ID as session_id, p.post_title as session_name, 
  a.user_nicename as admin, p.post_date, CONCAT('https://fotosnap.co/gallery/',p.post_name) as url, 

  REPLACE( REPLACE(photo_gallery.meta_value, 'a:1:{i:0;a:2:{s:6:\"ngg_id\";i:', ''), ';s:8:\"ngg_form\";s:7:\"gallery\";}}', '') as gallery_id,
    
  session_date.meta_value as session_date,
  session_time.meta_value as session_time,
  customer_name.meta_value as customer_name,
  customer_last_name.meta_value as customer_last_name,
  customer_email_address.meta_value as customer_email_address,
  customer_mobile_phone.meta_value as customer_mobile_phone,
  photographer_user.meta_value as photographer_id,
    u.display_name as photographer_name,
  venue.meta_value as venue_id,
    v.post_title as venue_name

  FROM wp_posts p
  LEFT JOIN wp_users a ON (p.post_author = a.ID)
  LEFT JOIN wp_postmeta session_date ON (session_date.meta_key = \"session_date\" and session_date.post_id = p.ID)
  LEFT JOIN wp_postmeta session_time ON (session_time.meta_key = \"session_time\" and session_time.post_id = p.ID)
  LEFT JOIN wp_postmeta customer_name ON (customer_name.meta_key = \"customer_name\" and customer_name.post_id = p.ID)
  LEFT JOIN wp_postmeta customer_last_name ON (customer_last_name.meta_key = \"customer_last_name\" and customer_last_name.post_id = p.ID)
  LEFT JOIN wp_postmeta customer_mobile_phone ON (customer_mobile_phone.meta_key = \"customer_mobile_phone\" and customer_mobile_phone.post_id = p.ID)
  LEFT JOIN wp_postmeta customer_email_address ON (customer_email_address.meta_key = \"customer_email_address\" and customer_email_address.post_id = p.ID)
  LEFT JOIN wp_postmeta photographer_user ON (photographer_user.meta_key = \"photographer_user\" and photographer_user.post_id = p.ID)
    LEFT JOIN wp_users u ON photographer_user.meta_value = u.ID
  LEFT JOIN wp_postmeta venue ON (venue.meta_key = \"venue\" and venue.post_id = p.ID)
    LEFT JOIN wp_posts v ON venue.meta_value = v.ID
  LEFT JOIN wp_postmeta photo_gallery ON (photo_gallery.meta_key = \"photo_gallery\" and photo_gallery.post_id = p.ID)

  WHERE p.post_type = \"shoot\"
  ";
  if( $all_or_linked == 'linked' ){
    $q .= "AND p.post_status = 'publish' HAVING gallery_id > 0";
  }
  return $q;

}

/* ----------------------------
    PHOTO ORDERS
----------------------------- */

// we wanted to customize our order screen, but the short codes
// don't get parsed inside of html tags like <a href="[[digital_downloads_page_url]"
// so this filter fixes that. 11 means it'll run AFTER NGG
add_action( 'ngg_order_details', 'fs_ngg_order_details', 11, 2);
function fs_ngg_order_details($retval,$order){
  if( stristr($retval, "&#91;digital_downloads_page_url&#93;") ){
    $retval = str_replace("&#91;digital_downloads_page_url&#93;", $order->digital_downloads_page_url, $retval);
  }
  return $retval;
}

// remove NGG's default and add our better one -- so we can see the images ordered!
// remove_action(
//     'manage_ngg_order_posts_columns',
//     array('M_NextGen_Pro_Ecommerce', 'order_columns')
// );
add_filter('manage_ngg_order_posts_columns', 'fs_ngg_manage_order_columns', 11);
function fs_ngg_manage_order_columns($columns)
{
  unset($columns['title']);

  $columns['order_images'] = __('#', 'nggallery-gallery-pro');
  $columns['order_image_thumbs'] = __('Thumbnails', 'nggallery-gallery-pro');
  $columns['order_hash']      = __('ID', 'nextgen-gallery-pro');
  $columns['order_customer']  = __('Customer', 'nextgen-gallery-pro');
  $columns['order_photographer']  = __('Photog', 'nextgen-gallery-pro');
  $columns['order_venue']     = __('Venue', 'nextgen-gallery-pro');
  $columns['order_session_date']     = __('Session', 'nextgen-gallery-pro');
  $columns['order_status']    = __('Order Status', 'nextgen-gallery-pro');
  $columns['order_gateway']   = __('Payment Gateway', 'nextgen-gallery-pro');
  $columns['order_coupon']    = __('Coupon', 'nextgen-gallery-pro');
  $columns['order_total']     = __('Total', 'nextgen-gallery-pro');

  return $columns;
}

/* get list of all galleries and sessions linked to order
 * @return array keyed off of order ID
  public session_id -> string(4) "1617"
  public session_name -> string(28) "Ann @ Cup and Bar - Feb 2017"
  public admin -> string(5) "jewel"
  public post_date -> string(19) "2017-03-19 21:51:39"
  public url -> string(48) "https://fotosnap.co/gallery/ann-cup-bar-feb-2017"
  public gallery_id -> string(2) "11"
  public session_date -> string(0) ""
  public session_time -> string(0) ""
  public customer_name -> string(13) "Ann Sanderson"
  public customer_last_name -> string(9) "Sanderson"
  public customer_email_address -> string(15) "ann@fotosnap.co"
  public customer_mobile_phone -> string(0) ""
  public photographer_id -> string(1) "5"
  public photographer_name -> string(13) "Jewel Mlnarik"
  public venue_id -> string(4) "1294"
  public venue_name -> string(11) "Cup and Bar"
 */
function fs_get_galleries_orders_meta(){
  global $wpdb;
  static $lookup;
  if( empty($lookup) ){
    // lookup to sessions - 1 gallery to 1 session
    $galleries_sessions = array();
    // orders metadata
    $orders = array();
    // sessions metadata
    $sessions = array();
    $order_mapper = C_Order_Mapper::get_instance();

    // @todo throw this in a table and (a) only update when needed as this won't scale

    // 1. get all sessions linked to photo galleries - we don't care about the others
    $q = fs_get_gallery_sessions_extended_q();
    // d($q);
    $results = $wpdb->get_results( $q );
    foreach($results as $session){
      // adjust the data so we can read it...
      if( $session->session_date ){
        $date = date_create_from_format ( 'Ymd' , $session->session_date );
        $session->session_date_formatted = $date->format('Y/m/d');
      }      
      $sessions[ $session->session_id ] = $session;
      $galleries_sessions[ $session->gallery_id ] = $session->session_id;
    }
    // d($sessions);

    // 2. get all orders and parse them ... and then throw it back into a table or cache or something, arg!
    $q = 'SELECT cart.post_id as order_id, cart.meta_value as cart_data, DATE_FORMAT(p.post_date,\'%Y/%m/%d\') as order_date FROM wp_postmeta cart 
          INNER JOIN wp_posts p ON (p.ID = cart.post_id)  
          WHERE meta_key = "cart"';  
    $results = $wpdb->get_results($q);
    foreach($results as $order){
      $galleryid = 0;
      $entity = $order_mapper->unserialize($order->cart_data);
      unset($order->cart_data);
      // save some key order data for quicker reporting
      $order->total = $entity['total'];
      $order->number_images = sizeof($entity['images']);
      $order->image_ids = $entity['image_ids'];      
      // technically a cart can have multiple galleries even though that's not our case
      // d($entity);
      foreach($entity['images'] as $id => $row){
        // d($row);
        $galleryid = $row['galleryid'];
      }
      if( !empty($galleries_sessions[ $galleryid ]) ){
        $sessions[ $galleries_sessions[ $galleryid ] ]->order = $order;
        $orders[$order->order_id] = $sessions[ $galleries_sessions[ $galleryid ] ];
      }
      // d($entity);
    }
    $lookup['sessions'] = $sessions;
    $lookup['orders'] = $orders;
    d($lookup);
  }
  return $lookup;
}

// remove_action('manage_ngg_order_posts_custom_column', array('M_NextGen_Pro_Ecommerce', 'output_order_column'));
add_action('manage_ngg_order_posts_custom_column', 'fs_ngg_output_order_column', 9, 2);
function fs_ngg_output_order_column($column_name, $post_id)
{
    global $post;
    $lookup = fs_get_galleries_orders_meta();
    $orders = $lookup['orders'];
    $order_mapper = C_Order_Mapper::get_instance();
    $entity = $order_mapper->unserialize($post->post_content);
    switch ($column_name) {

        case 'order_photographer':          
          // grab the associated photographer by checking our lookup table
          if( !empty($orders[$post_id]->photographer_name) ){
            echo $orders[$post_id]->photographer_name;
          }
          break;

        case 'order_venue':
          if( !empty($orders[$post_id]->venue_name) ){
            echo $orders[$post_id]->venue_name;
          }
          break;

        case 'order_session_date':
          if( !empty($orders[$post_id]->session_date_formatted) ){
            echo $orders[$post_id]->session_date_formatted;
          }
          echo "<br>";
          if( !empty($orders[$post_id]->session_time) ){
            echo $orders[$post_id]->session_time;
          }
          echo "<br><a href='./post.php?post={$orders[$post_id]->session_id}&action=edit'>edit/view</a>";
          break;

        case 'order_image_thumbs':
          foreach($entity['cart']['images'] as $id => $row){
            $full = str_replace("/thumbs/thumbs_", "/", $row['thumbnail_url']);
            echo "<a href='/wp-admin/admin.php?page=nggallery-manage-gallery&mode=edit&gid={$row['galleryid']}'><img width='100' src='{$row['thumbnail_url']}'></a>";
          }
          break;

        case 'order_images':
          echo $entity['item_count'];
          break;
    }

    // $order = Ngg_Serializable::unserialize($post->post_content);
    // [item_count] => 2
    // [file_list] => hams-1.jpg,somb-1.jpg
    // [cart] => Array
    //         (
    //             [images] => Array
    //                 (
    //                     [55] => Array
    //                         (
    //                             [pid] => 55
    //                             [thumbnail_url] => http://fs.wanderlustpdx.com/wp-content/gallery/client-test/thumbs/thumbs_hams-1.jpg
    //                      ...
    //            [image_ids] => Array
    //               (
    //                   [0] => 55
    //                   [1] => 57
    //                )
    // [item_count] => 1
    // [emails_sent] => 1
}
