<?php
/**
 * @package   DLN_Like_Model
 * @author    DinhLN <lenhatdinh@gmail.com>
 * @license   GPL-2.0+
 * @link      http://www.facebook.com/lenhatdinh
 * @copyright 2013 by DinhLN
 */

/**
 * Class model for table dln_user.
 *
 * @package   DLN_Like_Model_User
 * @author    dinhln <lenhatdinh@gmail.com> - i - 2:58:01 PM
 */
class DLN_Like_Model_User {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      protected
	 */
	protected static $instance = null;
	
	/**
	 * Table name.
	 *
	 * @since    1.0.0
	 *
	 * @var      public
	 */
	public $table = '';
	
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
		global $wpdb;
		
		// Setting variable
		$this->table = $wpdb->base_prefix . 'dln_user';
		
		if( @is_file( ABSPATH . '/wp-admin/includes/upgrade.php' ) )
			include_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
		else
			die( __( 'We have problem finding your \'/wp-admin/upgrade-functions.php\' and \'/wp-admin/includes/upgrade.php\'', DLN_LIKE_SLUG ) );
	}
	
	/**
	 * Function create new dln_user table.
	 * 
	 * @since    1.0.0
	 * 
	 * @return   void
	 */
	public function create_table() {
		global $wpdb;
		
		if ( ! empty( $wpdb->charset ) )
			$db_charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		if ( ! empty( $wpdb->collate ) )
			$db_charset_collate .= " COLLATE $wpdb->collate";
		
		if ( $this->table ) {
			$sql   = "CREATE TABLE $this->table (
			id bigint(20) unsigned NOT NULL auto_increment,
			userid bigint(35) NOT NULL default '0',
			fbid varchar(35) NULL,
			access_token text NULL,
			crawl bool DEFAULT 0,
			PRIMARY KEY  (id)
			) ENGINE=MyISAM $db_charset_collate;";
			dbDelta( $sql );
		}
	}
	
	/**
	 * Add new dln user.
	 * 
	 * @since    1.0.0
	 * 
	 * @return   string
	 */
	public function add_user( $userid = '', $fbid = '', $access_token = '', $crawl = '0' ) {
		if ( ! $this->table )
			return null;
		global $wpdb;
		$result = $wpdb->get_row( "INSERT INTO {$this->table} (`userid`, `fbid`, `access_token`, `crawl`) VALUES({$userid}, '{$fbid}', '{$access_token}', {$crawl})" );
		return $result;
	}
	
	/**
	 * Get user by id.
	 * 
	 * @since    1.0.0
	 * 
	 * @return   object
	 */
	public function get_user( $user_id = '' ) {
		if ( ! $this->table )
			return null;
		global $wpdb;
		$result = $wpdb->get_row( "SELECT * FROM {$this->table} WHERE `userid` = {$user_id}" );
		return $result;
	}
	
}
