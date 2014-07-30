<select class="form-control <?php echo esc_attr( ! empty( $field['class'] ) ? $field['class']: '' ) ?>"
	name="<?php echo esc_attr( isset( $field['name'] ) ? $field['name'] : $key ); ?>"
	id="<?php echo esc_attr( $key ); ?>">
	
	<?php foreach ( $field['options'] as $select_id => $select_value ) : ?>
	<option value="<?php echo esc_attr( $select_id ); ?>">
		<?php echo esc_html( $select_value ); ?>
	</option>
	<?php endforeach; ?>
	
</select>
