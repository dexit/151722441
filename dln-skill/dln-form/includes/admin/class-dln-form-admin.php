<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Form_Admin {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		include_once( 'class-dln-form-admin-post-type.php' );
	}
	
}

DLN_Form_Admin::get_instance();