<?php
/**
 * Template Name: Friends/Referrer Landing Pages
 */
get_header();
$referrer_name = get_post_meta($post->ID,'referrer_name',true);
$zozi_referral_code = get_post_meta($post->ID,'zozi_referral_code',true);
$cookie = array(
    'referral' => $post->post_name,
    'referral_code' => $zozi_referral_code,
    'referrer_name' => $referrer_name
);
setcookie('fsref',serialize($cookie),time() + (86400 * 30));
// $_COOKIE['fsref'])
?>
<div id="referral-layer" style="display: block;">
    <h2>You’ve been invited by <span class="invited-by"><?=$referrer_name ?></span> to FotoSnap your profile.</h2>

    <?php while (have_posts()) : the_post(); ?>

        <h1><?php
            the_content();
        ?></h1>

    <?php endwhile; ?>

    <p><a href="/book?ref=<?=$post->post_name ?>"
        data-track-event-category="referral"
        data-track-event-action="clicks through referral"
        data-track-event-label="<?=$zozi_referral_code ?>"
       class="ga-track">Book now + save</a> using referral code: <span class="referral-code"><?=$zozi_referral_code ?></span></p>
    <div class="character"></div>
    <div class="close"></div>
</div>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <?php
        $slider = array(
            'whiteboard' => array(
                'tagline' => "Get noticed. Get the job.",
                'align' => 'left'
            ),
            'fiona' => array(
                'tagline' => "Good-bye Selfie. Hello FotoSnap.",
                'align' => 'left'
            ),
            'kent-bkg' => array(
                'tagline' => "You're awesome. Get a profile photo to match.",
                'align' => 'right'
            ),
            'profile-bkg' => array(
                'tagline' => "Finally. Something to smile about.",
                'align' => 'right'
            ),
            // 'yellow' => array(
            //     'tagline' => "It's 2017. Time to FotoSnap your profile.",
            //     'align' => 'right'
            // ),
            // 'yellow-shoot' => array(
            //     'tagline' => "Locations for every personality.",
            //     'align' => 'left'
            // ),
        );
        $i = 1;

        $keys = array_keys($slider);
        $new = array();

        shuffle($keys);

        foreach($keys as $key) {
            $new[$key] = $slider[$key];
        }

        $slider = $new;
        ?>
        <div id="athena-jumbotron">
            <div id="athena-slider" class="hero">
                <?php foreach($slider as $thmb => $options): ?>

                <div id="slide<?=$i ?>" class="hidden" data-thumb="<?php echo esc_url( get_stylesheet_directory_uri() . '/img/splash-'.$thmb.'.jpg' ); ?>" 
                    data-src="<?php echo esc_url( get_stylesheet_directory_uri() . '/img/splash-'.$thmb.'.jpg' ); ?>">

                    <div class="overlay">
                        <div class="row">
                            <div class="col-sm-6 parallax <?= $options['align'] == 'right' ? 'col-sm-offset-6' : '' ?>">
                                <h2 class="header-text animated slide<?=$i ?>-header">
                                    <?=$options['tagline'] ?>
                                </h2>
                                <a href="/book"
                                    data-track-event-category="cta"
                                    data-track-event-action="clicks slider button"
                                    data-track-event-label="See Calendar"
                                   class="ga-track athena-button primary large animated slide1_button1 delay0">
                                   See Calendar
                                </a>
                                <a href="/faqs"
                                    data-track-event-category="cta"
                                    data-track-event-action="clicks slider button"
                                    data-track-event-label="How it Works"
                                   class="ga-track athena-button default large animated slide1_button2 delay0">
                                   How it Works
                                </a>                            
                            </div>
                        </div>
                    </div>                    

                </div>                
                <?php endforeach; ?>

            </div>
            <div class="slider-bottom">
                <div>
                    <span class="fa fa-chevron-down scroll-down animated slideInUp delay3"></span>
                </div>
            </div>        
        </div>
        <div class="clear"></div>
   
        <?php do_action('athena_homepage'); ?>

        <div class="row">
            <div class="homepage-page-content how-it-works">
                <?php if (is_home() && is_front_page()) :
                    // fetch the homepage editable copy
                    // $page = get_page_by_path('home', OBJECT, 'page');
                    // echo $page->post_content;
                endif; ?>

                <div class="center">
                With FotoSnap, getting <strong>great photos</strong> for your online profile is a snap! <strong>Convenient, flexible and fresh,</strong> a FotoSnapped profile will <strong>get you noticed</strong>&mdash;helping you get that job, date or client.
                </div>

                <div class="callout" style="padding-top: 0; margin: 120px 0 0;">
                    <h2 style="margin: -30px auto 30px; background-color: #fff; width: 50%; text-align: center;">How it Works: 3 Simple Steps</h2>
                        <div class="how-it-works row" style="font-size: 20px;">
                          <div class="col-md-4">
                            <h3 class="widget-title">1: Book</h3>
                            Choose from a selection of unique locations at a time that's right for you.
                          </div>
                          <div class="col-md-4">
                            <h3 class="widget-title">2: Smile</h3>
                            After meeting our photographer on location, you'll have 15 minutes of dedicated camera time.
                          </div>
                          <div class="col-md-4">
                            <h3 class="widget-title">3: Download</h3>
                            We pick, edit and share the best photos&nbsp;for you to choose from within 2 business days. Choose the one you want, download it for free—and enjoy the extra attention.
                          </div>
                        </div>
                        <div class="center"><a href="/venues" data-track-event-category="cta" data-track-event-action="clicks to book" data-track-event-label="Get Started" class="ga-track athena-button primary large">Get Started</a></div> 
                </div>

            </div>
        </div>

        <div class="row">
            <div class="homepage-page-content testimonials">
                <?php if (is_home() && is_front_page()) :
                    // @todo pull hard-coded copy into page for editability
                    // fetch the homepage editable copy
                    // $page = get_page_by_path('home/testimonials', OBJECT, 'page');
                    // echo $page->post_content;
                endif; ?>

                <p>&nbsp;</p>
                <p>&nbsp;</p>

                <div class="col-md-4">
                  <span class="client-avatar pull-left"><img class="alignnone size-medium wp-image-698" src="/wp-content/uploads/2016/09/Robert-Portland-Dylan-square-150x150.jpg" alt="" width="150" height="150"></span>
                  <blockquote>"I’m very happy with the whole experience and won’t hesitate to recommend your services to others! Thanks!"</blockquote>
                  <span class="client">&mdash; Robert</span>
                </div>

                <div class="col-md-4">
                  <span class="client-avatar pull-left"><img class="alignnone size-medium wp-image-698" src="/wp-content/uploads/2017/01/chris-umbrella-cropped-150x150.jpg" alt="" width="300" height="300"></span>
                  <blockquote>"I only wish I would have done this sooner! My online dating activity has nearly doubled."</blockquote>
                  <span class="client">&mdash; Chris L</span>
                </div>

                <div class="col-md-4">
                  <span class="client-avatar pull-left"><img class="alignnone size-medium wp-image-698" src="/wp-content/uploads/2017/01/MICHAEL-COATES_4_HS-150x150.jpg" alt="" width="300" height="300"></span>
                  <blockquote>"These people are terrific! Efficient, fast, professional and extremely good."</blockquote>
                  <span class="client">&mdash; Michael</span>
                </div>

                <!-- 
                <div class="col-md-4">
                  <span class="client-avatar pull-left"><img class="alignnone size-medium wp-image-698" src="/wp-content/uploads/2015/08/RAYMOND-RODRIGUEZ_2_version-2-e1483692719630-150x150.jpg" alt="" width="150" height="150"></span>
                  <blockquote>"The folks at FotoSnap took several fun, professional photos of me. I love them! Thank you for making me look great, guys!"</blockquote>
                  <span class="client">&mdash; Raymond</span>
                </div>
                <div class="col-md-12 center">
                    <a href="/gallery"
                    data-track-event-category="cta"
                    data-track-event-action="clicks to view testimonials"
                    data-track-event-label="See More"
                    class="ga-track athena-button default">Meet More Happy Clients</a>
                </div>
                -->

            </div>
        </div>

        <div class="clear">&nbsp;</div>

        <div class="row">
            <div class="homepage-page-content venues center">

                <h2>PopUp Studios @ Fun Locations</h2>
                <p>Snag your spot in these upcoming photoshoots before they fill up.</p>
                <?php fs_show_venues('active') ?>
                <div class="col-md-12 center">
                    <br>
                    <a href="/venues"
                        data-track-event-category="cta"
                        data-track-event-action="clicks to view locations"
                        data-track-event-label="See More"
                       class="ga-track athena-button primary large">See More</a>                            
                </div>
            </div>
        </div>

        <div class="clear"><br><br><br></div>

    </main><!-- #main -->
</div><!-- #primary -->
<script>
jQuery(document).ready(function ($) {
    $("#referral-layer .close").on('click',function(){
        $("#referral-layer").hide();
    });
});
</script>
<?php get_footer(); ?>