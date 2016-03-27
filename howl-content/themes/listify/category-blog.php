<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listify
 */

get_header(); ?>

	<div>
		<h1 class="page-title cover-wrapper">
			<?php
				if ( is_category() ) :
					single_cat_title();
				else :
					_e( 'Archives', 'listify' );

				endif;
			?>
		</h1>
	</div>

	<div id="primary" class="container">
		<div class="row content-area">

			<main id="main" class="site-main col-md-8 col-sm-7 col-xs-12" role="main">

				<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'content', 'blog' ); ?>

					<?php endwhile; ?>

					<?php get_template_part( 'content', 'pagination' ); ?>

				<?php else : ?>

					<?php get_template_part( 'content', 'none' ); ?>

				<?php endif; ?>

			</main>

			<?php get_sidebar(); ?>

		</div>
	</div>

<?php get_footer(); ?>
