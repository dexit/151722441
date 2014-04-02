<textarea class="form-control" name="<?php echo esc_attr( isset( $field['name'] ) ? $field['name'] : $key ); ?>"
	id="<?php echo esc_attr( $key ); ?>"
	placeholder="<?php echo esc_attr( $field['placeholder'] ); ?>"
	value="<?php echo isset( $field['value'] ) ? esc_attr( $field['value'] ) : ''; ?>"
	maxlength="<?php echo ! empty( $field['maxlength'] ) ? $field['maxlength'] : ''; ?>"
	rows="<?php echo ! empty( $field['rows'] ) ? $field['rows'] : ''; ?>">
</textarea>
<?php if ( ! empty( $field['description'] ) ) : ?>
<span class="help-block"><?php echo $field['description']; ?>
</span>
<?php endif; ?>