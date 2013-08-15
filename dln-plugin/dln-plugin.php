<?php
/*
  Plugin Name: DLN Plugin
  Plugin URI: http://www.facebook.com/lenhatdinh
  Description: DLN Plugin Description
  Version: 1.0
  Author: DinhLN
  Author URI: http://www.facebook.com/lenhatdinh
  License: GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) exit;

global $dln_db_version;
$dln_db_version = '1.0';


if ( ! class_exists( 'DLNPlugin' ) )
{
	class DLNPlugin
	{
		private static $instance;
		
		public static function instance()
		{
			if ( ! isset( self::$instance ) )
			{
				self::$instance = new BuddyPress;
				self::$instance->constants();
				self::$instance->includes();
			}
			return self::$instance;
		}
		
		private function __construct() { /* Do nothing here */ }
		
		private function constants()
		{
			if ( ! defined( 'BP_PLUGIN_DIR' ) )
			{
				define( 'DLN_PLUGIN_DIR', trailingslashit( WP_PLUGIN_DIR . '/dln-plugin/' ) );
			}
		}
		
		private function includes()
		{
			// Load core files
			require( DLN_PLUGIN_DIR . 'dln-core/dln-notifications.php' );
			
		}
	}
}