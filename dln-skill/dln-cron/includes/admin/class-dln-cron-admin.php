<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Cron_Admin {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		
	}
	
}

DLN_Cron_Admin::get_instance();
