<?php
/**
 * Template Name: Page: Professional Services
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
							<h1 class="home-widget-title"><?php // the_title(); ?>Professional Services</h1>
							<h2 class="home-widget-description"><?php echo strip_shortcodes( get_the_content() ); ?></h2>
						</div>

					<?php
						locate_template( array( 'job-filters-basic.php', 'job-filters.php'), true, false );
					?>						
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
					<div class="row">
	            
		        <section id="image-grid-term-dog-walking" class="col-xs-12 col-sm-6 col-md-4 image-grid-item">
		            <div style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/build/service-dog-walking.jpg');" class="col-xs-12 col-sm-6 col-md- image-grid-cover entry-cover has-image">
		                <a href="" class="image-grid-clickbox"></a>
		                <a href="" class="cover-wrapper">Dog Walking</a>
		            </div>
		        </section>

		        
		        <section id="image-grid-term-handyman" class="col-xs-12 col-sm-6 col-md-4 image-grid-item">
		            <div style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/build/service-handyman.jpg');" class="col-xs-12 col-sm-6 col-md- image-grid-cover entry-cover has-image">
		                <a href="" class="image-grid-clickbox"></a>
		                <a href="" class="cover-wrapper">Handyman</a>
		            </div>
		        </section>

		        
		        <section id="image-grid-term-plumbers" class="col-xs-12 col-sm-6 col-md-4 image-grid-item">
		            <div style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/build/service-plumbing-service.jpg');" class="col-xs-12 col-sm-6 col-md- image-grid-cover entry-cover has-image">
		                <a href="" class="image-grid-clickbox"></a>
		                <a href="" class="cover-wrapper">Plumbers</a>
		            </div>
		        </section>

		        
		        <section id="image-grid-term-electricians" class="col-xs-12 col-sm-6 col-md-4 image-grid-item">
		            <div style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/build/service-electrician.jpg');" class="col-xs-12 col-sm-6 col-md- image-grid-cover entry-cover has-image">
		                <a href="" class="image-grid-clickbox"></a>
		                <a href="" class="cover-wrapper">Electricians</a>
		            </div>
		        </section>

		        
		        <section id="image-grid-term-hvac" class="col-xs-12 col-sm-6 col-md-4 image-grid-item">
		            <div style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/build/service-ac-repair.jpg');" class="col-xs-12 col-sm-6 col-md- image-grid-cover entry-cover has-image">
		                <a href="" class="image-grid-clickbox"></a>
		                <a href="" class="cover-wrapper">HVAC</a>
		            </div>
		        </section>

		        
		        <section id="image-grid-term-car-washing" class="col-xs-12 col-sm-6 col-md-4 image-grid-item">
		            <div style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/build/service-car-wash.jpg');" class="col-xs-12 col-sm-6 col-md- image-grid-cover entry-cover has-image">
		                <a href="" class="image-grid-clickbox"></a>
		                <a href="" class="cover-wrapper">Car Washing</a>
		            </div>
		        </section>

	            
	        </div>

			</div>
	</main>
	<?php endwhile; ?>


<?php get_footer(); ?>
