<?php
/**
 * Widgets Handler.
 *
 * @since   1.0.0
 *
 * @package InstaFeed\Admin
 */

namespace InstaFeed;

use InstaFeed\Widgets\InstagramFeedWidget;

/**
 * Class Widgets
 */
class Widgets {

	/**
	 * Widgets constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		// Early bail out if widget is not enabled from settings.
		if ( ! iaf_is_widget_enabled() ) {
			return;
		}

		add_action( 'widgets_init', [ $this, 'register_instagramfeed_widget' ] );
	}

	/**
	 * Register Instagram Feed Widget.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_instagramfeed_widget() {
		register_widget( InstagramFeedWidget::class );
	}
}
