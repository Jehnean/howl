<?php
/**
 * Template Name: Customer Dashboard
 *
 */

get_header(); ?>

  <?php do_action( 'listify_page_before' ); ?>

  <div id="primary" class="container">

    <div class="dashboard-header-container">
      <h1 class="dashboard-title">Your Projects</h1>

      <div class="start-project-container">
        <a href="/post-a-project/">New Project</a>
      </div>
    </div>

    <div class="row">

      <div class="sidebar col-md-4 col-xs-12">
        sticky sidebar
      </div>

    <main id="main" class="site-main col-md-8 col-xs-12" role="main">


    <?php

    // do_shortcode('[piklist_form form="profile-edit" add_on="theme"]');
    // echo apply_filters( 'the_content','[piklist_form form="profile-edit" add_on="theme"]');

    if ( !is_user_logged_in() ) {
      echo 'Please login to view this page';
    } else {

    ?>



<?php
  $user_id = get_current_user_id();
  $custom_query_args = array(
    'post_type'=> 'customer_projects',
    'author' => $user_id,
    'post_status'=> 'ongoing',
    // 'paged' => $paged,
    'posts_per_page' => 14,
    'order'    => 'DESC',



  );

  // Get current page and append to custom query parameters array
  // $custom_query_args['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

  // Pagination fix
  // $temp_query = $wp_query;
  // $wp_query   = NULL;
  // $wp_query   = $custom_query_args;


  $the_query = new WP_Query( $custom_query_args );
  if($the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
  $project_id = get_the_ID();

?>

<div class="list-group">
  <div class="list-group-item">
    <a href="/post-project/?_post[ID]=<?php echo $project_id ?>" class="edit-project-link">Edit Project</a>
    <h4 class="list-group-item-heading">
      <a href="<?php the_permalink(); ?>">
      <?php the_title(); ?>
      </a>
    </h4>
    <div class="list-group-item-text">
      <?php the_content(); ?>
    </div>
  </div>
</div>

<?php endwhile; else: ?>

<p>You don't have any completed projects yet. <a href="/post-a-project">Start a new project</a></p>

<?php endif; wp_reset_postdata(); ?>

<?php
}
?>

<?php //howl_get_pagination(); ?>

<?php wp_reset_query(); ?>

      </main>

    </div>
  </div>

<?php get_footer(); ?>
