<?php if ( is_array( $field['options'] ) ) : ?>

<?php foreach ( $field['options'] as $option => $value ) :?>
<?php $checked = ( isset( $_POST[ $key ] ) && $_POST[ $key ] == $option ) ? 'checked="checked"' : ''; ?>
<span class="checkbox custom-checkbox custom-checkbox-inverse">
	<input
	<?php echo esc_attr( $checked ) ?>
	type="checkbox"
	name="<?php echo esc_attr( isset( $field['name'] ) ) ? $field['name'] : $key ?>"
	id="<?php echo esc_attr( $key . '_' . $option ) ?>" 
	value="<?php echo esc_attr( $option )?>" />
	<label for="<?php echo esc_attr( isset( $field['name'] ) ) ? $field['name'] : $key ?>">  <?php echo esc_html( $value ) ?></label>
</span>
<?php endforeach ?>

<?php endif ?>