<input type="password" class="form-control"
	name="<?php echo esc_attr( isset( $field['name'] ) ? $field['name'] : $key ); ?>"
	id="<?php echo esc_attr( $key ); ?>"
	placeholder="<?php echo esc_attr( $field['placeholder'] ); ?>"
	value="<?php echo esc_attr( isset( $field['value'] ) ? esc_attr( $field['value'] ) : '' ) ?>"
	maxlength="<?php echo esc_attr( ! empty( $field['maxlength'] ) ? $field['maxlength'] : '' ) ?>" />
<?php if ( ! empty( $field['description'] ) ) : ?>
<small class="description"><?php echo esc_html( $field['description'] ) ?>
</small>
<?php endif; ?>