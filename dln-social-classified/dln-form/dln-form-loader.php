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
		include( 'includes/class-dln-form-shortcodes.php' );
		include( 'includes/class-dln-form-functions.php' );
		include( 'includes/class-dln-form-forms.php' );
		
		if ( is_admin() ) {
			include( 'admin/class-dln-form-admin.php' );
		}
			
		
		// Init classes
		$this->forms      = new DLN_Forms();
		
		add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
		add_action( 'init', array( $this, 'init' ) );
		add_action( 'admin_init', array( $this, 'admin_init' ) );
	}
	
	public function init() {
		include( 'includes/woocommerce/class-dln-wc-product-fashion.php' );
	}
	
	public function admin_init() {
		wp_enqueue_script( 'dln-select2-js',             DLN_CLF_PLUGIN_URL . '/assets/3rd-party/select2/select2.min.js', array( 'jquery' ), '3.4.8', true );
		wp_enqueue_script( 'dln-select2-locale-js',      DLN_CLF_PLUGIN_URL . '/assets/3rd-party/select2/select2_locale_vi.js', array( 'jquery', 'dln-select2-js' ), '3.4.8', true );
		wp_enqueue_script( 'dln-admin-fashion-js',       DLN_CLF_PLUGIN_URL . '/dln-form/assets/js/admin/admin-form.js', array( 'jquery' ), '1.0.0', true );
		wp_enqueue_style( 'dln-select2-css',           DLN_CLF_PLUGIN_URL . '/assets/3rd-party/select2/select2.css', null, '3.4.8' );
		wp_enqueue_style( 'dln-select2-bootstrap-css', DLN_CLF_PLUGIN_URL . '/assets/3rd-party/select2/select2-bootstrap.css', null, '3.4.8' );
	}
	
	public function register_assets() {
		wp_register_script( 'dln-form-field-text-search', DLN_CLF_PLUGIN_URL . '/dln-form/assets/js/fields/text-search.js', array( 'jquery' ), DLN_CLF_VERSION, true );
		wp_register_script( 'dln-bootstrap-js',           DLN_CLF_PLUGIN_URL . '/assets/3rd-party/bootstrap3/js/bootstrap.min.js', array( 'jquery' ), '3.1.1', true );
		wp_register_script( 'dln-selectize-js',           DLN_CLF_PLUGIN_URL . '/assets/3rd-party/selectize/js/selectize.min.js', array( 'jquery' ), '1.0.0', true );
		wp_register_script( 'dln-dropzone-js',            DLN_CLF_PLUGIN_URL . '/assets/3rd-party/dropzone/dropzone.min.js', array( 'jquery' ), '1.0.0', true );
		
		wp_register_script( 'dln-form-submit-fashion-js', DLN_CLF_PLUGIN_URL . '/assets/theme-skill/js/form-submit-fashion.js', array( 'jquery' ), '1.0.0', true );
		
		wp_register_style( 'dln-bootstrap-css',         DLN_CLF_PLUGIN_URL . '/assets/3rd-party/bootstrap3/css/bootstrap.min.css', null, '3.1.1' );
		wp_register_style( 'dln-ui-element-css',        DLN_CLF_PLUGIN_URL . '/assets/theme-skill/css/uielement.css', null, '1.0.0' );
		wp_register_style( 'dln-ui-layout-css',         DLN_CLF_PLUGIN_URL . '/assets/theme-skill/css/layout.css', null, '1.0.0' );
		wp_register_style( 'dln-selectize-css',         DLN_CLF_PLUGIN_URL . '/assets/3rd-party/selectize/css/selectize.min.css', null, '1.0.0' );
		wp_register_style( 'dln-dropzone-css',          DLN_CLF_PLUGIN_URL . '/assets/3rd-party/dropzone/css/dropzone.css', null, '1.0.0' );
		wp_register_style( 'dln-ico-font-css',          DLN_CLF_PLUGIN_URL . '/assets/3rd-party/dln-ico-font/dln-ico-font.css', null, '1.0.0' );
		wp_register_style( 'dln-form-site-css',         DLN_CLF_PLUGIN_URL . '/assets/theme-skill/css/dln-form-site.css', null, '1.0.0' );
	}
	
}

$GLOBALS['dln_form'] = DLN_Form_Loader::get_instance();