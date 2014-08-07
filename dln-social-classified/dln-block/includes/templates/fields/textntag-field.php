<?php
wp_enqueue_script( 'dln-underscore-js', DLN_CLF_PLUGIN_URL . '/assets/3rd-party/underscore/underscore-min.js', array( 'jquery' ), '1.6.0', true );
wp_enqueue_script( 'dln-textntag-js', DLN_CLF_PLUGIN_URL . '/assets/3rd-party/jquery-textntags/jquery-textntags.js', array( 'jquery' ), '0.1.2', true );
wp_enqueue_style( 'dln-textntag-css', DLN_CLF_PLUGIN_URL . '/assets/3rd-party/jquery-textntags/jquery-textntags.css', null, '0.1.2' );
wp_enqueue_script( 'dln-block-field-textntag-js', DLN_CLF_PLUGIN_URL . '/assets/dln-clf/js/fields/block-field-textntag.js', array( 'jquery' ), '1.0.0', true );

$required    = ( isset( $field['required'] ) && $field['required'] == true ) ? '<span class="text-danger">*</span>' : '';
$r_attr      = ( ! empty( $required ) ) ? 'required' : '';
$placeholder = ( ! empty( $field['placeholder'] ) ) ? "placeholder='{$field['placeholder']}'" : '';
$class       = ( ! empty( $field['class'] ) ) ? $field['class'] : '';
?>
<?php if ( ! empty( $field['label'] ) ) :?>
<label class="control-label"><?php echo esc_html( $field['label'] ) ?> <?php echo $required ?></label>
<?php endif ?>
<textarea <?php echo $r_attr?>  id="dln_<?php echo $field['id']?>" name="dln_<?php echo $field['id']?>" rows="<?php echo $field['rows'] ?>" class="form-control <?php echo $class ?>" <?php echo $placeholder ?>></textarea>