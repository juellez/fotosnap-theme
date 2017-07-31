<?php
/**
 * Photographer upload page. Allows photographer to create or edit a session.
 * Still requires an admin to edit/review the gallery before sending to the client.
 */
get_header();
?>
<style>
    .error {
    padding: 10px 20px 0;
    margin-bottom: 20px;
    background-color: #e8e8e8;
    font-weight: bold;
    }
</style>
<div id="primary" class="content-area">
    <main id="main" class="site-main athena-page" role="main">

        <?php while (have_posts()) : the_post(); ?>

            <div class="row">
                                
                <div class="col-sm-<?php echo athena_main_width(); ?>">

                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                        <div class="entry-content">

                            <?php the_content(); ?>

                        </div><!-- .entry-content -->

                    </article><!-- #post-## -->
                </div>

            </div>

        <?php endwhile; // End of the loop. ?>

    </main><!-- #main -->
    
</div><!-- #primary -->

<?php get_footer(); ?>