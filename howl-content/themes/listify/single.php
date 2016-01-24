<?php
/**
* The Template for displaying all single posts.
*
* @package Listify
*/

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>
		<?php $author = get_the_author(); ?>

	<div <?php echo apply_filters( 'listify_cover', 'homepage-cover page-cover entry-cover', array( 'size' =>
	'full' ) ); ?>>

		<div class="cover-wrapper container">
			<div class="listify_widget_search_listings">
				<div class="home-widget-section-title">
					<h1 class="home-widget-title"><?php the_title(); ?></h1>

					<div class="entry-meta">
						<span class="entry-date">
							<?php echo get_the_date(); ?>
						</span>
						<span class="entry-author">					
							<?php echo $author; ?>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div id="primary" class="container">
			<div class="row content-area">

				<main id="main" class="site-main col-md-8 col-sm-7 col-xs-12" role="main">
					<?php get_template_part( 'content' ); ?>
					<!-- Needs social sharing -->
					<!-- Needs related posts -->
				</main>

	<?php endwhile; ?>

	<?php get_sidebar(); ?>

			</div>
	</div>

<?php get_footer(); ?>
