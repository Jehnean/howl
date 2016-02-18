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


      // do_shortcode('[piklist_form form="profile-edit" add_on="theme"]');
      // echo apply_filters( 'the_content','[piklist_form form="profile-edit" add_on="theme"]');

      if ( !is_user_logged_in() ) {
        echo 'Please login to view this page';
      } else { ?>

      <div class="page-cover entry-cover no-image">
          <h1 class="page-title cover-wrapper">Your Projects</h1>
      </div>      
      
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

?>

<?php echo get_post_meta( $post->ID, 'project_type', true ); ?>

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
