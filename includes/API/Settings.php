<?php
/**
 * Settings API Class
 *
 * @package InstaFeed\API
 */

namespace InstaFeed\API;

use WP_Http;
use WP_REST_Controller;
use WP_REST_Server;

/**
 * Class Settings
 */
class Settings extends WP_REST_Controller {
	/**
	 * Namespace.
	 *
	 * @since 1.0.0
	 *
	 * @var string Namespace.
	 */
	public $namespace = 'instagram-feed';

	/**
	 * Version.
	 *
	 * @var string version.
	 */
	public $version = 'v1';

	/**
	 * Initialize the class
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->rest_base = 'settings';
	}

	/**
	 * Registers the routes for the objects of the controller.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_routes() {
		register_rest_route(
			$this->get_namespace(),
			'/' . $this->rest_base,
			[
				[
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => [ $this, 'get_settings_data' ],
					'permission_callback' => [
						$this,
						'admin_permissions_check',
					],
					'args'                => $this->get_collection_params(),
				],
				[
					'methods'             => WP_REST_Server::EDITABLE,
					'callback'            => [ $this, 'update_settings' ],
					'args'                => $this->get_endpoint_args_for_item_schema( WP_REST_Server::EDITABLE ),
					'permission_callback' => [
						$this,
						'admin_permissions_check',
					],
				],
				'schema' => [ $this, 'get_item_schema' ],
			]
		);
	}

	/**
	 * Get settings data.
	 *
	 * @param object $request Request Object.
	 *
	 * @since 1.0.0
	 *
	 * @return \WP_Error|\WP_REST_Response
	 */
	public function get_settings_data( $request ) {
		$settings = iaf_get_settings();

		return rest_ensure_response( $settings );
	}

	/**
	 * Update settings.
	 *
	 * @param object $request Request Object.
	 *
	 * @since 1.0.0
	 *
	 * @return bool|void|\WP_Error|\WP_REST_Response
	 */
	public function update_settings( $request ) {
		$data = array_map( 'sanitize_text_field', $request->get_param( 'settings' ) );

		$update = update_option( 'instagram_feed_settings', $data, false );

		if ( is_wp_error( $update ) ) {
			return new \WP_Error(
				'instagram_feed_update_error',
				__( 'Something went wrong while saving.', 'insta-api-feed' ),
				[ 'status' => WP_Http::BAD_REQUEST ]
			);
		}

		return $this->get_settings_data( $request );
	}

	/**
	 * Permission check
	 *
	 * @param \WP_REST_Request $request WP Rest Request.
	 *
	 * @since 1.0.0
	 *
	 * @return \WP_Error|bool
	 */
	public function admin_permissions_check( $request ) {
		if ( ! current_user_can( 'manage_options' ) ) {
			return new \WP_Error(
				'instagram_feed_permission_error',
				__( 'You have no permission to do that', 'insta-api-feed' ),
				[ 'status' => WP_Http::BAD_REQUEST ]
			);
		}

		return true;
	}

	/**
	 * Get full namespace
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_namespace() {
		return $this->namespace . '/' . $this->version;
	}
}
