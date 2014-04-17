<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Source_Baomoi extends DLN_Source {
	
	public static $instance;
	public $source_type = 'bao-moi';
	public $rss_url     = 'http://www.baomoi.com/Rss/RssFeed.ashx';
	public $regex       = '/\/(\d+).epi/';
	
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