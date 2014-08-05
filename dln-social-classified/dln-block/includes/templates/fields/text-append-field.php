<?php
$required    = ( isset( $field['required'] ) && $field['required'] == true ) ? '<span class="text-danger">*</span>' : '';
$r_attr      = ( ! empty( $required ) ) ? 'required' : '';
$placeholder = ( ! empty( $field['placeholder'] ) ) ? "placeholder='{$field['placeholder']}'" : '';
$class       = ( ! empty( $field['class'] ) ) ? $field['class'] : '';
$prepend     = ( ! empty( $field['prepend'] ) ) ? '<span class="input-group-addon">' . $field['prepend'] . '</span>' : '';
$append      = ( ! empty( $field['append'] ) ) ? '<span class="input-group-addon">' . $field['append'] . '</span>' : '';
?>
<?php if ( ! empty( $field['label'] ) ) :?>
<label class="control-label"><?php echo esc_html( $field['label'] ) ?> <?php echo $required ?></label>
<?php endif ?>
<div class="input-group">
	<?php echo balanceTags( $prepend ) ?>
	<input type="text" class="form-control <?php echo $class ?>" <?php echo $placeholder ?> <?php echo $r_attr ?> id="dln_<?php echo $field['id']?>" name="dln_<?php echo $field['id']?>" value="<?php echo esc_attr( $field['value'] ) ?>" />
	<?php echo balanceTags( $append ) ?>
</div>