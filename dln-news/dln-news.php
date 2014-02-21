<?php
/*
Plugin Name: DLN News
Plugin URI: http://www.facebook.com/lenhatdinh
Description: Like Management for fb, pinterest or youtube...
Version: 0.1
Author: Dinh Le Nhat
Author URI: http://www.facebook.com/lenhatdinh
License: GPL2
 */

if ( ! defined( 'WPINC' ) ) { die; }

define( 'DLN_NEWS_SLUG', 'dln-news' );
define( 'DLN_NEWS_PLUGIN_DIR', trailingslashit( WP_PLUGIN_DIR . '/dln-news' ) );
define( 'DLN_NEWS_PLUGIN_URL', plugins_url() . '/' . basename( dirname( __FILE__ ) ) );
define( 'DLN_NEWS_PATH', dirname( __FILE__ ) );
define( 'DLN_NEWS_CLASS_PATH', DLN_NEWS_PATH . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'classes' );

function dln_news_autoload( $class_name = '' ) {
	if ( strpos( $class_name, 'DLN_News' ) === false )
		return;
	// Convert class name to filename format.
	$class_name = strtr( strtolower( $class_name ), '_', '-' );
	$class_name = str_replace( 'dln-news-', '', $class_name );
	$paths = array(
		DLN_NEWS_CLASS_PATH,
	);
	
	// Search each path for the class.
	foreach( $paths as $path ) {
		if( file_exists( "$path/class-$class_name.php" ) )
			require( "$path/class-$class_name.php" );
	}
}
spl_autoload_register( 'dln_news_autoload' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-dln-news.php' );
// register hooks that are fired when the plugin is activated or deactivated.
register_activation_hook( __FILE__, array( 'DLN_News', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'DLN_News', 'deactivate' ) );
