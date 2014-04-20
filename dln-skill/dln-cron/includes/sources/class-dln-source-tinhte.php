<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Source_TinhTe extends DLN_Source {
	
	public static $instance;
	public $source_type = 'tinh-te';
	public $rss_url     = 'http://www.tinhte.vn/rss/';
	public $regex       = '/.([0-9]+)\//';
	
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