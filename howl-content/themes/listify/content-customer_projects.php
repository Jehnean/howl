
		<?php $author = get_the_author(); ?>

  <?php do_action( 'listify_page_before' ); ?>

  <div id="primary" class="container">
    <div class="dashboard-header-container">
    	<a href="/customer-dashboard" class="back-to-dashboard-link">Your Projects</a>
      
      <h1 class="dashboard-title"><?php echo get_post_meta( $post->ID, 'project_type', true ); ?> Project</h1>

    </div> 

<!-- <h1 class="home-widget-title"><?php the_title(); ?></h1> -->


	<div class="entry-meta">
		<p>Professional Service</p>
		<span class="service-title">
			<?php echo get_post_meta( $post->ID, 'project_type', true ); ?>
		</span>
		<span class="entry-date">
			<?php echo get_the_date(); ?>
		</span>
	<!-- 	<span class="entry-author">					
			<?php echo $author; ?>
		</span> -->
		
		<span>Description</span>
		<?php the_content(); ?>
		
	</div>

</div>
