<?php

if ( ! defined( 'WPINC' ) ) { die; }
 
class DLN_Connections {
	
	public $plugin_path;
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		$this->plugin_path = plugin_dir_path(__FILE__);
		$this->includes();
	}
	
	public function includes() {
		require_once( $this->plugin_path . 'facebook/class-facebook.php');
	}
}

DLN_Connections::get_instance();