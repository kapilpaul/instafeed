<?php
/**
 * API Class
 *
 * @package InstaFeed\API
 */

namespace InstaFeed;

use InstaFeed\API\Settings;

/**
 * API Class
 */
class API {

	/**
	 * Holds the api classes.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	private $classes;

	/**
	 * Initialize the class.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		$this->classes = [
			Settings::class,
		];

		add_action( 'rest_api_init', [ $this, 'register_api' ] );
	}

	/**
	 * Register the API.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_api() {
		foreach ( $this->classes as $class ) {
			$object = new $class();
			$object->register_routes();
		}
	}
}
