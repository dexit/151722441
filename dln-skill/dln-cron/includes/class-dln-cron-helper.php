<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Cron_Helper {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	public static function generate_hash( $url = '' ) {
		if ( ! $url )
			return '';
		$arr_url = parse_url( $url );
		$hash    = md5( $arr_url['host'] . '|' . $arr_url['path'] );
	
		return $hash;
	}
	
	function __construct() { }
}

DLN_Cron_Helper::get_instance();