<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Controller_Report_Submit extends DLN_Controller {
	
	public static function render_html() {
		self::load_frontend_assets();
	
		self::controller_get_template(
			'modals/report-submit.php',
			array(
				'fields'     => ''//self::$fields
			)
		);
	}
	
	private static function load_frontend_assets() {
		
	}
	
}