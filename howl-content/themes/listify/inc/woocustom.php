<?php
/**
 * Custom Woocommerce functions.
 */


/**
 * Add new register fields for customer WooCommerce registration.
 *
 * @return string Register fields HTML.
 */
function wooc_extra_register_fields() {
  ?>

  <p class="form-row form-row-first">
  <label for="reg_billing_first_name"><?php _e( 'First name', 'woocommerce' ); ?> <span class="required">*</span></label>
  <input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" placeholder="First Name"/>
  </p>

  <p class="form-row form-row-last">
	  <label for="reg_billing_last_name"><?php _e( 'Last name', 'woocommerce' ); ?> <span class="required">*</span></label>
	  <input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" placeholder="Last Name"/>
  </p>


  <?php
}

?>
<?php
add_action( 'woocommerce_register_form_start', 'wooc_extra_register_fields' );

/**
 * Validate the extra customer register fields.
 *
 * @param  string $username          Current username.
 * @param  string $email             Current email.
 * @param  object $validation_errors WP_Error object.
 *
 * @return void
 */
function wooc_validate_extra_register_fields( $username, $email, $validation_errors ) {
  if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {
    $validation_errors->add( 'billing_first_name_error', __( '<strong>Error</strong>: First name is required!', 'woocommerce' ) );
  }

  if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {
    $validation_errors->add( 'billing_last_name_error', __( '<strong>Error</strong>: Last name is required!.', 'woocommerce' ) );
  }

	if(!isset($_POST['term_agree']) && $_POST['term_agree'] != "on") {
		$validation_errors->add('error', 'Please check box');
	}

}

add_action( 'woocommerce_register_post', 'wooc_validate_extra_register_fields', 10, 3 );

/**
 * Save the extra customer register fields.
 *
 * @param  int  $customer_id Current customer ID.
 *
 * @return void
 */
function wooc_save_extra_register_fields( $customer_id ) {

  if ( isset( $_POST['billing_first_name'] ) ) {
		// WordPress default first name field.
		update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['billing_first_name'] ) );

		// WooCommerce billing first name.
		update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
	}

	if ( isset( $_POST['billing_last_name'] ) ) {
		// WordPress default last name field.
		update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['billing_last_name'] ) );

		// WooCommerce billing last name.
		update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
	}

}

add_action( 'woocommerce_created_customer', 'wooc_save_extra_register_fields' );

// Extra fields for professional sign up form short flow
function howl_pro_form() {?>
	<?php if ( is_page('pro-sign-up') ) : ?>
		<p class="form-row form-row-wide">
      <span>What kind of services do you offer?</span>
  		<input type="text" class="input-text" name="business_primary_service" id="reg_business_service" value="<?php if ( ! empty( $_POST['business_primary_service'] ) ) esc_attr_e( $_POST['business_primary_service'] ); ?>" />
		</p>

		<p class="form-row form-row-first">
			<span>Street Address</span>
  		<input type="text" class="input-text" name="street_address" id="reg_street_address" value="<?php if ( ! empty( $_POST['street_address'] ) ) esc_attr_e( $_POST['street_address'] ); ?>" />
		</p>
		<p class="form-row form-row-last">
			<span>City</span>
  		<input type="text" class="input-text" name="city" id="reg_city" value="<?php if ( ! empty( $_POST['city'] ) ) esc_attr_e( $_POST['city'] ); ?>" />
		</p>
		<p class="form-row form-row-first">
			<span>State</span>
  		<input type="text" class="input-text" name="state" id="reg_state" value="<?php if ( ! empty( $_POST['state'] ) ) esc_attr_e( $_POST['state'] ); ?>" />
		</p>
		<p class="form-row form-row-last">
			<span>Zip</span>
  		<input type="text" class="input-text" name="zip" id="reg_zip" value="<?php if ( ! empty( $_POST['zip'] ) ) esc_attr_e( $_POST['zip'] ); ?>" />
		</p>

	<?php endif;
}
?>
<?php

