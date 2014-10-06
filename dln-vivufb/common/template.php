<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Common_Template {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() { }
	
	public static function render_view( $controller_name ) {
		if ( $controller = self::load_controller( $controller_name ) ) {
			ob_start();
			call_user_func( array( $controller, 'render' ) );
			return ob_get_clean();
		}
	}
	
	public static function load_controller( $controller_name = '' ) {
		if ( ! $controller_name )
			return false;
		
		// Load controller class
		$controller_class = 'DLN_Controller_' . str_replace( '-', '_', $controller_name );
		$controller_name  = sanitize_title( $controller_name );
		$controller_file  = DLN_VVF_PLUGIN_DIR . '/controllers/controller-' . $controller_name . '.php';
		
		if ( class_exists( $controller_class ) )
			return $controller_class;
		
		if ( ! file_exists( $controller_file ) )
			return false;
		
		if ( ! class_exists( $controller_class ) )
			include $controller_file;
		
		// Init the controller
		call_user_func( array( $controller_class, 'init' ) );
		
		return $controller_class;
	}

	public static function get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
		if ( $args && is_array( $args ) )
			extract( $args );

		include( self::locate_template( $template_name, $template_path, $default_path ) );
	}

	public static function locate_template( $template_name, $template_path = '', $default_path = '' ) {
		if ( ! $template_path )
			$template_path = 'dln_vivifb';
		if ( ! $default_path )
			$default_path = DLN_VVF_PLUGIN_DIR . '/views/';

		$template = locate_template(
				array(
						trailingslashit( $template_path ) . $template_name,
						$template_name,
				)
		);

		// Get default template
		if ( ! $template )
			$template = $default_path . $template_name;

		// Return what we found
		return apply_filters( 'dln_locate_template', $template, $template_name, $template_path );
	}

	public static function load_frontend_assets() {
		//wp_enqueue_script( 'dln-bootstrap-js' );
		//wp_enqueue_script( 'dln-dropzone-js' );
		//wp_enqueue_script( 'dln-parsley-js' );
		//wp_enqueue_script( 'dln-steps-js' );
		//wp_enqueue_script( 'dln-form-submit-fashion-js' );
		
		//wp_enqueue_style( 'dln-bootstrap-css' );
		//wp_enqueue_style( 'dln-ui-element-css' );
		//wp_enqueue_style( 'dln-ui-layout-css' );
		
		wp_enqueue_script( 'dln-app-js', DLN_VVF_PLUGIN_URL . '/assets/js/app.v1.js', array( 'jquery' ), DLN_VVF_VERSION, true );
		wp_enqueue_style( 'dln-app-css', DLN_VVF_PLUGIN_URL . '/assets/css/app.v1.css', null, DLN_VVF_VERSION );
		
		wp_enqueue_script( 'dln-selectize-js',  DLN_VVF_PLUGIN_URL . '/assets/3rd-party/selectize/js/selectize.min.js', array( 'dln-app-js' ), '1.0.0', true );
		wp_enqueue_style( 'dln-selectize-css', DLN_VVF_PLUGIN_URL . '/assets/3rd-party/selectize/css/selectize.min.css', array( 'dln-app-css' ), '1.0.0' );
		
		wp_enqueue_script( 'dln-script-js', DLN_VVF_PLUGIN_URL . '/assets/js/dln-script.js', array( 'jquery' ), DLN_VVF_VERSION, true );
		wp_localize_script(
			'dln-script-js',
			'dln_params',
			array(
				'site_url'     => site_url(),
				'fb_app_id'    => FB_APP_ID,
				'fb_url'       => FB_REDIRECT_URI,
				'dln_ajax_url' => admin_url( 'admin-ajax.php' ),
				'indicator'    => '<div class="indicator show"><span class="spinner spinner3"></span></div>',
				'language'     => array(
					'error_empty_source_link' => __( 'Please check your link!', DLN_VVF ),
				),
				'dln_nonce' => wp_create_nonce( DLN_VVF_NONCE ),
			)
		);
	}
	
}

DLN_Common_Template::get_instance();