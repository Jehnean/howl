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

    <?php $style = get_post()->hero_style; ?>

    <?php if ( 'none' !== $style ) : ?>

      <?php if ( in_array( $style, array( 'image', 'video' ) ) ) : ?>

      <div <?php echo apply_filters( 'listify_cover', 'homepage-cover page-cover entry-cover', array( 'size' =>
      'full' ) ); ?>>
        <div class="cover-wrapper container">
          <div class="listify_widget_search_listings">
            <div class="home-widget-section-title">
              <h1 class="home-widget-title"><?php // the_title(); ?>Grow Your Business</h1>
              <h2 class="home-widget-description"><?php //echo strip_shortcodes( get_the_content() ); ?> Choose your customers. Quote your price. Keep what you earn.</h2>
            </div>
          </div>

        <?php
          if ( 'video' == $style ) :
            wp_reset_query();

            add_filter( 'wp_video_shortcode_library', '__return_false' );
            
            the_content();

            remove_filter( 'wp_video_shortcode_library', '__return_false' );
          endif;
        ?>
        </div>
      </div>

      <?php endif; ?>

    <?php endif; ?>   


    <?php do_action( 'listify_page_before' ); ?>

      
      <div class="container homepage-hero-style-<?php echo $style; ?>">
        
      <div class="home-widget">
        <h3 class="home-widget-title">We are here to help your business. Real Leads. Honest Pricing.</h3>
      </div>

      </div>

      <div class="container homepage-hero-style-<?php echo $style; ?>">
        
        <div class="home-widget">
          <h3 class="home-widget-title">Howl takes less than 2 minutes.</h3>
          <p class="home-widget-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis rerum, distinctio amet quibusdam facere sint possimus vel sed. Maiores, enim, sunt! Ab error, magni dolor facilis deserunt laudantium molestiae ut?</p>
        </div>

      </div>

      <div class="container homepage-hero-style-<?php echo $style; ?>">
        
        <div class="home-widget">
          <h3 class="home-widget-title">Designed with customers in mind.</h3>
          <p class="home-widget-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis rerum, distinctio amet quibusdam facere sint possimus vel sed. Maiores, enim, sunt! Ab error, magni dolor facilis deserunt laudantium molestiae ut?</p>
        </div>

      </div>

      <div class="container homepage-hero-style-<?php echo $style; ?>">
        
        <div class="home-widget">
          <h3 class="home-widget-title">Still have questions?</h3>
          <p class="home-widget-description">Lorem ipsum dolor sit amet, <a href="/help">consectetur adipisicing</a> elit. </p>
        </div>

      </div>

  <?php endwhile; ?>


<?php get_footer(); ?>
