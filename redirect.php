<?php
/*
Template Name: Zozi Redirect
*/

if (have_posts()) : while (have_posts()) : the_post();

    $redirectUrl = "https://a.zozi.com/#/express/fotosnapor" . get_the_content('');

    header('Location: '.$redirectUrl);
    die();

  endwhile; 
endif;
?>