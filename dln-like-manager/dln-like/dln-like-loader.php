<?php
/**
 * @version    $Id$
 * @package    ITPGBLDR
 * @author     InnoThemes Team <support@innothemes.com>
 * @copyright  Copyright (C) 2012 InnoThemes.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.innothemes.com
 * Technical Support: Feedback - http://www.innothemes.com/contact-us/get-support.html
 */
 
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

class DLN_Like_Component {
	
	private static $instance;
	
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new DLN_Like_Component;
		}
		return $self::$instance;
	}
	
	public function __construct() {
		$this->includes();
	}
	
	public function includes() {
		$slashed_path = trailingslashit( DLN_LIKE_PLUGIN_DIR );
		// Loop through files to be included
		$helpers      = glob( DLN_LIKE_PLUGIN_DIR . 'dln-like/views/*.php' );
		$views        = glob( DLN_LIKE_PLUGIN_DIR . 'dln-like/views/*.php' );
		$controllers  = glob( DLN_LIKE_PLUGIN_DIR . 'dln-like/controllers/*.php' );
		$models       = glob( DLN_LIKE_PLUGIN_DIR . 'dln-like/models/*.php' );
		// merge
		$paths        = array_merge( $views, $controllers, $models );
		
		foreach ( $paths as $path ) {
			if ( @is_file( $path ) ) {
				require( $path );
				continue;
			}
		}
		// Listing files included and memory usage
		ini_set('xdebug.var_display_max_children', 1000);
		function convert($size)
		{
			$unit=array('b','kb','mb','gb','tb','pb');
			return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
		}
		var_dump(get_included_files());
		var_dump(convert(memory_get_usage(true)));die();
	}
	
}

function dln_setup_like() {
	global $dln_like_mananger;
	
	$dln_like_mananger->like = DLN_Like_Component::get_instance();
}
dln_setup_like();