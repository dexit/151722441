<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Source_24H extends DLN_Source {
	
	public static $instance;
	public $source_type = '24h';
	public $rss_url     = 'http://www.24h.com.vn/upload/rss/tintuctrongngay.rss';
	public $regex       = '/-([a-z0-9]+).html/';
	
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