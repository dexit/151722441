<?php

if ( ! defined( 'WPINC' ) ) { die; }

/**
 * DLN_PushNews_Admin class.
 */
if ( ! class_exists( 'DLN_PushNews_Admin' ) ) {
	class DLN_PushNews_Admin {
	
		/**
		 * __construct function.
		 *
		 * @access public
		 * @return void
		 */
		public function __construct() {
			//include_once( 'class-dln-job-user-infor.php' );
			include_once( 'class-dln-admin-facebook.php' );
		}
	}
	new DLN_PushNews_Admin();
}
