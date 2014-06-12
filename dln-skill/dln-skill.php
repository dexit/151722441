<?php
/*
Plugin Name: DLN Skill
Plugin URI: http://www.facebook.com/lenhatdinh
Description: Like Management for fb, pinterest or youtube...
Version: 1.0.0
Author: Dinh Le Nhat
Author URI: http://www.facebook.com/lenhatdinh
License: GPL2
 */

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Skill {
	
	public function __construct() {
		// Define constants
		define( 'DLN_SKILL_VERSION', '1.0.0' );
		define( 'DLN_SKILL', 'dln-skill' );
		define( 'DLN_SKILL_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
		define( 'DLN_SKILL_PLUGIN_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );
		define( 'FB_APP_ID', get_option( 'dln_fb_app_id' ) ? get_option( 'dln_fb_app_id' ) : '251847918233636' );
		define( 'FB_SECRET', get_option( 'dln_fb_secret' ) ? get_option( 'dln_fb_secret' ) : '31f3e2be38cd9a9e6e0a399c40ef18cd' );
		
		$this->requires();
		
		register_activation_hook( __FILE__, array( $this, 'install' ) );
	}
	
	public function requires() {
		//$this->required_components = apply_filters( 'dln_required_components', array( 'connections', 'cron' ) );
		$this->required_components = apply_filters( 'dln_required_components', array( 'oauth', 'restful' ) );
		
		// Loop through required components
		foreach( $this->required_components as $component ) {
			if ( file_exists( DLN_SKILL_PLUGIN_DIR . '/dln-' . $component . '/dln-' . $component . '-loader.php' ) )
				include( DLN_SKILL_PLUGIN_DIR . '/dln-' . $component . '/dln-' . $component . '-loader.php' );
		}
	}
	
	public static function install() {
		//DLN_Cron_Loader::activate();
	}
	
}

$GLOBALS['dln_skill'] = new DLN_Skill();
