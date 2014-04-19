<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Source_Kenh14 extends DLN_Source {
	
	public static $instance;
	public $source_type = 'kenh14';
	public $rss_url     = 'http://kenh14.vn/home.rss';
	public $regex       = '/-(\d+).chn/';
	
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