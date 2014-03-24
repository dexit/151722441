<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Forms {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		add_action( 'init', array( $this, 'load_posted_form' ) );
	}
	
	public function load_posted_form() {
		if ( ! empty( $_POST['dln_manager_form'] ) ) {
			$this->load_form_class( sanitiza_title( $_POST['dln_manager_form'] ) );
		}
	}
	
	private function load_form_class( $form_name ) {
		// Load the form abtract
		if ( ! class_exists( 'DLN_Form' ) )
			include( 'abstracts/abstract-dln-form.php' );
		
		// Now try to load the form_name
		$form_class  = 'DLN_Form_' . str_replace( '-', '_', $form_name );
		$form_file   = DLN_SKILL_PLUGIN_DIR . '/dln-form/includes/forms/class-dln-form-' . $form_name . '.php';

		if ( class_exists( $form_class ) )
			return $form_class;
		
		if ( ! file_exists( $form_file ) )
			return false;
		
		if ( ! class_exists( $form_class ) )
			include $form_file;
		
		// Init the form
		call_user_func( array( $form_class, "init" ) );
		
		return $form_class;
	}
	
	public function get_form( $form_name ) {
		if ( $form = $this->load_form_class( $form_name ) ) {
			
			ob_start();
			call_user_func( array( $form, 'output' ) );
			return ob_get_clean();
		}
	}
	
}

DLN_Forms::get_instance();