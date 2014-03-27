<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Form_Loader {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		define( 'DLN_COMPANY_SLUG', 'dln_company' );
		define( 'DLN_COMPANY_TYPE_SLUG', 'dln_company_type' );
		define( 'DLN_EMPLOYEE_NUMBER_SLUG', 'dln_employ_number' );
		
		include( 'dln-form-functions.php' );
		include( 'dln-form-template.php' );
		include( 'includes/class-dln-form-shortcodes.php' );
		include( 'includes/class-dln-form-forms.php' );
		
		// Init classes
		$this->forms      = new DLN_Forms();
		
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );
	}
	
	public function frontend_scripts() {
		wp_register_script( 'dln-form-field-text-search', DLN_SKILL_PLUGIN_URL . '/dln-form/assets/js/fields/text-search.js', array( 'jquery' ), DLN_SKILL_VERSION, true );
	}
	
}

$GLOBALS['dln_form'] = DLN_Form_Loader::get_instance();