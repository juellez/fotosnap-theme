<?php
/**
 * Template Name: Photographer
 */
get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main athena-page" role="main">

        <?php while (have_posts()) : the_post(); ?>

            <div class="row">
                
                <div class="col-sm-8">
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div class="entry-content">
                            <h1><a href="/photographers/">Photographers</a></h1>
                            <h2><?php the_title() ?></h2>
                            <?php the_content(); ?>
                            <br>
                            <br>
                            <?php 
                                ob_start(); 
                                fs_show_related_photogs_venues('venue');
                                $output = ob_get_contents();
                                ob_end_clean();
                                if( $output ){
                                    echo '<h3>Favorite + Recent Locations</h3>';
                                    echo $output;
                                }
                            ?>
                        </div>
                    </article>
                </div>

                <div class="col-sm-3 col-sm-offset-1">
                    <?php if (get_post_thumbnail_id($post->ID)) : ?>
                            <img src="<?php echo wp_get_attachment_url(get_post_thumbnail_id($post->ID)) ?>" alt="<?php the_title() ?>" 
                                class="photographer-avatar pull-right">
                    <?php endif; ?>
                </div>
            </div>

        <?php endwhile; // End of the loop. ?>

    </main><!-- #main -->
    
</div><!-- #primary -->

<?php get_footer(); ?>