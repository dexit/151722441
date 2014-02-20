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
	}
	
	public function init() {
		$this->site = DLN_News_Site::get_instance();
		$this->site->fetchURL( 'http://vozforums.com/forumdisplay.php?f=33' );
	}
	
}
$_dln_question = DLN_News::get_instance();