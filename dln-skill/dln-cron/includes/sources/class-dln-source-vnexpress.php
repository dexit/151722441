<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Source_VNExpress extends DLN_Source {

	public static $instance;
	public $source_type = 'vnexpress';
	public $rss_url     = 'http://vnexpress.net/rss/tin-moi-nhat.rss';
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