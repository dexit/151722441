<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Helper_Hire {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {  }
	
	public static function get_hire_type() {
		return array(
			'basic',
			'silver',
			'gold',
		);
	}
	
	public static function get_hire_days() {
		return array(
			'7'  => __( 'a week', DLN_ABE ),
			'30' => __( 'a month', DLN_ABE )
		);
	}
}

DLN_Helper_Hire::get_instance();