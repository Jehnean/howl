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
							<h1 class="home-widget-title"><?php the_title(); ?></h1>
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

<?php

// check if the flexible content field has rows of data
if( have_rows('how_it_works_page_modules') ): 
     // loop through the rows of data
    while ( have_rows('how_it_works_page_modules') ) : the_row(); ?>


<?php
 
 if( get_row_layout() == 'large_description_block' ): ?>  

		 <?php  

			$large_text_description = get_sub_field('large_text_description');

		 ?>

			<div class="container large-text-description-block">
				
				<div class="content-area leadertext-area">
					<div class="col-md-12 col-sm-12 col-xs-12 text-center items-3-section-title home-widget">
						<h2 class="home-widget-title"><?php echo $large_text_description; ?></h2>	
					</div>
					
				</div>

			</div>

			<?php elseif( get_row_layout() == 'how_it_works_steps_block' ): ?>

      <div class="container how-it-works-steps-module">
      <?php  
        // check if the nested repeater field has rows of data
        if( have_rows('project_overview_steps') ): ?>

        <?php while ( have_rows('project_overview_steps') ) : the_row(); ?>

		      <?php 
		        $product_gallery_image_id = get_sub_field('project_step_image');
		        $size = 'large'; // (thumbnail, medium, large, full or custom size)      
            $product_gallery_image = wp_get_attachment_image_src( $product_gallery_image_id, $size );

            $project_step_title 			= get_sub_field('project_step_title');
            $project_step_description = get_sub_field('project_step_description');
		      ?>
				<?php  
					if (get_sub_field('alternate_layout') == 'yes') { ?>		      

	        <div class="row alternate-row">
	          
	          <div class="col-xs-12 col-sm-6 text-center">
	            <img src="<?php echo $product_gallery_image[0]; ?>">
	          </div>

						<div class="col-xs-12 col-sm-6 ">
	            <div class="callout-feature-content">
	              <h2 class="callout-feature-title"><?php echo $project_step_title; ?></h2>
	              <p><?php echo $project_step_description; ?></p>
	            </div>
	          </div>	          
	        </div>

					<?php } else { ?>

		        <div class="row">
		          <div class="col-xs-12 col-sm-6 ">
		            <div class="callout-feature-content">
		              <h2 class="callout-feature-title"><?php echo $project_step_title; ?></h2>
		              <p><?php echo $project_step_description; ?></p>
		            </div>
		          </div>

		          <div class="col-xs-12 col-sm-6 text-center">
		            <img src="<?php echo $product_gallery_image[0]; ?>">
		          </div>
		        </div>

					<?php } ?>
				<?php endwhile; endif; ?>

				<?php elseif( get_row_layout() == 'image_column_callout_block' ): ?>


					<?php 
		        $callout_bg_image_id = get_sub_field('image_callout_background_image');
		        $size = 'full'; // (thumbnail, medium, large, full or custom size)
            $callout_bg_image = wp_get_attachment_image_src( $callout_bg_image_id, $size );

            $image_callout_title 			= get_sub_field('image_callout_title');
            $image_callout_description = get_sub_field('image_callout_description');
		      ?>

      <div class="image-headline-wrapper home-footer-headline" style="background-image: url('<?php echo $callout_bg_image[0] ?>') !important;">
        <div class="content-area<?php echo $style; ?> container ">
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 text-center">
              <div class="home-widget-section-title">
                <h2 class="home-widget-title"><?php echo $image_callout_title; ?></h2>
                <p class="image-widget-description"><?php echo $image_callout_description; ?></p>

              </div>
            </div>
          </div>            
        </div>


			<?php  
        // check if the nested repeater field has rows of data
        if( have_rows('image_callout_columns') ): ?>
				
				<div class="container">
					<div class="row">
        
        <?php while ( have_rows('image_callout_columns') ) : the_row(); ?>

				<?php  
				  $callout_column_icon_id				= get_sub_field('callout_column_icon');
				  $size = 'full'; // (thumbnail, medium, large, full or custom size)
				  $callout_column_icon_image		= wp_get_attachment_image_src( $callout_column_icon_id, $size );
				  $callout_column_title 				= get_sub_field('callout_column_title');
				  $callout_column_description 	= get_sub_field('callout_column_description');
				?>
                
            <div class="col-md-4">
              <div class="home-feature">
                <div class="inner-feature-media">
                  <img src="<?php echo $callout_column_icon_image[0]; ?>">
                </div>

                <div class="home-feature-title">
                  <h3><?php echo $callout_column_title; ?></h3>
                </div>

                <div class="home-feature-description">
                  <p><?php echo $callout_column_description; ?></p>
                </div>
              </div>
              
            </div>

				<?php endwhile; ?> 
          </div>
        </div>				
			<?php endif; ?>
      </div>


      <?php elseif( get_row_layout() == 'standard_column_callout_block' ): ?>

				<?php  
				  $standard_callout_title							= get_sub_field('standard_callout_title');
				  $standard_callout_description				= get_sub_field('standard_callout_description');

				  
				?>
      <div class="standard-description-module">
        <div class="content-area<?php echo $style; ?> container ">
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                <h2 class="standard-widget-title"><?php echo $standard_callout_title; ?></h2>
                <p class="standard-widget-description"><?php echo $standard_callout_description; ?></p>
            </div>
          </div>            
        </div>

			<?php  
        // check if the nested repeater field has rows of data
        if( have_rows('standard_callout_columns') ): ?>        

        <div class="container">
          <div class="row text-center">

					<?php while ( have_rows('standard_callout_columns') ) : the_row(); ?>

						<?php  
							$standard_callout_column_title							= get_sub_field('standard_callout_column_title');
							$standard_callout_column_description				= get_sub_field('standard_callout_column_description');
						?>

            <div class="col-md-4">
              <div class="home-feature">

                <div class="home-feature-title">
                  <h3><?php echo $standard_callout_column_title; ?></h3>
                </div>

                <div class="home-feature-description">
                  <p><?php echo $standard_callout_column_description; ?></p>
                </div>
              </div>
              
            </div>

				<?php endwhile; ?> 
          </div>
        </div>				
			<?php endif; ?>

      </div>
      
      <?php elseif( get_row_layout() == 'simple_callout_module' ): ?>

			<?php  
				$simple_callout_title							= get_sub_field('simple_callout_title');
				$simple_callout_description				= get_sub_field('simple_callout_description');
			?>

      <div class="simple-callout-module">
        <div class="container">         
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 text-center">
              <h3 class="simple-callout-title"><?php echo $simple_callout_title; ?></h3>
              <div class="simple-callout-description">
              	<?php echo $simple_callout_description; ?>
              </div>
            </div>
          </div>

        </div>
      </div>        

       <?php endif; ?>
      </div>

      <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>

      <?php

    endwhile;

else : ?>

	<div class="container">         
	  <div class="row">
	    <div class="col-md-12 col-sm-12 col-xs-12 text-center">
	      <p>No layouts being used for page template in use.</p>
	    </div>
	  </div>

	</div>

<?php endif;

?>

	</main>
	<?php endwhile; ?>


<?php get_footer(); ?>
