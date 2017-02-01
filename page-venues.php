<?php
/**
 * Template Name: Location / Venue
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

                        <header class="entry-header center">
                            <small><a href="/venues/">Pop-Up Photo Studio <?= $venue ? "Locations" : "" ?></a></small>
                            <h1 class="entry-title">
                                <?php the_title() ?>
                            </h1>
                            <?php if( $active && $zozi_id ): ?>
                              <?php the_content(); ?>
                            <?php endif; ?>
                        </header>

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
                    <a href="/host" 
                        data-track-event-category="cta"
                        data-track-event-action="clicks to host/request"
                        data-track-event-label="Learn More"
                        class="athena-button default large">Learn More</a>
                    <br><br>
                    <br><br>

                </div>

                <div class="col-sm-8 col-sm-offset-1">
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div class="entry-content">

                        <?php /* potential to pull straight from zozi 
                            <iframe data-src="https://a.zozi.com/#/embed/fotosnapor/products-list?embedOptions=%7B%22merchantCode%22%3A%22fotosnapor%22%2C%22view%22%3A%22month%22%2C%22productIDs%22%3A%22%22%2C%22capacityDisplay%22%3A%22text%22%2C%22capacityText%22%3A%22BOOK%22%2C%22soldOutDisplay%22%3A%22text%22%2C%22soldOutText%22%3A%22Sold%20Out%22%2C%22includeName%22%3Anull%2C%22pastDatesBehavior%22%3A%22hide%22%2C%22allowAddonsPriceRollup%22%3A%22true%22%2C%22availabilityView%22%3A%22first%22%2C%22modalButtonText%22%3A%22Open%20Calendar%22%2C%22listButtonText%22%3A%22Browse%20%2B%20Book%22%2C%22buttonTextColor%22%3A%22%23FFFFFF%22%2C%22iconColor%22%3A%22%23000000%22%2C%22checkoutButtonColor%22%3A%22%23F0722C%22%2C%22accentColor%22%3A%22%23f37521%22%2C%22allowLocationHashControl%22%3A%22true%22%2C%22productContent%22%3A%22show%22%2C%22showProductsPage%22%3A%22hide%22%2C%22defaultOpenView%22%3A%22app.embed.merchant.calendarWidget%22%2C%22addonsPage%22%3A%22show%22%2C%22buttonBackground%22%3A%22%23FF8200%22%2C%22lowerMaxQuantitySelectableLimit%22%3A1000%2C%22upperMaxQuantitySelectableLimit%22%3A10000%7D" data-allow-hashchange="true" frameborder="0" id="zozi-embedded-checkout" scrolling="no" seamless="seamless" style="width: 100%; height: 500px; position: relative; top: -120px;"></iframe><script src="https://a.zozi.com/assets/widgets/embedded.origin.js"></script>
                            */ ?>

                            <h2>The city is our photo studio.</h2>
                            <p>We're excited to be popping up in beautiful cafes, stores and cityscapes around Portland! 

                            Find a location that suits your personality&mdash;and helps you stand out from the competition. It's a great way to explore and support awesome, local businesses, too. Looking good never felt so great.</p>

                            <?php fs_show_venues('active') ?>

                            <p>Prefer to <a href="/book">book your headshot appointment from a calendar</a>? You can do that, too!</p>


                            <h3>Where we've been ... and may return.</h3>

                            <?php fs_show_venues('archived') ?>

                        </div>
                    </article>
                </div>
            </div>
        <?php endwhile; // End of the loop. ?>

    </main><!-- #main -->    
</div><!-- #primary -->

<script type="text/javascript" src="//s3.amazonaws.com/downloads.mailchimp.com/js/signup-forms/popup/embed.js" data-dojo-config="usePlainJson: true, isDebug: false"></script><script type="text/javascript">require(["mojo/signup-forms/Loader"], function(L) { L.start({"baseUrl":"mc.us11.list-manage.com","uuid":"d40bd49ac434fceb17a599c6e","lid":"3da796abc2"}) })</script>

<?php get_footer(); ?>