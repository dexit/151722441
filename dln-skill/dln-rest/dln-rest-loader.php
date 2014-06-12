<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Rest_Loader {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		include( 'includes/class-dln-json-fbusers.php' );
		add_action( 'wp_json_server_before_serve', array( $this, 'json_api_filters' ) );
	}
	
	public function json_api_filters( $server ) {
		// FB Users
		$dln_json_fbusers = new DLN_JSON_FBUsers( $server );
		add_filter( 'json_endpoints', array( $dln_json_fbusers, 'register_routes' ) );
	}
	
}

$GLOBALS['dln_rest'] = DLN_Rest_Loader::get_instance();