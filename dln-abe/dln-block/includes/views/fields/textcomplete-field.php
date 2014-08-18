<?php
wp_enqueue_script( 'dln-textcomplete-emoji-js', DLN_ABE_PLUGIN_URL . '/assets/3rd-party/jquery-textcomplete/emoji.js', array( 'jquery' ), '0.2.5', true );
wp_enqueue_script( 'dln-overlay-js', DLN_ABE_PLUGIN_URL . '/assets/3rd-party/jquery-textcomplete/jquery.overlay.js', array( 'jquery' ), '0.2.5', true );
wp_enqueue_script( 'dln-textcomplete-js', DLN_ABE_PLUGIN_URL . '/assets/3rd-party/jquery-textcomplete/jquery.textcomplete.js', array( 'jquery' ), '0.2.5', true );
wp_enqueue_style( 'dln-textcomplete-css', DLN_ABE_PLUGIN_URL . '/assets/3rd-party/jquery-textcomplete/jquery.textcomplete.css', null, '0.2.5' );
wp_enqueue_script( 'dln-block-field-textcomplete-js', DLN_ABE_PLUGIN_URL . '/assets/dln-clf/js/fields/block-field-textcomplete.js', array( 'jquery' ), '1.0.0', true );
wp_localize_script(
	'dln-block-field-textcomplete-js',
	'dln_textcomplete_params',
	array(
		'url' => DLN_ABE_PLUGIN_URL,
	)
);

$required    = ( isset( $field['required'] ) && $field['required'] == true ) ? '<span class="text-danger">*</span>' : '';
$r_attr      = ( ! empty( $required ) ) ? 'required' : '';
$placeholder = ( ! empty( $field['placeholder'] ) ) ? "placeholder='{$field['placeholder']}'" : '';
$class       = ( ! empty( $field['class'] ) ) ? $field['class'] : '';
?>
<?php if ( ! empty( $field['label'] ) ) :?>
<label class="control-label"><?php echo esc_html( $field['label'] ) ?> <?php echo $required ?></label>
<?php endif ?>
<textarea <?php echo $r_attr?>  id="dln_<?php echo $field['id']?>" name="dln_<?php echo $field['id']?>" rows="<?php echo $field['rows'] ?>" class="form-control <?php echo $class ?>" <?php echo $placeholder ?>></textarea>