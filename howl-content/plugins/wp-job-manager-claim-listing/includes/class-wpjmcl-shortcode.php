<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WPJMCL_Shortcode {

    public function __construct() {
        add_shortcode( 'claim_listing', array( $this, 'paid_claim_listing_shortcode' ) );
    }

    public function paid_claim_listing_shortcode( $atts ) {
        if ( ! isset( $_REQUEST[ 'listing_id' ] ) ) {
            return;
        }

        return wpjmcl()->forms->get_form( 'claim-listing', $atts );
    }

}
