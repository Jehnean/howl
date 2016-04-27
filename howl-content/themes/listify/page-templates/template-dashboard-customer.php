<?php
/**
 * Template Name: Customer Dashboard
 *
 */

get_header(); ?>

  <?php do_action( 'listify_page_before' ); ?>

  <?php

    // $pr = get_users( array("role" => "professional") );
    // foreach ($pr as $prr) {
    //   wp_delete_user($prr->ID);
    // }

    /*
    TODO:
      # https://developers.google.com/maps/articles/phpsqlsearch_v3?csw=1
      # geo searching in mysql, but in order to use need to add lat, lan to each user
      SELECT id, ( 3959 * acos( cos( radians(37) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(-122) ) + sin( radians(37) ) * sin( radians( lat ) ) ) ) AS distance FROM markers HAVING distance < 25 ORDER BY distance LIMIT 0 , 20;
     */
    // $Address = urlencode("75 Tremont St, Braintree, MA");
    // $request_url = "http://maps.googleapis.com/maps/api/geocode/xml?address=".$Address."&sensor=true";
    // $xml = simplexml_load_file($request_url) or die("url not loading");
    // $status = $xml->status;
    // if ($status=="OK") {
    //     $Lat = $xml->result->geometry->location->lat;
    //     $Lon = $xml->result->geometry->location->lng;
    //     $LatLng = "$Lat,$Lon";
    //     echo "<pre>";
    //     echo $LatLng;
    //     echo "</pre>";
    // }
    //
    //
    //
    // $all_users = get_users();
    // foreach ( $all_users as $user ) {
    // 	echo '<span>' . esc_html( $user->user_email ) . '</span>';
    // }
  ?>

  <div id="primary" class="container">

    <div class="dashboard-header-container">
      <h1 class="dashboard-title">Your Projects</h1>

      <div class="start-project-container">
        <a href="/post-a-project/">New Project</a>
      </div>
    </div>

    <div class="row">

      <div class="sidebar col-md-4 col-xs-12">
        sticky sidebar
      </div>

    <main id="main" class="site-main col-md-8 col-xs-12" role="main">


    <?php

    // do_shortcode('[piklist_form form="profile-edit" add_on="theme"]');
    // echo apply_filters( 'the_content','[piklist_form form="profile-edit" add_on="theme"]');

    if ( !is_user_logged_in() ) {
      echo 'Please login to view this page';
    } else {

    ?>

<style media="screen">
.list-group-item {
    padding: 0;
}
.list-group-item  > * {
    padding: 10px 15px;
}
.list-group-item  > .edit-project-link{
   text-transform: uppercase;
   float: right;
   clear: both;
   display: block;
   height: 36px;
   width: 180px;
   text-align: right;
}
.list-group-item  > .list-pros {
    padding: 0;
}
.list-group-item  > .list-pros .prep-pros{
   padding: 10px 15px;
   background-color: #F7F7F7;
}
.list-group-item  > .list-pros .prep-pros p{
   margin: 20px auto;
   display: block;
   width: calc(100% - 20px);
   font-size: 17px;
}
.list-group-item .list-group-item-heading{
  font-size: 32px;
}
.list-group-item .list-group-item-heading > a{
  font-size: 32px;
  color: #6D6D6D;
}
.list-group-item .list-group-item-heading,
.list-group-item .list-group-item-text{
  text-align: center;
}
.list-group-item .project_date{
  color: #C5C5C5;
  text-align: center;
  display: block;
}
.client-dashboard-pro-container{
  clear: both;
  float: none;
  width: 100%;
}
.client-dashboard-pro{
  width: calc(20% - 20px);
  float: left;
  margin: 10px;
}
.client-dashboard-pro h4{
  min-height: 48px;
}
.client-dashboard-pro .pro-image{
 border-radius: 50%;
}
</style>

<?php
  $user_id = get_current_user_id();
  $custom_query_args = array(
    'post_type'=> 'customer_projects',
    'author' => $user_id,
    'post_status'=> 'ongoing',
    // 'paged' => $paged,
    'posts_per_page' => 14,
    'order'    => 'DESC'
  );

  // Get current page and append to custom query parameters array
  // $custom_query_args['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

  // Pagination fix
  // $temp_query = $wp_query;
  // $wp_query   = NULL;
  // $wp_query   = $custom_query_args;

  $the_query = new WP_Query( $custom_query_args );
  if($the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
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

<div class="list-group">
  <div class="list-group-item">
    <a href="/post-project/?_post[ID]=<?php echo $project_id ?>" class="edit-project-link">Update Project</a>
    <h4 class="list-group-item-heading">
      <a href="<?php the_permalink(); ?>">
      <?php the_title(); ?>
      </a>
    </h4>
    <?php the_date('m/d/Y', '<span class="project_date">', '</span>'); ?>
    <div class="list-group-item-text">
      <?php the_content(); ?>
    </div>
    <div
     id="project_row_<?php echo $project_id; ?>"
     data-post-id="<?php echo $project_id; ?>"
     data-project-type="<?php echo $term; ?>"
     data-location="<?php echo $location; ?>"
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

<?php endwhile; else: ?>

<p>You don't have any completed projects yet. <a href="/post-a-project">Start a new project</a></p>

<?php endif; wp_reset_postdata(); ?>

<?php
}
?>

<?php //howl_get_pagination(); ?>

<?php wp_reset_query(); ?>

      </main>

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
    		location: $element.attr("data-location")
    	},
    	success: function( html ) {
    		$("#" + elId).html( html );
    	}
    });
  });
});
</script>
<?php get_footer(); ?>
