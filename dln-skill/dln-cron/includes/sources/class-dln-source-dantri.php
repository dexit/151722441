<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Source_Dantri extends DLN_Source {
	
	public static $instance;
	public $source_type = 'dan-tri';
	public $rss_url     = 'http://dantri.com.vn/trangchu.rss';
	public $regex       = '/-(\d+).htm/';
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		parent::__construct();
	}

}