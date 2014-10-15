<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Source_BachayBochet extends DLN_Source_Abstract {
	
	public static $instance;
	protected $sel_listing = array(
		'.pin-container div.title a',
	);
	protected $arr_prevent = array(
		'#',
		'javascript:void(0)',
	);
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {}
	
}

DLN_Source_BachayBochet::get_instance();