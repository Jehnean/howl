<?php
$atts = apply_filters( 'job_manager_ouput_jobs_defaut', array(
    'per_page' => get_option( 'job_manager_per_page' ),
    'orderby' => 'featured',
    'order' => 'DESC',
    'show_categories' => true,
    'categories' => true,
    'selected_category' => false,
    'job_types' => false,
    'location' => false,
    'keywords' => false,
    'selected_job_types' => false,
    'show_category_multiselect' => false,
    'selected_region' => false
) );
?>

<?php do_action( 'job_manager_job_filters_before', $atts ); ?>

<form name="job_search_form" class="job_search_form" action="/post-a-project/" method="POST">

 <?php
 if ( is_user_logged_in() ) {
     $current_user = wp_get_current_user();
     $user_id = $current_user->ID;
     $single = true;
     $street_address = get_user_meta($user_id, "billing_address_1", $single);
     $address_line_2 = get_user_meta($user_id, "billing_address_2", $single);
     $city = get_user_meta($user_id, "billing_city", $single);
     $state = get_user_meta($user_id, "billing_state", $single);
     $zip = get_user_meta($user_id, "billing_postcode", $single);
     $country = get_user_meta($user_id, "billing_country", $single);
     if(!empty($street_address)){ ?>
      <input type="hidden" id="street_address" name="street_address" value="<?php echo $street_address; ?>">
     <?php }
     if(!empty($address_line_2)){ ?>
      <input type="hidden" id="address_line_2" name="address_line_2" value="<?php echo $address_line_2; ?>">
     <?php }
     if(!empty($city)){ ?>
      <input type="hidden" id="city" name="city" value="<?php echo $city; ?>">
     <?php }
     if(!empty($state)){ ?>
      <input type="hidden" id="state" name="state" value="<?php echo $state; ?>">
     <?php }
     if(!empty($zip)){ ?>
      <input type="hidden" id="zip" name="zip" value="<?php echo $zip; ?>">
     <?php }
     if(!empty($country)){ ?>
      <input type="hidden" id="country" name="country" value="<?php echo $country; ?>">
     <?php }
 } else { ?>
  <input type="hidden" id="street_address" name="street_address" value="">
  <input type="hidden" id="address_line_2" name="address_line_2" value="">
  <input type="hidden" id="city" name="city" value="">
  <input type="hidden" id="state" name="state" value="">
  <input type="hidden" id="zip" name="zip" value="">
  <input type="hidden" id="country" name="country" value="">
 <?php } ?>

	<?php do_action( 'job_manager_job_filters_start', $atts ); ?>

	<div class="search_jobs">
		<?php do_action( 'job_manager_job_filters_search_jobs_start', $atts ); ?>

		<div class="search_keywords">
			<label for="search_keywords"><?php _e( 'Keywords', 'listify' ); ?></label>
            <input type="text" name="search_keywords" id="search_keywords" placeholder="<?php esc_attr_e( 'What Service Do You Need?', 'listify' ); ?>" />
		</div>

		<?php do_action( 'job_manager_job_filters_search_jobs_end', $atts ); ?>
	</div>

	<?php do_action( 'job_manager_job_filters_end', $atts ); ?>

</form>
<?php do_action( 'job_manager_job_filters_after', $atts ); ?>

<noscript><?php _e( 'Your browser does not support JavaScript, or it is disabled. JavaScript must be enabled in order to view listings.', 'wp-job-manager' ); ?></noscript>
