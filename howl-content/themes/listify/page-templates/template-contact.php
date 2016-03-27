<?php
/**
 * Template Name: Page: Contact
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


					<style media="screen">

					</style>


						<div class="home-widget-section-title">
							<h1 class="home-widget-title"><?php // the_title(); ?>How can we help you?</h1>

							<form id="search-faq-form" class="" action="http://howl.wp/listings/" method="GET">
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
												$(".page-template-template-contact .homepage-cover").addClass("search-on");
												$(".page-template-template-contact .form-block.faq-block").addClass("search-on");
												$(".page-template-template-contact .content-area").addClass("search-on");


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
    <main id="main" class="site-main" role="main">
      <div class="container large-text-description-block">

        <div class="content-area leadertext-area">

										<div class="form-block faq-block col-md-12 col-sm-12 col-xs-12">
													<div class="faq-entry-meta">
													</div>
										</div>

										<div class="col-md-12 col-sm-12 col-xs-12 text-center items-3-section-title">
            <h2 class="home-widget-title">Popular Topics</h2>
            <p class="home-widget-description">Find some solutions to commonly asked questions.</p>
          </div>

        </div>

      </div>

      <div class="container icon-column-block">
        <div class="row text-center">
          <div class="icon-column col-md-4 col-sm-12 col-xs-12">
            <div class="icon-header">
              <img src="<?php echo get_template_directory_uri(); ?>/images/build/icon-contact-customer-how-it-works.png" alt="">
            </div>
            <div class="block-description">
              <p><a href="">How it works for customers.</a></p>
            </div>
          </div>

          <div class="icon-column col-md-4 col-sm-12 col-xs-12">
            <div class="icon-header">
              <img src="<?php echo get_template_directory_uri(); ?>/images/build/icon-contact-pro-matching.png" alt="">
            </div>
            <div class="block-description">
              <p><a href="">How do pros get matched to projects?</a></p>
            </div>
          </div>

          <div class="icon-column col-md-4 col-sm-12 col-xs-12">
            <div class="icon-header">
              <img src="<?php echo get_template_directory_uri(); ?>/images/build/icon-contact-no-spam.png" alt="">
            </div>
            <div class="block-description">
              <p><a href="">No spam or fake leads. We Promise.</a></p>
            </div>
          </div>

        </div>

        <div class="row text-center">
          <div class="icon-column col-md-4 col-sm-12 col-xs-12">
            <div class="icon-header">
              <img src="<?php echo get_template_directory_uri(); ?>/images/build/icon-contact-pro-how-it-works.png" alt="">
            </div>
            <div class="block-description">
              <p><a href="">How it works for professionals.</a></p>
            </div>
          </div>

          <div class="icon-column col-md-4 col-sm-12 col-xs-12">
            <div class="icon-header">
              <img src="<?php echo get_template_directory_uri(); ?>/images/build/icon-contact-reviews.png" alt="">
            </div>
            <div class="block-description">
              <p><a href="">How do you reviews work?</a></p>
            </div>
          </div>

          <div class="icon-column col-md-4 col-sm-12 col-xs-12">
            <div class="icon-header">
              <img src="<?php echo get_template_directory_uri(); ?>/images/build/icon-contact-pro-pricing.png" alt="">
            </div>
            <div class="block-description">
              <p><a href="">Learn about professional pricing.</a></p>
            </div>
          </div>
        </div>
      </div>

    <div class="form-block">
      <div class="container small-text-description-block" id="contactform">
        <div class="inner-content-wrapper">
          <div class="content-area leadertext-area">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
              <div class="text-wrapper text-center">
                <h2 class="block-widget-title">Send us a message</h2>
                <p>We'd love to hear from you! Please help us improve this platform by sending us your comments, suggesstions, and complaints - and let us know if you'd like to help. You can use the form below to reach us. We read every email and completed form you send. Promise.</p>
              </div>

              <?php gravity_form('Flexible Contact Form', false, false, false, '', true); ?>

          <div class="modal fade bs-example-modal-md" id="flexFormModal" tabindex="-1" role="dialog" aria-labelledby="flexFormModal">
            <div class="modal-dialog modal-md">
              <div class="modal-content text-center">
                <h1>Thank you for sending us a message!</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
              </div>
            </div>
          </div>
            </div>

          </div>
        </div>

      </div>
    </div>

    <div class="form-block">
      <div class="container small-text-description-block">
        <div class="inner-content-wrapper">
          <div class="content-area leadertext-area">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
              <div class="text-wrapper text-center">
                <h2 class="block-widget-title">Let's Talk!</h2>
                <p>Please share your email address and telephone number to have a customer service representative give you a call at right away.</p>
              </div>

              <?php gravity_form('Phone Call Feedback', false, false, false, '', true); ?>


          <div class="modal fade bs-example-modal-md" id="callModal" tabindex="-1" role="dialog" aria-labelledby="callModal">

            <div class="modal-dialog modal-md">
              <div class="modal-content text-center">
                <h1>Thanks for requesting a call.</h1>
                <p>A Howl customer service representative will give you a call at right away.</p>

                <a href="#" class="blue-btn">Cancel call</a>

                <p><sub>Need something else? <a href="/contact-us#contactform">Contact Us</a></sub></p>
              </div>
            </div>
          </div>

            </div>

          </div>
        </div>
      </div>
    </div>

    </main>


	<?php endwhile; ?>


<?php get_footer(); ?>
