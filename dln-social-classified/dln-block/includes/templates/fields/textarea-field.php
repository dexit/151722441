<?php
$required    = ( isset( $field['required'] ) && $field['required'] == true ) ? '<span class="text-danger">*</span>' : '';
$r_attr      = ( ! empty( $required ) ) ? 'required' : '';
$placeholder = ( ! empty( $field['placeholder'] ) ) ? "placeholder='{$field['placeholder']}'" : '';
$class       = ( ! empty( $field['class'] ) ) ? $field['class'] : '';
?>
<?php if ( ! empty( $field['label'] ) ) :?>
<label class="control-label"><?php echo esc_html( $field['label'] ) ?> <?php echo $required ?></label>
<?php endif ?>
<textarea <?php echo $r_attr?>  id="dln_<?php echo $field['id']?>" name="dln_<?php echo $field['id']?>" rows="<?php echo $field['rows'] ?>" class="form-control <?php echo $class ?>" <?php echo $placeholder ?>></textarea>