<?php
/**
 * Widget Form Default Input.
 *
 * @since 1.0.0
 *
 * @package InstaFeed
 */

?>

<p>
	<label for="<?php echo esc_attr( $field_id ); ?>"><?php echo esc_html( $widget_field['label'] ); ?>:</label>
	<br>
	<input
		<?php
		// add class widefat if type is not color.
		if ( 'color' !== $widget_field['type'] ) :
			?>
			class="widefat"
		<?php endif; ?>
		id="<?php echo esc_attr( $field_id ); ?>"
		name="<?php echo esc_attr( $field_name ); ?>"
		type="<?php echo esc_attr( $widget_field['type'] ); ?>"
		value="<?php echo esc_html( $widget_value ); ?>"

		<?php
		// Adding min max for number field.
		if ( isset( $widget_field['min'] ) ) :
			?>
		min="<?php echo esc_html( $widget_field['min'] ); ?>"
		<?php endif; ?>

		<?php if ( isset( $widget_field['max'] ) ) : ?>
		max="<?php echo esc_html( $widget_field['max'] ); ?>"
		<?php endif; ?>
	>

	<?php if ( isset( $widget_field['help_text'] ) ) : ?>
	<span class="description"><?php echo esc_html( $widget_field['help_text'] ); ?></span>
	<?php endif; ?>
</p>
