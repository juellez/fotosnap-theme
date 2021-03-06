<?php
/*
Template Name: Portfolio Grid
*/
get_header();
?>
<div id="primary" class="content-area">
  <main id="main" class="site-main athena-page" role="main">

    <?php get_template_part('template-parts/content', 'page'); ?>

    <div id="content" class="container">
      <div class="row">
          <div class="main <?php echo kadence_main_class(); ?>" id="ktmain" role="main">
            <?php if ( ! post_password_required() ) { ?>
        <div class="entry-content" itemprop="mainContentOfPage">
          <?php get_template_part('templates/content', 'page'); ?>
        </div>
            <?php 
            global $post, $virtue_premium; 
            
            if(isset($virtue_premium['virtue_animate_in']) && $virtue_premium['virtue_animate_in'] == 1) {
              $animate = 1;
            } else {
              $animate = 0;
            }
            $portfolio_category = get_post_meta( $post->ID, '_kad_portfolio_type', true );
          $portfolio_items = get_post_meta( $post->ID, '_kad_portfolio_items', true );
          $portfolio_order = get_post_meta( $post->ID, '_kad_portfolio_order', true );
          $portfolio_filter = get_post_meta( $post->ID, '_kad_portfolio_filter', true );
          $portfolio_column = get_post_meta( $post->ID, '_kad_portfolio_columns', true );
          $portfolio_item_excerpt = get_post_meta( $post->ID, '_kad_portfolio_item_excerpt', true );
          $portfolio_item_types = get_post_meta( $post->ID, '_kad_portfolio_item_types', true );
          $portfolio_cropheight = get_post_meta( $post->ID, '_kad_portfolio_img_crop', true );
          $portfolio_crop = get_post_meta( $post->ID, '_kad_portfolio_crop', true );
          $portfolio_lightbox = get_post_meta( $post->ID, '_kad_portfolio_lightbox', true );

          if(isset($portfolio_order)) {
            $p_orderby = $portfolio_order;
          } else {
            $p_orderby = 'menu_order';
          }
          if($p_orderby == 'menu_order' || $p_orderby == 'title') {$p_order = 'ASC';} else {$p_order = 'DESC';}
        
        if($portfolio_category == '-1' || empty($portfolio_category)) {
          $portfolio_cat_slug = ''; $portfolio_cat_ID = ''; 
        } else {
          $portfolio_cat = get_term_by ('id',$portfolio_category,'portfolio-type' );
          $portfolio_cat_slug = $portfolio_cat -> slug;
          $portfolio_cat_ID = $portfolio_cat -> term_id;
        }
        $portfolio_category = $portfolio_cat_slug;
        if($portfolio_items == 'all') { 
          $portfolio_items = '-1'; 
        }
                
            if ($portfolio_column == '2') {$itemsize = 'tcol-md-6 tcol-sm-6 tcol-xs-12 tcol-ss-12'; $slidewidth = 560; $slideheight = 560;} 
            else if ($portfolio_column == '3'){ $itemsize = 'tcol-md-4 tcol-sm-4 tcol-xs-6 tcol-ss-12'; $slidewidth = 366; $slideheight = 366;} 
            else if ($portfolio_column == '1'){ $itemsize = 'tcol-md-12 tcol-sm-12 tcol-xs-12 tcol-ss-12'; $slidewidth = 1140; $slideheight = 1140;} 
            else if ($portfolio_column == '6'){ $itemsize = 'tcol-md-2 tcol-sm-3 tcol-xs-4 tcol-ss-6'; $slidewidth = 240; $slideheight = 240; } 
            else if ($portfolio_column == '5'){ $itemsize = 'tcol-md-25 tcol-sm-3 tcol-xs-4 tcol-ss-6'; $slidewidth = 240; $slideheight = 240;} 
            else {$itemsize = 'tcol-md-3 tcol-sm-4 tcol-xs-6 tcol-ss-12'; $slidewidth = 270; $slideheight = 270;}
            
            $crop = true;
            if (!empty($portfolio_cropheight)){
              $slideheight = $portfolio_cropheight; 
            } 
            if ($portfolio_crop == 'no'){ $slideheight = ''; $crop = false; } 
                
                if ($portfolio_lightbox == 'yes'){
                  $plb = 'true';
                } else {
                $plb = 'false';
              }
              if($portfolio_item_excerpt == true) {
                  $showexcerpt = 'true';
              } else {
                $showexcerpt = 'false';
              }
              if($portfolio_item_types == true) {
                  $portfolio_item_types = 'true';
        } else {
          $portfolio_item_types = 'false';
        }

              global $kt_portfolio_loop;
                 $kt_portfolio_loop = array(
                  'lightbox' => $plb,
                  'showexcerpt' => $showexcerpt,
                  'showtypes' => $portfolio_item_types,
                  'slidewidth' => $slidewidth,
                  'slideheight' => $slideheight,
                  );
                  ?>

               <div id="portfoliowrapper" class="init-isotope rowtight" data-fade-in="<?php echo esc_attr($animate);?>" data-iso-selector=".p-item" data-iso-style="masonry" data-iso-filter="true"> 
   
            <?php 
        $temp = $wp_query; 
          $wp_query = null; 
          $wp_query = new WP_Query();
          $wp_query->query(array(
          'paged' => $paged,
          'orderby' => $p_orderby,
          'order' => $p_order,
          'post_type' => 'portfolio',
          'portfolio-type'=>$portfolio_cat_slug,
          'posts_per_page' => $portfolio_items
          )
          );
          
          if ( $wp_query ) : 
               
          while ( $wp_query->have_posts() ) : $wp_query->the_post();
            $terms = get_the_terms( $post->ID, 'portfolio-type' );
            if ( $terms && ! is_wp_error( $terms ) ) : 
              $links = array();
                foreach ( $terms as $term ) { $links[] = $term->slug;}
              $links = preg_replace("/[^a-zA-Z 0-9]+/", " ", $links);
              $links = str_replace(' ', '-', $links); 
              $tax = join( " ", $links );   
            else :  
              $tax = '';  
            endif;
            ?>
          <div class="<?php echo esc_attr($itemsize); ?> <?php echo strtolower($tax); ?> all p-item">
                  <?php do_action('kadence_portfolio_loop_start');
              get_template_part('templates/content', 'loop-portfolio'); 
              do_action('kadence_portfolio_loop_end');
          ?>
                    </div>
          <?php endwhile; else: ?>
           
          <li class="error-not-found"><?php _e('Sorry, no portfolio entries found.', 'virtue');?></li>
            
        <?php endif; ?>
                </div> <!--portfoliowrapper-->
                                    
                    <?php  
                    $wp_query = null; 
                    $wp_query = $temp;  // Reset
                    wp_reset_query(); ?>

                    <?php global $virtue_premium; if(isset($virtue_premium['page_comments']) && $virtue_premium['page_comments'] == '1') { comments_template('/templates/comments.php');} ?>

<?php } else { ?>
      <?php echo get_the_password_form();
    }?>


  </main>
</div>