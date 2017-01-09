<?php
/**
 * Template Name: Location / Venue
 */
get_header();

$venue = false;
$active = false;
$zozi_id = 0;

if( is_page() && $post->post_parent > 0 ) { 
  // post has parents
  $venue = true;
  $zozi_id = get_post_meta( $post->ID, 'zozi_product_id', true );
  $active = has_term( 'active', 'status', $post );
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

            <?php if (get_post_thumbnail_id($post->ID)) : ?>
                <div id="athena-page-jumbotron" class="parallax-window" data-parallax="scroll" data-image-src="<?php echo wp_get_attachment_url(get_post_thumbnail_id($post->ID)) ?>">
                    <div class="dark-overlay"></div>
                    <div class="dark-overlay-text">

                        <header class="entry-header center">
                            <small><a href="/venues/">Pop-Up Studio <?= $venue ? "Locations" : "" ?></a></small>
                            <h1 class="entry-title">
                                <?php the_title() ?>
                            </h1>
                        </header><!-- .entry-header -->

                        <?php // see if there's a booking button to display
                            if( $active && $zozi_id ): ?>
                        <script src="https://a.zozi.com/assets/widgets/bookit.js"></script>
                        <div class="center">
                            <div id="zozi_advance_activity_<?=$zozi_id ?>" class="zozi-advance-button-container"><a class="ga-track athena-button primary large"
                                href="https://a.zozi.com/#/express/fotosnapor/products/<?=$zozi_id ?>" target="_blank">Book It!</a></div>
                        </div>
                        <?php endif; ?>

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
                
                <div class="col-sm-3">

                <?php if( $venue ):
                    echo '<div class="row venue-gallery">';
                    if( !$active ){
                        echo '<br><br><small>Typically available weekends before 10am.</small>';
                        echo '<a class="ga-track athena-button primary large"
                                href="typeform" target="_blank">Request It!</a>';
                        echo '<br><br><small>Typically available weekends before 10am.</small>';
                    }
                    $media = get_attached_media( 'image' );
                    foreach($media as $img):
                        $url = wp_get_attachment_image_src($img->ID,'thumbnail');
                        echo '<div class="col-xs-6"><img src="'.$url[0].'" /></div>';
                    endforeach;
                    echo '</div>';
                else: ?>
                    <small>Want to be the first to know when a new location is added?</small>
                    <br><br>
                    <a href="http://eepurl.com/bB6v6j"
                        data-track-event-category="cta"
                        data-track-event-action="clicks to join mailing list"
                        data-track-event-label="Join Now"
                       class="ga-track athena-button primary large">Get Notified</a>                            

                    <br><br>
                    <small>Have a fun venue or location in mind for a pop-up studio?</small>
                    <br><br>
                    <a href="host" class="athena-button default large">Learn More</a>
                    <br><br>
                    <br><br>
                <?php endif; ?>
                </div>

                <div class="col-sm-8 col-sm-offset-1">
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div class="entry-content">
                            <?php if( $venue ): ?>
                                <?php the_content(); ?>

                                    <div class="callout">
                                        <small>Whether you are online looking for a job or a date, a selfie is a bad way to make a good impression. Instead, book a FotoSnap mini photo session! We offer fun locations to fit your personality and convenient times to fit your schedule. Just $49 and a 15 minute session gets you a professional photo to use on all your online profiles.</small>
                                    </div>

                                <?php
                                wp_link_pages(array(
                                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'athena'),
                                    'after' => '</div>',
                                ));
                                ?>
                            <?php else: ?>

                                <h2>Upcoming: Available for Booking</h2>
                                <?php // the_content(); ?>
                                <?php fs_show_children('active') ?>


                                <h2>Where We've Been ... and may return</h2>
                                <?php // the_content(); ?>
                                <?php fs_show_children('archived') ?>

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

<script type="text/javascript" src="//s3.amazonaws.com/downloads.mailchimp.com/js/signup-forms/popup/embed.js" data-dojo-config="usePlainJson: true, isDebug: false"></script><script type="text/javascript">require(["mojo/signup-forms/Loader"], function(L) { L.start({"baseUrl":"mc.us11.list-manage.com","uuid":"d40bd49ac434fceb17a599c6e","lid":"3da796abc2"}) })</script>

<?php get_footer(); ?>