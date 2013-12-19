<?php
/**
 * @package   DLN_Like_Class
 * @author    DinhLN <lenhatdinh@gmail.com>
 * @license   GPL-2.0+
 * @link      http://www.facebook.com/lenhatdinh
 * @copyright 2013 by DinhLN
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// Include WP's list table class
if ( ! class_exists( 'WP_List_Table' ) ) require( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );

/**
 * Table listing user for backend.
 *
 * @package   DLN_Class_List_User extends WP_List_Table
 * @author    dinhln <lenhatdinh@gmail.com> - i - 3:26:26 PM
 */
class DLN_Class_List_User extends WP_List_Table {

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
		parent::__construct( array(
			'ajax'     => false,
			'plural'   => 'dln_users',
			'singular' => 'dln_user',
			'screen'   => get_current_screen()
		) );
	}
	
	/**
	 * Handle filtering of data, sorting, pagination, and any other data manipulation prior to rendering.
	 * 
	 * @since    1.0.0
	 * 
	 * @return   void
	 */
	public function prepare_items() {
		// Option defaults
		$filter       = array();
		$include_id   = false;
		$search_terms = false;
		$sort         = 'DESC';
		
		// Set current page
		$page = $this->get_pagenum();
		
		// Set per page from the screen options
		$per_page = $this->get_items_per_page( str_replace( '-', '_', "{$this->screen->id}_per_page" ) );
		
		// Sort order
		if ( ! empty( $_REQUEST['order'] ) && $_REQUEST['order'] != 'desc' ) {
			$sort = 'ASC';
		}
		
		// Filter
		//if ( ! empty( $_REQUEST ) )
			
		// Search
		if ( ! empty( $_REQUEST['s'] ) ) {
			$search_terms = $_REQUEST['s'];
		}
		
		$tbl_user = DLN_Class_Model_User::get_instance();
		
		$users = $tbl_user::get( array( 
			'filter'       => $filter,
			'in'           => $include_id,
			'page'         => $page,
			'per_page'     => $per_page,
			'search_terms' => $search_terms,
			'sort'         => $sort
		 ) );
	}
	
}
