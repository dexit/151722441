<?php

if ( ! defined( 'WPINC' ) ) { die; }

include_once( DLN_ABE_PLUGIN_DIR . '/dln-block/includes/helpers/helper-photo.php' );
include_once( DLN_ABE_PLUGIN_DIR . '/dln-block/includes/helpers/helper-photo-tmpl.php' );

class DLN_Block_Photo_Listing extends DLN_Block {
	
	public static $fields;
	public static $action;
	
	public static function init() { }
	
	public static function render_html() {
		DLN_Blocks::block_load_frontend_assets();
		self::load_frontend_assets();
		
		DLN_Blocks::block_get_template(
			'photo-listing.php',
			array(
				'fields'     => ''//self::$fields
			)
		);
	}
	
	private static function load_frontend_assets() {
		wp_enqueue_script( 'dln-block-photo-listing-js', DLN_ABE_PLUGIN_URL . '/assets/dln-abe/js/block-photo-listing.js', array( 'jquery' ), '1.0.0', true );
	}
}