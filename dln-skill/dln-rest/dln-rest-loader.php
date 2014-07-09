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
		//include( 'includes/class-dln-json-checkpoint.php' );
		include( 'includes/slowaes/class-dln-helper-decrypt.php' );
		include( 'includes/class-dln-json-fbusers.php' );
		include( 'includes/class-dln-json-post.php' );
		include( 'includes/class-dln-json-user.php' );
		
		add_action( 'wp_json_server_before_serve', array( $this, 'json_api_filters' ) );
		add_action( 'init', array( $this, 'dln_flush_rewrites' ), 1000 );
	}
	
	function dln_flush_rewrites() {
		flush_rewrite_rules();
	}
	
	public function json_api_filters( $server ) {
		// Check Points
		//$dln_check_point = new DLN_JSON_CheckPoint( $server );
		//add_filter( 'json_endpoints', array( $dln_check_point, 'register_routes' ) );
		
		// FB Users
		$dln_json_fbusers = new DLN_JSON_FBUsers( $server );
		add_filter( 'json_endpoints', array( $dln_json_fbusers, 'register_routes' ) );
		
		// Phrases
		$dln_json_post = new DLN_JSON_Post( $server );
		add_filter( 'json_endpoints', array( $dln_json_post, 'register_routes' ) );
		
		// User 
		$dln_json_user = new DLN_JSON_User( $server );
		add_filter( 'json_endpoints', array( $dln_json_user, 'register_routes' ) );
	}
	
}

$GLOBALS['dln_rest'] = DLN_Rest_Loader::get_instance();