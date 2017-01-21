<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Athena
 */
get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main athena-page" role="main">

            <div class="row">
                
                <div class="col-sm-8">
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div class="entry-content">

                                <h1><a href="/blog">FotoSnap Pro Tips + Blog</a></h1>


                                <?php /* Start the Loop */ ?>
                                <?php while (have_posts()) : the_post(); ?>

                                    <?php get_template_part('template-parts/content-blog', get_post_format()); ?>

                                <?php endwhile; ?>


                        </div><!-- .entry-content -->
                    </article><!-- #post-## -->
                </div>

                <div class="col-sm-3 col-sm-offset-1">
                    <br><br>
                    <h3>Don't Miss Out</h3>
                    <small>Join our mailing list to discover how you can make your best first impression&mdash;and be the first 
                      to hear about new pop-up shoots and locations.</small>

                    <br><br>

                    <a href="http://eepurl.com/bB6v6j"
                        data-track-event-category="cta"
                        data-track-event-action="clicks to join mailing list"
                        data-track-event-label="Join our Mailing List"
                       class="ga-track athena-button default large">Join our Mailing List</a>  

                    <br><br>
                    <br><br>

                    <h3>The City is our Studio</h3>

                    <?php fs_show_venues('active',$post->ID,1) ?>

                </div>
            </div>

    </main><!-- #main -->
    
</div><!-- #primary -->

<?php get_footer(); ?>
