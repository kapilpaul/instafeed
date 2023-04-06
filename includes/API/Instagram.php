<?php
/**
 * Instagram API Request.
 *
 * @since 1.0.0
 *
 * @package InstaFeed\API
 */

namespace InstaFeed\API;

use WP_Http;

/**
 * Class Instagram
 */
class Instagram {

	/**
	 * Holds the processor class
	 *
	 * @var Instagram
	 *
	 * @since 1.0.0
	 */
	public static $instance;

	/**
	 * Get self instance
	 *
	 * @since 1.0.0
	 *
	 * @return Instagram
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new Instagram();
		}

		return self::$instance;
	}

	/**
	 * Get instagram feeds.
	 *
	 * @param int    $limit        Fetch Feed Limit. Default 5.
	 * @param string $user_name    Instagram Username.
	 * @param string $access_token Access Token.
	 * @param string $fields       Instagram fields to fetch.
	 *
	 * @since 1.0.0
	 *
	 * @return mixed|\WP_Error
	 */
	public function get_feeds( $limit = 5, $user_name = '', $access_token = '', $fields = '' ) {
		$fields = ! empty( $fields ) ? $fields : 'id,media_type,media_url,caption';

		$user_name    = iaf_get_instagram_username();
		$access_token = iaf_get_instagram_access_token();

		// return if no user name/access token found.
		if ( empty( $user_name ) || empty( $access_token ) ) {
			return new \WP_Error(
				'instagram_credentials_not_found',
				__( 'No username/access token found.', 'insta-api-feed' ),
				[ 'status' => WP_Http::INTERNAL_SERVER_ERROR ]
			);
		}

		// building the Instagram endpoint url.
		$instagram_url = add_query_arg(
			array(
				'fields'       => $fields,
				'access_token' => $access_token,
				'limit'        => $limit,
			),
			'https://graph.instagram.com/me/media'
		);

		// Sending the request.
		$request = wp_remote_get( $instagram_url );

		if ( is_wp_error( $request ) ) {
			return new \WP_Error(
				'instagram_api_error',
				$request->get_error_message(),
				[ 'status' => WP_Http::INTERNAL_SERVER_ERROR ]
			);
		}

		$result = wp_remote_retrieve_body( $request );

		return json_decode( $result, true );
	}

}
