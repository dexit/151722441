<?php if ( is_array( $field['options'] ) ) : ?>
<?php foreach ( $field['options'] as $option => $value ) :?>
<input
	type="checkbox"
	name="<?php echo esc_attr( isset( $field['name'] ) ) ? $field['name'] : $key ?>[]"
	id="<?php echo esc_attr( $key ) ?>" 
	value="<?php echo esc_attr( $option )?>"
	><?php echo esc_html( $value ) ?>
</input>
<?php endforeach ?>
<?php endif ?>