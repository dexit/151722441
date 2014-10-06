<?php

if ( ! defined( 'WPINC' ) ) { die; }

//include_once( DLN_ABE_PLUGIN_DIR . '/dln-block/includes/helpers/helper-photo-tmpl.php' );

class DLN_Controller_Source_Listing {
	
	public static $fields;
	public static $action;
	
	public static function init() { }
		
	public static function render() {
		DLN_Helper_Template::load_frontend_assets();
		
		DLN_Helper_Template::get_template(
			'view-source-listing.php'
		);
	}
	
	private static function load_frontend_assets() {
		wp_enqueue_script( 'dln-block-product-submit-js', DLN_NEW_PLUGIN_URL . '/assets/dln-abe/js/block-product-submit.js', array( 'jquery' ), '1.0.0', true );
		wp_enqueue_script( 'plupload-handlers' );
	}
}