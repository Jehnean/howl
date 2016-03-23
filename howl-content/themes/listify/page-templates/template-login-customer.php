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
<div class="login-content-wrapper">
  <div class="login-header-title-container">
    <div class="home-widget-section-title">
      <h1 class="home-widget-title">Login</h1>
      <h2 class="home-widget-description">Don't have an account? <a href="<?php echo esc_url( home_url( '/sign-up' ) ); ?>">Sign Up!</a></h2>
    </div>
  </div>		

<div class="social-login-container">
  <?php woocommerce_social_login_buttons(); ?>

  <p class="social-login-disclaimer text-center">
    Don't worry, we won't post to your social media.
  </p>  
</div>

<?php wc_print_notices(); ?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>


<div class="alternate-login-header text-center">
  <span class="thin-line"></span><p>Or log in with your email</p><span class="thin-line"></span>
</div>


    <form method="post" class="login">

      <?php do_action( 'woocommerce_login_form_start' ); ?>

      <p class="form-row form-row-wide">
        <label for="username"><?php _e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label>
        <input type="text" class="input-text" name="username" id="username" placeholder="Email" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
      </p>
      <p class="form-row form-row-wide">
        <label for="password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
        <input class="input-text" type="password" name="password" id="password" placeholder="Password"/>
      </p>

      <?php do_action( 'woocommerce_login_form' ); ?>

      <p class="lost_password">
        <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php _e( 'Forgot your password?', 'woocommerce' ); ?></a>
      </p>

      <p class="form-row">
        <?php wp_nonce_field( 'woocommerce-login' ); ?>
        <input type="submit" class="blue-btn" name="login" value="<?php esc_attr_e( 'Sign In', 'woocommerce' ); ?>" />
        <label for="rememberme" class="inline">
          <input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php _e( 'Remember me', 'woocommerce' ); ?>
        </label>
      </p>

      <div class="form-disclaimer text-center">
        <p>By signing in, you agree with our <a href="/terms-of-service">Terms &amp; Conditions.</a></p>
      </div>

      <?php do_action( 'woocommerce_login_form_end' ); ?>

    </form>
<?php do_action( 'woocommerce_after_customer_login_form' ); ?>


</div>
	<?php endwhile; ?>


<?php get_footer(); ?>