add_action( 'register_form', 'howl_pro_form' );

/**
 * Validate the extra professional register fields.
 *
 * @param  string $username          Current username.
 * @param  string $email             Current email.
 * @param  object $validation_errors WP_Error object.
 *
 * @return void
 */
function wooc_validate_howl_pro_form( $username, $email, $validation_errors ) {
  if ( isset( $_POST['business_primary_service'] ) && empty( $_POST['business_primary_service'] ) ) {
    $validation_errors->add( 'billing_business_primary_service_error', __( '<strong>Error</strong>: Primary business service is required!', 'woocommerce' ) );
  }

  if ( isset( $_POST['business_location'] ) && empty( $_POST['business_location'] ) ) {
    $validation_errors->add( 'billing_business_location_error', __( '<strong>Error</strong>: Business location is required!.', 'woocommerce' ) );
  }

}

add_action( 'woocommerce_register_post', 'wooc_validate_howl_pro_form', 10, 3 );

/**
 * Save the extra professional register fields.
 *
 * @param  int  $customer_id Current customer ID.
 *
 * @return void
 */
function wooc_save_extra_howl_pro_form_fields( $customer_id ) {
	if ( isset( $_POST['business_primary_service'] ) ) {
		// WordPress default first name field.
		update_user_meta( $customer_id, 'business_primary_service', sanitize_text_field( $_POST['business_primary_service'] ) );

		wp_update_user(array(
		  'ID' => $customer_id,
		  'role' => 'professional' // Update to desired role
		));

	}

	//if ( isset( $_POST['street_address'] ) ) {
		// WordPress default last name field.

    //update_user_meta( $customer_id, 'business_location', sanitize_text_field( $_POST['business_location'] ) );

    $street_address =  isset( $_POST['street_address']) ?  $_POST['street_address'] : '';
    $city =  isset( $_POST['city']) ?  $_POST['city'] : '';
    $state =  isset( $_POST['state']) ?  $_POST['state'] : '';
    $zip =  isset( $_POST['zip']) ?  $_POST['zip'] : '';

    if(!empty($street_address)){
         update_user_meta( $customer_id, 'billing_address_1', $street_address);
     }

     if(!empty($city)){
         update_user_meta( $customer_id, 'billing_city', $city);
     }

     if(!empty($zip)){
         update_user_meta( $customer_id, 'billing_postcode', $zip);
     }

     if(!empty($state)){
         update_user_meta( $customer_id, 'billing_state', $state);
     }


    $lat = false;
  	$lon = false;
    $full_address = $street_address . ", " . $city . ", " . $state  . ", " . $zip;
    $use_address = urlencode($full_address);
    $request_url = "http://maps.googleapis.com/maps/api/geocode/xml?address=".$use_address."&sensor=true";
    $xml = simplexml_load_file($request_url);
    if(!empty($xml)){
      $status = $xml->status;
      if ($status=="OK") {
        $lat = (string)$xml->result->geometry->location->lat;
        $lon = (string)$xml->result->geometry->location->lng;
      }
    }

    if($lat){
      update_user_meta( $customer_id, 'lat', $lat);
    }

    if($lon){
      update_user_meta( $customer_id, 'lon', $lon);
    }
	//}

  update_user_meta( $customer_id, 'review_count', 0);

  update_user_meta( $customer_id, 'rating', 3);

  update_user_meta( $customer_id, 'business_image', "");

}

add_action( 'woocommerce_created_customer', 'wooc_save_extra_howl_pro_form_fields' );

/**
 * Redirect users to custom URL based on their role after login
 *
 * @param string $redirect
 * @param object $user
 * @return string
 */
