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

                <p>Select a time slot on the calendar to <strong>book a photoshoot instantly</strong>.
                Have a specific place in mind? Filter the calendar by location.
                Don’t see a time slot or location that works well for you? 
                <a href="/contact" class="ga-track" data-track-event-category="bookings" data-track-event-action="contact us">Let us know</a> a few times or places you’d love to see and we’ll do our best to make it happen.</p>

                <?php // the_content(); ?>

                <div class="zozi-frame-wrapper">

                    <iframe data-src="https://a.zozi.com/#/embed/fotosnapor/calendar?embedOptions=%7B%22merchantCode%22%3A%22fotosnapor%22%2C%22view%22%3A%22month%22%2C%22productIDs%22%3A%22%22%2C%22capacityDisplay%22%3A%22text%22%2C%22capacityText%22%3A%22BOOK%22%2C%22soldOutDisplay%22%3A%22text%22%2C%22soldOutText%22%3A%22Sold%20Out%22%2C%22includeName%22%3Anull%2C%22pastDatesBehavior%22%3A%22hide%22%2C%22allowAddonsPriceRollup%22%3A%22true%22%2C%22availabilityView%22%3A%22first%22%2C%22modalButtonText%22%3A%22Open%20Calendar%22%2C%22listButtonText%22%3A%22Book%20Now%22%2C%22buttonTextColor%22%3A%22%23FFFFFF%22%2C%22iconColor%22%3A%22%23000000%22%2C%22checkoutButtonColor%22%3A%22%23F0722C%22%2C%22accentColor%22%3A%22%23f37521%22%2C%22allowLocationHashControl%22%3A%22true%22%2C%22productContent%22%3A%22show%22%2C%22showProductsPage%22%3A%22hide%22%2C%22defaultOpenView%22%3A%22app.embed.merchant.calendarWidget%22%2C%22addonsPage%22%3A%22show%22%2C%22buttonBackground%22%3A%22%23FF8200%22%2C%22lowerMaxQuantitySelectableLimit%22%3A1000%2C%22upperMaxQuantitySelectableLimit%22%3A10000%7D" data-allow-hashchange="true" frameborder="0" id="zozi-embedded-checkout" scrolling="no" seamless="seamless" class="zozi-frame-full"></iframe><script src="https://a.zozi.com/assets/widgets/embedded.origin.js"></script>

                </div>

                <br><br>

                <div class="center">
                    <br><br>
                    <small>Want to be the first to know when a new location is added?</small>
                    <br><br>
                    <a href="http://eepurl.com/bB6v6j"
                        data-track-event-category="cta"
                        data-track-event-action="clicks to join mailing list"
                        data-track-event-label="Join our Mailing List"
                       class="ga-track athena-button primary large">Join our Mailing List</a>                            
               </div>

                <br><br>
                <br><br>

                <?php fs_show_venues('active') ?>

                <br><br>
                <br><br>

            </div>

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