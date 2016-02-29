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
	
		<div class="row content-area">

			<main id="main" class="site-main col-md-8 col-sm-7 col-xs-12" role="main">
				<?php get_template_part( 'content', 'customer_projects' ); ?>
			</main>

    <?php  
    $edit_post_data      = isset($_GET['_post']) ? $_GET['_post'] : null;
    $edit_post_id        = isset($edit_post_data['ID']) ? absint($edit_post_data['ID']) : -1;
    $edit_post_status    = get_post_status($edit_post_id);
    $edit_post_published = ( 'ongoing' === $edit_post_status ) ? true : false;

    // Hide field if editing a published post
    if ( ! $edit_post_published ) {
        // My piklist field(s)

    }
    ?>
    </div>
	<?php endwhile; ?>


  </div>
<?php get_footer(); ?>
