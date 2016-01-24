<?php

class WPJMCL_Claim_Paid {

    public function apply_package_selection( $args ) {
        if ( ! $args[ 'order_id' ] || ! $args[ 'package_id' ] ) {
            return;
        }

        $order = wc_get_order( $args[ 'order_id' ] );

        foreach ( $order->get_items() as $item ) {
            $product = wc_get_product( $item[ 'product_id' ] );

            if ( $product->is_type( array( 'job_package', 'job_package_subscription' ) ) && $order->customer_user ) {
                // WC Paid Listings will automatically give the package when an order is completed
                // and an associated product is a listing package. So find that and use that instead.
                //
                // It won't be increased because this won't fire fore these orders:
                // https://github.com/Automattic/wp-job-manager-wc-paid-listings/blob/master/includes/class-wc-paid-listings-orders.php#L136
                global $wpdb;

                $package = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wcpl_user_packages WHERE user_id = %d AND order_id = %d AND ( package_count < package_limit OR package_limit = 0 );", $order->customer_user, $args[ 'order_id' ] ) );

                // Increase the package usage (to be 1/1) and assign the user's package
                if ( isset( $item['listing_id'] ) && $package ) {
                    $listing_id = $item[ 'listing_id' ];

                    wc_paid_listings_increase_package_count( $order->customer_user, $package->id );
                    update_post_meta( $args[ 'listing_id' ], '_user_package_id', $package->id );

                    // mirrors https://github.com/Automattic/wp-job-manager-wc-paid-listings/blob/master/includes/class-wc-paid-listings-subscriptions.php#L400
                    do_action( 'wpjmcl_switched_package', $args[ 'listing_id' ], $package );
                }
            }
        }
    }

    public function apply_package_attributes( $args ) {
        if ( ! $args[ 'package_id' ] ) {
            return;
        }

        $package_id = $args[ 'package_id' ];
        $package = wc_get_product( $package_id );

        update_post_meta( $args[ 'listing_id' ], '_job_duration', $package->get_duration() );
        update_post_meta( $args[ 'listing_id' ], '_featured', $package->is_featured() ? 1 : 0 );
        update_post_meta( $args[ 'listing_id' ], '_package_id', $package_id );
        update_post_meta( $args[ 'listing_id' ], '_claimed', 1 );

        if ( 'listing' === $package->package_subscription_type ) {
            update_post_meta( $args[ 'listing_id' ], '_job_expires', '' ); // Never expire automatically
        }

        // remove the temporary package_id
        delete_post_meta( $args[ 'listing_id' ], '_maybe_package_id', $package_id );
    }

}
