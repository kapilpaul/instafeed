<?php
/**
 * Widget Form.
 *
 * @since 1.0.0
 *
 * @package InstaFeed
 */

// Bail out `InstagramFeedWidget` class not found.
if ( ! $instagram_feed_widget_instance instanceof \InstaFeed\Widgets\InstagramFeedWidget ) {
	printf( '<p>InstagramFeedWidget %s</p>', esc_html__( 'class not found', 'insta-api-feed' ) );
	return false;
}

$title_field_id   = $instagram_feed_widget_instance->get_field_id( 'title' );
$title_field_name = $instagram_feed_widget_instance->get_field_name( 'title' );

?>

<div class="instagram-feed-widget-conatiner">

	<!-- This is for title -->
	<p>
		<label for="<?php echo esc_attr( $title_field_id ); ?>">
			<?php esc_attr_e( 'Title:', 'insta-api-feed' ); ?>
		</label>

		<input
			class="widefat"
			id="<?php echo esc_attr( $title_field_id ); ?>"
			name="<?php echo esc_attr( $title_field_name ); ?>"
			type="text"
			value="<?php echo esc_attr( $title ); ?>"
		>
	</p>
	<!-- Ends of title -->

	<!-- Widgets Field Start -->

	<?php
	foreach ( $widget_fields as $widget_field ) :

		$default = '';
		$output  = '';

		if ( ! empty( $widget_field['default'] ) ) {
			$default = $widget_field['default'];
		}

		$widget_value = ! empty( $widget_data[ $widget_field['id'] ] ) ? $widget_data[ $widget_field['id'] ] : $default;

		switch ( $widget_field['type'] ) {
			case 'select':
				$template_slug = 'input-select';
				break;

			case 'checkbox':
				$template_slug = 'input-checkbox';
				break;

			default:
				$template_slug = 'input-default';
				break;
		}

		iaf_get_template_part(
			'widgets/instagram-feed/form',
			$template_slug,
			[
				'field_id'     => $instagram_feed_widget_instance->get_field_id( $widget_field['id'] ),
				'field_name'   => $instagram_feed_widget_instance->get_field_name( $widget_field['id'] ),
				'widget_field' => $widget_field,
				'widget_value' => $widget_value,
			]
		);

	endforeach;
	?>

	<!-- Widgets Field End -->

</div>
