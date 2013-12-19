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
if ( ! defined( 'WPINC' ) ) { die; }

if ( ! defined( 'DLN_LIKE_SLUG' ) ) {
	define( 'DLN_LIKE_SLUG', 'dln-like-manager' );
}
if ( ! defined( 'DLN_LIKE_PLUGIN_DIR' ) ) {
	define( 'DLN_LIKE_PLUGIN_DIR', trailingslashit( WP_PLUGIN_DIR . '/dln-like-manager' ) );
}
if( ! defined( 'DLN_LIKE_PLUGIN_URL' ) ) {
	define( 'DLN_LIKE_PLUGIN_URL', plugins_url() . '/' . basename( dirname( __FILE__ ) ) );
}
if( ! defined( 'DLN_LIKE_PATH' ) ) {
	define( 'DLN_LIKE_PATH', dirname( __FILE__ ) );
}
if( ! defined( 'Class_PATH' ) ) {
	define( 'Class_PATH', DLN_LIKE_PATH . DIRECTORY_SEPARATOR . 'classes' );
}

// require includes files
$files = glob( plugin_dir_path( __FILE__ ) . 'includes/*.php' );
foreach ( $files as $file ) {
    require( $file );
}
// Setting autoload
function dln_like_autoload( $class_name )
{
	if ( strpos( $class_name, 'DLN_Class' ) === false )
		return;
	// Convert class name to filename format.
	$class_name = strtr( strtolower( $class_name ), '_', '-' );
	$class_name = str_replace( 'dln-class-', '', $class_name );
	$paths = array(
		Class_PATH,
	);

	// Search each path for the class.
	foreach( $paths as $path ) {
		if( file_exists( "$path/class-$class_name.php" ) )
			require_once( "$path/class-$class_name.php" );
	}
}
spl_autoload_register( 'dln_like_autoload' );

// require plugin files
require_once( plugin_dir_path( __FILE__ ) . 'public/class-dln-like-manager.php' );
// register hooks that are fired when the plugin is activated or deactivated.
register_activation_hook( __FILE__, array( 'DLN_Like_Manager', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'DLN_Like_Manager', 'deactivate' ) );
// initialize action for frontend
add_action( 'init', array( 'DLN_Like_Manager', 'get_instance' ) );
// initialize action for backend
if ( is_admin() && ( !defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-dln-like-manager-admin.php' );
	add_action( 'init', array( 'DLN_Like_Manager_Admin', 'get_instance' ) );
}
// initialize action for ajax
add_action( 'init', array( 'DLN_Like_Ajax', 'get_instance' ) );
?>