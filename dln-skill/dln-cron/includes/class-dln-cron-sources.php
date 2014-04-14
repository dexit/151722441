<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Cron_Sources {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		add_action( 'init', array( $this, 'crawl_process' ) );
	}
	
	public function crawl_process() {
		if ( ! isset( $_GET['dln_crawl_news'] ) || ! isset( $_GET['dln_crawl_source'] ) )
			return;

		if ( ! ( $crawl_source = $_GET['dln_crawl_source'] ) ) 
			return;
		
		if ( ! class_exists( 'DLN_Source' ) ) 
			include( 'abstracts/abstract-dln-source.php' );
		
		$source_class = 'DLN_Source_' . str_replace( '-', '_', $crawl_source );
		$source_file  = DLN_SKILL_PLUGIN_DIR . '/dln-cron/includes/sources/class-dln-source-' . $crawl_source . '.php';
		
		if ( class_exists( $source_class ) )
			return $form_class;
		
		if ( ! file_exists( $source_file ) )
			return false;
		
		if ( ! class_exists( $source_class ) )
			include $source_file;
		
		// Init the form
		call_user_func( array( $source_class, "init" ) );
		
		return $source_class;
	}
	
}

DLN_Cron_Sources::get_instance();