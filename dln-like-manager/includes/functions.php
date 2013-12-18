<?php
/**
 * @package   DLN_Like_Manager_Helpers
 * @author    DinhLN <lenhatdinh@gmail.com>
 * @license   GPL-2.0+
 * @link      http://www.facebook.com/lenhatdinh
 * @copyright 2013 by DinhLN
 */

/**
 * All functions helpers using for backend and frontend..
 *
 * @package   DLN_Like_Helpers
 * @author    dinhln <lenhatdinh@gmail.com> - i - 10:33:45 AM
 */
class DLN_Like_Helpers {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      protected
	 */
	protected static $instance = null;
	
	/**
	 * Return an instance of this class.
	 * 
	 * @since    1.0.0
	 * 
	 * @return   object
	 */
	public function get_instance() {
	
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		
		return self::$instance;
	}
	
	/**
	 * Initialize the plugin by setting localization and loading public scripts.
	 * 
	 * @since 	 1.0.0
	 * 
	 * @return   void
	 */
	private function __construct() {
		
	}

	/**
	 * function get content using CURL.
	 * 
	 * @since    1.0.0
	 * 
	 * @return   string
	 */
	public static function curl_get_contents( $url = '' ) {
	
		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $curl, CURLOPT_URL, $url );
		curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );
		$html = curl_exec( $curl );
		curl_close( $curl );
		return $html;
		
	}

	/**
	 * Function generate signature SHA256.
	 * 
	 * @since    1.0.0
	 * 
	 * @return   string
	 */
	public static function generate_signature( $data ) {
		return hash( 'SHA256', AUTH_KEY . $data );
	}
	
	/**
	 * Function verify signature.
	 * 
	 * @since    1.0.0
	 * 
	 * @return   void
	 */
	public static function verify_signature( $data, $signature, $redirect_to ) {
		$generated_signature = self::generate_signature( $data );
		
		if ( $generated_signature != $signature ) {
			wp_safe_redirect( $redirect_to );
			exit();
		}
	}
	
	/**
	 * Function get user metadata.
	 * 
	 * @since    1.0.0
	 * 
	 * @return   string
	 */
	public static function get_user_by_meta( $meta_key, $meta_value ) {
		global $wpdb;
		
		$sql = "SELECT user_id FROM $wpdb->usermeta WHERE meta_key = '%s' AND meta_value = '%s'";
		return $wpdb->get_var( $wpdb->prepare( $sql, $meta_key, $meta_value ) );
	}
	
}
