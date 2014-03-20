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
