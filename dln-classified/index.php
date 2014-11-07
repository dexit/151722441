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
	
	public static function get_instance() {
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

	public static function install() {
		$user_premium = self::get_models( 'DLN_Model_User_Premium' );
		$user_premium->import( 'dln-classified/sql/dln_user_premium.sql' );
	}

	public function actions() {
		osc_register_plugin(osc_plugin_path(__FILE__), array( 'DLN_Classified', 'install' ) );
		// Add admin menu
		//$helper_premium = $this->get_helper( 'DLN_Helper_Premium' );
		//osc_add_hook('admin_menu_init', array( $helper_premium, 'init_admin_menu' ) );
		
		// Add google map drag n drop
		$helper_google = $this->get_helper( 'DLN_Helper_Google' );
		osc_add_hook( 'user_form',           array( $helper_google, 'load_google_map' ) );
		osc_add_hook( 'user_edit_completed', array( $helper_google, 'insert_google_map' ) );
		
		// For users premium
		$helper_premium = $this->get_helper( 'DLN_Helper_Premium' );
		osc_add_hook( 'admin_users_table', array( $helper_premium, 'admin_users_table' ) );
		osc_add_filter( 'users_processing_row', array( $helper_premium, 'users_processing_row' ) );
		osc_add_hook( 'after_admin_html', array( $helper_premium, 'users_html_modal' ) );
	}
	
	public static function get_controller( $c_name = '' ) {
		if ( ! $c_name ) return false;
		
		$c_name_lower = self::slug_class( $c_name );
		
		if ( file_exists( DLN_CLF_PLUGIN_DIR . "controllers/{$c_name_lower}.php" ) )
			require( DLN_CLF_PLUGIN_DIR . "controllers/{$c_name_lower}.php" );
		
		return $c_name::get_instance();
	}
	
	public static function get_helper( $h_name = '' ) {
		if ( ! $h_name ) return false;
		
		$h_name_lower = self::slug_class( $h_name );
		
		if ( file_exists( DLN_CLF_PLUGIN_DIR . "helpers/{$h_name_lower}.php" ) )
			require( DLN_CLF_PLUGIN_DIR . "helpers/{$h_name_lower}.php" );
		
		return $h_name::get_instance();
	}
	
	public static function get_view( $v_name = '' ) {
		if ( ! $v_name ) return false;
		
		$v_name_lower = self::slug_class( $v_name );
		
		if ( file_exists( DLN_CLF_PLUGIN_DIR . "views/{$v_name_lower}.php" ) )
			require( DLN_CLF_PLUGIN_DIR . "views/{$v_name_lower}.php" );
	}
	
	public static function get_models( $m_name = '' ) {
		if ( ! $m_name ) return false;
		
		$m_name_lower = self::slug_class( $m_name );
		
		if ( file_exists( DLN_CLF_PLUGIN_DIR . "models/{$m_name_lower}.php" ) )
			require( DLN_CLF_PLUGIN_DIR . "models/{$m_name_lower}.php" );
		
		return $m_name::get_instance();
	}
	
	private static function slug_class( $name = '' ) {
		if ( ! $name ) return false;
		
		$name_slug = strtolower( $name );
		$name_slug = str_replace( '_', '-', $name_slug );
		$name_slug = str_replace( 'dln-', '', $name_slug );
		
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

}

DLN_Classified::get_instance();