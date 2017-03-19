<?php
/*
  Photo handling and orders.
  All of NGG's data is serialized in the DB using their proprietary encode/decode
  Ngg_Serializable


*/


// customize the next gen gallery admin: called by apply_filters('ngg_manage_gallery_columns', $columns)
// add_action( 'ngg_manage_gallery_columns', 'fs_ngg_manage_gallery_columns' );
function fs_ngg_manage_gallery_columns($columns){
      // $picturelist = $nggdb->get_gallery($act_gid, $ngg->options['galSort'], $ngg->options['galSortDir'], false, 50, $start);      
      // $gallery_columns['thumbnail'] = __('Thumbnail', 'nggallery');
      return $columns;
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

// customize orders
function fs_ngg_order_details($retval,$order){
  var_dump($retval);
  var_dump($order);
  return $retval;
}
add_action( 'ngg_order_details', 'fs_ngg_order_details');

