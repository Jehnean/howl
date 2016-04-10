<?php

$CONSUMER_KEY = "72OYsiVPHy1bPMg2oHfBuw";
$CONSUMER_SECRET = "lBTtQP_CDJfFSTGvYp4UebT-1eI";
$TOKEN = "T8Om6Po4cF34S72jh7oRAwb1nON_DE_T";
$TOKEN_SECRET = "l1CH__MsiBrIoJL1yM-GYeNptys";


define( 'CONSUMER_KEY', '72OYsiVPHy1bPMg2oHfBuw' );
define( 'CONSUMER_SECRET', 'lBTtQP_CDJfFSTGvYp4UebT-1eI' );
define( 'TOKEN', 'T8Om6Po4cF34S72jh7oRAwb1nON_DE_T' );
define( 'TOKEN_SECRET', 'l1CH__MsiBrIoJL1yM-GYeNptys' );

define( 'HOWL_API_ENDPOINT', 'https://yoda.p.mashape.com/yoda' );

define( 'HOWL_CACHE', 'transients' );

add_action( 'admin_notices' , 		'admin_yoda' );
add_filter( 'the_content', 			'translate_to_yoda' );

function admin_yoda() {
		$text = 'You will do something important today.';
		echo translate_to_yoda( $text ) . '</br>';
		echo translate_to_yoda( $text );
}

function translate_to_yoda( $text ) {

		$cache_key = 'HOWL_CACHE_' . md5( $text );
		if ( HOWL_CACHE == 'transients' ) {
				$yoda_speak = get_transient( $cache_key );
		} else {
				$yoda_speak = wp_cache_get( $cache_key , 'yoda_speak' );
		}

	if ( false === $yoda_speak ) {

		$args = array(
			'headers' => array(
				'X-Mashape-Authorization' 	=> MASHAPE_API_KEY,
				'Accept'					=> 'text/plain',
			)
		);

		$yoda_url = HOWL_API_ENDPOINT.'?sentence='.urlencode( $text );
		$response = wp_remote_request( $yoda_url , $args );

		if ( ! is_wp_error( $response ) ) {
			$code = wp_remote_retrieve_response_code( $response );
		 	if ( $code == '200' ) {
				// sometimes need to json_decode this...
				$yoda_speak = wp_remote_retrieve_body( $response );
				if ( HOWL_CACHE == 'transients' ) {
					set_transient( $cache_key , $yoda_speak , 10 );
				} else {
					wp_cache_set( $cache_key , $yoda_speak , 'yoda_speak' , 10 );
				}
			} else {
				$yoda_speak = 'At this time, Yoda not avalilable is.';
			}
		} else {
			$yoda_speak = 'WP error this was.';
		}
	} else {
		if ( HOWL_CACHE == 'transients' ) {
			$yoda_speak = 'This response from transients still is useful. No? ' . $yoda_speak;
		} else {
			$yoda_speak = 'A response from cache still is useful. No? ' . $yoda_speak;
		}
	}

	return $yoda_speak;

}

function yoda_debug( $var ) {

	print '<pre>'; print_r( $var ); print '</pre>';
}


 ?>
