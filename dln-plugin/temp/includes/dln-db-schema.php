<?php
/**
 * Plugin Name.
 *
 * @package   DLN_Poll
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 */
 
class DLN_Poll_Schema {
	
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
	
	public static function create_poll_database() {
		DLN_Poll_Schema::create_poll_logs_table();
		DLN_Poll_Schema::create_poll_voters_table();
		DLN_Poll_Schema::create_poll_bans_table();
		DLN_Poll_Schema::create_poll_votes_custom_fields_table();
	}
	
	public static function create_poll_logs_table() {
		global $wpdb;
		$sql = "CREATE TABLE " . $wpdb->dln_poll_logs . " (
		id int(11) NOT NULL AUTO_INCREMENT,
		poll_id int(11) NOT NULL,
		vote_id varchar(255) NOT NULL,
		answer_id int(11) NOT NULL,
		ip varchar(100) NOT NULL,
		user_id int(11) NOT NULL,
		user_type ENUM( 'facebook', 'wordpress', 'anonymous', 'default' ) NOT NULL DEFAULT 'default',
		http_referer varchar(255) NOT NULL,
		tr_id varchar(255) NOT NULL,
		other_answer_value text NOT NULL,
		host varchar(200) NOT NULL,
		vote_date datetime NOT NULL,
		PRIMARY KEY  (id),
		KEY poll_id (poll_id)) CHARSET=".self::get_charset()." ;";
		dbDelta( $sql );
	}
	
	public static function create_poll_voters_table() {
		global $wpdb;
		$sql = "CREATE TABLE " . $wpdb->dln_poll_voters . " (
		id int(11) NOT NULL AUTO_INCREMENT,
		poll_id int(11) NOT NULL,
		user_id int(11) NOT NULL,
		user_type ENUM( 'facebook', 'wordpress', 'anonymous', 'default' ) NOT NULL DEFAULT 'default',
		PRIMARY KEY  (id),
		KEY poll_id (poll_id)) CHARSET=".self::get_charset()." ;";
		dbDelta( $sql );
	}
	
	public static function create_poll_bans_table() {
		global $wpdb;
		$sql = "CREATE TABLE " . $wpdb->dln_poll_bans . " (
		id int(11) NOT NULL AUTO_INCREMENT,
		poll_id int(11) NOT NULL,
		type varchar(255) NOT NULL,
		value varchar(255) NOT NULL,
		PRIMARY KEY  (id),
		KEY poll_id (poll_id)) CHARSET=".self::get_charset()." ;";
		dbDelta( $sql );
	}
	
	public static function create_poll_votes_custom_fields_table() {
		global $wpdb;
		$sql = "CREATE TABLE " . $wpdb->dln_poll_votes_custom_fields . " (
		id int(11) NOT NULL AUTO_INCREMENT,
		poll_id int(11) NOT NULL,
		vote_id varchar(255) NOT NULL,
		custom_field_id int(11) NOT NULL,
		user_id int(11) NOT NULL,
		user_type ENUM( 'facebook', 'wordpress', 'anonymous', 'default' ) NOT NULL DEFAULT 'default',
		custom_field_value text NOT NULL,
		tr_id varchar(255) NOT NULL,
		vote_date datetime NOT NULL,
		PRIMARY KEY  (id),
		KEY poll_id (poll_id)) CHARSET=".self::get_charset()." ;";
	
		dbDelta( $sql );
	}
	
}