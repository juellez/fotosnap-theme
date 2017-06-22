<?php
/**
 * Template Name: Location / Venue
 */
get_header();

$peek_id = get_post_meta( $post->ID, 'peek_product_id', true ) + 0;
$zozi_id = get_post_meta( $post->ID, 'zozi_product_id', true ) + 0;
$attributes = get_post_meta( $post->ID, 'photogenic_attributes', true );
$active = has_term( 'active', 'status', $post );
$address = get_geocode_address( $post->ID );
$website = get_post_meta( $post->ID, 'website_url', true );
$mapurl = "https://www.google.com/maps?q=".urlencode($address);

// @todo load iFrame faster
// e.g. http://www.aaronpeters.nl/blog/iframe-loading-techniques-performance?%3E
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main athena-page" role="main">

        <?php while (have_posts()) : the_post(); ?>

            <?php if ($thmbid = get_post_thumbnail_id($post->ID)) : ?>
                <div id="athena-page-jumbotron" class="parallax-window" data-parallax="scroll" 
                    data-image-src="<?php echo wp_get_attachment_image_src($thmbid, array(1200,800,true))[0] ?>">
                    <div class="dark-overlay"></div>
                    <div class="dark-overlay-text">

                        <header class="entry-header center">
                            <small><a href="/venues/">Pop-Up Photo Studio Locations</a></small>
                            <h1 class="entry-title">
                                <?php the_title() ?>
                            </h1>
                            <h2 class="entry-address">
                                <a href="<?=$mapurl ?>" title="<?php the_title() ?> map and directions"
                                    target="_blank"
                                    data-track-event-category="venue meta" 
                                    data-track-event-action="clicks to view map/directions">  
                                        <?=$address ?></a>
                                <?php if( $website ): ?>
                                    | <a href="<?=$website ?>" title="<?php the_title() ?> website"
                                    target="_blank"
                                    data-track-event-category="venue meta" 
                                    data-track-event-action="clicks to view website" 
                                    data-track-event-label="<?=$website ?>">website</a>
                                <?php endif; ?></h2>
                        </header>

                        <?php
                            $next = get_next_post();
                            $previous = get_previous_post();
                        ?>
                        <nav class="locations-nav">
                            <?php if( $previous && $previous->post_name ): ?>
                                <a class="previous" href="/venues/<?=$previous->post_name ?>"> &lt; </a>
                            <?php endif; ?>

                            <?php if( $next && $next->post_name ): ?>
                                <a class="next" href="/venues/<?=$next->post_name  ?>"> &gt; </a>
                            <?php endif; ?>
                        </nav>


                        <?php // see if there's a cta to throw into this header space
                            $cta_url = get_post_meta( $post->ID, 'cta_url', true );
                            $cta_track_action = get_post_meta( $post->ID, 'cta_track_action', true );
                            $cta_label = get_post_meta( $post->ID, 'cta_label', true );
                            if( $cta_url && $cta_label ): ?>
                            <div class="center">
                                <a class="ga-track athena-button primary large" href="<?=$cta_url ?>" 
                                data-track-event-category="header cta" 
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
                <?php if( false && $active && $zozi_id ): // active - no more zozi ?>
                    <div class="col-sm-12">
                      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div class="entry-content">

                          <div class="zozi-frame-wrapper">

                            <iframe data-src="https://a.zozi.com/#/embed/fotosnapor/products/<?= $zozi_id ?>?embedOptions=%7B%22merchantCode%22%3A%22fotosnapor%22%2C%22view%22%3A%22month%22%2C%22productIDs%22%3A%22%22%2C%22capacityDisplay%22%3A%22text%22%2C%22capacityText%22%3A%22BOOK%22%2C%22soldOutDisplay%22%3A%22text%22%2C%22soldOutText%22%3A%22Sold%20Out%22%2C%22includeName%22%3Anull%2C%22pastDatesBehavior%22%3A%22hide%22%2C%22allowAddonsPriceRollup%22%3A%22true%22%2C%22availabilityView%22%3A%22first%22%2C%22modalButtonText%22%3A%22Open%20Calendar%22%2C%22listButtonText%22%3A%22Book%20Now%22%2C%22buttonTextColor%22%3A%22%23FFFFFF%22%2C%22iconColor%22%3A%22%23000000%22%2C%22checkoutButtonColor%22%3A%22%23F0722C%22%2C%22accentColor%22%3A%22%23f37521%22%2C%22allowLocationHashControl%22%3A%22true%22%2C%22productContent%22%3A%22show%22%2C%22showProductsPage%22%3A%22hide%22%2C%22defaultOpenView%22%3A%22app.embed.merchant.calendarWidget%22%2C%22addonsPage%22%3A%22show%22%2C%22buttonBackground%22%3A%22%23FF8200%22%2C%22lowerMaxQuantitySelectableLimit%22%3A1000%2C%22upperMaxQuantitySelectableLimit%22%3A10000%7D" data-allow-hashchange="true" frameborder="0" id="zozi-embedded-checkout" scrolling="no" seamless="seamless" class="zozi-frame"><?php the_content(); ?></iframe><script src="https://a.zozi.com/assets/widgets/embedded.origin.js"></script>

                          </div>

                        </div>
                      </article>
                    </div>

                <?php else: // NOT A ZOZI ACTIVITY -- display some stuff ?>
                    <div class="col-sm-3">
                        <div class="row venue-gallery">
                            <?php
                                $media = get_attached_media( 'image' );
                                foreach($media as $img):
                                    $url = wp_get_attachment_image_src($img->ID,'thumbnail');
                                    echo '<div class="col-xs-6"><img src="'.$url[0].'" /></div>';
                                endforeach;
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-8 col-sm-offset-1">
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <div class="entry-content">

                                    <?php the_content(); ?>

                                    <?php if( is_array($attributes) && !in_array('indoor', $attributes) ): ?>
                                        
                                            <!-- We know the weather can be difficult this time of year. While crisp air and holiday lighting can create a great natural looking photo, 
                                            windstorms and hard rain is just too much nature for the camera. -->
                                            <strong>Good Weather Guarantee</strong><br>
                                            Okay, we can't guarantee the weather will always cooperate. So know that even if Mother Nature doesn't abide, we'll 
                                            reschedule your session or issue a full refund.
                                        
                                    <?php endif; ?>


                                    <?php if( $active ): ?>
                                        <!--                                                 
                                        <a href="https://www.peek.com/s/c74c5080-8031-4867-bc34-66878fb89340/47lM" 
                                            data-button-text="Book Now">Book Now</a>
                                        -->
                                        <a href="/book" 
                                            data-track-event-category="cta"
                                            data-track-event-action="clicks to book from venue"
                                            data-track-event-label="Book a spot (active)"
                                            class="athena-button primary large">Check availability + Reserve a session</a>
                                        <br><br>

                                    <?php elseif( $post->post_type == 'venue' && !$active ): ?>
                                        <br><br><small></small>
                                        <a href="/book" 
                                            data-track-event-category="cta"
                                            data-track-event-action="clicks to book from venue"
                                            data-track-event-label="Book a spot (inactive)"
                                            class="athena-button primary large">Check availability</a>
                                    <?php endif; ?>

                            </div>
                        </article>
                    </div>
                <?php endif; ?>        
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <br><br>
                    <div class="callout">
                        <strong>The City is our Photo Studio</strong>
                        <br>
                        <small>We've curated some of the best places around Portland, Oregon, to capture eye-catching, natural-looking portraits.
                        We believe you should <strong>look as great online as you do in real life</strong>. We find that when you're out
                        in natural and public spaces, you'll forget you're on camera&mdash;and you'll look relaxed and just like YOU ... great!</small>
                        <br><br>
                        <strong>How it Works</strong>
                        <br>
                        <small>We offer fun locations to fit your personality and at convient times to fit your schedule. Sessions typically take less
                        than 15 minutes (it's how we keep it affordable for you and profitable for our photographers) 
                        and you'll get professional photos to use on all your online profiles. 
                        Whether you need an eye-catching, up-to-date photo for your LinkedIn, Facebook, dating profile or any professional or personal needs&mdash;FotoSnap photographers have you covered.</small>
                        <!--
                        <small>Whether you are online looking for a job or a date, a selfie is a bad way to make a good impression. Instead, book a FotoSnap mini photo session! We offer fun locations to fit your personality and convenient times to fit your schedule. Just $49 and a 15 minute session gets you a professional photo to use on all your online profiles.</small>
                        -->
                    </div>
                    <br>

                    <!-- 
                    <a href="http://www.peek.com/purchase/gift_card/592dbb1e66b50b9871000110" class="peek-book-button-flat peek-book-btn-yellow peek-book-button-size-lg peek-book-icon-gift" data-purchase-type="gift-card" data-button-text="Purchase Gift Card" data-partner-gid="592dbb1e66b50b9871000110">FotoSnap</a>
                    -->

                    <br>
                    <br>
                    <?php 
                        ob_start(); 
                        fs_show_related_photogs_venues('photographer');
                        $output = ob_get_contents();
                        ob_end_clean();
                        if( $output ){
                            echo '<h3>Photographers who\'ve shot at this location.</h3>';
                            echo $output;
                        }
                    ?>
                </div>
                <?php if( false && $active ): // output "extra" content here in case iframe doesn't load and for seo ?>
                <div class="col-sm-12">
                <h3>More about this location</h3>
                    <?php the_content() ?>
                </div>
                <?php endif; ?>
            </div>


        <?php endwhile; // End of the loop. ?>

    </main><!-- #main -->    
</div><!-- #primary -->

<script type="text/javascript" src="//s3.amazonaws.com/downloads.mailchimp.com/js/signup-forms/popup/embed.js" data-dojo-config="usePlainJson: true, isDebug: false"></script><script type="text/javascript">require(["mojo/signup-forms/Loader"], function(L) { L.start({"baseUrl":"mc.us11.list-manage.com","uuid":"d40bd49ac434fceb17a599c6e","lid":"3da796abc2"}) })</script>

<?php get_footer(); ?>