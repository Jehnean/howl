<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Listify
 */

get_header(); ?>

		<main id="main" class="site-main" role="main">
	<div class="page-cover entry-cover errorpage-cover">
			<div class="row content-area leadertext-area">
				<div class="col-md-12 col-sm-12 col-xs-12 text-center items-3-section-title home-widget">
		<div class="cover-wrapper container">
			<div class="listify_widget_search_listings">
				<div class="home-widget-section-title">
					<h1 class="home-widget-title"><?php _e( 'Oh no! Page not found.', 'listify' ); ?></h1>
					<p><?php _e( 'Looks like the page you&rsquo;re trying to visit doesn&rsquo;t exist. Help us find what you&rsquo;re looking for.', 'listify' ); ?></p>
					<?php get_search_form(); ?>
				</div>

			</div>
		</div>		
	</div>
</div>
		</div>
	</main>
<?php get_footer(); ?>
