<?php
/**
 * @package   DLN_Like_Manager_Helpers
 * @author    DinhLN <lenhatdinh@gmail.com>
 * @license   GPL-2.0+
 * @link      http://www.facebook.com/lenhatdinh
 * @copyright 2013 by DinhLN
 */

/**
 * Facebook functions helpers.
 *
 * @package   DLN_Facebook_Helpers
 * @author    dinhln <lenhatdinh@gmail.com> - i - 10:43:24 AM
 */
class DLN_Facebook_Helpers {

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
	public function get_instance() {
	
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
		
	}

}
