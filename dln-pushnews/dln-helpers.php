<?php

if ( ! defined( 'WPINC' ) ) { die; }

/**
 * DLN_Job_Admin class.
 */
class DLN_Helpers {
	
	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
		
	}
	
	public static function curl_get_contents( $url ) {
		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $curl, CURLOPT_URL, $url );
		curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );
	
		$html = curl_exec( $curl );
	
		curl_close( $curl );
	
		return $html;
	}
}
new DLN_Helpers();