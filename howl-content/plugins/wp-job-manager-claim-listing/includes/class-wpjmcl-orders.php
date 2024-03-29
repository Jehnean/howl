<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class WPJMCL_Orders.
 *
 * Orders class.
 *
 * @class		WPJMCL_Orders
 * @version		1.1.0
 * @author		Jeroen Sormani
 */
class WPJMCL_Orders {

    public function __construct() {
        // Create a claim
        add_action( 'woocommerce_checkout_order_processed', array( $this, 'create_claim_on_checkout' ) );

        // If default claimed, mark the listing as claimed on a standard submission
        add_action( 'woocommerce_order_status_completed', array( $this, 'mark_claimed_on_payment' ) );

        // Add order item meta (at create_order() method)
        add_action( 'woocommerce_add_order_item_meta', array( $this, 'add_order_item_meta_listing' ), 10, 3 );
    }

    public function create_claim_on_checkout( $order_id ) {
        $order = wc_get_order( $order_id );

        foreach ( $order->get_items() as $item ) {
            $product = wc_get_product( $item[ 'product_id' ] );

            if ( $product->is_type( array( 'job_package', 'job_package_subscription' ) ) && $order->customer_user ) {
                if ( isset( $item[ 'listing_id' ] ) ) {
                    wpjmcl()->claims->create( $item[ 'listing_id' ], $order_id, $order->customer_user );
                }
            }
        }
    }

    /**
     * Order item meta.
     *
     * Add item meta (listing ID) to the order item.
     * Fires on WC()->order->create_order() method.
     *
     * @since 1.0.0
     *
     * @param int  $item_id Order item ID.
     * @param array $values List of values given through WooCommerce.
     * @param string $cart_item_key ID of the item in the cart.
     */
    public function add_order_item_meta_listing( $item_id, $values, $cart_item_key ) {
        if ( ! isset( $values[ 'listing_id' ] ) ) {
            return;
        }

        wc_add_order_item_meta( $item_id, '_listing_id', $values['listing_id'] );
    }

    /**
     * Default to Claimed
     *
     * On the standard submission form if the package purchased is set to mark
     * a listing as claimed automatically, do that here
     *
     * @since 2.3.0
     */
    public function mark_claimed_on_payment( $order_id ) {
        $order = wc_get_order( $order_id );

        foreach ( $order->get_items() as $item ) {
            $product = wc_get_product( $item[ 'product_id' ] );

            if ( $product->is_type( array( 'job_package', 'job_package_subscription' ) ) && $order->customer_user ) {
                $listing_id = isset( $item[ 'job_id' ] ) ? absint( $item[ 'job_id' ] ) : false;
                $mark_as_claimed = 'yes' == get_post_meta( $product->id, '_default_to_claimed', true );

                if ( $listing_id && $mark_as_claimed ) {
                    update_post_meta( $listing_id, '_claimed', 1 );
                }
            }
        }
    }

}
