<?php
require_once( ABSPATH . 'wp-admin/includes/upgrade.php');

class DLN_Install_DB {

	protected static $instance = null;

	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}
	
	function __construct() {
		DLN_Install_DB::create_source_links();
		DLN_Install_DB::create_source_folder();
		DLN_Install_DB::create_post_links();
		DLN_Install_DB::create_source_post();
	}

	public static function get_charset() {
		if ( defined( 'DB_CHARSET' ) ) {
			return DB_CHARSET;
		} else {
			return 'utf8';
		}
	}

	public static function create_source_post() {
		global $wpdb;
	
		if ( ! empty( $wpdb->charset ) )
			$db_charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		if ( ! empty( $wpdb->collate ) )
			$db_charset_collate .= " COLLATE $wpdb->collate";
	
		$sql = "CREATE TABLE {$wpdb->dln_source_post} (
		id int(11) NOT NULL AUTO_INCREMENT,
		source_id int(11) NOT NULL,
		post_id int(11) NOT NULL,
		PRIMARY KEY  (id)
		) CHARSET=" . self::get_charset() . ", ENGINE=InnoDB $db_charset_collate;";
	
		dbDelta( $sql );
	}
	
	public static function create_source_folder() {
		global $wpdb;
		
		if ( ! empty( $wpdb->charset ) )
			$db_charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		if ( ! empty( $wpdb->collate ) )
			$db_charset_collate .= " COLLATE $wpdb->collate";
		
		$sql = "CREATE TABLE {$wpdb->dln_source_folder} (
			id int(11) NOT NULL AUTO_INCREMENT,
			source_id int(11) NOT NULL,
			folder_id int(11) NOT NULL,
			PRIMARY KEY  (id)
		) CHARSET=" . self::get_charset() . ", ENGINE=InnoDB $db_charset_collate;";
		
		dbDelta( $sql );
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
			priority int(11) DEFAULT 10,
			crawl tinyint(1) DEFAULT 0,
			enable tinyint(1) DEFAULT 1,
			PRIMARY KEY  (id)
		) CHARSET=" . self::get_charset() . ", ENGINE=InnoDB $db_charset_collate;";
		
		dbDelta( $sql );
	}
	
	public static function create_post_links() {
		global $wpdb;
		
		if ( ! empty( $wpdb->charset ) )
			$db_charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		if ( ! empty( $wpdb->collate ) )
			$db_charset_collate .= " COLLATE $wpdb->collate";
		
		$sql = "CREATE TABLE {$wpdb->dln_post_link} (
			id int(11) NOT NULL AUTO_INCREMENT,
			post_id int(11) NOT NULL,
			site varchar(50) NOT NULL,
			hash varchar(255) NOT NULL,
			link text NOT NULL,
			time_create datetime NOT NULL,
			time_update datetime NOT NULL,
			crawl tinyint(1) DEFAULT 0,
			is_fetch tinyint(1) DEFAULT 0,
			total_count int(11) DEFAULT 0,
			comment_fbid varchar(50) NOT NULL,
			PRIMARY KEY  (id)
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

DLN_Install_DB::get_instance();