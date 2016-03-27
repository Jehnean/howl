<?php


function example_ajax_request() {

	// The $_REQUEST contains all the data sent via ajax
	if ( isset($_REQUEST) ) {

		$fruit = $_REQUEST['fruit'];

		// Let's take the data that was sent and do something with it
		if ( $fruit == 'Banana' ) {
			$fruit = 'Apple';
		}

		// Now we'll return it to the javascript function
		// Anything outputted will be returned in the response
		echo $fruit;

		// If you're debugging, it might be useful to see what was sent in the $_REQUEST
		// print_r($_REQUEST);

	}

	// Always die in functions echoing ajax content
   wp_die();
}

add_action( 'wp_ajax_example_ajax_request', 'example_ajax_request' );

// If you wanted to also use the function for non-logged in users (in a theme for example)
add_action( 'wp_ajax_nopriv_example_ajax_request', 'example_ajax_request' );





function search_ajax_faqs() {
 $faq_array = array();
	// The $_REQUEST contains all the data sent via ajax
	if ( isset($_REQUEST) ) {

		$usertype = $_REQUEST['usertype'];
		$search = $_REQUEST['s'];

		// Let's take the data that was sent and do something with it
		if ( $usertype == 'pro' ) {
			 $tax = 'professional-answers';
   // faqtags
		}else{
    $tax = 'customer-answers';
  }

  $args = array(
  	'posts_per_page'   => 5000,
  	'orderby'          => 'date',
  	'order'            => 'DESC',
  	'post_type'        => 'faq',
   'faqtags' => $tax,
  	'post_status'      => 'publish',
  	'suppress_filters' => true
  );

  if(!empty($search)){
    $args['s'] = sanitize_text_field($search);
  }

  $faq_query = get_posts( $args );
  foreach ( $faq_query as $post ) : setup_postdata( $post );
  array_push($faq_array, array(
   "question" => get_the_title($post->ID),
   "answer" => get_the_content()
  ));
  endforeach;
  wp_reset_postdata();


	}

 if(!empty($faq_array)){
   $results = json_encode($faq_array);
 }else{
  array_push($faq_array, array(
   "question" => "No Results",
   "answer" => "Try leaving the search empty or being less specific"
  ));
  $results = json_encode($faq_array);
 }


	// Always die in functions echoing ajax content
   wp_die($results);
}

add_action( 'wp_ajax_search_ajax_faqs', 'search_ajax_faqs' );

// If you wanted to also use the function for non-logged in users (in a theme for example)
add_action( 'wp_ajax_nopriv_search_ajax_faqs', 'search_ajax_faqs' );
