<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Source_VietnamNet extends DLN_Source {
	
	public static $instance;
	public $source_type = 'viet-nam-net';
	public $rss_url     = 'http://vietnamnet.vn/rss/home.rss';
	public $regex       = '/\/(\d+)\/[a-z0-9-]+.html/';
	
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