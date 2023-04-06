<?php
/**
 * Class Shortcode
 *
 * @package InstaFeed\Frontend\Shortcode
 */

namespace InstaFeed\Frontend;

use InstaFeed\API\Instagram;

/**
 * Class Shortcode
 */
class Shortcode {

	/**
	 * Constructor class
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		add_shortcode( 'instagram_api_feed', [ $this, 'render_frontend' ] );
	}

	/**
	 * Render frontend app
	 *
	 * @param array  $atts    Shortcode attributes.
	 * @param string $content Content data.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function render_frontend( $atts, $content = '' ) {
		$default = [
			'title'            => __( 'Instagram Feed', 'insta-api-feed' ),
			'limit'            => 20,
			'column'           => 3,
			'background_color' => '',
			'text_color'       => '',
			'show_link'        => '',
			'link_text'        => __( 'See More', 'insta-api-feed' ),
		];

		$attrs = shortcode_atts( $default, $atts );

		// setting default value if a value is blank coming from shortcode.
		foreach ( $attrs as $key => $attr ) {
			if ( empty( $attrs[ $key ] ) ) {
				$attrs[ $key ] = $default[ $key ];
			}
		}

		$attrs = apply_filters( 'iaf_shortcode_attrs', $attrs );

		$instagram_api = Instagram::get_instance();
		$feeds         = $instagram_api->get_feeds( (int) $attrs['limit'] );

		// if get an error while fetching then display message to the user.
		if ( is_wp_error( $feeds ) ) {
			return sprintf(
				'<p class="text-danger">%s</p>',
				esc_html( $feeds->get_error_message() )
			);
		}

		do_action( 'iaf_before_render_shortcode', $attrs, $feeds );

		ob_start();

		iaf_get_template(
			'feeds',
			[
				'feeds'    => $feeds,
				'settings' => $attrs,
			]
		);

		$feeds_html = ob_get_clean();

		do_action( 'iaf_after_render_shortcode', $feeds_html, $attrs, $feeds );

		return apply_filters( 'iaf_render_shortcode_html', $feeds_html );
	}
}
