<?php

class WPJMCL_Claim_Free {

    public function __construct() {
        add_action( 'template_redirect', array( $this, 'create_claim' ) );
        add_action( 'template_redirect', array( $this, 'display_guest_notice' ) );

        // All we need to do is mark it as claimed
        add_action( 'wpjmcl_approve_claim', array( $this, 'apply_claimed_attributes' ) );
    }

    public function create_claim() {
        if ( get_option( 'wpjmcl_paid_claiming' ) && defined( 'JOB_MANAGER_WCPL_VERSION' ) ) {
           return;
        }

        if ( ! isset( $_GET[ 'action' ] ) || 'claim_listing' != $_GET[ 'action' ] ) {
            return;
        }

        if ( ! isset( $_GET[ 'listing_id' ] ) ) {
            return;
        }

        $listing_id = absint( $_GET[ 'listing_id' ] );

        if ( ! is_user_logged_in() ) {
            wp_safe_redirect( esc_url_raw( add_query_arg( array( 'action' => 'claim_as_guest', 'listing_id' => $listing_id ), get_permalink( $listing_id ) ) ) );
            exit();
        } else {
            $claim_id = wpjmcl()->claims->create( $listing_id, false, get_current_user_id() );

            if ( $claim_id ) {
                // Add a notice if the theme is using WC
                if ( defined( 'WC_VERSION' ) ) {
                    wc_add_notice( __( 'Your claim has been submitted.', 'wp-job-manager-claim-listing' ) );
                }

                do_action( 'wpjmcl_free_claim_created', $claim_id, $listing_id );

                wp_safe_redirect( esc_url_raw( get_permalink( $listing_id ) ) );
                exit();
            }
        }
    }

    public function display_guest_notice() {
        if ( ! isset( $_GET[ 'action' ] ) || 'claim_as_guest' != $_GET[ 'action' ] ) {
            return;
        }

        if ( ! isset( $_GET[ 'listing_id' ] ) ) {
            return;
        }

        $listing_id = absint( $_GET[ 'listing_id' ] );

        // Add a notice if the theme is using WC
        if ( defined( 'WC_VERSION' ) ) {
            wc_add_notice( sprintf( __( 'Please <a href="%s">log in</a> to claim this listing.', 'wp-job-manager-claim-listing' ), wp_login_url( get_permalink( $listing_id ) ) ) );
        }

        do_action( 'wpjmcl_guest_claim_redirect', $listing_id );
    }

    public function apply_claimed_attributes( $args ) {
        update_post_meta( $args[ 'listing_id' ], '_claimed', 1 );
    }

}
