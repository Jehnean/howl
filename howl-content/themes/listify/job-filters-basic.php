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

<form class="job_search_form" action="<?php echo get_post_type_archive_link( 'job_listing' ); ?>" method="GET">
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
<script type="text/javascript">
(function( $ ) {
	$(function() {
		var url = FindPros.url + "?action=findpros_search";
		$( "#search_keywords" ).autocomplete({
			source: url,
			delay: 500,
			minLength: 3
		});
	});

})( jQuery );
</script>
<?php do_action( 'job_manager_job_filters_after', $atts ); ?>

<noscript><?php _e( 'Your browser does not support JavaScript, or it is disabled. JavaScript must be enabled in order to view listings.', 'wp-job-manager' ); ?></noscript>
