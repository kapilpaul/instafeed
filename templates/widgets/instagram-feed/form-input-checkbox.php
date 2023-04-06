<?php
/**
 * Widget Form Checkbox Input.
 *
 * @since 1.0.0
 *
 * @package InstaFeed
 */

?>

<p>
	<label for="<?php echo esc_attr( $field_id ); ?>">
		<input
			class="checkbox"
			type="checkbox"
			id="<?php echo esc_attr( $field_id ); ?>"
			name="<?php echo esc_attr( $field_name ); ?>"
			value="1"
			<?php checked( $widget_value ); ?>
		>

		<?php echo esc_html( $widget_field['label'] ); ?>
	</label>
</p>
