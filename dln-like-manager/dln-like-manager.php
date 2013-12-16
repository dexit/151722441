<?php
/*
Plugin Name: DLN Like Manager
Plugin URI: http://www.facebook.com/lenhatdinh
Description: Like Management for fb, pinterest or youtube...
Version: 0.1
Author: Dinh Le Nhat
Author URI: http://www.facebook.com/lenhatdinh
License: GPL2
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// require plugin files
require_once( plugin_dir_path( __FILE__ ) . 'public/class-dln-like-manager.php' );

// register hooks that are fired when the plugin is activated or deactivated.
register_activation_hook( __FILE__, array( 'DLN_Like_Manager', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'DLN_Like_Manager', 'deactivate' ) );

add_action( 'plugin_loaded', array( 'DLN_Like_Manager', 'get_instance' ) );

if ( is_admin() && ( !defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
	
	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-dln-like-manager-admin.php' );
	add_action( 'plugin_loaded', array( 'DLN_Like_Manager_Admin', 'get_instance' ) );
	
}

// if ( ! class_exists( 'DLNLikeManager' ) ) {

// class DLN_Like_Manager {
	
// 	/**
// 	 * @var string
// 	 */
// 	public $version = '0.1';
	
// 	/**
// 	 * @var string
// 	 */
// 	public $plugin_dir;
	
// 	/**
// 	 * @var string
// 	 */
// 	public $plugin_url;
	
// 	/**
// 	 * @var object
// 	 */
// 	private static $instance;
	
// 	/**
// 	 * DLN Like Manager Constructor
// 	 * 
// 	 * @access public
// 	 * @return void
// 	 */
// 	public function __construct() {
// 		// Installation
// 		//register_activation_hook( __FILE__, array( $this, 'activate' ) );
// 	}
	
// 	public static function instance() {
// 		if ( ! isset( self::$instance ) ) {
// 			self::$instance = new DLN_Like_Manager;
// 			self::$instance->constants();
// 			self::$instance->setup_globals();
// 			self::$instance->includes();
// 		}
// 		return self::$instance;
// 	}
	
// 	/**
// 	 * Constant function
// 	 * 
// 	 * @access private
// 	 * @return void
// 	 */
// 	private function constants() {
// 		// Define version constant
// 		if ( ! defined( 'DLN_LIKE_VERSION' ) ) {
// 			define( 'DLN_LIKE_VERSION', $this->version );
// 		}
// 		// Path and URL
// 		if ( ! defined( 'DLN_LIKE_PLUGIN_DIR' ) ) {
// 			define( 'DLN_LIKE_PLUGIN_DIR', trailingslashit( WP_PLUGIN_DIR . '/dln-like-manager' ) );
// 		}
// 		if ( ! defined( 'DLN_LIKE_PLUGIN_URL' ) ) {
// 			$plugin_url = plugin_dir_url( __FILE__ );
// 			if ( is_ssl() )
// 				$plugin_url = str_replace( 'http://', 'https://', $plugin_url );
// 			define( 'DLN_LIKE_PLUGIN_URL', $plugin_url );
// 		}
// 	}
	
// 	/**
// 	 * Component global variables
// 	 *
// 	 * @access private
// 	 * @return void
// 	 */
// 	private function setup_globals() {
// 		// BuddyPress root directory
// 		$this->file           = __FILE__;
// 		$this->basename       = plugin_basename( $this->file );
// 		$this->plugin_dir     = DLN_LIKE_PLUGIN_DIR;
// 		$this->plugin_url     = DLN_LIKE_PLUGIN_URL;
// 	}
	
// 	/**
// 	 * Include required files
// 	 * 
// 	 * @access private
// 	 * @return void
// 	 */
// 	private function includes() {
// 		require( $this->plugin_dir . 'dln-like/dln-like-loader.php' );
// 	}
	
// }

// function dln_like_mananger() {
// 	return DLN_Like_Manager::instance();
// }

// $GLOBALS['dln_like_mananger'] = dln_like_mananger();

// }
?>