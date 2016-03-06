<?php
/**
 * Template Name: Page: How it Works
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
				<div class="cover-wrapper container ">
					<div class="listify_widget_search_listings">
						<div class="home-widget-section-title">
							<h1 class="home-widget-title"><?php // the_title(); ?>How it Works</h1>
							<h2 class="home-widget-description"><?php echo strip_shortcodes( get_the_content() ); ?></h2>
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
			
			<div class="container">
				
			<div class="home-widget">
				<h3 class="home-widget-title">We'll match you to the 5 best project pros in your area for your project.</h3>
			</div>

			</div>

			<div class="container">
				
<!-- 				<div class="home-widget">
					<h3 class="home-widget-title">Howl takes less than 2 minutes.</h3>
					<p class="home-widget-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis rerum, distinctio amet quibusdam facere sint possimus vel sed. Maiores, enim, sunt! Ab error, magni dolor facilis deserunt laudantium molestiae ut?</p>
				</div> -->

				<div class="row">
					<div class="col-xs-12 col-sm-6 ">
						<div class="callout-feature-content">
							<h2 class="callout-feature-title">1. Post whatever you want help with.</h2>
							<p>Tell us what you need help with and we wil send you the details to the most qualified professionals in your area.</p>
						</div>
					</div>

					<div class="col-xs-12 col-sm-6">
						<img src="<?php echo get_template_directory_uri(); ?>/images/build/howl-customer-how-it-works-step-1.png" alt="">
					</div>
				</div>

				<div class="row">
					<div class="col-xs-12 col-sm-6">
						<img src="<?php echo get_template_directory_uri(); ?>/images/build/howl-customer-how-it-works-step-2.png" alt="">
					</div>

					<div class="col-xs-12 col-sm-6 ">
						<div class="callout-feature-content">
							<h2 class="callout-feature-title">2. Post whatever you want help with.</h2>
							<p>Tell us what you need help with and we wil send you the details to the most qualified professionals in your area.</p>
						</div>
					</div>

				</div>

				<div class="row">
					<div class="col-xs-12 col-sm-6 ">
						<div class="callout-feature-content">
							<h2 class="callout-feature-title">3. Post whatever you want help with.</h2>
							<p>Tell us what you need help with and we wil send you the details to the most qualified professionals in your area.</p>
						</div>
					</div>

					<div class="col-xs-12 col-sm-6">
						<img src="<?php echo get_template_directory_uri(); ?>/images/build/howl-customer-how-it-works-step-3.png" alt="">
					</div>
				</div>

			</div>


			<div class="image-headline-wrapper home-footer-headline">
				<div class="row content-area<?php echo $style; ?> container ">
					<div class="col-md-12 col-sm-12 col-xs-12 text-center">
						<div class="home-widget-section-title">
							<h3 class="home-widget-title">Howl takes less than 2 minutes.</h3>
							<p class="home-widget-description">Why not use the time you would have spent on the phone trying to find someone to fix the water heater(or whatever) to watch one more episode on Netflix, walk your dog, play with your kids, or take a bubble bath? We'll take care of the rest. </p>

						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis, illo distinctio assumenda nobis nostrum. Error nihil eligendi modi fugiat iure, eveniet, nisi soluta blanditiis itaque ipsam similique voluptatibus minima quidem.</p>
					</div>
					<div class="col-md-4">
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis, illo distinctio assumenda nobis nostrum. Error nihil eligendi modi fugiat iure, eveniet, nisi soluta blanditiis itaque ipsam similique voluptatibus minima quidem.</p>
					</div>
					<div class="col-md-4"><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis, illo distinctio assumenda nobis nostrum. Error nihil eligendi modi fugiat iure, eveniet, nisi soluta blanditiis itaque ipsam similique voluptatibus minima quidem.</p></div>
				</div>

			</div>		

<!-- 			<div class="container">
				
				<div class="home-widget">
					<h3 class="home-widget-title">Designed with customers in mind.</h3>
					<p class="home-widget-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis rerum, distinctio amet quibusdam facere sint possimus vel sed. Maiores, enim, sunt! Ab error, magni dolor facilis deserunt laudantium molestiae ut?</p>
				</div>

			</div>

			<div class="container">
				
				<div class="home-widget">
					<h3 class="home-widget-title">Still have questions?</h3>
					<p class="home-widget-description">Lorem ipsum dolor sit amet, <a href="/help">consectetur adipisicing</a> elit. </p>
				</div>

			</div> -->

	<?php endwhile; ?>


<?php get_footer(); ?>
