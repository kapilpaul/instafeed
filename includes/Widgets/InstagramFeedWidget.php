<?php
/**
 * Instagram Feed Widget Handler
 *
 * @since   1.0.0
 *
 * @package InstaFeed\Admin\Widgets
 */

namespace InstaFeed\Widgets;

use InstaFeed\API\Instagram;
use WP_Widget;

/**
 * Class InstagramFeedWidget
 */
class InstagramFeedWidget extends WP_Widget {

	/**
	 * Widget Fields.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	private $widget_fields = [
		[
			'label'     => 'No of Images',
			'id'        => 'iaf-no-of-images',
			'default'   => 9,
			'type'      => 'number',
			'min'       => 1,
			'max'       => 20,
			'help_text' => 'Max input number is 20',
		],
		[
			'label'   => 'Column',
			'id'      => 'iaf-column',
			'class'   => 'widefat',
			'type'    => 'select',
			'default' => '3',
			'options' => [
				'1' => 'one-column',
				'2' => 'two column',
				'3' => 'three-column',
				'4' => 'four-column',
			],
		],
		[
			'label'   => 'Background Color',
			'id'      => 'iaf-background-color',
			'type'    => 'color',
			'default' => '#fff',
		],
		[
			'label'   => 'Text Color',
			'id'      => 'iaf-text-color',
			'type'    => 'color',
			'default' => '#000',
		],
		[
			'label' => 'Link to the Instagram page',
			'id'    => 'iaf-link-to-instagram-page',
			'type'  => 'checkbox',
		],
		[
			'label' => 'Link Text',
			'id'    => 'iaf-link-text',
			'type'  => 'text',
		],
	];

	/**
	 * InstagramFeedWidget constructor.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct(
			'instagram-feed-widget',
			__( 'Instagram Feed', 'insta-api-feed' ),
			[ 'description' => __( 'Display Instagram Feeds.', 'insta-api-feed' ) ]
		);
	}

	/**
	 * Render frontend Widget HTML.
	 *
	 * @param array $args     Display arguments including 'before_title',
	 *                        'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance The settings for the particular instance of the
	 *                        widget.
	 *
	 * @since 1.0.0
	 *
	 * @see   WP_Widget::widget()
	 *
	 * @return void
	 */
	public function widget( $args, $instance ) {
		wp_enqueue_style( 'instagram-feed-main' );
		wp_enqueue_script( 'instagram-feed-main' );

		printf( wp_kses_post( $args['before_widget'] ) );

		$title = '';

		if ( ! empty( $instance['title'] ) ) {
			$title = sprintf(
				'%1$s %2$s %3$s',
				wp_kses_post( $args['before_title'] ),
				wp_kses_post( apply_filters( 'widget_title', $instance['title'] ) ),
				wp_kses_post( $args['after_title'] )
			);
		}

		// building shortcode data.
		$shortcode = sprintf(
			'[instagram_api_feed title="%1$s" limit="%2$s" column="%3$s" background_color="%4$s" text_color="%5$s" show_link="%6$s" link_text="%7$s" ]',
			$title,
			$instance['iaf-no-of-images'],
			$instance['iaf-column'],
			$instance['iaf-background-color'],
			$instance['iaf-text-color'],
			$instance['iaf-link-to-instagram-page'],
			$instance['iaf-link-text']
		);

		// printing shortcode here.
		printf( '%s', do_shortcode( $shortcode ) );

		printf( wp_kses_post( $args['after_widget'] ) );
	}

	/**
	 * Outputs the settings update form.
	 *
	 * @since 1.0.0
	 *
	 * @param array $instance Current settings.
	 *
	 * @return void.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';

		$title = apply_filters( 'iaf_widget_title', $title );

		$widget_fields = apply_filters( 'iaf_widget_fields', $this->widget_fields );

		iaf_get_template(
			'widgets/instagram-feed/form',
			[
				'title'                          => $title,
				'widget_fields'                  => $widget_fields,
				'widget_data'                    => $instance,
				'instagram_feed_widget_instance' => $this,
			]
		);
	}

	/**
	 * Updates a particular instance of a widget.
	 *
	 * @param array $new_instance New settings for this instance as input by the user via WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance          = [];
		$instance['title'] = ! empty( $new_instance['title'] ) ? wp_strip_all_tags( $new_instance['title'] ) : '';

		$widget_fields = apply_filters( 'iaf_widget_fields', $this->widget_fields );

		foreach ( $widget_fields as $widget_field ) {
			switch ( $widget_field['type'] ) {
				case 'number':
					// Check for number if its exceed its min or max value.
					if ( ! empty( $new_instance[ $widget_field['id'] ] ) ) {
						$new_value = wp_strip_all_tags( $new_instance[ $widget_field['id'] ] );

						if ( ! empty( $widget_field['min'] ) && $new_value <= $widget_field['min'] ) {
							$new_value = $widget_field['min'];
						}

						if ( ! empty( $widget_field['max'] ) && $new_value >= $widget_field['max'] ) {
							$new_value = $widget_field['max'];
						}

						$instance[ $widget_field['id'] ] = $new_value;

					} else {
						$instance[ $widget_field['id'] ] = '';
					}

					break;
				default:
					$instance[ $widget_field['id'] ] = ( ! empty( $new_instance[ $widget_field['id'] ] ) ) ? wp_strip_all_tags( $new_instance[ $widget_field['id'] ] ) : '';
					break;
			}
		}

		return $instance;
	}
}
