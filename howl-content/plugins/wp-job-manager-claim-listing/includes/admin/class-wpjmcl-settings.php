<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class WPJMCL_Settings.
 */
class WPJMCL_Settings {

    public function __construct() {
        add_action( 'job_manager_settings', array( $this, 'wpjmcl_settings' ) );
    }

    /**
     * Settings page.
     *
     * Add an settings tab to the Listings -> settings page.
     *
     * @since 1.0.0
     *
     * @param 	array 	$settings	Array of default settings.
     * @return 	array	$settings	Array including the new settings.
     */
    public function wpjmcl_settings( $settings )  {
        if ( defined( 'JOB_MANAGER_WCPL_VERSION' ) ) {
            $settings['wpjmcl_settings'] = array(
                __( 'Claim Listing', 'wp-job-manager-claim-listing' ),
                array(
                    array(
                        'name'			=> 'wpjmcl_paid_claiming',
                        'type'			=> 'checkbox',
                        'label'			=> __( 'Paid Claims', 'wp-job-manager-claim-listing' ),
                        'cb_label'		=> __( 'Require a purchase', 'wp-job-manager-claim-listing' ),
                        'desc'			=> __( 'A listing is claimed by purchasing a listing package.', 'wp-job-manager-claim-listing' ),
                        'std'			=> 0,
                    )
                ),
            );
        }

        // Add setting to the 'pages' tab
        $settings['job_pages'][1][] = array(
            'name' 		=> 'job_manager_claim_listing_page_id',
            'std' 		=> '',
            'label' 	=> __( 'Claim Listing Page', 'wp-job-manager' ),
            'desc'		=> __( 'Select the page where you have placed the [claim_listing] shortcode.', 'wp-job-manager' ),
            'type'      => 'page'
        );

        return $settings;

    }

}
