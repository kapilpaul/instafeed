<?php
/**
 * Admin Pages Handler
 *
 * @since 1.0.0
 *
 * @package InstaFeed\Admin
 */

namespace InstaFeed\Admin;

/**
 * Class Menu
 */
class Menu {

	/**
	 * Menu Slug.
	 *
	 * @var string
	 */
	const MENUSLUG = 'instagram-api-feed';

	/**
	 * Menu constructor.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'admin_menu' ] );
		add_filter( 'plugin_action_links_' . INSTAGRAM_API_FEED_BASENAME_FILE, [ $this, 'plugin_action_links' ] );
	}

	/**
	 * Register our menu page
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function admin_menu() {
		$parent_slug = 'options-general.php';
		$capability  = 'manage_options';

		$hook = add_submenu_page(
			$parent_slug,
			__( 'Instagram Feed', 'insta-api-feed' ),
			__( 'Instagram API Feed', 'insta-api-feed' ),
			$capability,
			self::MENUSLUG,
			[ $this, 'plugin_page' ]
		);

		add_action( 'load-' . $hook, [ $this, 'init_hooks' ] );
	}

	/**
	 * Initialize our hooks for the admin page
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init_hooks() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
	}

	/**
	 * Load scripts and styles for the app
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'instagram-feed-admin' );
		wp_enqueue_script( 'instagram-feed-admin' );

		$localize_data = apply_filters(
			'iaf_admin_localize_script',
			[
				'shortcode_help_text' => 'Instagram Feed Shortcode can be add like this <pre>[instagram_api_feed title="Your Title" limit="9" column="4" background_color="#fff" text_color="#000" show_link="true" link_text="See More" ]</pre>',
			]
		);

		wp_localize_script( 'instagram-feed-admin', 'instagramFeed', $localize_data );
	}

	/**
	 * Handles the main page
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function plugin_page() {
		printf( '<div class="instagram-feed-setting-container" id="instagram-feed-setting-container"></div>' );
	}

	/**
	 * Plugin action links
	 *
	 * @param array $links plugin links.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function plugin_action_links( $links ) {
		$settings_link = sprintf(
			'<a href="%1$s">%2$s</a>',
			esc_url( admin_url( 'options-general.php?page=' . self::MENUSLUG ) ),
			__( 'Settings', 'insta-api-feed' )
		);

		array_unshift( $links, $settings_link );

		return $links;
	}
}
