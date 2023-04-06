<?php
/**
 * Scripts and Styles Class.
 *
 * @package InstaFeed\Assets
 */

namespace InstaFeed;

/**
 * Scripts and Styles Class
 */
class Assets {

	/**
	 * Assets constructor.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		if ( is_admin() ) {
			add_action( 'admin_enqueue_scripts', [ $this, 'register' ], 5 );
		} else {
			add_action( 'wp_enqueue_scripts', [ $this, 'register' ], 5 );
		}
	}

	/**
	 * Register our app scripts and styles
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register() {
		$this->register_scripts( $this->get_scripts() );
		$this->register_styles( $this->get_styles() );

		global $post;

		// Enqueue styles and script if post content has shortcode.
		if ( ! empty( $post->ID ) && has_shortcode( $post->post_content, 'instagram_api_feed' ) ) {
			wp_enqueue_style( 'instagram-feed-main' );
			wp_enqueue_script( 'instagram-feed-main' );
		}
	}

	/**
	 * Register scripts
	 *
	 * @param array $scripts Scripts data with path.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function register_scripts( $scripts ) {
		foreach ( $scripts as $handle => $script ) {
			$deps      = isset( $script['deps'] ) ? $script['deps'] : false;
			$in_footer = isset( $script['in_footer'] ) ? $script['in_footer'] : false;
			$version   = isset( $script['version'] ) ? $script['version'] : INSTAGRAM_API_FEED_VERSION;

			wp_register_script( $handle, $script['src'], $deps, $version, $in_footer );
		}
	}

	/**
	 * Register styles
	 *
	 * @param array $styles Styles data with path.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_styles( $styles ) {
		foreach ( $styles as $handle => $style ) {
			$deps = isset( $style['deps'] ) ? $style['deps'] : false;

			wp_register_style( $handle, $style['src'], $deps, INSTAGRAM_API_FEED_VERSION, 'all' );
		}
	}

	/**
	 * Get all registered scripts
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_scripts() {
		$plugin_js_assets_path = INSTAGRAM_API_FEED_ASSETS . '/js';

		// Automatically load dependencies and version.
		$asset_file = require_once INSTAGRAM_API_FEED_ASSETS_DIR . '/js/admin.asset.php';

		$scripts = [
			'instagram-feed-admin' => [
				'src'       => $plugin_js_assets_path . '/admin.js',
				'deps'      => $asset_file['dependencies'],
				'in_footer' => true,
			],
			'instagram-feed-main' => [
				'src'       => $plugin_js_assets_path . '/main.js',
				'in_footer' => true,
			],
		];

		return $scripts;
	}

	/**
	 * Get registered styles
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_styles() {
		$plugin_css_assets_path = INSTAGRAM_API_FEED_ASSETS . '/css';

		$styles = [
			'instagram-feed-admin' => [
				'src'  => $plugin_css_assets_path . '/style-admin.css',
				'deps' => [ 'wp-components' ],
			],
			'instagram-feed-main' => [
				'src'  => $plugin_css_assets_path . '/main.css',
			],
		];

		return $styles;
	}
}
