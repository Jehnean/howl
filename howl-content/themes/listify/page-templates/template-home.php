<?php
/**
 * Template Name: Page: Home
 *
 * @package Listify
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
					<?php
						the_widget(
							'Listify_Widget_Search_Listings',
							apply_filters( 'listify_widget_search_listings_default', array(
								'title' => get_the_title(),
								'description' => strip_shortcodes( get_the_content() )
							) ),
							array(
								'before_widget' => '<div class="listify_widget_search_listings">',
								'after_widget'  => '</div>',
								'before_title'  => '<div class="home-widget-section-title"><h1 class="home-widget-title">',
								'after_title'   => '</h1></div>',
								'widget_id'     => 'search-12391'
							)
						);
					?>
					 <div class="geo-location">
								<span class="address" data-format="city, state"></span>
								<a class="action" data-action="google" href="#">Change Location</a>
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

			<?php endif; ?>

		<?php endif; ?>

		<?php do_action( 'listify_page_before' ); ?>

		<main id="main" class="site-main" role="main">
			<div class="container">

			<div class="row content-area leadertext-area">
				<div class="col-md-12 col-sm-12 col-xs-12 text-center items-3-section-title home-widget">
					<h2>Tell us what you need. Get free quotes. Choose the right pro for the job.</h2>
			 	</div>
			</div>
		</div>
			<div class="row content-area home-how-it-works">
				<div class="col-xs-12">
				<?php
					if ( is_active_sidebar( 'widget-area-home' ) ) :
						dynamic_sidebar( 'widget-area-home' );
					endif;
				?>
				</div>

				<div class="customer-cta cta-module text-center">
						<p>Not sure what you're looking for? Look around and explore different services.</p>
						<a href="<?php echo esc_url( home_url( '/professional-services' ) ); ?>" class="button">Find Professionals</a>
				</div>
			</div>

			<div class="row content-area<?php echo $style; ?> home-footer-headline">
				<div class="col-md-12 col-sm-12 col-xs-12 text-center">
					<div class="home-widget-section-title">
						<h3 class="home-widget-title"><?php // the_title(); ?>Howl for Professionals</h3>
						<h4 class="home-widget-description">Immediately connect to consumers. No empty leads.
Smallest, flat fee for services like this.</h4>
						<a href="<?php echo esc_url( home_url( '/how-it-works-professionals' ) ); ?>" class="button">How it Works</a>
					</div>
				</div>
			</div>
		</div>
	</main>
	<?php endwhile; ?>

<?php get_footer(); ?>
