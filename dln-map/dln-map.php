<?php
/*
Plugin Name: DLN Map
Plugin URI: http://www.facebook.com/lenhatdinh
Description: Manage job listings from the WordPress admin panel, and allow users to post jobs directly to your site.
Version: 1.0.0
Author: Dinh Le Nhat
Author URI: http://www.facebook.com/lenhatdinh
Requires at least: 3.5
Tested up to: 3.5

	Copyright: 2013 Mike Jolley
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

// Exit if access directly
if ( ! defined( 'ABSPATH' ) )
	exit;

/**
 * DLN_Map class
 */
class DLN_Map {
	
	/**
	 * __construct function.
	 */
	public function __construct() {
		// Define constants
		define( 'DLN_MAP_VERSION', '1.0.0' );
		define( 'DLN_MAP_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
		define( 'DLN_MAP_PLUGIN_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );
		
		// Include
		include( 'dln-map-functions.php' );
		
		// Actions
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );
	}
	
	/**
	 * frontend_scripts function.
	 *
	 * @access public
	 * @return void
	 */
	public function frontend_scripts() {
		wp_enqueue_script( 'dln-map-libs-js', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places', null, DLN_MAP_VERSION, false);
		wp_enqueue_script( 'dln-map-js', DLN_MAP_PLUGIN_URL . '/assets/js/dln-map.js', array('dln-map-libs-js'), DLN_MAP_VERSION, false);
		wp_enqueue_style( 'dln-map-css', DLN_MAP_PLUGIN_URL . '/assets/css/dln-map.css' );
	}
	
}

$dln_map = new DLN_Map();
