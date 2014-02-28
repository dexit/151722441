<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Job_Shortcodes {
	
	public function __construct() {
		add_shortcode( 'submit_job_freelance', array( $this, 'submit_job_freelance' ) );
	}
	
	public function submit_job_freelance() {
		return $GLOBAL['dln_job']->forms->get_form( 'submit-freelance' );
	}
	
}

new DLN_Job_Shortcodes();