function wc_custom_user_redirect( $redirect, $user ) {
	// Get the first of all the roles assigned to the user
	$role = $user->roles[0];
	$dashboard = admin_url();
	$myaccount = get_permalink( wc_get_page_id( 'myaccount' ) ); // change to redirect to project dashboard
	$customer_dashboard = get_permalink(922);
	$pro_dashboard = get_permalink(924);
	if( $role == 'administrator' ) {
		//Redirect administrators to the dashboard
		$redirect = $dashboard;
	} elseif ( $role == 'shop-manager' ) {
		//Redirect shop managers to the dashboard
		$redirect = $dashboard;
	} elseif ( $role == 'editor' ) {
		//Redirect editors to the dashboard
		$redirect = $dashboard;
	} elseif ( $role == 'author' ) {
		//Redirect authors to the dashboard
		$redirect = $dashboard;
	} elseif ( $role == 'customer' || $role == 'subscriber' ) {
		//Redirect customers to their dashboard
		$redirect = $customer_dashboard;
	} elseif ( $role == 'professional') {
		//Redirect pros to their dashboard
		$redirect = $pro_dashboard;
	} else {
		//Redirect any other role to the previous visited page or, if not available, to the home
		$redirect = wp_get_referer() ? wp_get_referer() : home_url();
	}
	return $redirect;
}
add_filter( 'woocommerce_login_redirect', 'wc_custom_user_redirect', 10, 2 );

// protect dashboards from outside eyes.
function howl_stop_guests( $content ) {
    global $post;

    if ( $post->post_type == 'customer-projects' ) {
        if ( !is_user_logged_in() ) {
            $content = 'Please login to view this page';
        }
    }

    return $content;
}
add_filter( 'the_content', 'howl_stop_guests' );


/**
 * Detect if a User has a Subscription with Woocommerce Subscriptions
 *
 * if (has_woocommerce_subscription('','','')) {
 *    // do something
 * }
 *
 * @since Howl 1.0.0
 *
 */
function has_woocommerce_subscription($the_user_id, $the_product_id, $the_status) {
	$current_user = wp_get_current_user();
	if (empty($the_user_id)) {
		$the_user_id = $current_user->ID;
	}
	if (WC_Subscriptions_Manager::user_has_subscription( $the_user_id, $the_product_id, $the_status)) {
		return true;
	}
}

function modify_contact_methods($profile_fields) {

  // Add new fields
  $profile_fields['company_category'] = 'Business Primary Category';

  // Remove old fields
  unset($profile_fields['github']);
  unset($profile_fields['googleplus']);

  return $profile_fields;
}
add_filter('user_contactmethods', 'modify_contact_methods');


/**
 * Dynamically pulls related posts regardless
 *
 */
function howl_get_related_posts( $post_id, $related_count, $args = array() ) {
    $args = wp_parse_args( (array) $args, array(
        'orderby' => 'rand',
        'return'  => 'query', // Valid values are: 'query' (WP_Query object), 'array' (the arguments array)
    ) );

    $related_args = array(
        'post_type'      => get_post_type( $post_id ),
        'posts_per_page' => $related_count,
        'post_status'    => 'publish',
        'post__not_in'   => array( $post_id ),
        'orderby'        => $args['orderby'],
        'tax_query'      => array()
    );

    $post       = get_post( $post_id );
    $taxonomies = get_object_taxonomies( $post, 'names' );

    foreach( $taxonomies as $taxonomy ) {
        $terms = get_the_terms( $post_id, $taxonomy );
        if ( empty( $terms ) ) continue;
        $term_list = wp_list_pluck( $terms, 'slug' );
        if( isset($term_list) ) {
          $term_list = array_values($term_list);
          $related_args['tax_query'][] = array(
              'taxonomy' => $taxonomy,
              'field'    => 'slug',
              'terms'    => $term_list[0]
          );
        }

    }

    if( count( $related_args['tax_query'] ) > 1 ) {
        $related_args['tax_query']['relation'] = 'OR';
    }
    if( $args['return'] == 'query' ) {
        return new WP_Query( $related_args );
    } else {
        return $related_args;
    }
}
