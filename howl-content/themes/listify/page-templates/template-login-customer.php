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
  
  <?php do_action( 'listify_page_before' ); ?>
  
  <div class="listify_widget_search_listings">
    <div class="home-widget-section-title">
      <h1 class="home-widget-title"><?php // the_title(); ?>Login</h1>
      <h2 class="home-widget-description"><?php //echo strip_shortcodes( get_the_content() ); ?> Don't have an account? <a href="<?php echo esc_url( home_url( '/sign-up' ) ); ?>">Sign Up!</a></h2>
    </div>
  </div>		

  <?php woocommerce_social_login_buttons(); ?>

<?php wc_print_notices(); ?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

    <form method="post" class="login">

      <?php do_action( 'woocommerce_login_form_start' ); ?>

      <p class="form-row form-row-wide">
        <label for="username"><?php _e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label>
        <input type="text" class="input-text" name="username" id="username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
      </p>
      <p class="form-row form-row-wide">
        <label for="password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
        <input class="input-text" type="password" name="password" id="password" />
      </p>

      <?php do_action( 'woocommerce_login_form' ); ?>

      <p class="form-row">
        <?php wp_nonce_field( 'woocommerce-login' ); ?>
        <input type="submit" class="button" name="login" value="<?php esc_attr_e( 'Login', 'woocommerce' ); ?>" />
        <label for="rememberme" class="inline">
          <input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php _e( 'Remember me', 'woocommerce' ); ?>
        </label>
      </p>
      <p class="lost_password">
        <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php _e( 'Forgot your password?', 'woocommerce' ); ?></a>
      </p>

      <?php do_action( 'woocommerce_login_form_end' ); ?>

    </form>
<?php do_action( 'woocommerce_after_customer_login_form' ); ?>

	<?php endwhile; ?>


<?php get_footer(); ?>
