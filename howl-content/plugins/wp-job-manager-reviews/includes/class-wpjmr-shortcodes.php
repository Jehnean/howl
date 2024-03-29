<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 *	Class WPJMR_Shortcodes
 *
 *	Handle all reviews.
 *
 *	@class		WPJMR_Shortcodes
 *	@version	1.0.0
 *	@author		Jeroen Sormani
 */
class WPJMR_Shortcodes {

	/**
	 * Construct.
	 *
	 * Initialize this class including hooks.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		// [review_stars]
		add_shortcode( 'review_stars', array( $this, 'shortcode_review_stars' ) );

		// [review_average]
		add_shortcode( 'review_average', array( $this, 'shortcode_review_average' ) );

		// [review_count]
		add_shortcode( 'review_count', array( $this, 'shortcode_review_count' ) );

		// [reviews]
		add_shortcode( 'reviews', array( $this, 'shortcode_reviews' ) );

		// Review moderation - [review_dashboard]
		add_shortcode( 'review_dashboard', array( $this, 'shortcode_review_dashboard' ) );
	}


	/**
	 * [review_stars].
	 *
	 * A shortcode for the review stars..
	 *
	 * @since 1.0.0
	 *
	 * @param array		@atts 		Attributes given in the shortcode.
	 * @param string 	@content 	Content of the shortcode.
	 */
	public function shortcode_review_stars( $atts = array(), $content = '' ) {
		extract( shortcode_atts( array(
			'post_id' => get_the_ID(),
		), $atts ) );

		$post_id = (int) $post_id;

		if ( ! $post_id || ! is_integer( $post_id ) ) {
			return;
		}

		$return = WPJMR()->review->get_stars( $post_id );

		return '<span class="review-stars">' . $return . '</span>';
	}


	/**
	 * [review_average].
	 *
	 * A shortcode for the review average.
	 *
	 * @since 1.0.0
	 *
	 * @param array		@atts 		Attributes given in the shortcode.
	 * @param string 	@content 	Content of the shortcode.
	 */
	public function shortcode_review_average( $atts = array(), $content = '' ) {
		extract( shortcode_atts( array(
			'post_id' => get_the_ID(),
		), $atts ) );

		$post_id = (int) $post_id;

		if ( ! $post_id || ! is_integer( $post_id ) ) {
			return;
		}

		$return = WPJMR()->review->average_rating_listing( $post_id );

		return '<span class="review-average">' . $return . '</span>';
	}


	/**
	 * [review_count].
	 *
	 * A shortcode for the review count.
	 *
	 * @since 1.0.0
	 *
	 * @param array		@atts 		Attributes given in the shortcode.
	 * @param string 	@content 	Content of the shortcode.
	 */
	public function shortcode_review_count( $atts = array(), $content = '' ) {
		extract( shortcode_atts( array(
			'post_id' => get_the_ID(),
		), $atts ) );

		$post_id = (int) $post_id;

		if ( ! $post_id || ! is_integer( $post_id ) ) {
			return;
		}

		$return = WPJMR()->review->review_count( $post_id );

		return '<span class="review-count">' . $return . '</span>';
	}


	/**
	 * [reviews].
	 *
	 * A shortcode to get the reviews.
	 *
	 * @since 1.0.0
	 *
	 * @param array		@atts 		Attributes given in the shortcode.
	 * @param string 	@content 	Content of the shortcode.
	 */
	public function shortcode_reviews( $atts = array(), $content = '' ) {
		extract( shortcode_atts( array(
			'post_id' => get_the_ID(),
		), $atts ) );

		$post_id = (int) $post_id;

		if ( ! $post_id || ! is_integer( $post_id ) ) {
			return;
		}

		ob_start();
			wp_list_comments( array( 'callback' => array( WPJMR()->review, 'wpjmr_comments' ) ), WPJMR()->review->get_reviews_by_id( $post_id ) );
			$return = ob_get_contents();
		ob_end_clean();

		return $return;
	}


	/**
	 * Review Dashboard.
	 *
	 * Shortcode to display the review moderate in the dashboard.
	 *
	 * @since 1.0.1
	 */
	public function shortcode_review_dashboard() {

		// Bail if listing owner moderate is not active
		if ( 0 == get_option( 'wpjmr_listing_authors_can_moderate', '0' ) ) :
			return;
		endif;

		if ( is_user_logged_in() ) :

			$reviews = get_comments( apply_filters( 'wpjmr_moderate_review_comments_args', array(
				'post_author'			=> get_current_user_id(),
				'author__not_in'		=> array( get_current_user_id() ),
				'status'				=> 'all',
				'include_unapproved'	=> true,
				'number'				=> 10,
				'offset'				=> get_query_var( 'paged' ) > 1 ? ( ( get_query_var( 'paged' ) * 10 ) - 10 ) : 0,
			) ) );

			$comment_query = new WP_Comment_Query();
			$comment_count = $comment_query->query( array(
				'count'					=> true,
				'post_author'			=> get_current_user_id(),
				'status'				=> 'all',
				'include_unapproved'	=> true,
			) );

		else :

			$reviews = array();
			$comment_count = 0;

		endif;

		get_job_manager_template( 'job-review-moderate.php', array(
			'reviews' 		=> $reviews,
			'max_num_pages' => $comment_count / 10,
			'number' 		=> 2,
		), '', plugin_dir_path( wpjmr()->file ) . 'templates/' );


	}



}
