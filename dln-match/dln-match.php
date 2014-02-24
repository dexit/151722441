<?php
/*
Plugin Name: DLN Match
Plugin URI: http://www.facebook.com/lenhatdinh
Description: Like Management for fb, pinterest or youtube...
Version: 0.1
Author: Dinh Le Nhat
Author URI: http://www.facebook.com/lenhatdinh
License: GPL2
 */

if ( ! defined( 'WPINC' ) ) { die; }

define( 'DLN_MATCH_SLUG', 'dln-match' );
define( 'DLN_MATCH_PLUGIN_DIR', trailingslashit( WP_PLUGIN_DIR . '/dln-match' ) );
define( 'DLN_MATCH_PLUGIN_URL', plugins_url() . '/' . basename( dirname( __FILE__ ) ) );
define( 'DLN_MATCH_PATH', dirname( __FILE__ ) );
define( 'DLN_MATCH_CLASS_PATH', DLN_MATCH_PATH . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'classes' );
define( 'DLN_VERSION', '1.0.0' );

function dln_match_autoload( $class_name = '' ) {
	if ( strpos( $class_name, 'DLN_Match' ) === false )
		return;
	// Convert class name to filename format.
	$class_name = strtr( strtolower( $class_name ), '_', '-' );
	$class_name = str_replace( 'dln-match-', '', $class_name );
	$paths = array(
		DLN_MATCH_CLASS_PATH,
	);
	
	// Search each path for the class.
	foreach( $paths as $path ) {
		if( file_exists( "$path/class-$class_name.php" ) )
			require( "$path/class-$class_name.php" );
	}
}
spl_autoload_register( 'dln_match_autoload' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-dln-match.php' );

$_dln_match_comment = DLN_Match_Comment::get_instance();

// register hooks that are fired when the plugin is activated or deactivated.
register_activation_hook( __FILE__, array( 'DLN_Match', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'DLN_Match', 'deactivate' ) );

