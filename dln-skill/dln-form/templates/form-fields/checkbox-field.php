<?php if ( is_array( $field['options'] ) ) : ?>
<?php foreach ( $field['options'] as $option => $value ) :?>
<span class="checkbox custom-checkbox custom-checkbox-inverse">
	<input
	type="checkbox"
	name="<?php echo esc_attr( isset( $field['name'] ) ) ? $field['name'] : $key ?>"
	id="<?php echo esc_attr( $key ) ?>" 
	value="<?php echo esc_attr( $option )?>" />
	<label for="<?php echo esc_attr( isset( $field['name'] ) ) ? $field['name'] : $key ?>"><?php echo esc_html( $value ) ?></label>
</span>

<?php endforeach ?>
<?php endif ?>