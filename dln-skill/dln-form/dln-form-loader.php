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
		define( 'DLN_POINT_SLUG', 'dln_point' );
		
		include( 'dln-form-functions.php' );
		include( 'dln-form-template.php' );
		include( 'includes/class-dln-form-shortcodes.php' );
		include( 'includes/class-dln-form-forms.php' );
		
		if ( is_admin() )
			include( 'includes/admin/class-dln-form-admin.php' );
		
		// Init classes
		$this->forms      = new DLN_Forms();
		
		add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
	}
	
	public function register_assets() {
		wp_register_script( 'dln-form-field-text-search', DLN_SKILL_PLUGIN_URL . '/dln-form/assets/js/fields/text-search.js', array( 'jquery' ), DLN_SKILL_VERSION, true );
		wp_register_script( 'dln-bootstrap-js', DLN_SKILL_PLUGIN_URL . '/assets/3rd-party/bootstrap3/js/bootstrap.min.js', array( 'jquery' ), '3.1.1', true );
		
		wp_register_style( 'dln-bootstrap-css', DLN_SKILL_PLUGIN_URL . '/assets/3rd-party/bootstrap3/css/bootstrap.min.css', null, '3.1.1' );
		wp_register_style( 'dln-ui-element-css', DLN_SKILL_PLUGIN_URL . '/assets/theme-skill/css/uielement.min.css', array( 'dln-bootstrap-css' ), DLN_SKILL_VERSION );
	}
	
}

$GLOBALS['dln_form'] = DLN_Form_Loader::get_instance();