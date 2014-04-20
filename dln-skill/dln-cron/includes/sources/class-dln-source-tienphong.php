<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Source_TienPhong extends DLN_Source {

	public static $instance;
	public $source_type = 'tien-phong';
	public $rss_url     = 'http://www.tienphong.vn/rss/home.rss';
	public $regex       = '/-([0-9]+).tpo/';
	public $type_crawl  = 'rss';

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