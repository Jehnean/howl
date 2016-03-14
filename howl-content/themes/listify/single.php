<?php
/**
* The Template for displaying all single posts.
*
* @package Listify
*/

get_header(); ?>

<div class="blog-subheader">
	<div class="container">
		<div class="row">
			<div class="col-md-3 col-sm-6 col-xs-12">
				<a href="/blog" class="clear-btn"> <span class="btn-icon"> < </span> Advice &amp; Blog</a>
			</div>

			<div class="col-md-9 col-sm-6 col-xs-12 text-right sm-text-center">
				<a href="/post-a-project" class="blue-btn">+ New project</a>
			</div>
		</div>		
	</div>	
</div>

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
							<?php echo get_the_date(); ?> by
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
					<div class="entry-content">
						<?php the_content(); ?>
					</div>

					<div class="social-sharing">
					<!-- Needs social sharing -->	
					</div>
										
				</main>

	<?php endwhile; ?>

	<?php get_sidebar(); ?>

			</div>
	</div>

	<div class="related-posts-wrapper">
		<div class="container">
			<div class="row">
				<div class="title-container text-center">
					<h3>More Reading</h3>
				</div>
			</div>

      <?php
      $related = howl_get_related_posts( get_the_ID(), 3 );
       
      if( $related->have_posts() ):
      ?>

    <?php while( $related->have_posts() ): $related->the_post(); ?>
    	<?php $author = get_the_author(); ?>

			<div class="col-sm-4 related-article text-center">
				<div class="related-thumbnail">
					<a href="<?php the_permalink(); ?>">
					<?php 
					if (has_post_thumbnail( $post->ID ) ): ?>
					<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
					$image = $image[0]; 
					?>
					<?php else :
					$image = get_template_directory_uri() . '/images/build/howl-placeholder.jpg';
					?>
					<?php endif; ?>

					<img src="<?php echo $image; ?>" alt="<?php the_title(); ?> thumbnail">
					</a>
				</div>
				<div class="related-description">
          <div class="related-title">
            <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
          </div>

					<span class="entry-date">
						<?php echo get_the_date(); ?> by <?php echo $author; ?>
					</span>

       </div> 
			</div>
                        
			<?php endwhile; ?>
			<?php endif; wp_reset_postdata(); ?>

		</div>
	</div>	

<?php get_footer(); ?>
