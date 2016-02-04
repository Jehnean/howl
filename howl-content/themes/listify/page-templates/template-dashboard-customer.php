<?php
/**
 * Template Name: Customer Dashboard
 *
 */

get_header(); ?>

  <?php do_action( 'listify_page_before' ); ?>

  <div id="primary" class="container">
    <div class="row content-area">

      <main id="main" class="site-main col-md-10 col-md-offset-1 col-xs-12" role="main">

      <?php

      if ( !is_user_logged_in() ) {
        echo 'Please login to view this page';
      } else { ?>

      <div class="page-cover entry-cover no-image">
          <h1 class="page-title cover-wrapper">Your Projects</h1>
      </div>      
      
      <?php the_content(); ?>

      <?php
      }
      ?>



      </main>

    </div>
  </div>

<?php get_footer(); ?>
