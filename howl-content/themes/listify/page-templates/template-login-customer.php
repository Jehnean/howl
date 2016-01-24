<?php
/**
 * Template Name: Page: Login Customer
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
      <h1 class="home-widget-title"><?php // the_title(); ?>Login</h1>
      <h2 class="home-widget-description"><?php //echo strip_shortcodes( get_the_content() ); ?> Don't have an account? <a href="<?php echo esc_url( home_url( '/sign-up' ) ); ?>">Sign Up!</a></h2>
  </div>

</div>		

  <?php woocommerce_social_login_buttons(); ?>
		<?php do_action( 'listify_page_before' ); ?>

	<?php endwhile; ?>


<?php get_footer(); ?>
