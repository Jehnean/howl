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

<div class="login-content-wrapper">
  <div class="login-header-title-container">
    <div class="home-widget-section-title">
      <h1 class="home-widget-title"><?php // the_title(); ?>Sign Up</h1>
      <h2 class="home-widget-description"><?php //echo strip_shortcodes( get_the_content() ); ?> Are you a professional? <a href="<?php echo esc_url( home_url( '/pro-sign-up' ) ); ?>">Sign up here!</a> Already have an account? <a href="<?php echo esc_url( home_url( '/login' ) ); ?>">Log in here.</a></h2>
    </div>
  </div>

<div class="social-login-container">
  <?php woocommerce_social_login_buttons(); ?>

  <p class="social-login-disclaimer text-center">
    Don't worry, we won't post to your social media.
  </p>  
</div>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php wc_print_notices(); ?>  

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

  <!-- </div> -->

  <div class="col-2">

  <div class="alternate-login-header text-center">
    <span class="thin-line"></span><p><?php _e( 'Or sign up with your email', 'woocommerce' ); ?></p><span class="thin-line"></span>
  </div>

    <form method="post" class="register">

      <?php do_action( 'woocommerce_register_form_start' ); ?>

      <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

        <p class="form-row form-row-wide">
          <label for="reg_username"><?php _e( 'Username', 'woocommerce' ); ?> <span class="required">*</span></label>
          <input type="text" class="input-text" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
        </p>

      <?php endif; ?>

      <p class="form-row form-row-wide">
        <!-- <label for="reg_email"><?php _e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label> -->
        <input type="email" class="input-text" placeholder="Email*" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" />
      </p>

      <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

        <p class="form-row form-row-wide">
          <label for="reg_password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
          <input type="password" class="input-text" name="password" id="reg_password" placeholder="Password*" />
        </p>

      <?php endif; ?>

      <!-- Spam Trap -->
      <div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;"><label for="trap"><?php _e( 'Anti-spam', 'woocommerce' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>

      <?php do_action( 'woocommerce_register_form' ); ?>
      <?php do_action( 'register_form' ); ?>

      <p class="form-row">
        <?php wp_nonce_field( 'woocommerce-register' ); ?>
        <input type="submit" class="button" name="register" value="<?php esc_attr_e( 'Sign Up', 'woocommerce' ); ?>" />
      </p>

      <div class="form-disclaimer text-center">
        <p>By signing up with Howl, you agree with our <a href="/terms-of-service">Terms &amp; Conditions.</a></p>
      </div>

      <?php do_action( 'woocommerce_register_form_end' ); ?>

    </form>

  </div>

<!-- </div> -->
<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>

    <?php do_action( 'listify_page_before' ); ?>
</div>
  <?php endwhile; ?>


<?php get_footer(); ?>
