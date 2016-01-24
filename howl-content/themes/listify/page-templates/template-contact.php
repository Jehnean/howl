<?php
/**
 * Template Name: Page: Contact
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
							<h1 class="home-widget-title"><?php // the_title(); ?>How can we help you?</h1>
							<div class="search-form-container">
              <!-- Move below to separate file -->
              <form role="search" method="get" class="search-form" action="<?php echo esc_url( get_post_type_archive_link( 'job_listing' ) ); ?>">
                <label>
                  <span class="screen-reader-text"><?php _e( 'Search for:', 'listify' ); ?></span>
                  <input type="search" class="search-field" placeholder="<?php esc_attr_e( 'Search for anything. (booking a pro, getting paid, reviews)', 'listify' ); ?>" value="" name="search_keywords" title="<?php echo esc_attr_e( 'Search for anything', 'listify' ); ?>" />
                </label>
                <button type="submit" class="search-submit"></button>
              </form>                
              </div>
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

    <div id="primary" class="container" role="main">
      <div class="row content-area">
        <main id="main" class="site-main col-md-12 col-sm-7 col-xs-12 ">
          <div class="center-block">
          <h3 class="home-widget-title">Popular Topics</h3>
          <p class="home-widget-description">Lorem ipsum dolor sit amet</p>  
          </div>
          
        </main>
      </div>

      <div class="row content-area">
        <main id="main" class="site-main col-md-8 col-sm-7 col-xs-12">
          <h3 class="home-widget-title">Send us a Message</h3>
          <p class="home-widget-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima quidem dignissimos voluptatum laboriosam fuga dolore, necessitatibus saepe ad accusantium. In animi, voluptates voluptatibus similique ratione eius nulla voluptatum dolorum aperiam.</p>
        </main>
      </div>
    </div>

	<?php endwhile; ?>


<?php get_footer(); ?>
