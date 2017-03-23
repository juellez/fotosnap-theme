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

/* ----------------------------
    PHOTO SHOOTS (BOOKINGS)
----------------------------- */

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
          global $post;
          echo $post->post_password;
            // echo $post_id
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
          $to = get_field('customer_email', $post);
          echo "<a href=\"/wp-admin/tools.php?page=sefa_email&gallery={$gallery}&password={$password}&to={$to}\">Preview + Send Email</a>";
          // http://fotosnap.dev/wp-admin/tools.php?page=sefa_email&gallery=something&password=else&to=jewel%40mlnarik.com
          break;
    }
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
