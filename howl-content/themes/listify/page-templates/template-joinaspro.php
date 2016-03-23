<?php
/**
 * Template Name: Page: Join as pro
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
              <h1 class="home-widget-title"><?php // the_title(); ?>Grow Your Business</h1>
              <h2 class="home-widget-description"><?php //echo strip_shortcodes( get_the_content() ); ?> Choose your customers. Quote your price. Keep what you earn.</h2>
            </div>

            <div class="professional-services-wrapper">
              <form action="" class="professional-services">
                <select name="professional_categories" id="professional_categories">
                  <option value="test_category">Select a category</option>
                  <option value="test_category">Select a category</option>
                  <option value="test_category">Select a category</option>
                  <option value="test_category">Select a category</option>
                </select>

                <button type="submit" class="blue-btn">Get Started</button>
              </form>  
            </div>
            
          </div>

           <div class="geo-location">
              <span class="address" data-format="city, state"></span>
              <a class="action" data-action="google" href="#">Change Location</a>
            </div>
        </div>
      </div>

      <?php endif; ?>

    <?php endif; ?>   


    <?php do_action( 'listify_page_before' ); ?>
    <main id="main" class="site-main" role="main">      
      <div class="container small-text-description-block">
        
        <div class="content-area leadertext-area">
          <div class="col-md-12 col-sm-12 col-xs-12 text-center items-3-section-title home-widget">
            <h2 class="home-widget-title">We are here to help your business. Real Leads. Honest Pricing.</h2> 
          </div>
          
        </div>

      </div>

      
        <div class="row home-how-it-works pro-how-it-works-area">

        <div class="container">

            <div class="home-features-wrapper row">
              <div class="col-md-4">
                <div class="home-feature">
                  <div class="home-feature-media">
                    <img src="/howl-content/themes/listify/images/icon-computer.png" alt="1. Post your job.">
                  </div>
                  <div class="home-feature-title">
                    <h2>1. Pick customers.</h2>
                  </div>
                  <div class="home-feature-description">
                    <p>You will be notified when a new job becomes available in your area.</p>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="home-feature">
                  <div class="home-feature-media">
                    <img src="/howl-content/themes/listify/images/icon-computer.png" alt="1. Post your job.">
                  </div>
                  <div class="home-feature-title">
                    <h2>2. Send a Quote</h2>
                  </div>
                  <div class="home-feature-description">
                    <p>Review the details, send a message, share your availability, submit a brief or proposal.</p>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="home-feature">
                  <div class="home-feature-media">
                    <img src="/howl-content/themes/listify/images/icon-computer.png" alt="1. Post your job.">
                  </div>
                  <div class="home-feature-title">
                    <h2>3. Get Hired</h2>
                  </div>
                  <div class="home-feature-description">
                    <p>Once you've been selected, you will be connected with a new client.</p>
                  </div>
                </div>
              </div>
              
            </div>
            
            <div class="row">
              <div class="col-sm-12 text-center">
                <a href="/pro-how-it-works" class="blue-btn">How it Works</a>
              </div>
            </div>
        </div>


      </div>


    <!-- Plans -->
    <section id="plans">

        <div class="container">
          <div class="inner-leadertext-area about-page-leaderboard">
            <div class="content-area leadertext-area">
              <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                
                <h2 class="block-widget-title">Our plans pay for themselves</h2>  
                <p>Choose between twenty, fifty, or seventy projects a month. We offer Lorem ipsum dolor sit amet, consectetur adipisicing elit. Harum officia, ipsum voluptatum inventore quisquam culpa dolorem quae sed unde debitis facilis aut.</p>
                
                
              </div>              
            </div>
          </div>          



      </div>

      <div class="container">
        <div class="row">

          <!-- item -->
          <div class="col-md-4 text-center">
            <div class="panel panel-pricing">
              <div class="panel-heading">
                <i class="fa fa-desktop"></i>
                <h3>The Part Timer</h3>
              </div>
              <div class="panel-body text-center">
                <p>$19 <br> <span>Per Month</span></p>
              </div>
              <div class="pricing-cta-container">
                <a class="clear-btn dark-bdr" href="#">Select Plan</a>
              </div>
              <ul class="list-group text-center">
                <li class="list-group-item"><strong>20</strong> projects per month</li>
                <li class="list-group-item">Lorem ipsum dolor sit amet</li>
                <li class="list-group-item">Consectetur adipisicing elit</li>
                <li class="list-group-item">Save $50 a year with an <strong>annual plan</strong>.</li>
              </ul>
              
            </div>
          </div>
          <!-- /item -->

          <!-- item -->
          <div class="col-md-4 text-center">
            <div class="panel panel-pricing light-bg">
              <div class="panel-heading">
                <i class="fa fa-desktop"></i>
                <h3>The Freelancer</h3>
              </div>
              <div class="panel-body text-center">
                <p>$39 <br> <span>Per Month</span></p>
              </div>
              <div class="pricing-cta-container">
                <a class="clear-btn dark-bdr" href="#">Select Plan</a>
              </div>
              <ul class="list-group text-center">
                <li class="list-group-item"><strong>50</strong> projects per month</li>
                <li class="list-group-item">Lorem ipsum dolor sit amet</li>
                <li class="list-group-item">Consectetur adipisicing elit</li>
                <li class="list-group-item">Save $60 a year with an <strong>annual plan</strong>.</li>
              </ul>
              
            </div>
          </div>
          <!-- /item -->

          <!-- item -->
          <div class="col-md-4 text-center">
            <div class="panel panel-pricing blue-bg">
              <div class="panel-heading">
                <i class="fa fa-desktop"></i>
                <h3>The Professional</h3>
              </div>
              <div class="panel-body text-center">
                <p>$59 <br> <span>Per Month</span></p>
              </div>
              <div class="pricing-cta-container">
                <a class="clear-btn dark-bdr" href="#">Select Plan</a>
              </div>
              <ul class="list-group text-center">
                <li class="list-group-item"><strong>70</strong> projects per month</li>
                <li class="list-group-item">Lorem ipsum dolor sit amet</li>
                <li class="list-group-item">Consectetur adipisicing elit</li>
                <li class="list-group-item">Save $70 a year with an <strong>annual plan</strong>.</li>
              </ul>              
            </div>
          </div>
          <!-- /item -->

        </div>
      </div>
    </section>
    <!-- /Plans -->

      <div class="image-headline-wrapper home-footer-headline" style="background-image: url('') !important;">
        <div class="content-area container ">
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 text-center">
              <div class="home-widget-section-title">
                <h2 class="home-widget-title">No matter what plan you choose</h2>
                <p class="image-widget-description">We offer lorem ipsum dolor sit amet, consectetur adipisicing elit. libero aperiam autem praesentium ipsam tenetur.</p>

              </div>
            </div>
          </div>            
        </div>
      <!-- </div> -->


        
        <div class="container">
          <div class="row">
        
                
            <div class="col-md-4">
              <div class="home-feature">
                <div class="inner-feature-media">
                  <img src="">
                </div>

                <div class="home-feature-title">
                  <h3>Project Matching</h3>
                </div>

                <div class="home-feature-description">
                  <p>Matching qualified professionals in their area with relevant customer projects.</p>
                </div>
              </div>
              
            </div>

            <div class="col-md-4">
              <div class="home-feature">
                <div class="inner-feature-media">
                  <img src="">
                </div>

                <div class="home-feature-title">
                  <h3>Business Profile</h3>
                </div>

                <div class="home-feature-description">
                  <p>Easy to setup professional profiles with business info, scheduling options, and customer reviews.</p>
                </div>
              </div>
              
            </div>

            <div class="col-md-4">
              <div class="home-feature">
                <div class="inner-feature-media">
                  <img src="">
                </div>

                <div class="home-feature-title">
                  <h3>Get Reviews</h3>
                </div>

                <div class="home-feature-description">
                  <p>Customer reviews are a major factor in their decision of who to hire.</p>
                </div>
              </div>
              
            </div>

          </div>

          <div class="row">        
                
            <div class="col-md-4">
              <div class="home-feature">
                <div class="inner-feature-media">
                  <img src="">
                </div>

                <div class="home-feature-title">
                  <h3>Messaging</h3>
                </div>

                <div class="home-feature-description">
                  <p>Easy to use messaging system with project details, scheduling, and customer details.</p>
                </div>
              </div>
              
            </div>

            <div class="col-md-4">
              <div class="home-feature">
                <div class="inner-feature-media">
                  <img src="">
                </div>

                <div class="home-feature-title">
                  <h3>Give Estimates</h3>
                </div>

                <div class="home-feature-description">
                  <p>Customers are more likely to hire professionals when provided estimates. Choose from hourly or set pricing.</p>
                </div>
              </div>
              
            </div>

            <div class="col-md-4">
              <div class="home-feature">
                <div class="inner-feature-media">
                  <img src="">
                </div>

                <div class="home-feature-title">
                  <h3>Scheduling Tool</h3>
                </div>

                <div class="home-feature-description">
                  <p>Easy to use scheduling tool to help you keep track of service appointments.</p>
                </div>
              </div>
              
            </div>

          </div>

        </div>
          
        </div>

        <div class="simple-callout-module button-callout-module dark-callout-module">
          <div class="container">         
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                <h3 class="simple-callout-title">Not ready to start a trial?</h3>
                <div class="simple-callout-description">
                  <p><a href="/pro-sign-up">Sign up for free</a> and explore Howl features, <strong>no credit card required</strong>. When you're ready to start accepting client projects upgrade to any paid plan.</p>
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
