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

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

global $dln_db_version;
$dln_db_version = '1.0.0';

if ( ! class_exists( 'DLNPlugin' ) )
{
	class DLNPlugin
	{
		private static $instance;
		public $table_prefix;
		public $core;
		
		public static function instance()
		{
			if ( ! isset( self::$instance ) )
			{
				self::$instance = new DLNPlugin;
				self::$instance->constants();
				self::$instance->includes();
				self::$instance->setup_globals();
			}
			return self::$instance;
		}
		
		private function __construct() { /* Do nothing here */ }
		
		private function constants()
		{
			if ( ! defined( 'DLN_PLUGIN_DIR' ) )
			{
				define( 'DLN_PLUGIN_DIR', trailingslashit( WP_PLUGIN_DIR . '/dln-plugin/' ) );
			}
		}
		
		private function includes()
		{
			// Load core files
			require( DLN_PLUGIN_DIR . 'dln-core/dln-core-functions.php' );
			require( DLN_PLUGIN_DIR . 'dln-core/dln-core-schema.php' );
			require( DLN_PLUGIN_DIR . 'dln-core/dln-core-notification.php' );
		}
		
		private function setup_globals()
		{
			if ( empty( $this->table_prefix ) )
				$this->table_prefix = dln_core_get_table_prefix();
			
			// Notifications Table
			$this->core = new stdClass;
			$this->core->table_name_notifications = $this->table_prefix . 'dln_notifications';
		}
	}
}

$dln_plugin = DLNPlugin::instance();
