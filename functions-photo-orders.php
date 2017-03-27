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
  return $columns;
}

// manage_edit-post_staff_columns

add_action('manage_shoot_posts_custom_column', 'fs_output_shoot_column', 9, 2);
function fs_output_shoot_column($column_name, $post_id)
{
    global $post;
    switch ($column_name) {
        case 'post_password':
          echo $post->post_password;
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
            echo "<br>password: ".$post->post_password;
          }
          break;

        case 'fs_send_email':
          $gallery = get_permalink($post);
          $password = $post->post_password;
          $to = get_field('customer_email_address', $post_id);
          // cache this shit
          $cache_key = 'fs-shoot-emails-col-'.$post_id;
          $content = get_transient($cache_key);
          // if not set, fetch a value & cache it
          if( $content === false ){
            $emails         = array('email_photos_ready' =>'Photos Ready Email', 'email_photos_ready_reminder' => 'Photos Ready Reminder');
            $email_actions  = array('email_photos_ready' =>array(),        'email_photos_ready_reminder' => array());
            $history = fs_get_shoot_email_history($post_id);

            foreach($emails as $k => $l){
             $email_actions[$k][] = "<a href=\"/wp-admin/tools.php?page=sefa_email&event={$k}&id={$post_id}&to=[to]&gallery=[gallery]&password=[password]\">Send {$l}</a>";
            }
            foreach($history as $r){
              $email_actions[$r->activity][] = "\_ sent on {$r->timestamp} to {$r->meta['to']}";
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
  $columns['order_status']    = __('Order Status', 'nextgen-gallery-pro');
  $columns['order_gateway']   = __('Payment Gateway', 'nextgen-gallery-pro');
  $columns['order_coupon']    = __('Coupon', 'nextgen-gallery-pro');
  $columns['order_total']     = __('Total', 'nextgen-gallery-pro');

  return $columns;
}

// remove_action('manage_ngg_order_posts_custom_column', array('M_NextGen_Pro_Ecommerce', 'output_order_column'));
add_action('manage_ngg_order_posts_custom_column', 'fs_ngg_output_order_column', 9, 2);
function fs_ngg_output_order_column($column_name, $post_id)
{
    global $post;
    $order_mapper = C_Order_Mapper::get_instance();
    $entity = $order_mapper->unserialize($post->post_content);
    switch ($column_name) {

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
