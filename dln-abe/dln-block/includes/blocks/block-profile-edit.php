<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Block_Profile_Edit extends DLN_Block {
	
	public static $fields;
	public static $action;
	
	public static function init() {
		
	}
	
	public static function render_html() {
		DLN_Blocks::block_load_frontend_assets();
		self::load_frontend_assets();
		
		DLN_Blocks::block_get_template(
			'profile-edit.php',
			array(
				'fields'     => ''//self::$fields
			)
		);
	}
	
	private static function load_frontend_assets() {
		wp_enqueue_script( 'dln-block-photo-listing-js', DLN_ABE_PLUGIN_URL . '/assets/dln-abe/js/block-photo-listing.js', array( 'jquery' ), '1.0.0', true );
	}
}