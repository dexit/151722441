<?php

if ( ! defined( 'WPINC' ) ) { die; }
 
class DLN_Match {
	
	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;
	
	public $site;
	
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
	
	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {
		// Load plugin text domain
		add_action( 'init', array( $this, 'init' ) );
		add_action( 'dln_site_edit_form', array( 'DLN_News_Site', 'dln_site_metabox_edit' ), 10, 2 );
	}
	
	public function init() {
		
	}
	
	public static function activate() {
		self::setup_table_user_like();
	}
	
	private static function setup_table_user_like() {
		global $wpdb;
		
		if ( $id !== false)
			switch_to_blog( $id );
		
		$charset_collate = '';
		if ( ! empty($wpdb->charset) )
			$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		if ( ! empty($wpdb->collate) )
			$charset_collate .= " COLLATE $wpdb->collate";
		
		$tables = $wpdb->get_results("show tables like '{$wpdb->prefix}dln_user_like'");
		if (!count($tables))
			$wpdb->query("CREATE TABLE {$wpdb->prefix}dln_user_like (
			ul_id bigint(20) unsigned NOT NULL auto_increment,
			user_id bigint(20) unsigned NOT NULL default '0',
			post_id bigint(20) unsigned NOT NULL default '0',
			post_type varchar(255) default NULL,
			like_amount int(20) unsigned NOT NULL default '0',
			like_date datetime,
			PRIMARY KEY	(ul_id)
		) $charset_collate;");
	}

}
$_dln_question = DLN_Match::get_instance();