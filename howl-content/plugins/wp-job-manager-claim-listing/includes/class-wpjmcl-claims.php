<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class WPJMCL_Claims.
 */
class WPJMCL_Claims {

    public function __construct() {
        $this->statuses = apply_filters( 'wpjmcl_claim_statuses', array(
            'approved' => __( 'Approved', 'wp-job-manager-claim-listing' ),
            'pending' => __( 'Pending', 'wp-job-manager-claim-listing' ),
            'declined' => __( 'Declined', 'wp-job-manager-claim-listing' ),
        ) );

        add_action( 'init', array( $this, 'register_post_type' ) );

        // trigger the main approval callback which gathers some additional information first
        add_action( 'wpjmcl_claim_status_update_to_approved', array( $this, 'approve' ) );

        // everything gets a new user assigned
        add_action( 'wpjmcl_approve_claim', array( $this, 'apply_user_attributes' ) );

        // Init so their respective actions are called
        $this->free = new WPJMCL_Claim_Free();
        $this->paid = new WPJMCL_Claim_Paid();
    }

    public function register_post_type() {
        $labels = array(
            'name'               => __( 'Claims ', 'wp-job-manager-claim-listing' ),
            'singular_name'      => __( 'Claim', 'wp-job-manager-claim-listing' ),
            'menu_name'          => __( 'Claims', 'wp-job-manager-claim-listing' ),
            'name_admin_bar'     => __( 'Claims', 'wp-job-manager-claim-listing' ),
            'add_new'            => __( 'Add New', 'wp-job-manager-claim-listing' ),
            'add_new_item'       => __( 'Add New Claim', 'wp-job-manager-claim-listing' ),
            'new_item'           => __( 'New Claim', 'wp-job-manager-claim-listing' ),
            'edit_item'          => __( 'Edit Claim', 'wp-job-manager-claim-listing' ),
            'view_item'          => __( 'View Claim', 'wp-job-manager-claim-listing' ),
            'all_items'          => __( 'All Claims', 'wp-job-manager-claim-listing' ),
            'search_items'       => __( 'Search Claims', 'wp-job-manager-claim-listing' ),
            'parent_item_colon'  => __( 'Parent Claims:', 'wp-job-manager-claim-listing' ),
            'not_found'          => __( 'No Claims found.', 'wp-job-manager-claim-listing' ),
            'not_found_in_trash' => __( 'No Claims found in Trash.', 'wp-job-manager-claim-listing' )
        );

        $args = array(
            'labels'             => $labels,
            'public'             => false,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => false,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'claim' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array(),
        );

        register_post_type( 'claim', $args );
    }


    /**
     * Create a claim
     *
     * Either an order or user neesd to be passed in order to be able to properly set
     * the listing's author once claimed.
     */
    public function create( $listing_id, $order_id = false, $user_id = false ) {
        if ( ! is_user_logged_in() ) {
            return;
        }

        $listing = get_post( $listing_id );

        $claim_args = array(
            'post_title' => sprintf( __( 'Claim listing #%d - %s', 'wp-job-manager-claim-listing' ), $listing->ID, $listing->post_title ),
            'post_status' => 'publish',
            'post_type' => 'claim',
        );

        if ( isset( $order_id ) && ! $user_id ) {
            $claim_args[ 'post_author' ] = get_post_meta( $order_id, '_customer_user', true );
        } else if ( $user_id ) {
            $claim_args[ 'post_author' ] = $user_id;
        }

        $claim_id = wp_insert_post( $claim_args );

        if ( $claim_id ) {
            update_post_meta( $claim_id, '_status', apply_filters( 'wpjmcl_new_claim_status', 'pending' ) );
            update_post_meta( $claim_id, '_listing_id', apply_filters( 'wpjmcl_new_claim_listing_id', $listing->ID ) );

            if ( $order_id ) {
                update_post_meta( $claim_id, '_order_id', apply_filters( 'wpjmcl_new_claim_order_id', $order_id ) );
            }
        }

        do_action( 'wpjmcl_after_create_claim', $claim_id );

        return $claim_id;
    }

    public function approve( $claim_id ) {
        $listing_id = get_post_meta( $claim_id, '_listing_id', true );
        $package_id = get_post_meta( $listing_id, '_maybe_package_id', true );
        $order_id   = get_post_meta( $claim_id, '_order_id', true );

        /**
         * A claim has been approved.
         *
         * @see `apply_package_selection()`
         * @see `apply_package_attributes()`
         */
        do_action( 'wpjmcl_approve_claim', compact( 'listing_id', 'claim_id', 'order_id', 'package_id' ), $this );
    }


    public function apply_user_attributes( $args ) {
        wp_update_post( array(
            'ID' => $args[ 'listing_id' ],
            'post_author' => get_post( $args[ 'claim_id' ] )->post_author
        ) );
    }
}
