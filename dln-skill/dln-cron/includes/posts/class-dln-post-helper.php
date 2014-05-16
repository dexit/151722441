<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Post_Helper {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {  }
	
	public static function get_post_link( $amount = 50 ) {
		if ( ! $amount ) return;
		
		global $wpdb;
		$sql = "SELECT ";
	}
	
}

DLN_Post_Helper::get_instance();