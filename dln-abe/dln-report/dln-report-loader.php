<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Report_Loader {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		include( DLN_ABE_PLUGIN_DIR . '/dln-report/includes/report-ajax.php' );
		
		if ( is_admin() ) {
			include( DLN_ABE_PLUGIN_DIR . '/dln-report/includes/admin/report-post-type.php' );
		}
		
		add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'init', array( $this, 'init' ) );
	}
	
	public function admin_init() {
		wp_enqueue_style( 'dln-report-admin-css',   DLN_ABE_PLUGIN_URL . '/assets/dln-abe/css/report-admin.css', null, '1.0.0' );
	}
	
	public function init() {
		self::load_posted_form();
	}
	
	public function register_assets() {
		
	}
	
	public static function get_controller( $form_name ) {
		if ( $form = self::load_controller_class( $form_name ) ) {
			ob_start();
			call_user_func( array( $form, 'render_html' ) );
			return ob_get_clean();
		}
	}
	
	private static function load_posted_form() {
		if ( ! empty( $_GET['dln_report'] ) ) {
			echo self::get_controller( sanitize_title( $_GET['dln_report'] ) );
			die();
		}
	}
	
	private static function load_controller_class( $form_name ) {
		// Load the form abtract
		if ( ! class_exists( 'DLN_Controller' ) )
			include( 'abstracts/controller.php' );
	
		// Now try to load the form_name
		$controller_class = 'DLN_Controller_' . str_replace( '-', '_', $form_name );
		$controller_file  = DLN_ABE_PLUGIN_DIR . '/dln-report/includes/controllers/ctrl-' . $form_name . '.php';
	
		if ( class_exists( $controller_class ) )
			return $controller_class;
	
		if ( ! file_exists( $controller_file ) )
			return false;
	
		if ( ! class_exists( $controller_class ) )
			include $controller_file;
	
		// Init the form
		call_user_func( array( $controller_class, 'init' ) );
	
		return $controller_class;
	}
	
}

$GLOBALS['dln_report'] = DLN_Report_Loader::get_instance();