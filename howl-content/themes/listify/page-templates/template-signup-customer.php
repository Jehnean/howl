<?php
/**
 * Template Name: Page: Sign Up Customer
 *
 * @package Howl
 */

if ( ! listify_has_integration( 'wp-job-manager' ) ) {
  return locate_template( array( 'page.php' ), true );
}

get_header(); ?>

  <?php while ( have_posts() ) : the_post(); ?>

  <div class="listify_widget_search_listings">
    <div class="home-widget-section-title">
      <h1 class="home-widget-title"><?php // the_title(); ?>Sign Up</h1>
      <h2 class="home-widget-description"><?php //echo strip_shortcodes( get_the_content() ); ?> Are you a professional? <a href="<?php echo esc_url( home_url( '/pro-sign-up' ) ); ?>">Sign up here!</a> Already have an account? <a href="<?php echo esc_url( home_url( '/login' ) ); ?>">Log in here.</a></h2>
  </div>

</div>    

  <?php woocommerce_social_login_buttons(); ?>
    <?php do_action( 'listify_page_before' ); ?>

  <?php endwhile; ?>


<?php get_footer(); ?>
