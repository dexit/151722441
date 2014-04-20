<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Source_NguoiDuaTin extends DLN_Source {
	
	public static $instance;
	public $source_type = 'nguoi-dua-tin';
	public $rss_url     = 'http://www.nguoiduatin.vn/trang-chu.rss';
	public $regex       = '/-a([0-9]+).html/';
	
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