<?php /* Template: FotoSnap Photographer Profile */ ?>

<div class="row">
    
    <div class="col-sm-8">

<h1>Our Headshot Photographers <small><a href="/photographers">view all</a></small></h1>

<div class="um <?php echo $this->get_class( $mode ); ?> um-<?php echo $form_id; ?> um-role-<?php echo um_user('role'); ?> ">

  <div class="um-form">
  
    <?php do_action('um_profile_before_header', $args ); ?>
    
    <?php if ( um_is_on_edit_profile() ) { ?><form method="post" action=""><?php } ?>
    
      <?php do_action('um_profile_header_cover_area', $args ); ?>
      
      <?php do_action('um_profile_header', $args ); ?>
      
      <?php do_action('um_profile_navbar', $args ); ?>
      
      <?php
        
      $nav = $ultimatemember->profile->active_tab;
      $subnav = ( get_query_var('subnav') ) ? get_query_var('subnav') : 'default';
        
      print "<div class='um-profile-body $nav $nav-$subnav'>";
        
        // Custom hook to display tabbed content
        do_action("um_profile_content_{$nav}", $args);
        do_action("um_profile_content_{$nav}_{$subnav}", $args);
        
      print "</div>";
        
      ?>
    
    <?php if ( um_is_on_edit_profile() ) { ?></form><?php } ?>
  
  </div>
  
</div>

    <?php 
        $profile_id = um_profile_id();
        $photographer = fs_get_photographer_by_userid($profile_id);
        // var_dump($photographer);

        ob_start(); 
        fs_show_related_photogs_venues('venue', $photographer->ID);
        $output = ob_get_contents();
        ob_end_clean();
        if( $output ){
            echo '<h3>Favorite + Recent Locations</h3>';
            echo $output;
        }
    ?>



    </div>

    <div class="col-sm-3 col-sm-offset-1">

        <h3>Join our Team</h3>
        <small>Love capturing confidence, beauty, smiles and striking profiles? Join our FotoSnap photographers team.</small>
        <br><br>
        <a href="/contact"
            data-track-event-category="cta"
            data-track-event-action="clicks to join as a photographer"
            data-track-event-label="Apply"
           class="ga-track um-button athena-button primary large">Apply</a>                            

    </div>
</div>