<?php
/*
Plugin Name: DLN Classified
Plugin URI: http://www.osclass.org/
Description: This plugin shows a Google Map on the location space of every item.
Version: 2.1.6
Author: Osclass & kingsult
Author URI: http://www.osclass.org/
Plugin update URI: http://www.osclass.org/files/plugins/google_maps/update.php
*/

if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');

class DLN_Classified {
	
	private static $instance;
	
	public function new_instance() {
		if( !self::$instance instanceof self ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	
	public function __construct() {
		$this->define_constant();
		$this->actions();
	}
	
	public function define_constant() {
		// Define constants
		define( 'DLN_CLF_VERSION', '1.0.0' );
		define( 'DLN_CLF', 'dln-classified' );
		define( 'DLN_CLF_PLUGIN_DIR', osc_plugins_path() . DLN_CLF . '/' );
		
		//define( 'FB_APP_ID', get_option( 'dln_fb_app_id' ) ? get_option( 'dln_fb_app_id' ) : '251847918233636' );
		//define( 'FB_SECRET', get_option( 'dln_fb_secret' ) ? get_option( 'dln_fb_secret' ) : '31f3e2be38cd9a9e6e0a399c40ef18cd' );
	}

	public function actions() {
		// Add google map drag n drop
		$helper_google = $this->get_helper( 'DLN_Helper_Google' );
		osc_add_hook( 'edited_post', array( $helper_google, 'insert_google_map' ) );
		osc_add_hook( 'posted_item', array( $helper_google, 'insert_google_map' ) );
		
	}
	
	public static function get_controller( $c_name = '' ) {
		if ( ! $c_name ) return false;
		
		$c_name_lower = self::slug_class( $c_name );
		
		if ( file_exists( DLN_CLF_PLUGIN_DIR . "controllers/{$c_name_lower}.php" ) )
			include_once( DLN_CLF_PLUGIN_DIR . "controllers/{$c_name_lower}.php" );
		
		return $c_name::get_instance();
	}
	
	public static function get_helper( $h_name = '' ) {
		if ( ! $h_name ) return false;
		
		$h_name_lower = self::slug_class( $h_name );
		
		if ( file_exists( DLN_CLF_PLUGIN_DIR . "helpers/{$h_name_lower}.php" ) )
			include_once( DLN_CLF_PLUGIN_DIR . "helpers/{$h_name_lower}.php" );
		
		return $h_name::get_instance();
	}
	
	private static function slug_class( $name = '' ) {
		if ( ! $name ) return false;
		
		$name_slug = strtolower( $name );
		$name_slug = str_replace( 'dln', '', $name_slug );
		$name_slug = str_replace( '_', '-', $name_slug );
		
		return $name_slug;
	}
	
	public function requires() {
		$this->required_components = osc_apply_filters( 'dln_required_components', array( 'map' ) );

		// Loop through required components
		foreach ( $this->required_components as $component ) {
			if ( file_exists( DLN_CLF_PLUGIN_DIR . '/' . $component . '/' . $component . '-loader.php' ) )
				include( DLN_CLF_PLUGIN_DIR . '/' . $component . '/' . $component . '-loader.php' );
		}
	}

	public static function install() {
		//DLN_Cron_Loader::activate();
		//DLN_Upload_Loader::activate();
	}

}

DLN_Classified::new_instance();