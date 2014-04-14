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
	}
	
	public function crawl_process() {
		
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
	
	public function load_source( $source_name = '' ) {
		if ( ! $source_name )
			return;
		$source = $this->crawl_process( $source_name );
		var_dump($source_name);die(123);
		return $source;
		//if ( $source = $this->crawl_process( $form_name ) ) {
			//ob_start();
			//call_user_func( array( $source, 'output' ) );
			//return ob_get_clean();
		//}
	}
	
}

DLN_Cron_Sources::get_instance();