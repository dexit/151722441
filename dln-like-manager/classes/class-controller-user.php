<?php
/**
 * @package   DLN_Like_Controller_User
 * @author    DinhLN <lenhatdinh@gmail.com>
 * @license   GPL-2.0+
 * @link      http://www.facebook.com/lenhatdinh
 * @copyright 2013 by DinhLN
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Controller class of User.
 *
 * @package   DLN_Class_Controller_User
 * @author    admin <lenhatdinh@gmail.com> - i - 21:40:58
 */
class DLN_Class_Controller_User {

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
		
	}
	
	/**
	 * Get list users.
	 * 
	 * @since    1.0.0
	 * 
	 * @return   array
	 */
	public function get_users( $args = '' ) {
		$defaults = array(
			'max'          => false,
			'page'         => 1,
			'per_page'     => false,
			'sort'         => 'DESC',
			'meta_query'   => false,
			'search_terms' => false,
			'in'           => false,
			'filter'       => array()
		);
		$r = wp_parse_args( $args, $defaults );
		extract( $r, EXTR_SKIP );
		
		// Cache first load list users
		if ( 1 == (int) $page && empty( $max ) && empty( $search_terms ) && empty( $filter ) && empty( $in ) && $sort == 'DESC' ) {
			if ( ! $user = wp_cache_get( 'dln_list_users', 'dln_like' ) ) {
				$args = array(
					'page'             => $page,
					'per_page'         => $per_page,
					'max'              => $max,
					'sort'             => $sort,
					'search_terms'     => $search_terms,
					'filter'           => $filter,
				);
				$tbl_user = DLN_Class_Model_User::get_instance();
				$user     = $tbl_user->get( $args );
			}
		}
	}
	
}
