<?php 
$required    = ( isset( $field['required'] ) && $field['required'] == true ) ? '<span class="text-danger">*</span>' : '';
$r_attr      = ( ! empty( $required ) ) ? 'required' : '';
$multiple    = ( isset( $field['multiple'] ) && $field['multiple'] == true ) ? 'multiple' : '';

?>
<?php if ( ! empty( $field['label'] ) ) :?>
<label class="control-label col-sm-2"><?php echo esc_html( $field['label'] ) ?> <?php echo $required ?></label>
<?php endif ?>
<div class="col-sm-10">
	<?php if ( ! is_wp_error( $field['options'] ) ) : ?>
	<select <?php echo $multiple ?> <?php echo $r_attr ?> class="form-control <?php echo esc_attr( ! empty( $field['class'] ) ? $field['class']: '' ) ?>"
		name="dln_<?php echo esc_attr( $field['id'] ); ?>"
		id="dln_<?php echo esc_attr( $field['id'] ); ?>">
		
		<?php foreach ( $field['options'] as $select_id => $select_value ) : ?>
		<option value="<?php echo esc_attr( $select_id ); ?>">
			<?php echo esc_html( $select_value ); ?>
		</option>
		<?php endforeach; ?>
		
	</select>
	<?php else : ?>
	<label class="form-control"><?php echo $field['options']->get_error_message()?></label>
	<?php endif ?>
</div>