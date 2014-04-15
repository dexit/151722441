<?php
require_once( ABSPATH . 'wp-admin/includes/upgrade.php');

class DLN_Install_DB {

	protected static $instane = null;

	private function __construct() {

	}

	public static function get_instance() {
		if ( null == self::$instane ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public static function get_charset() {
		if ( defined( 'DB_CHARSET' ) ) {
			return DB_CHARSET;
		} else {
			return 'utf8';
		}
	}

	public static function create_crawl_database() {
		DLN_Poll_Schema::create_crawl_links_table();
	}

	public static function create_crawl_links_table() {
		global $wpdb;
		$sql = "CREATE TABLE {$wpdb->prefix}dln_crawl_links (
		id int(11) NOT NULL AUTO_INCREMENT,
		host_id int(11) NOT NULL,
		link text NOT NULL,
		time_create datetime NOT NULL,
		is_crawl tinyint(1) NOT NULL,
		PRIMARY KEY  (id) 
		CHARSET=".self::get_charset()." ;";
		dbDelta( $sql );
	}

}