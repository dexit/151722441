<?php
$required    = ( isset( $field['required'] ) && $field['required'] == true ) ? '<span class="text-danger">*</span>' : '';
$r_attr      = ( ! empty( $required ) ) ? 'required' : '';
$placeholder = ( ! empty( $field['placeholder'] ) ) ? "placeholder='{$field['placeholder']}'" : '';
$class       = ( ! empty( $field['class'] ) ) ? $field['class'] : '';
$input_type  = ( ! empty( $field['input_type'] ) ) ? $field['input_type'] : 'text';
?>
<label class="control-label col-sm-2"><?php echo esc_html( $field['label'] ) ?> <?php echo $required ?></label>
<div class="col-sm-10">
	<input type="<?php echo $input_type ?>" class="form-control <?php echo $class ?>" <?php echo $placeholder ?> <?php echo $r_attr ?> id="dln_<?php echo $field['id']?>" name="dln_<?php echo $field['id']?>" value="<?php echo esc_attr( $field['value'] ) ?>" />
</div>