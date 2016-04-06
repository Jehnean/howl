<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Listify
 */

get_header(); ?>

		<main id="main" class="site-main" role="main">
	<div class="page-cover entry-cover errorpage-cover">
			<div class="row content-area leadertext-area">
				<div class="col-md-12 col-sm-12 col-xs-12 text-center items-3-section-title home-widget">
		<div class="cover-wrapper container">
			<div class="listify_widget_search_listings">
				<div class="home-widget-section-title">
					<h1 class="home-widget-title"><?php _e( 'Oh no! Page not found.', 'listify' ); ?></h1>
					<p><?php _e( 'Looks like the page you&rsquo;re trying to visit doesn&rsquo;t exist. Help us find what you&rsquo;re looking for.', 'listify' ); ?></p>

					<?php

					// Register Custom Taxonomy
					function custom_taxonomy($name) {

					   //CODE TO REGISTER TAXONOMY
					   // taxonomy=project_tags&post_type=customer_projects
								$wp_data = "exists";
					   if( !term_exists( $name, 'project_tags' ) ) {
					       $wp_data = wp_insert_term( $name, 'project_tags');
					   }
								return $wp_data;
					}

					$args = array(
						'fields' => 'all'//,
						//'number' => 1
					);
					$users = get_users( $args );

					$company_categories = array();

					for ($i=0; $i < count($users); $i++) {
							$user_id = $users[$i]->data->ID;
							$company_categories[] = get_user_meta($user_id, 'company_category', true);
					}

					echo "<pre>";
					echo "Before Count: " . count($company_categories);
					echo "</pre>";

					$company_categories = array_unique($company_categories);

					echo "<pre>";
					echo "Removing Dupes Count: " . count($company_categories);
					echo "</pre>";

					$cleaned_company_categories = array();

					for ($j=0; $j < count($company_categories); $j++) {
							if(!empty($company_categories[$j])){
									$cleaned_company_categories[] = $company_categories[$j];
							}
					}

					echo "<pre>";
					echo "Removing Blanks Count: " . count($cleaned_company_categories);
					echo "</pre>";

					for ($k=0; $k < count($cleaned_company_categories); $k++) {
							$tax_term_to_check = $cleaned_company_categories[$k];
							$created_taxonomy = custom_taxonomy($tax_term_to_check);
							if ( is_wp_error( $created_taxonomy ) ) {
										echo "<pre style='background-color: red;'>";
							   echo "For:".$tax_term_to_check." | Error" . $result->get_error_message();
										echo "</pre>";
							}else if($created_taxonomy == "exists"){
									echo "<pre style='background-color: yellow;'>";
									echo "Exists: " . $tax_term_to_check;
									echo "</pre>";
							}else{
									echo "<pre style='background-color: green;'>";
									echo "Success: " . $tax_term_to_check;
									echo "</pre>";
							}
					}
					?>

					<?php get_search_form(); ?>
				</div>

			</div>
		</div>
	</div>
</div>
		</div>
	</main>
<?php get_footer(); ?>
