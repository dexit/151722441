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
		DLN_Install_Phrase::create_match_user();
		DLN_Install_Phrase::create_phrase_request();
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
	
	public static function create_match_user() {
		global $wpdb;
		
		if ( ! empty( $wpdb->charset ) )
			$db_charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		if ( ! empty( $wpdb->collate ) )
			$db_charset_collate .= " COLLATE $wpdb->collate";
		
		$sql = "CREATE TABLE {$wpdb->dln_match_user} (
			id int(11) NOT NULL AUTO_INCREMENT,
			match_id int(11) NOT NULL,
			user_id int(11) NOT NULL,
			money int(11) NOT NULL,
			is_paid tinyint(1) DEFAULT 0,
			time_create datetime NOT NULL,
			time_update datetime NOT NULL,
			PRIMARY KEY  (id)
		) CHARSET=" . self::get_charset() . ", ENGINE=InnoDB $db_charset_collate;";
		
		dbDelta( $sql );
	}
	
	public static function create_phrase_request() {
		global $wpdb;
		
		if ( ! empty( $wpdb->charset ) )
			$db_charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		if ( ! empty( $wpdb->collate ) )
			$db_charset_collate .= " COLLATE $wpdb->collate";
		
		$sql = "CREATE TABLE {$wpdb->dln_phrase_request} (
			id int(11) NOT NULL AUTO_INCREMENT,
			ip nvarchar(50) NOT NULL,
			date datetime NOT NULL,
			code nvarchar(50) NULL,
			PRIMARY KEY  (id)
		) CHARSET=" . self::get_charset() . ", ENGINE=InnoDB $db_charset_collate;";
		
		dbDelta( $sql );
	}
	
}

DLN_Install_Phrase::get_instance();