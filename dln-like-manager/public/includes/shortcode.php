<?php
/**
 * @package   DLN_Like_Manager
 * @author    DinhLN <lenhatdinh@gmail.com>
 * @license   GPL-2.0+
 * @link      http://www.facebook.com/lenhatdinh
 * @copyright 2013 by DinhLN
 */

/**
 * DLN Shortcode.
 *
 * @package   DLN_Like_Shortcode
 * @author    dinhln <lenhatdinh@gmail.com> - i - 11:06:11 AM
 */
class DLN_Like_Shortcode {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      protected
	 */
	protected static $instance = null;
	
	/**
	 * Return an instance of this class.
	 * 
	 * @since    1.0.0
	 * 
	 * @return   object
	 */
	public static function get_instance() {
	
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		
		return self::$instance;
	}
	
   /**
	 * Initialize the plugin by setting localization and loading public scripts.
	 * 
	 * @since 	 1.0.0
	 * 
	 * @return   void
	 */
	private function __construct() {
		add_shortcode( 'dln_fb_login', array( $this, 'dln_fb_login' ) );
	}
	
	/**
	 * Shortcode Facebook Login Form.
	 * 
	 * @since    1.0.0
	 * 
	 * @return   string
	 */
	public function dln_fb_login( $atts, $content = NULL ) {
	
		return '123456';
		
	}
	
}
