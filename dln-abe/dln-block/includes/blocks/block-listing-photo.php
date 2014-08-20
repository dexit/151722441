<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Block_Submit_Photo extends DLN_Block {
	
	public static $fields;
	public static $action;
	
	public static function init() {
		
	}
	
	public static function render_html() {
		self::init_fields();
		
		DLN_Blocks::block_load_frontend_assets();
		DLN_Block_Submit_Photo::load_frontend_assets();
		
		DLN_Blocks::block_get_template(
			'listing-photo.php',
			array(
				'fields'     => ''//self::$fields
			)
		);
	}
	
	private static function load_frontend_assets() {
		wp_enqueue_script( 'dln-block-listing-photo-js', DLN_ABE_PLUGIN_URL . '/assets/dln-abe/js/block-listing-photo.js', array( 'jquery' ), '1.0.0', true );
	}
}