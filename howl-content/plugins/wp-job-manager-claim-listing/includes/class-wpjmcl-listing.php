<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class WPJMCL_Listing.
 */
class WPJMCL_Listing {

    public function __construct() {
        // Add 'claim this listing' link
        add_action( 'single_job_listing_start', array( $this, 'claim_listing_link' ) );

        // Add post class
        add_filter( 'post_class', array( $this, 'add_post_class' ) );

        add_action( 'after_setup_theme', array( $this, 'listify_shim' ) );
    }

    public function listify_shim() {
        global $listify_job_manager_claim_listing;

        if ( $listify_job_manager_claim_listing ) {
            remove_action( 'listify_single_job_listing_actions_start', array( $listify_job_manager_claim_listing, 'claim_button' ) );
            add_action( 'listify_single_job_listing_actions_start', array( $this, 'listify_claim_button' ) );
        }
    }


    /**
     * Is claimable.
     *
     * Check if the current listing is claimable.
     *
     * @since 1.0.0
     */
    public function is_claimed( $listing_id = false ) {
        if ( ! $listing_id ) {
            $listing_id = get_the_ID();
        }

        $listing = get_post( $listing_id );

        if ( 'publish' != $listing->post_status ) {
            return false;
        }

        $claimed = 1 === absint( $listing->_claimed ) ? true : false;

        return apply_filters( 'wpjmcl_is_claimed', $claimed, $listing );
    }


    /**
     * Claim listing link.
     *
     * Display 'Claim this listing' link.
     *
     * @since 1.0.0
     */
    public function claim_listing_link() {
        global $post;

        if ( ! $this->is_claimed() ) {
            $paid_claim_listing_page = job_manager_get_permalink( 'claim_listing' );

            $href = add_query_arg( array(
                'action' => 'claim_listing',
                'listing_id' => $post->ID
            ), $paid_claim_listing_page );

            $href = esc_url( wp_nonce_url( $href, 'claim_listing', 'claim_listing_nonce' ) );
?>
    <a href='<?php echo $href; ?>' class='claim-listing'><?php _e( 'Claim this listing', 'wp-job-manager-claim-listing' ); ?></a>
<?php
        }

    }

	public function listify_claim_button() {
		global $post;

		if ( $this->is_claimed() ) {
			return;
		}

        $paid_claim_listing_page = job_manager_get_permalink( 'claim_listing' );

        $href = add_query_arg( array(
            'action' => 'claim_listing',
            'listing_id' => $post->ID
        ), $paid_claim_listing_page );

        $href = esc_url( wp_nonce_url( $href, 'claim_listing', 'claim_listing_nonce' ) );

	?>
		<a href="<?php echo esc_url( $href ); ?>" class="claim-listing"><i class="ion-thumbsup"></i> <?php _e( 'Claim Listing', 'listify' ); ?></a>
	<?php
	}

    /**
     * Post class.
     *
     * Add a post class 'claimed' or 'not-claimed'.
     *
     * @since 1.0.0
     *
     * @param	array $classes 	List of existing classes.
     * @return	array 			List of modified classes.
     */
    public function add_post_class( $classes ) {
        global $post;

        $classes[] = $this->is_claimed( $post->ID ) ? 'claimed' : 'not-claimed';

        return $classes;
    }

}
