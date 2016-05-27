
		<?php 
			$author = get_the_author();
		  $project_id = get_the_ID();
		  $project_address = get_post_meta( get_the_ID(), 'project_address', true );
		  $project_city = get_post_meta( get_the_ID(), 'project_city', true );
		  $project_state = get_post_meta( get_the_ID(), 'project_state', true );
		  $pros = get_post_meta($project_id, 'pro_options', true);
		  // if(!empty($pros)){
		  //   $pros = strip_tags($pros);
		  // }
		  $has_pros = (!empty($pros)) ? true : false;
		  $has_city_state = !empty($project_city) && !empty($project_state);
		  $has_howl_api = function_exists("howl_query_api");

		  $project_type = "";
		  $term = "";
		  $location = "";
		  $how_query = "";
		  $businesses = false;

		  $project_type = wp_get_post_terms( $project_id, 'project_tags');
		  if($project_type){
		    $project_type = $project_type[0]->name;
		  }else{
		    $project_type = "";
		  }
		  $term = $project_type;
		  $location = $project_address . ", " . $project_city . ", " . $project_state;
		?>


  <?php //do_action( 'listify_page_before' ); ?>

		<div class="row">
    	<div class="dashboard-header-container">
    		<a href="/customer-dashboard" class="back-to-dashboard-link">Your Projects</a>      
      	<h1 class="dashboard-title"><?php the_title(); ?></h1>
    	</div> 
		</div>

<div class="row">
	<div class="col-md-4">
		<div class="entry-meta">
			<p>Professional Service</p>
			<div class="service-title">
				<h1><?php echo $project_type; ?></h1>
			</div>
			<div class="entry-date">
				<?php echo get_the_date(); ?>
			</div>
			<div class="entry-author">
				<div>Project Contact</div>
				<?php echo $author; ?>
			</div>
			
			<div class="entry-description">
				<span>Description</span>
				<?php the_content(); ?>	
			</div>

			<div class="update-project">
		  <?php
		    $edit_page_id = 1338;

		    do_action('gform_update_post/edit_link', array(
		        'post_id' => $post->ID,
		        'url' => $edit_page_id,
		        'text'    => 'Update Project',
		    ) );
		  ?>				
			</div>	
		</div>	
	</div>


	<div class="col-md-8">
	<div class="matched-professionals-detailed-view">
			<div class="quick-info">
				<h1>Matched Professionals</h1>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A atque quasi maxime, aliquid, ducimus minus dolorem alias vel laborum neque eaque nulla aut officia cumque! Tenetur voluptatem officia adipisci! Perferendis.</p>
			</div>
    <div
     id="project_row_<?php echo $project_id; ?>"
     data-post-id="<?php echo $project_id; ?>"
     data-project-type="<?php echo $term; ?>"
     data-location="<?php echo $location; ?>"
     data-address="<?php echo $project_address; ?>"
     data-city="<?php echo $project_city; ?>"
     data-state="<?php echo $project_state; ?>"
     data-zip="<?php echo $project_state; ?>"
     class="list-pros<?php if(!$has_pros){ echo " need-pros"; } ?>">
      <?php
      if($has_city_state){
        if($has_pros){
          //  echo "<pre>";
          //  var_export($business->location);
          //  echo "</pre>";
          //echo display_client_dashboard_5_pro(json_decode($pros));
          echo display_client_dashboard_5_pro($pros);
        }else{
         echo "<div class='prep-pros'>";
         echo "<p>";
         echo "We're working to match you with the best professionals for your project.";
         echo " You'll be matched very soon,";
         echo "so professionals can ask you questions about your project and provide a quote.";
         echo "</p>";
         echo "</div>";
        }
      }
      ?>
    </div>		
	</div>

</div>

<script type="text/javascript">
jQuery(document).ready(function($){
  $(".list-pros.need-pros").each(function(index, value){
    var $element = $(value);
    var elId = $element.attr("id");
    $.ajax({
    	url: FindPros.url,
    	type: 'post',
    	data: {
    		action: 'save_dashboard_pros',
    		postId: $element.attr("data-post-id"),
    		currentUser: <?php echo get_current_user_id(); ?>,
    		projectType: $element.attr("data-project-type"),
    		location: $element.attr("data-location"),
       address: $element.attr("data-address"),
       city: $element.attr("data-city"),
       state: $element.attr("data-state"),
       zip: $element.attr("data-zip")
    	},
    	success: function( html ) {
    		$("#" + elId).html( html );
    	}
    });
  });
});
</script>