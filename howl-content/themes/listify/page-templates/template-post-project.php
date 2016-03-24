<?php
/**
 * Template Name: Post a Project
 *
 */

get_header(); ?>

  <?php do_action( 'listify_page_before' ); ?>

  <div id="primary" class="container">
    <div class="row content-area">

      <main id="main" class="site-main col-md-10 col-md-offset-1 col-xs-12" role="main">

      <div class="page-cover entry-cover no-image">
          <h1 class="page-title cover-wrapper">Help us match the right <br> professionals to your job.</h1>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut sed nesciunt iste nobis dolores natus odio atque repellat non, id eligendi nam inventore laudantium ullam quidem vitae placeat quisquam. Quos.</p>
      </div>
      
      <?php 
        // echo apply_filters( 'the_content','[piklist_form form="post-project" add_on="theme"]'); 
      ?>
      <?php gravity_form('Post a Project', false, false, false, '', true); ?>
      </main>

    </div>
  </div>

<?php get_footer(); ?>
