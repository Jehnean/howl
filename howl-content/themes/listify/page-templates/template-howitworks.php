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
		<main id="main" class="site-main" role="main">			
			<div class="container">
				
			<div class="content-area leadertext-area">
				<div class="col-md-12 col-sm-12 col-xs-12 text-center items-3-section-title home-widget">
					<h2 class="home-widget-title">We'll match you to the 5 best project pros in your area for your project.</h2>	
				</div>
				
			</div>

			</div>

			<div class="container how-it-works-steps-module">

				<div class="row">
					<div class="col-xs-12 col-sm-6 ">
						<div class="callout-feature-content">
							<h2 class="callout-feature-title">1. Post whatever you want help with.</h2>
							<p>Tell us what you need help with and we wil send you the details to the most qualified professionals in your area.</p>
						</div>
					</div>

					<div class="col-xs-12 col-sm-6 text-center">
						<img src="<?php echo get_template_directory_uri(); ?>/images/build/howl-customer-how-it-works-step-1.png" alt="">
					</div>
				</div>

				<div class="row">
					<div class="col-xs-12 col-sm-6 text-center">
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

					<div class="col-xs-12 col-sm-6 text-center">
						<img src="<?php echo get_template_directory_uri(); ?>/images/build/howl-customer-how-it-works-step-3.png" alt="">
					</div>
				</div>

			</div>


			<div class="image-headline-wrapper home-footer-headline">
				<div class="content-area<?php echo $style; ?> container ">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 text-center">
							<div class="home-widget-section-title">
								<h2 class="home-widget-title">Howl takes less than 2 minutes.</h2>
								<p class="image-widget-description">Why not use the time you would have spent on the phone trying to find someone to fix the water heater(or whatever) to watch one more episode on Netflix, walk your dog, play with your kids, or take a bubble bath? We'll take care of the rest. </p>

							</div>
						</div>
					</div>						
				</div>

				<div class="container">
					<div class="row">
						<div class="col-md-4">
							<div class="home-feature">
								<div class="home-feature-media">
									<img src="" alt="">
								</div>

								<div class="home-feature-title">
									<h3>Pricing</h3>
								</div>

								<div class="home-feature-description">
									<p>Easy to understand and compare pricing from pros.</p>
								</div>
							</div>
							
						</div>

						<div class="col-md-4">
							<div class="home-feature">
								<div class="home-feature-media">
									<img src="" alt="">
								</div>

								<div class="home-feature-title">
									<h3>Scheduling</h3>
								</div>

								<div class="home-feature-description">
									<p>Schedule service right away at a time that works best for you.</p>
								</div>
							</div>
							
						</div>

						<div class="col-md-4">
							<div class="home-feature">
								<div class="home-feature-media">
									<img src="" alt="">
								</div>

								<div class="home-feature-title">
									<h3>Reviews</h3>
								</div>

								<div class="home-feature-description">
									<p>Select the professional with the best reviews and share your review too.</p>		
								</div>
							</div>
							
						</div>

					</div>
				</div>

			</div>


			<div class="standard-description-module">
				<div class="content-area<?php echo $style; ?> container ">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 text-center">
								<h2 class="standard-widget-title">Designed with customers in mind.</h2>
								<p class="standard-widget-description">Other professional service providers give your information to unselected professionals, resulting in unwanted calls or even visits. Howl is different. We only share your information with your selected, local professional.</p>
						</div>
					</div>						
				</div>

				<div class="container">
					<div class="row text-center">
						<div class="col-md-4">
							<div class="home-feature">

								<div class="home-feature-title">
									<h3>FREE</h3>
								</div>

								<div class="home-feature-description">
									<p>Howl is always free for customers</p>
								</div>
							</div>
							
						</div>

						<div class="col-md-4">
							<div class="home-feature">

								<div class="home-feature-title">
									<h3>NO SPAM</h3>
								</div>

								<div class="home-feature-description">
									<p>Your information is only shared with the pro you hire.</p>
								</div>
							</div>
							
						</div>

						<div class="col-md-4">
							<div class="home-feature">

								<div class="home-feature-title">
									<h3>FAST</h3>
								</div>

								<div class="home-feature-description">
									<p>Professionals matched to your project right away.</p>
								</div>
							</div>
							
						</div>

					</div>
				</div>

			</div>

			<div class="simple-callout-module">
				<div class="container">					
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 text-center">
							<h3 class="simple-callout-title">Still have questions?</h3>
							<p class="simple-callout-description">Visit our <a href="/help">Help Center</a> to Learn More. </p>
						</div>
					</div>

				</div>
			</div>
	</main>
	<?php endwhile; ?>


<?php get_footer(); ?>
