<?php
/**
 * Template Name: Photographer
 */
get_header();

if( is_page() && $post->post_parent > 0 ) { 
  // post has parents
  $photog = true;

  /*
  $children = get_pages('child_of='.$post->ID);
  if( count( $children ) != 0 ) {
    // display sidebar-menu layout
  }

  $parent = get_post_ancestors($post->ID);
  if( count( $children ) <= 0  && empty($parent[1]) ) {
    // display full-width layout
  } elseif ( count( $children ) <= 0  && !empty($parent[1]) )  {
    // display sidebar-menu layout
  }
  */
}
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main athena-page" role="main">

        <div class="portfolionav clearfix">
            <a href="/photographers/mike/" rel="prev" title="Mike"><i class="icon-arrow-left"></i></a>
            <a href="http://fotosnap.co/photographers/"><i class="icon-grid"></i></a> 
            <a href="http://fotosnap.co/portfolio/katelyn/" rel="next" title="Katelyn"><i class="icon-arrow-right"></i></a>
        </div>

        <?php while (have_posts()) : the_post(); ?>

            <div class="row">
                
                <div class="col-sm-3">
                <?php if( $photog ): ?>
                    <?php if (get_post_thumbnail_id($post->ID)) : ?>
                            <img src="<?php echo wp_get_attachment_url(get_post_thumbnail_id($post->ID)) ?>" alt="<?php the_title() ?>" 
                                class="photographer-avatar pull-right">
                    <?php endif; ?>
                <?php else: ?>
                    <br><br>
                    <small>Love capturing confidence, beauty, smiles and striking profiles? Join our FotoSnap photographers.</small>
                    <br><br>
                    <a href="apply" class="athena-button primary large">Apply</a>
                <?php endif; ?>
                </div>

                <div class="col-sm-1">
                </div>

                <div class="col-sm-8">
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div class="entry-content">
                            <?php if( $photog ): ?>
                                <h1><a href="/photographers/">Photographers</a></h1>
                                <h2><?php the_title() ?></h2>

                                <?php the_content(); ?>
                                <?php
                                wp_link_pages(array(
                                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'athena'),
                                    'after' => '</div>',
                                ));
                                ?>
                            <?php else: ?>

                                <h1>Photographers</h1>
                                <?php // the_content(); ?>
                                <?php fs_show_children() ?>

                            <?php endif; ?>
                        </div><!-- .entry-content -->

                        <footer class="entry-footer">
                            <?php
                            edit_post_link(
                                    sprintf(
                                            /* translators: %s: Name of current post */
                                            esc_html__('Edit %s', 'athena'), the_title('<span class="screen-reader-text">"', '"</span>', false)
                                    ), '<span class="edit-link">', '</span>'
                            );
                            ?>
                        </footer><!-- .entry-footer -->

                    </article><!-- #post-## -->
                </div>
            </div>

        <?php endwhile; // End of the loop. ?>

    </main><!-- #main -->
    
</div><!-- #primary -->

<?php get_footer(); ?>