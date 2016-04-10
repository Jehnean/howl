<?php
/**
 * Plugin Name: Howl API
 * Description: Search Howl API across Yelp API
 * Version: 1.0
 * Author: Toybox Media
 */
$dir = plugin_dir_path( __FILE__ );
require_once($dir . 'lib/OAuth.php');

define( 'CONSUMER_KEY', '72OYsiVPHy1bPMg2oHfBuw' );
define( 'CONSUMER_SECRET', 'lBTtQP_CDJfFSTGvYp4UebT-1eI' );
define( 'TOKEN', 'T8Om6Po4cF34S72jh7oRAwb1nON_DE_T' );
define( 'TOKEN_SECRET', 'l1CH__MsiBrIoJL1yM-GYeNptys' );

define( 'API_HOST', 'api.yelp.com' );
define( 'DEFAULT_TERM', 'dinner' );
define( 'DEFAULT_LOCATION', 'San Francisco, CA' );
define( 'SEARCH_LIMIT', 3 );
define( 'SEARCH_PATH', '/v2/search/' );
define( 'BUSINESS_PATH', '/v2/business/' );

/**
 * Makes a request to the Yelp API and returns the response
 *
 * @param    $host    The domain host of the API
 * @param    $path    The path of the APi after the domain
 * @return   The JSON response from the request
 */
function request($host, $path) {
    $unsigned_url = "https://" . $host . $path;

    // Token object built using the OAuth library
    $token = new OAuthToken(TOKEN, TOKEN_SECRET);

    // Consumer object built using the OAuth library
    $consumer = new OAuthConsumer(CONSUMER_KEY, CONSUMER_SECRET);

    // Yelp uses HMAC SHA1 encoding
    $signature_method = new OAuthSignatureMethod_HMAC_SHA1();

    $oauthrequest = OAuthRequest::from_consumer_and_token(
        $consumer,
        $token,
        'GET',
        $unsigned_url
    );

    // Sign the request
    $oauthrequest->sign_request($signature_method, $consumer, $token);

    // Get the signed URL
    $signed_url = $oauthrequest->to_url();

    // Send Yelp API Call
    try {
        $ch = curl_init($signed_url);
        if (FALSE === $ch)
            throw new Exception('Failed to initialize');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);

        if (FALSE === $data)
            throw new Exception(curl_error($ch), curl_errno($ch));
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (200 != $http_status)
            throw new Exception($data, $http_status);

        curl_close($ch);
    } catch(Exception $e) {
        trigger_error(sprintf(
            'Curl failed with error #%d: %s',
            $e->getCode(), $e->getMessage()),
            E_USER_ERROR);
    }

    return $data;
}

/**
 * Query the Search API by a search term and location
 *
 * @param    $term        The search term passed to the API
 * @param    $location    The search location passed to the API
 * @return   The JSON response from the request
 */
function search($term, $location) {
    $url_params = array();

    $url_params['term'] = $term ?: DEFAULT_TERM;
    $url_params['location'] = $location?: DEFAULT_LOCATION;
    $url_params['limit'] = SEARCH_LIMIT;
    $search_path = SEARCH_PATH . "?" . http_build_query($url_params);

    return request(API_HOST, $search_path);
}

/**
 * Query the Business API by business_id
 *
 * @param    $business_id    The ID of the business to query
 * @return   The JSON response from the request
 */
function get_business($business_id) {
    $business_path = BUSINESS_PATH . urlencode($business_id);

    return request(API_HOST, $business_path);
}

/**
 * Queries the API by the input values from the user
 *
 * @param    $term        The search term to query
 * @param    $location    The location of the business to query
 */
function how_query_api($term, $location) {
    $full_response = json_decode(search($term, $location));
    $business_id = $full_response->businesses[0]->id;
    $response = get_business($business_id);
    return array($business_id, count($response->businesses),  $response, $full_response);
}
