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
	
	function __construct() {
		$this->includes();
	}
	
	public function includes() {
		require_once( $this->plugin_dir . 'dln-like/dln-like-helper.php' );
		require_once( $this->plugin_dir . 'dln-like/dln-like-view.php' );
		require_once( $this->plugin_dir . 'dln-like/dln-like-controller.php' );
	}
	
}

function dln_setup_like() {
	global $dln_like_mananger;
	
	$dln_like_mananger->like = DLN_Like_Component::get_instance();
}