<?php
/**
 * Template Name: Book Now / Calendar
 */
get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main athena-page" role="main">

        <?php while (have_posts()) : the_post(); ?>


            <?php if (get_post_thumbnail_id($post->ID)) : ?>
                <div id="athena-page-jumbotron" class="parallax-window" data-parallax="scroll" data-image-src="<?php echo wp_get_attachment_url(get_post_thumbnail_id($post->ID)) ?>">
                    <div class="dark-overlay"></div>
                    <div class="dark-overlay-text">

                        <header class="entry-header">
                            <h1 class="entry-title">Book a Convenient Time</h1>
                        </header><!-- .entry-header -->

                        <?php // see if there's a cta to throw into this header space
                            $cta_url = get_post_meta( $post->ID, 'cta_url', true );
                            $cta_track_action = get_post_meta( $post->ID, 'cta_track_action', true );
                            $cta_label = get_post_meta( $post->ID, 'cta_label', true );
                            if( $cta_url && $cta_label ): ?>
                            <div class="center">
                                <a class="ga-track athena-button primary large" href="<?=$cta_url ?>" data-track-event-category="header cta" 
                            data-track-event-action="<?=$cta_track_action ?>" 
                            data-track-event-label="<?=$cta_label ?>" 
                            title="<?=$cta_label ?>"><?=$cta_label ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <br><br>
            <?php endif; ?>

            <div class="row">
                
                <?php get_sidebar('left'); ?>
                
                <div class="col-sm-<?php echo athena_main_width(); ?>">

                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                        <div class="entry-content">
                            <?php the_content(); ?>

                            <iframe id="zozi-advance-calendar-iframe" style="width: 100%; height: 100%;" width="100" height="50" frameborder="0" scrolling="no" seamless="seamless" data-src="https://a.zozi.com/#/promote/widgets/fotosnapor/calendar"></iframe>

                            <script src="https://a.zozi.com/assets/widgets/calendar.origin.js"></script>

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

                <?php get_sidebar(); ?>

            </div>

        <?php endwhile; // End of the loop. ?>

    </main><!-- #main -->
    
</div><!-- #primary -->

<?php get_footer(); ?>