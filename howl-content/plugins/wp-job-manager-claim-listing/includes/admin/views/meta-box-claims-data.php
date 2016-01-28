<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post;

$order_id 		= get_post_meta( $post->ID, '_order_id', true );
$current_status	= get_post_meta( $post->ID, '_status', true );
$listing_id		= get_post_meta( $post->ID, '_listing_id', true );
$listing		= get_post( $listing_id );
$claimer_id		= $post->post_author;
$claimer_data	= get_userdata( $claimer_id );

// Listings
$listings_query = new WP_Query( array(
	'posts_per_page'	=> -1,
	'post_type'			=> 'job_listing',
	'post_status'		=> 'publish',
) );
$listings = $listings_query->get_posts();

// Orders
if ( $order_id ) {
    $order_query = new WP_Query( array(
        'posts_per_page'	=> -1,
        'post_type'			=> 'shop_order',
        'post_status'		=> array_keys( wc_get_order_statuses() ),
    ) );
    $orders = $order_query->get_posts();
}

// Users
$user_query = new WP_User_Query( array(
	'search'	=> '',
) );
$users = $user_query->get_results();

?><div class='option-group'>

	<label for='listing'><?php _e( 'Listing', 'wp-job-manager-claim-listing' ); ?></label>
	<select class='claim-listing-chosen-listings' name='listing_id'><?php
		foreach ( $listings as $value ) :
			?><option <?php selected( $listing_id, $value->ID ); ?> value='<?php echo $value->ID; ?>'><?php echo $value->post_title; ?></option><?php
		endforeach;
	?></select>

	&nbsp;
	<span class='option-value'>
		<a href='<?php echo add_query_arg( 'p', $listing_id, home_url() ); ?>'><?php _e( 'View', 'wp-job-manager-claim-listing' ); ?></a>
	</span>&#124;
	<span class='option-value'>
		<a href='<?php echo add_query_arg( array( 'post' => $listing_id, 'action' => 'edit' ), admin_url( 'post.php' ) ); ?>'><?php _e( 'Edit', 'wp-job-manager-claim-listing' ); ?></a>
	</span>

</div>

<?php if ( $order_id ) : ?>
	<div class='option-group'>

		<label for='order_id'><?php _e( 'Order ID', 'wp-job-manager-claim-listing' ); ?></label>
		<select class='claim-listing-chosen-orders' name='order_id'><?php
			foreach ( $orders as $value ) :
				$order = wc_get_order( $value );

				if ( $order->user_id ) {
                    $user_info = get_userdata( $order->user_id );

					if ( $user_info->first_name || $user_info->last_name ) {
						$username = esc_html( ucfirst( $user_info->first_name ) . ' ' . ucfirst( $user_info->last_name ) );
					} else {
						$username = esc_html( ucfirst( $user_info->display_name ) );
					}

				} else {
					if ( $order->billing_first_name || $order->billing_last_name ) {
						$username = trim( $order->billing_first_name . ' ' . $order->billing_last_name );
					} else {
						$username = __( 'Guest', 'woocommerce' );
					}
				}

				?><option <?php selected( $order_id, $order->id ); ?> value='<?php echo $order->id; ?>'><?php
					printf( _x( '%s by %s', 'Order number by X', 'woocommerce' ), '#' . esc_attr( $order->get_order_number() ), $username );
				?></option><?php
			endforeach;
		?></select>

		&nbsp;
		<span class='option-value'>
			<a href='<?php echo add_query_arg( array( 'post' => $order_id, 'action' => 'edit' ), admin_url( 'post.php' ) ); ?>'><?php
				_e( 'Edit', 'wp-job-manager-claim-listing' );
			?></a>
		</span>

	</div>
<?php endif; ?>

<div class='option-group'>

	<label for='claimer'><?php _e( 'Claimer', 'wp-job-manager-claim-listing' ); ?></label>
	<select class='claim-listing-chosen-users' name='user_id'><?php
		foreach ( $users as $user ) :
			?><option <?php selected( $claimer_data->ID, $user->ID ); ?> value='<?php echo $user->ID; ?>'><?php echo '#' . $user->ID . ' - ' . $user->display_name; ?></option><?php
		endforeach;
	?></select>

	&nbsp;
	<span class='option-value'>
		<a href='<?php echo add_query_arg( 'user_id', $claimer_id, admin_url( 'user-edit.php' ) ); ?>'><?php _e( 'Edit', 'wp-job-manager-claim-listing' ); ?></a>
	</span>

</div>

<div class='option-group'>

	<label for='status'><?php _e( 'Status', 'wp-job-manager-claim-listing' ); ?></label>
	<select name='status'>
		<?php foreach ( $statuses as $key => $status ) : ?>
			<option <?php selected( $key, $current_status ); ?> value='<?php echo $key; ?>'><?php echo $status; ?></option>
		<?php endforeach; ?>
	</select>

</div>

<?php wp_nonce_field( 'data_meta_box', 'data_meta_box_nonce' );
