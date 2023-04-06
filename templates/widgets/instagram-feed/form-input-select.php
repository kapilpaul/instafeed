<?php
/**
 * Widget Form Select Input.
 *
 * @since 1.0.0
 *
 * @package InstaFeed
 */

?>

<p>
	<label for="<?php echo esc_attr( $field_id ); ?>"><?php echo esc_html( $widget_field['label'] ); ?>:</label>

	<select class="widefat" id="<?php echo esc_attr( $field_id ); ?>" name="<?php echo esc_attr( $field_name ); ?>">
		<?php
		foreach ( $widget_field['options'] as $key => $option ) {
			printf(
				'<option value="%1$s" %2$s>%3$s</option>',
				esc_attr( $key ),
				(int) $widget_value === $key ? 'selected' : '',
				esc_attr( $option )
			);
		}
		?>
	</select>
</p>
