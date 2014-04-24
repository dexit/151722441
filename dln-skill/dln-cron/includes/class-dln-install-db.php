<?php
require_once( ABSPATH . 'wp-admin/includes/upgrade.php');

class DLN_Install_DB {

	protected static $instane = null;

	private function __construct() { }

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
		//DLN_Install_DB::create_crawl_links_table();
		//DLN_Install_DB::create_crawl_links_meta_table();
		DLN_Install_DB::create_source_links();
	}

	public static function create_source_links() {
		global $wpdb;
		
		if ( ! empty( $wpdb->charset ) )
			$db_charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		if ( ! empty( $wpdb->collate ) )
			$db_charset_collate .= " COLLATE $wpdb->collate";
		
		$sql = "CREATE TABLE {$wpdb->dln_source_link} (
			id int(11) NOT NULL AUTO_INCREMENT,
			term_id int(11) NOT NULL,
			hash varchar(255) NOT NULL,
			link text NOT NULL,
			crawl int(11) DEFAULT 0,
			PRIMARY KEY (id)
		) CHARSET=" . self::get_charset() . ", ENGINE=InnoDB $db_charset_collate;";
		
		dbDelta( $sql );
	}
	
	public static function create_crawl_links_meta_table() {
		global $wpdb;
		
		if ( ! empty( $wpdb->charset ) )
			$db_charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		if ( ! empty( $wpdb->collate ) )
			$db_charset_collate .= " COLLATE $wpdb->collate";
		
		$sql = "CREATE TABLE {$wpdb->dln_crawl_links_meta} (
			id int(11) NOT NULL AUTO_INCREMENT,
			link_id int(11) NOT NULL,
			meta_key varchar(255) NOT NULL,
			meta_value longtext NOT NULL,
			PRIMARY KEY (id)
		) CHARSET=" . self::get_charset() . ", ENGINE=InnoDB $db_charset_collate;";
		
		dbDelta( $sql );
	}
	
	public static function create_crawl_links_table() {
		global $wpdb;
		
		if ( ! empty( $wpdb->charset ) )
			$db_charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		if ( ! empty( $wpdb->collate ) )
			$db_charset_collate .= " COLLATE $wpdb->collate";
		
		$sql = "CREATE TABLE {$wpdb->dln_crawl_links} (
			id int(11) NOT NULL AUTO_INCREMENT,
			host_id varchar(255) NOT NULL,
			site varchar(50) NOT NULL,
			link text NOT NULL,
			time_create datetime NOT NULL,
			time_update datetime NOT NULL,
			total_count int(11) DEFAULT 0,
			crawl int(11) DEFAULT 0,
			PRIMARY KEY (id)
		) CHARSET=" . self::get_charset() . ", ENGINE=MyISAM $db_charset_collate;";
		
		dbDelta( $sql );
	}

}