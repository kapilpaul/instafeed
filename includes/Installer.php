<?php
/**
 * The Installer class.
 * Install all dependency from here while activating the plugin.
 *
 * @package InstaFeed\Installer
 */

namespace InstaFeed;

/**
 * Class Installer
 *
 * @package InstaFeed
 */
class Installer {

	/**
	 * Run the installer.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function run() {
		$this->add_version();
	}

	/**
	 * Add time and version on DB.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function add_version() {
		$installed = get_option( 'instagram_api_feed_installed' );

		if ( ! $installed ) {
			update_option( 'instagram_api_feed_installed', time() );
		}

		update_option( 'instagram_api_feed_version', INSTAGRAM_API_FEED_VERSION );
	}
}
