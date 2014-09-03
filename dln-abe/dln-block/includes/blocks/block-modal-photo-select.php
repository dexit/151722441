<?php

if ( ! defined( 'WPINC' ) ) { die; }

include_once( DLN_ABE_PLUGIN_DIR . '/dln-block/includes/helpers/helper-photo-tmpl.php' );

class DLN_Block_Modal_Photo_Select extends DLN_Block {
	
	public static function init() {
		
	}
	
	public static function render_html() {
		self::load_frontend_assets();
		wp_print_styles( 'dln-block-modal-photo-select-css' );
		DLN_Blocks::block_get_template(
			'modals/photo-select.php',
			array(
				'fields' => null
			)
		);
	}
	
	private static function load_frontend_assets() {
		wp_enqueue_style( 'dln-block-modal-photo-select-css', DLN_ABE_PLUGIN_URL . '/assets/dln-abe/css/modals/photo-select.css', null, '1.0.0' );
		wp_enqueue_script( 'dln-block-modal-photo-select-js', DLN_ABE_PLUGIN_URL . '/assets/dln-abe/js/modals/photo-select.js', array( 'jquery' ), '1.0.0', true );
	}
}