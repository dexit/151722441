<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Source_LaoDong extends DLN_Source {
	
	public static $instance;
	public $source_type = 'lao-dong';
	public $rss_url     = 'http://laodong.com.vn/rss/home.rss';
	public $regex       = '/-([0-9]+).bld/';
	
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