<?php

if ( ! defined( 'WPINC' ) ) { die; }
 
class DLN_News {
	
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
		add_action( 'add_meta_boxes', array( $this, 'add_metabox' ) );
		add_action( 'dln_site_edit_form', array( 'DLN_News_Site', 'dln_site_metabox_edit' ), 10, 2 );
	}
	
	public function init() {
		//$this->site = DLN_News_Site::get_instance();
		//$this->site->fetchURL( 'http://vozforums.com/forumdisplay.php?f=33' );
	}
	
	public static function activate() {
		self::setup_term_meta();
	}
	
	private static function setup_term_meta() {
		global $wpdb;
		
		if ( $id !== false)
			switch_to_blog( $id );
		
		$charset_collate = '';
		if ( ! empty($wpdb->charset) )
			$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		if ( ! empty($wpdb->collate) )
			$charset_collate .= " COLLATE $wpdb->collate";
		
		$tables = $wpdb->get_results("show tables like '{$wpdb->prefix}termsmeta'");
		if (!count($tables))
			$wpdb->query("CREATE TABLE {$wpdb->prefix}termsmeta (
			meta_id bigint(20) unsigned NOT NULL auto_increment,
			taxonomy_id bigint(20) unsigned NOT NULL default '0',
			meta_key varchar(255) default NULL,
			meta_value longtext,
			PRIMARY KEY	(meta_id),
			KEY taxonomy_id (taxonomy_id),
			KEY meta_key (meta_key)
		) $charset_collate;");
	}

}
$_dln_question = DLN_News::get_instance();