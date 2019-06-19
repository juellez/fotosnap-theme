                <div class="col-sm-3">
                <?php 
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
                ?>
                </div>

                <div class="col-sm-8 col-sm-offset-1">
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div class="entry-content">

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
                        </div>
                        <footer class="entry-footer">
                            <?php
                            edit_post_link(
                                    sprintf(
                                            /* translators: %s: Name of current post */
                                            esc_html__('Edit %s', 'athena'), the_title('<span class="screen-reader-text">"', '"</span>', false)
                                    ), '<span class="edit-link">', '</span>'
                            );
                            ?>
                        </footer>
                    </article>
                </div>