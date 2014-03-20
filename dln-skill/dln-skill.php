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
		define( 'DLN_SKILL', 'dln-job' );
		define( 'DLN_SKILL_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
		define( 'DLN_SKILL_PLUGIN_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );
		
		$this->requires();
	}
	
	public function requires() {
		$this->required_components = apply_filters( 'dln_required_components', array( 'connections', 'form' ) );
		
		// Loop through required components
		foreach( $this->required_components as $component ) {
			if ( file_exists( DLN_SKILL_PLUGIN_DIR . '/dln-' . $component . '/dln-' . $component . '-loader.php' ) )
				include( DLN_SKILL_PLUGIN_DIR . '/dln-' . $component . '/dln-' . $component . '-loader.php' );
		}
		
	}
	
}

$GLOBALS['dln_skill'] = new DLN_Skill();