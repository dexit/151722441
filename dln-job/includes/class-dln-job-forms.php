<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Job_Forms {
	
	public function __construct() {
		add_action( 'init', array( $this, 'load_posted_form' ) );
	}
	
	public function load_posted_form() {
		if ( ! empty( $_POST['dln_job_form'] ) ) {
			$this->load_form_class( sanitize_title( $_POST['dln_job_form'] ) );
		}
	}
	
	public function load_form_class( $form_name ) {
		global $dln_job;
		
		// Load the form abstract
		if ( ! class_exists( 'DLN_Job_Form' ) )
			include( 'abstracts/abstract-dln-job-form.php' );
		
		// Now try to load the form_name
		$form_class  = 'DLN_Job_Form_' . str_replace( '-', '_', $form_name );
		$form_file   = DLN_JOB_PLUGIN_DIR . '/includes/forms/class-dln-job-form-' . $form_name . '.php';
		
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
	
}

