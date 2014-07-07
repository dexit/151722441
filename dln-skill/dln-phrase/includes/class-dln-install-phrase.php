<?php
require_once( ABSPATH . 'wp-admin/includes/upgrade.php');

class DLN_Install_Phrase {
	
	protected static $instance = null;
	
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		DLN_Install_Phrase::create_user_phrase();
	}
	
	public static function get_charset() {
		if ( defined( 'DB_CHARSET' ) ) {
			return DB_CHARSET;
		} else {
			return 'utf8';
		}
	}
	
	public static function create_user_phrase() {
		global $wpdb;
		
		if ( ! empty( $wpdb->charset ) )
			$db_charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		if ( ! empty( $wpdb->collate ) )
			$db_charset_collate .= " COLLATE $wpdb->collate";
		
		$sql = "CREATE TABLE {$wpdb->dln_user_phrase} (
			id int(11) NOT NULL AUTO_INCREMENT,
			user_id int(11) NOT NULL,
			phrase_id int(11) NOT NULL,
			PRIMARY KEY  (id)
		) CHARSET=" . self::get_charset() . ", ENGINE=InnoDB $db_charset_collate;";
		
		dbDelta( $sql );
	}
	
}

DLN_Install_Phrase::get_instance();