<?php
/**
 * Plugin Name.
 *
 * @package   DLN_Bet
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 */

class DLN_Schema {
	
	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;
	
	public $db_charset_collate = '';
	
	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {
	
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	public function __construct() {
		
	}
	
	public static function activate() {
		global $wpdb;
		if( @is_file( ABSPATH . '/wp-admin/includes/upgrade.php' ) )
			include_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
		else
			die( __( 'We have problem finding your \'/wp-admin/upgrade-functions.php\' and \'/wp-admin/includes/upgrade.php\'', DLN_BET_SLUG ) );
		
		if ( ! empty( $wpdb->charset ) )
			$db_charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		if ( ! empty( $wpdb->collate ) )
			$db_charset_collate .= " COLLATE $wpdb->collate";
		
		self::create_table_dln_choose_user( $db_charset_collate );
	}
	
	public static function deactivate() {
		
	}
	
	public static function create_table_dln_choose_user( $db_charset_collate ) {
		global $wpdb;
		
		$table = $wpdb->base_prefix . 'dln_choose_user';
		$sql = "CREATE TABLE $table (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT ,
			post_id bigint(20) NULL,
			user_id bigint(20) NULL,
			multiple text NULL,
			cost text NULL,
			date text NULL,
			PRIMARY KEY  (id)
		) ENGINE=InnoDB $db_charset_collate";
		dbDelta( $sql );
	}
	
	public static function insert_choose_user( $id = 0, $choose_id, $user_id, $multiple = 0, $cost = 0 ) {
		global $wpdb;
		
		$table = $wpdb->base_prefix . 'dln_choose_user';
		$cur_date = date('Y-m-d G:i:s');
		$insert_id = '';
		if ( ! empty( $id ) ) {
			$insert_id = $wpdb->update( $table,
				array(
					'post_id'  => $choose_id,
					'user_id'  => $user_id,
					'multiple' => $multiple,
					'cost'     => $cost,
					'date'     => $cur_date
				),
				array(
					'id' => $id
				)
			);
		} else {
			$insert_id = $wpdb->insert( $table, 
				array(
					'post_id'  => $choose_id,
					'user_id'  => $user_id,
					'multiple' => $multiple,
					'cost'     => $cost,
					'date'     => $cur_date
				)
			);
		}
		
		return $insert_id;
	}
	
}
$_dln_schema = DLN_Schema::get_instance();
