<?php
/**
 * Plugin Name: Instagram API feed
 * Plugin URI: https://kapilpaul.me/instagram-api-feed
 * Description: That plugin will display an Instagram feed using the Instagram API.
 * Version: 1.0.0
 * Author: Kapil Paul
 * Author URI: https://kapilpaul.me
 * License: GPLv2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: insta-api-feed
 * Domain Path: /languages/
 *
 * @package InstaFeed
 */

/**
 * Copyright (c) 2022 Kapil Paul (email: kapilpaul007@gmail.com). All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * **********************************************************************
 */

// don't call the file directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Instagram_API_Feed class.
 *
 * @class Instagram_API_Feed The class that holds the entire Instagram_API_Feed plugin.
 */
final class Instagram_API_Feed {
	/**
	 * Plugin version
	 *
	 * @var string
	 *
	 * @since 1.0.0
	 */
	const VERSION = '1.0.0';

	/**
	 * Holds various class instances.
	 *
	 * @var array
	 *
	 * @since 1.0.0
	 */
	private $container = [];

	/**
	 * Constructor for the Instagram_API_Feed class.
	 *
	 * Sets up all the appropriate hooks and actions
	 * within our plugin.
	 *
	 * @since 1.0.0
	 */
	private function __construct() {
		$this->define_constants();

		register_activation_hook( __FILE__, [ $this, 'activate' ] );

		add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
	}

	/**
	 * Initializes the Instagram_API_Feed() class.
	 *
	 * Checks for an existing Instagram_API_Feed() instance
	 * and if it doesn't find one, creates it.
	 *
	 * @since 1.0.0
	 *
	 * @return Instagram_API_Feed|bool
	 */
	public static function init() {
		static $instance = false;

		if ( ! $instance ) {
			$instance = new Instagram_API_Feed();
		}

		return $instance;
	}

	/**
	 * Magic getter to bypass referencing plugin.
	 *
	 * @param string $prop Prop name.
	 *
	 * @since 1.0.0
	 *
	 * @return mixed
	 */
	public function __get( $prop ) {
		if ( array_key_exists( $prop, $this->container ) ) {
			return $this->container[ $prop ];
		}

		return $this->{$prop};
	}

	/**
	 * Magic isset to bypass referencing plugin.
	 *
	 * @param string $prop Prop name.
	 *
	 * @since 1.0.0
	 *
	 * @return mixed
	 */
	public function __isset( $prop ) {
		return isset( $this->{$prop} ) || isset( $this->container[ $prop ] );
	}

	/**
	 * Define the constants.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function define_constants() {
		define( 'INSTAGRAM_API_FEED_VERSION', self::VERSION );
		define( 'INSTAGRAM_API_FEED_FILE', __FILE__ );
		define( 'INSTAGRAM_API_FEED_PATH', dirname( INSTAGRAM_API_FEED_FILE ) );
		define( 'INSTAGRAM_API_FEED_INCLUDES', INSTAGRAM_API_FEED_PATH . '/includes' );
		define( 'INSTAGRAM_API_FEED_TEMPLATE_PATH', INSTAGRAM_API_FEED_PATH . '/templates/' );
		define( 'INSTAGRAM_API_FEED_URL', plugins_url( '', INSTAGRAM_API_FEED_FILE ) );
		define( 'INSTAGRAM_API_FEED_ASSETS', INSTAGRAM_API_FEED_URL . '/assets' );
		define( 'INSTAGRAM_API_FEED_ASSETS_DIR', INSTAGRAM_API_FEED_PATH . '/assets' );
		define( 'INSTAGRAM_API_FEED_BASENAME_FILE', plugin_basename( __FILE__ ) );
	}

	/**
	 * Load the plugin after all plugins are loaded.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init_plugin() {
		$this->includes();
		$this->init_hooks();
	}

	/**
	 * Placeholder for activation function.
	 *
	 * Nothing being called here yet.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function activate() {
		$installer = new InstaFeed\Installer();
		$installer->run();
	}

	/**
	 * Include the required files.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function includes() {
		if ( $this->is_request( 'admin' ) ) {
			$this->container['admin'] = new InstaFeed\Admin();
		}

		if ( $this->is_request( 'frontend' ) ) {
			$this->container['frontend'] = new InstaFeed\Frontend();
		}

		$this->container['widgets'] = new InstaFeed\Widgets();
	}

	/**
	 * Initialize the hooks.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init_hooks() {
		add_action( 'init', [ $this, 'init_classes' ] );

		// Localize our plugin.
		add_action( 'init', [ $this, 'localization_setup' ] );
	}

	/**
	 * Instantiate the required classes.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init_classes() {
		$this->container['api']    = new InstaFeed\Api();
		$this->container['assets'] = new InstaFeed\Assets();

		$this->container = apply_filters( 'iaf_get_class_container', $this->container );
	}

	/**
	 * Initialize plugin for localization.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 * @uses  load_plugin_textdomain()
	 */
	public function localization_setup() {
		load_plugin_textdomain( 'insta-api-feed', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * What type of request is this?
	 *
	 * @param string $type admin, ajax, cron or frontend.
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	private function is_request( $type ) {
		switch ( $type ) {
			case 'admin':
				return is_admin();

			case 'ajax':
				return defined( 'DOING_AJAX' );

			case 'rest':
				return defined( 'REST_REQUEST' );

			case 'cron':
				return defined( 'DOING_CRON' );

			case 'frontend':
				return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
		}
	}

} // Instagram_API_Feed

/**
 * Initialize the main plugin.
 *
 * @since 1.0.0
 *
 * @return \Instagram_API_Feed|bool
 */
function instagram_api_feed() {
	return Instagram_API_Feed::init();
}

/**
 * Kick-off the plugin.
 *
 * @since 1.0.0
 */
instagram_api_feed();
