<?php
/**
 * Template Name: Book Now / Calendar
 */
if( $_COOKIE['fsref'] ){
    // they clicked through from a referral - track this
    $cookie = unserialize($_COOKIE['fsref']);
    // referral, referral_code, referrer_name
}
else {
    $cookie = false;
}
get_header();

// @todo load iFrame faster
// e.g. http://www.aaronpeters.nl/blog/iframe-loading-techniques-performance?%3E
?>
<div id="primary" class="content-area">
    <main id="main" class="site-main athena-page" role="main">

        <?php while (have_posts()) : the_post(); ?>

            <?php /*
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
            */ ?>

            <div class="row" style="min-height: 800px">

                <h1 class="title">Book Now</h1>

                <p>Select a time slot on the calendar to <strong>book a photoshoot instantly</strong>. <em>(Sometimes it can take the calendar a moment to load.)</em>
                
                You can also <a href="/contact" class="ga-track" data-track-event-category="bookings" data-track-event-action="contact us">request a PopUp near you</a> &mdash; and join our mailing list to 
                <a href="http://eepurl.com/bB6v6j"
                        data-track-event-category="cta"
                        data-track-event-action="clicks to join mailing list"
                        data-track-event-label="Join our Mailing List"
                       class="ga-track">be alerted in a few weeks</a>, when new PopUps are announced.</p>

                <!-- FareHarbor calendar of all items -->
<script src="https://fareharbor.com/embeds/script/calendar/fotosnap/?fallback=simple&full-items=yes"></script>
<!-- FareHarbor item grid of all items -->
<script src="https://fareharbor.com/embeds/script/items/fotosnap/?full-items=yes&fallback=simple"></script>
        <?php endwhile; // End of the loop. ?>

    </main><!-- #main -->
    
</div><!-- #primary -->

<?php if( $cookie ): ?>
<script type="text/javascript">
(function($){
    $(window).load(function() {
        ga('send', 'event', 'referral', 'pageview','<?=$cookie['referral'] ?>');
    });
})(jQuery);
</script>
<?php endif; ?>

<?php get_footer(); ?>