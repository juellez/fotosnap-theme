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

        <?php while (have_posts()) : the_post(); ?>

            <div class="row">
                
                <div class="col-sm-8">
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div class="entry-content">

                                <h1><a href="/blog">FotoSnap Pro Tips + Blog</a></h1>
                                <h2><?php the_title() ?></h2>

                                <?php the_content(); ?>
                                <?php
                                wp_link_pages(array(
                                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'athena'),
                                    'after' => '</div>',
                                ));
                                ?>
                        </div><!-- .entry-content -->

                    <div class="center">
                      <a href="/book"
                        data-track-event-category="cta"
                        data-track-event-action="clicks to book"
                        data-track-event-label="FotoSnap Your Profile Today!"
                       class="ga-track athena-button primary large">FotoSnap Your Profile Today!</a></div>

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

        <?php endwhile; // End of the loop. ?>

    </main><!-- #main -->
    
</div><!-- #primary -->

<?php get_footer(); ?>
