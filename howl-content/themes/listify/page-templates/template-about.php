<?php
/**
 * Template Name: Page: About
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
							<h1 class="home-widget-title"><?php // the_title(); ?>About Howl</h1>
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
			<div class="container small-text-description-block">
				<div class="inner-leadertext-area about-page-leaderboard">
					<div class="content-area leadertext-area">
						<div class="col-md-12 col-sm-12 col-xs-12 text-center">
              
              <?php 
                $about_page_section_title = get_field('standard_header_title');
                $about_page_section_description = get_field('standard_header_description');
                $general_content_area = get_field('general_content_area');
              ?>

							<h2 class="block-widget-title"><?php echo $about_page_section_title; ?></h2>	
							<?php echo $about_page_section_description ?>

              
						</div>
						

					</div>
				</div>

        <div class="general-content-area-wrapper">
          <?php echo $general_content_area; ?>
        </div>

			</div>

      <div class="standard-description-module about-description-module">
        <div class="content-area<?php echo $style; ?> container ">
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                <h2 class="standard-widget-title">Designed with pros in mind</h2>
                <p class="standard-widget-description">We are here to help you grow your business in the most cost effective way possible. Just because we could charge more, doesn't mean we should. Howl is a better stand-alone alternative.</p>
            </div>
          </div>            
        </div>			

        <div class="container">
          <div class="row text-center">

            <div class="col-md-4">
              <div class="about-feature">

                <div class="about-feature-title">
                  <h3>200,000</h3>
                </div>

                <div class="about-feature-description">
                  <p>Active Professionals</p>
                </div>
              </div>
              
            </div>

            <div class="col-md-4">
              <div class="about-feature">

                <div class="about-feature-title">
                  <h3>400+</h3>
                </div>

                <div class="about-feature-description">
                  <p>Types of Services</p>
                </div>
              </div>
              
            </div>

            <div class="col-md-4">
              <div class="about-feature">

                <div class="about-feature-title">
                  <h3>$500,000</h3>
                </div>

                <div class="about-feature-description">
                  <p>Yearly revenue for pros</p>
                </div>
              </div>
              
            </div>            

          </div>
        </div>
      </div>

      <div class="simple-callout-module button-callout-module">
        <div class="container">         
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 text-center">
              <h3 class="simple-callout-title">Get started with Howl</h3>
              <div class="simple-callout-description">
              	<p>Need to hire a great professional? Want to grow your own business? We can help. Already have an account? <a href="/login">Log In</a>.</p>
              </div>

              <div class="home-how-it-works">
              	<a href="" class="button">Customer Sign Up</a> <a href="" class="button">Professional Sign Up</a>
              </div>
            </div>
          </div>

        </div>
      </div>
	</main>
	<?php endwhile; ?>


<?php get_footer(); ?>
