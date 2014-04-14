<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Cron_Shortcodes {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	public function __construct() {
		add_shortcode( 'crawl_dantri', array( $this, 'crawl_dantri' ) );
	}
	
	public function crawl_dantri() {
		$cron_source = DLN_Cron_Sources::get_instance();
		$cron_source->load_source( 'dantri' );
		//$_GET['dln_crawl_news'] = 1;
		//$_GET['dln_crawl_source'] = 'dantri';
	}
	
}

DLN_Cron_Shortcodes::get_instance();