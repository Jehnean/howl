<?php
/**
 * Template Name: Page: Help
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

    <div id="primary" class="container">
        <div class="row content-area">

            <main id="main" class="site-main col-md-8 col-sm-7 col-xs-12" role="main">

              <h3>Help Center</h3>

              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto esse ut perspiciatis maiores earum atque veritatis tempora, expedita dolorem reiciendis? Ratione ea amet doloremque, quis aspernatur recusandae, animi saepe eaque.</p>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto esse ut perspiciatis maiores earum atque veritatis tempora, expedita dolorem reiciendis? Ratione ea amet doloremque, quis aspernatur recusandae, animi saepe eaque.</p>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto esse ut perspiciatis maiores earum atque veritatis tempora, expedita dolorem reiciendis? Ratione ea amet doloremque, quis aspernatur recusandae, animi saepe eaque.</p>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto esse ut perspiciatis maiores earum atque veritatis tempora, expedita dolorem reiciendis? Ratione ea amet doloremque, quis aspernatur recusandae, animi saepe eaque.</p>

            </main>

             <?php get_sidebar(); ?>

        </div>
    </div>

	<?php endwhile; ?>


<?php get_footer(); ?>
