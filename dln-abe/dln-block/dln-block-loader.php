<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Block_Loader {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		include( 'includes/block-cache.php' );
		include( 'includes/block-ajax.php' );
		include( 'includes/blocks.php' );
		
		if ( is_admin() ) {
			//include( 'admin/class-dln-form-admin.php' );
		}
		
		// Init classes
		$this->blocks      = DLN_Blocks::get_instance();
		
		add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
		add_action( 'init', array( $this, 'init' ) );
		//add_action( 'admin_init', array( $this, 'admin_init' ) );
	}
	
	public function init() {
		
	}
	
	/*public function admin_init() {
		wp_enqueue_script( 'dln-select2-js',             DLN_ABE_PLUGIN_URL . '/assets/3rd-party/select2/select2.min.js', array( 'jquery' ), '3.4.8', true );
		wp_enqueue_script( 'dln-select2-locale-js',      DLN_ABE_PLUGIN_URL . '/assets/3rd-party/select2/select2_locale_vi.js', array( 'jquery', 'dln-select2-js' ), '3.4.8', true );
		wp_enqueue_script( 'dln-colorpicker-js',         DLN_ABE_PLUGIN_URL . '/assets/3rd-party/jquery-colorpicker/js/colorpicker.js', array( 'jquery' ), '1.0.0', true );
		wp_enqueue_script( 'dln-admin-fashion-js',       DLN_ABE_PLUGIN_URL . '/dln-form/assets/js/admin/admin-form.js', array( 'jquery' ), '1.0.0', true );
		wp_enqueue_style( 'dln-select2-css',             DLN_ABE_PLUGIN_URL . '/assets/3rd-party/select2/select2.css', null, '3.4.8' );
		wp_enqueue_style( 'dln-select2-bootstrap-css',   DLN_ABE_PLUGIN_URL . '/assets/3rd-party/select2/select2-bootstrap.css', null, '3.4.8' );
		wp_enqueue_style( 'dln-colorpicker-css',         DLN_ABE_PLUGIN_URL . '/assets/3rd-party/jquery-colorpicker/css/colorpicker.css', null, '3.4.8' );
	}*/
	
	public function register_assets() {
		wp_register_script( 'dln-form-field-text-search', DLN_ABE_PLUGIN_URL . '/assets/js/fields/text-search.js', array( 'jquery' ), DLN_ABE_VERSION, true );
		wp_register_script( 'dln-bootstrap-js',           DLN_ABE_PLUGIN_URL . '/assets/3rd-party/bootstrap3/js/bootstrap.min.js', array( 'jquery' ), '3.1.1', true );
		wp_register_script( 'dln-selectize-js',           DLN_ABE_PLUGIN_URL . '/assets/3rd-party/selectize/js/selectize.min.js', array( 'jquery' ), '1.0.0', true );
		wp_register_script( 'dln-dropzone-js',            DLN_ABE_PLUGIN_URL . '/assets/3rd-party/dropzone/dropzone.min.js', array( 'jquery' ), '1.0.0', true );
		wp_register_script( 'dln-parsley-js',             DLN_ABE_PLUGIN_URL . '/assets/3rd-party/parsley/js/parsley.min.js', array( 'jquery' ), '1.0.0', true );
		wp_register_script( 'dln-steps-js',               DLN_ABE_PLUGIN_URL . '/assets/3rd-party/steps/js/jquery.steps.min.js', array( 'jquery' ), '1.0.0', true );
		
		wp_register_style( 'dln-bootstrap-css',         DLN_ABE_PLUGIN_URL . '/assets/3rd-party/bootstrap3/css/bootstrap.min.css', null, '3.1.1' );
		wp_register_style( 'dln-selectize-css',         DLN_ABE_PLUGIN_URL . '/assets/3rd-party/selectize/css/selectize.min.css', null, '1.0.0' );
		wp_register_style( 'dln-dropzone-css',          DLN_ABE_PLUGIN_URL . '/assets/3rd-party/dropzone/css/dropzone.css', null, '1.0.0' );
		wp_register_style( 'dln-ico-font-css',          DLN_ABE_PLUGIN_URL . '/assets/3rd-party/dln-ico-font/dln-ico-font.css', null, '1.0.0' );
		wp_register_style( 'dln-steps-css',             DLN_ABE_PLUGIN_URL . '/assets/3rd-party/steps/css/jquery-steps.min.css', null, '1.0.0' );
		wp_register_style( 'dln-summernote-css',        DLN_ABE_PLUGIN_URL . '/assets/3rd-party/summernote/css/summernote.min.css', null, '1.0.0' );
		wp_register_style( 'dln-font-awesome-css',      DLN_ABE_PLUGIN_URL . '/assets/3rd-party/font-awesome/css/font-awesome.min.css', null, '4.1.0' );
		wp_register_style( 'dln-form-site-css',         DLN_ABE_PLUGIN_URL . '/assets/dln-abe/css/dln-form-site.css', null, '1.0.0' );
		wp_register_style( 'dln-ui-element-css',        DLN_ABE_PLUGIN_URL . '/assets/dln-abe/css/uielement.min.css', null, '1.0.0' );
		wp_register_style( 'dln-ui-layout-css',         DLN_ABE_PLUGIN_URL . '/assets/dln-abe/css/layout.css', null, '1.0.0' );
		
		wp_register_script( 'dln-summernote-js',             DLN_ABE_PLUGIN_URL . '/assets/3rd-party/summernote/js/summernote.min.js', array( 'jquery' ), '1.0.0', true );
		wp_register_script( 'dln-form-wysiwyg-js',           DLN_ABE_PLUGIN_URL . '/assets/dln-abe/js/forms/wysiwyg.js', array( 'jquery' ), '1.0.0', true );
		
		wp_register_script( 'dln-jquery-unveil-js', DLN_ABE_PLUGIN_URL . '/assets/3rd-party/jquery-unveil/jquery.unveil.js', array( 'jquery' ), '1.0.0', true );
		wp_register_style( 'dln-block-photo-css',   DLN_ABE_PLUGIN_URL . '/assets/dln-abe/css/block-photo.css', null, '1.0.0' );
	}
	
}

$GLOBALS['dln_block'] = DLN_Block_Loader::get_instance();