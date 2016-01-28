<?php
/**
 * Template Name: Page: Sign Up Professional
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
      <h1 class="home-widget-title"><?php // the_title(); ?>Professional Sign Up</h1>
      <h2 class="home-widget-description"><?php //echo strip_shortcodes( get_the_content() ); ?> Not a professional? <a href="<?php echo esc_url( home_url( '/sign-up' ) ); ?>">Sign up here!</a> Already have an account? <a href="<?php echo esc_url( home_url( '/login' ) ); ?>">Log in</a></h2>
  </div>

</div>    

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>


<?php wc_print_notices(); ?>  

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

  </div>

  <div class="col-2">

    <form method="post" class="register">

      <?php do_action( 'woocommerce_register_form_start' ); ?>

      <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

        <p class="form-row form-row-wide">
          <label for="reg_username"><?php _e( 'Username', 'woocommerce' ); ?> <span class="required">*</span></label>
          <input type="text" class="input-text" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
        </p>

      <?php endif; ?>

      <p class="form-row form-row-wide">
        <label for="reg_email"><?php _e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label>
        <input type="email" class="input-text" placeholder="Email*" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" />
      </p>

      <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

        <p class="form-row form-row-wide">
          <label for="reg_password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
          <input type="password" class="input-text" name="password" id="reg_password" />
        </p>

      <?php endif; ?>

      <?php do_action('howl_pro_form'); ?>

      <!-- Spam Trap -->
      <div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;"><label for="trap"><?php _e( 'Anti-spam', 'woocommerce' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>

      <?php do_action( 'woocommerce_register_form' ); ?>

      <?php do_action( 'register_form' ); ?>

      <p class="form-row">
        <?php wp_nonce_field( 'woocommerce-register' ); ?>
        <input type="submit" class="button" name="register" value="<?php esc_attr_e( 'Professional Sign Up', 'woocommerce' ); ?>" />
      </p>

      <?php do_action( 'woocommerce_register_form_end' ); ?>

    </form>

  </div>

</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>

    <?php do_action( 'listify_page_before' ); ?>

  <?php endwhile; ?>


<?php get_footer(); ?>
