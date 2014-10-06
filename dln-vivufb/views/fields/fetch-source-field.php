<?php
wp_enqueue_script( 'dln-fetch-source-field-js', DLN_VVF_PLUGIN_URL . '/assets/js/fields/fetch-source.js', array( 'jquery' ), '1.0.0', true );

$required    = ( isset( $field['required'] ) && $field['required'] == true ) ? '<span class="text-danger">*</span>' : '';
$r_attr      = ( ! empty( $required ) ) ? 'required' : '';
$placeholder = ( ! empty( $field['placeholder'] ) ) ? "placeholder='{$field['placeholder']}'" : '';
$class       = ( ! empty( $field['class'] ) ) ? $field['class'] : '';
$input_type  = ( ! empty( $field['input_type'] ) ) ? $field['input_type'] : 'text';
?>
<label class="control-label col-sm-2"><?php echo esc_html( $field['label'] ) ?> <?php echo $required ?></label>
<div class="col-sm-10">
	<div class="row">
		<div class="col-xs-9">
			<input type="<?php echo $input_type ?>" class="form-control <?php echo $class ?>" <?php echo $placeholder ?> <?php echo $r_attr ?> id="dln_<?php echo $field['id']?>" name="dln_<?php echo $field['id']?>" value="<?php echo esc_attr( $field['value'] ) ?>" />
		</div>
		<div class="col-xs-3">
			<a id="vff_btn_fetch" class="btn btn-default" href="javascript:void(0)"><?php _e( 'Fetch', DLN_VVF ) ?></a>
		</div>
	</div>
</div>