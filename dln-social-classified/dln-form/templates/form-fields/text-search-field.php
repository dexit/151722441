<?php
wp_enqueue_script( 'dln-form-field-text-search' );
?>
<input
	type="text" class="form-control"
	name="<?php echo esc_attr( isset( $field['name'] ) ? $field['name'] : $key ); ?>"
	id="<?php echo esc_attr( $key ); ?>"
	placeholder="<?php echo esc_attr( $field['placeholder'] ); ?>"
	value="<?php echo isset( $field['value'] ) ? esc_attr( $field['value'] ) : ''; ?>"
	maxlength="<?php echo ! empty( $field['maxlength'] ) ? $field['maxlength'] : ''; ?>" />
<?php if ( ! empty( $field['description'] ) ) : ?>
<small class="description"><?php echo $field['description']; ?>
</small>
<?php endif; ?>
