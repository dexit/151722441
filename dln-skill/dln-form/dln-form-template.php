<?php

if ( ! defined( 'WPINC' ) ) { die; }

function dln_form_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
	if ( $args && is_array( $args ) )
		extract( $args );
	
	include( dln_form_locate_template( $template_name, $template_path, $default_path ) );
}

function dln_form_locate_template( $template_name, $template_path = '', $default_path = '' ) {
	if ( ! $template_path )
		$template_path = 'dln_skill';
	if ( ! $default_path )
		$default_path = DLN_SKILL_PLUGIN_DIR . '/dln-form/templates/';

	$template = locate_template( 
		array(
			trailingslashit( $template_path ) . $template_name,
			$template_name
		)
	);
	
	// Get default template
	if ( ! $template )
		$template = $default_path . $template_name;
	
	// Return what we found
	return apply_filters( 'dln_form_locate_template', $template, $template_name, $template_path );
}

function dln_form_profile_fields( $profile_fields ) {
	do_action( 'submit_profile_form_profile_fields_start' );
	
	foreach( $profile_fields as $key => $field ) { ?>
		<div class="form-group fieldset-<?php esc_attr_e( $key ); ?>">
			<?php if ( $field['label'] ) : ?>
			<label class="col-sm-3 control-label" for="<?php esc_attr_e( $key ); ?>"><?php echo $field['label'] . ( $field['required'] ? '' : ' <small>' . __( '(optional)', 'dln-skill' ) . '</small>' ); ?></label>
			<?php endif ?>
			<div class="col-sm-9">
				<?php dln_form_get_template( 'form-fields/' . $field['type'] . '-field.php', array( 'key' => $key, 'field' => $field ) ) ?>
			</div>
		</div>
	<?php }
	
	do_action( 'submit_profile_form_profile_fields_end' );
}

function dln_load_frontend_assets() {
	wp_enqueue_script( 'dln-bootstrap-js' );
	wp_enqueue_style( 'dln-bootstrap-css' );
	wp_enqueue_style( 'dln-ui-element-css' );
}
