<?php

if ( ! defined( 'WPINC' ) ) { die; }

/**
 * DLN_Job_Admin class.
 */
class DLN_Job_Admin {
	
	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
		//include_once( 'class-dln-job-user-infor.php' );
		include_once( 'class-dln-job-company.php' );
	}
}
new DLN_Job_Admin();