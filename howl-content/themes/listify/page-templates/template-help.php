<?php
/**
 * Template Name: Page: Help
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
							<h1 class="home-widget-title"><?php // the_title(); ?>How can we help you?</h1>


						<form id="search-faq-form" method="GET">
							<div class="search_keywords">
							    <input type="text" name="s" id="search_faqs" placeholder="Search for anything. (booking a pro, getting paid, reviews)" />
											<button type="submit" data-refresh="Loading..." data-label="Get Started" name="update_faqs" class="update_faqs">GO</button>
							</div>
						</form>


						<script type="text/javascript">
							jQuery(document).ready(function($){

									$("#search-faq-form").on("submit", function(e){
											e.preventDefault();
											var faqsearch = $(this).find("#search_faqs").val();
											$(".page-template-template-help .homepage-cover").addClass("search-on");
											$(".page-template-template-help .form-block.faq-block").addClass("search-on");
											$(".page-template-template-help .content-area").addClass("search-on");


											<?php
											global $current_user;

											$user_role = false;
											if(!empty($current_user)){
													$user_roles = $current_user->roles;
													$user_role = array_shift($user_roles);
											}

											switch ($user_role) {
												case 'administrator':
												case 'professional':
															$usertype = "pro";
													break;
												default:
															$usertype = "customer";
													break;
											}
											?>
											var usertype = '<?php echo $usertype; ?>';

											$.ajax({
													url: listifySettings.ajaxurl,
													dataType: "json",
													data: {
														'action':'search_ajax_faqs',
														'usertype' : usertype,
														's': faqsearch
													},
													success:function(data) {
													  	//console.log(data);

																var list = "";
																function tplr(title, answer){
																		var tpl = '<h1 itemprop="name" class="faq_listing-title">'+title+'</h1>' +
																		'<div class="job_listing-location job_listing-location-formatted">' +
																		'		<span class="answer">'+answer+'</span>' +
																		'</div>';
																		return tpl;
																}

																$.each(data, function(index, value){
																		list += tplr(value.question, value.answer);
																});

																$(".faq-entry-meta").html(list);
													},
													error: function(errorThrown){
													   //console.log(errorThrown);
																$(".faq-entry-meta").html(errorThrown);
													}
											});

											return false;
									});



							});
						</script>


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

    <div id="primary" class="container">

			<div class="container large-text-description-block">

					<div class="content-area leadertext-area">

							<div class="form-block faq-block col-md-12 col-sm-12 col-xs-12">
										<div class="faq-entry-meta">
										</div>
							</div>

					</div>

			</div>

  <div class="row content-area">

      <main id="main" class="site-main col-md-8 col-sm-7 col-xs-12" role="main">

        <h3>Help Center</h3>

        <div id="help-tabs-content" class="tab-content">
        	<div class="tab-pane active" id="customer">
					<?php 
					// Define custom query parameters
					$customer_args = array(
					  'post_type' => 'faq',
						'showposts' => -1,
						'faqtags' => 'customer-answers',
						'order' => 'ASC'
					);

					// Instantiate custom query
					$custom_query = new WP_Query( $customer_args);

					?>

					<?php if ( $custom_query->have_posts() ) : ?>
					  <?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>

					  	<?php 
					  		$postid = get_the_ID(); 
					  		$post_slug=$post->post_name;
					  	?>

					      <h4 class="panel-title">
									<a class="faq-title-toggle" role="button" data-toggle="collapse" href="#<?php echo $post_slug; ?>" aria-expanded="false" aria-controls="<?php echo $post_slug; ?>">
									  <?php the_title(); ?>
									</a>
					      </h4>
						    <div id="<?php echo $post_slug; ?>" class="collapse" aria-labelledby="<?php echo $post_slug; ?>">
						      <div class="well">
						        <?php the_content(); ?>
						      </div>
						    </div>


					  <?php endwhile; endif; wp_reset_postdata(); ?>				

        	</div>

        	<div class="tab-pane" id="professional">
        	<?php 
					// Define custom query parameters
					$pro_args = array(
					  'post_type' => 'faq',
						'showposts' => -1,
						'faqtags' => 'professional-answers',
						'order' => 'ASC'
					);

					// Instantiate custom query
					$pro_query = new WP_Query( $pro_args);

					?>

					<?php if ( $pro_query->have_posts() ) : ?>
					  <?php while ( $pro_query->have_posts() ) : $pro_query->the_post(); ?>

					  	<?php 
					  	$postid = get_the_ID();
							$post_slug=$post->post_name;
							?>

					      <h4 class="panel-title">
									<a class="faq-answer-title" role="button" data-toggle="collapse" href="#<?php echo $post_slug; ?>p" aria-expanded="false" aria-controls="<?php echo $post_slug; ?>">
									  <?php the_title(); ?>
									</a>
					      </h4>
						    <div id="<?php echo $post_slug; ?>p" class="collapse" aria-labelledby="<?php echo $post_slug; ?>">
						      <div class="faq-answer-container">
						        <?php the_content(); ?>
						      </div>
						    </div>


					  <?php endwhile; endif; wp_reset_postdata(); ?>
        	</div>
        	
        </div>

      </main>

       <?php get_sidebar('faq-module'); ?>

  </div>
    </div>

	<?php endwhile; ?>


<?php get_footer(); ?>
