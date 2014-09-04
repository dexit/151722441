<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Member_Loader {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		global $wpdb;
		$wpdb->dln_hire = $wpdb->prefix . 'dln_hire';
		
		include( DLN_ABE_PLUGIN_DIR . '/dln-member/includes/helpers/helper-hire.php' );
		
		if ( is_admin() ) {
			include( DLN_ABE_PLUGIN_DIR . '/dln-member/includes/admin/mycred-admin.php' );
		}
	}
	
	public static function activate() {
		DLN_Member_Loader::create_table_hire();
	}
	
	public static function create_table_hire() {
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
		global $wpdb;
	
		if ( ! empty( $wpdb->charset ) )
			$db_charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		if ( ! empty( $wpdb->collate ) )
			$db_charset_collate .= " COLLATE $wpdb->collate";
	
		$sql = "CREATE TABLE {$wpdb->dln_hire} (
		id int(11) NOT NULL AUTO_INCREMENT,
		type nvarchar(50) NOT NULL,
		user_id int(11) NOT NULL,
		start_time datetime NOT NULL,
		end_time datetime NOT NULL,
		day_limit int(11) NOT NULL,
		cost int(11) DEFAULT 0,
		cost_paid int(11) DEFAULT 0,
		active tinyint(1) DEFAULT 0,
		PRIMARY KEY  (id)
		) CHARSET=utf8, ENGINE=InnoDB $db_charset_collate;";
	
		dbDelta( $sql );
	}
	
}

$GLOBALS['dln_member'] = DLN_Member_Loader::get_instance();