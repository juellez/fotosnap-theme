<?php
/**
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Athena
 */
get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <?php
        $slider = array(
            'fiona' => array(
                'tagline' => "Good-bye Selfie. Hello FotoSnap.",
                'align' => 'left'
            ),
            'whiteboard' => array(
                'tagline' => "Get noticed. Get the job.",
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
            'yellow' => array(
                'tagline' => "It's 2017. Time to FotoSnap your profile.",
                'align' => 'right'
            ),
        );
        $i = 1;
        // shuffle($slider);
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
            <div class="homepage-page-content how-it-works col-sm-12">
                <?php if (is_home() && is_front_page()) :
                    // fetch the homepage editable copy
                    $page = get_page_by_path('home', OBJECT, 'page');
                    echo $page->post_content;
                endif; ?>
            </div>
        </div>

        <div class="row">
            <div class="homepage-page-content testimonials col-sm-12">
                <?php if (is_home() && is_front_page()) :
                    // fetch the homepage editable copy
                    $page = get_page_by_path('home/testimonials', OBJECT, 'page');
                    echo $page->post_content;
                endif; ?>
            </div>
        </div>

        <div class="row">
            <?php get_sidebar('left'); ?>

            <h2>Fun Locations</h2>
            <?php // the_content(); ?>
            <?php fs_show_children('active') ?>
            <a href="/venues"
                data-track-event-category="cta"
                data-track-event-action="clicks to view locations"
                data-track-event-label="See More"
               class="ga-track athena-button primary large animated">See More</a>                            

            <br><br>
            <div class="clear">&nbsp;</div>
            <br><br>

            <div class="homepage-page-content col-sm-<?php echo athena_main_width(); ?>">                
                <?php if (have_posts()) : ?>

                    <?php if (is_home() && !is_front_page()) : ?>
                        <header>
                            <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
                        </header>
                    <?php endif; ?>

                    <?php $front = get_option('show_on_front'); ?>

                    <?php echo $front == 'posts' ? '<div class="athena-blog-content">' : ''; ?>

                    <?php while (have_posts()) : the_post(); ?>

                        <?php
                        if ('posts' == get_option('show_on_front')) :
                            get_template_part('template-parts/content-blog', get_post_format());
                        else:
                            get_template_part('template-parts/content-page-home', get_post_format());
                        endif;
                        ?>

                    <?php endwhile; ?>
                    <?php echo $front == 'posts' ? '</div>' : ''; ?>
                    <div class="athena-pagination">
                        <?php echo paginate_links(); ?>
                    </div>

                <?php else : ?>

                    <?php get_template_part('template-parts/content', 'none'); ?>

                <?php endif; ?>

            </div>

            <?php get_sidebar(); ?>


        </div>
    </main><!-- #main -->
</div><!-- #primary -->


<?php get_footer(); ?>        