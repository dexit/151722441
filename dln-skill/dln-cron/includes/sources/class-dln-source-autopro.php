<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Source_AutoPro extends DLN_Source {
	
	public static $instance;
	public $source_type = 'autopro';
	public $rss_url     = 'http://autopro.com.vn/home.rss';
	public $regex       = '/-([0-9]+).chn/';
	
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