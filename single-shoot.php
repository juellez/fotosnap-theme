<?php
/**
 * Single client shoot
 */
get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main athena-page" role="main">

        <?php while (have_posts()) : the_post(); ?>

            <div class="row">
                
                <?php get_sidebar('left'); ?>
                
                <div class="col-sm-<?php echo athena_main_width(); ?>">

                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                        <div class="entry-content">
                            <?php 
                            global $nggdb;

                            if( $gallery = get_field('photo_gallery', $post_id) ): ?>

                              <h1><?= $ngg_gallery->title ?></h1>

                              <?php if ( post_password_required() ) : ?>
                                  <?php echo get_the_password_form(); ?>
                              <?php else : ?>

                                <?php  
                                  // display the gallery
                                  $gid = $gallery[0]['ngg_id'];

                                  $ngg_gallery = $nggdb->find_gallery($gid);
                                  //  stdClass Object ( [gid] => 9 [name] => 2017-feb-cupbar-annsanderson [slug] => 2017-Feb-CupBar-AnnSanderson [path] => /wp-content/gallery/2017-feb-cupbar-annsanderson [title] => 2017-Feb-CupBar-AnnSanderson [galdesc] => [pageid] => 0 [previewpic] => 0 [author] => 3 [extras_post_id] => 1506 [pricelist_id] => 0 [id_field] => gid [__defaults_set] => 1 ) ?>

                                <p>You look great! <a href="/shopping-cart/" id='ngg_checkout_btn'>View Cart / Checkout</a></p>

                                <?php

                                  $shortcode = '[ngg_images source="galleries" container_ids="'.$gid.'" display_type="photocrati-nextgen_pro_film" override_thumbnail_settings="0" thumbnail_width="240" thumbnail_height="160" thumbnail_crop="0" images_per_page="20" image_spacing="5" border_size="1" frame_size="20" border_color="#CCCCCC" frame_color="#FFFFFF" ngg_triggers_display="always" ngg_proofing_display="0" captions_enabled="0" captions_display_sharing="1" captions_display_title="1" captions_display_description="1" captions_animation="slideup" is_ecommerce_enabled="1" order_by="sortorder" order_direction="ASC" returns="included" maximum_entity_count="500"]';

                                  echo do_shortcode($shortcode);

                                ?>
                              
                                <?php the_content(); ?>

                                <p>You'll be able to download your images immediately upon checkout and you'll also receive an email with a confirmation and link, so you can download later to your computer or phone. When you download your photos, the watermark found at the bottom will have been removed. There's no limit to how many times you can download your photos.</p>

                                <?php endif; // end protected content ?>

                              <?php else: ?>

                              <p>We'll let you know as soon as your photos are uploaded!</p>

                            <?php  endif; ?>
                        </div><!-- .entry-content -->

                    </article><!-- #post-## -->
                </div>

                <?php get_sidebar(); ?>

            </div>

        <?php endwhile; // End of the loop. ?>

    </main><!-- #main -->
    
</div><!-- #primary -->

<?php get_footer(); ?>