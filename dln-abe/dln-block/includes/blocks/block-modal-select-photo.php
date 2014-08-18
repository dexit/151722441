<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Block_Modal_Select_Photo extends DLN_Block {
	
	public static function init() {
		
	}
	
	public static function render_html() {
		self::load_frontend_assets();
		DLN_Blocks::block_get_template(
			'modals/select-photo.php',
			array(
				'fields'     => self::$fields
			)
		);
	}
	
	private static function load_frontend_assets() {
		wp_enqueue_style( 'dln-block-modal-select-photo-css', DLN_ABE_PLUGIN_URL . '/assets/dln-abe/css/modals/select-photo.css', null, '1.0.0' );
		wp_enqueue_script( 'dln-block-modal-select-photo-js', DLN_ABE_PLUGIN_URL . '/assets/dln-abe/js/modals/select-photo.js', array( 'jquery' ), '1.0.0', true );
	}
}