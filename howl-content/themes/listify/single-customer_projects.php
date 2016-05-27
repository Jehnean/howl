<?php
/**
* The Template for displaying all single posts.
*
* @package Listify
*/

get_header(); ?>


<div id="primary" class="container">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php $author = get_the_author(); ?>
	
		<!-- <div class="row content-area"> -->

			<!-- <main id="main" class="site-main col-md-8 col-sm-7 col-xs-12" role="main"> -->
				<?php get_template_part( 'content', 'customer_projects' ); ?>
			<!-- </main> -->

    </div>
	<?php endwhile; ?>


  </div>
<?php get_footer(); ?>
