<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Source_ZingNews extends DLN_Source {
	
	public static $instance;
	public $source_type = 'zing-news';
	public $rss_url     = 'http://news.zing.vn/rss/tin-moi.rss';
	public $regex       = '/-post([0-9]+).html/';
	
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