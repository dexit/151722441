<?php
/**
 * Plugin Name.
 *
 * @package   DLN_Bet
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class DLN_Choose {
	
	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;
	
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
		// Ajax
		add_action('wp_ajax_dln_add_choose', array( $this, 'ajax_add_choose' ) );
		add_action('wp_ajax_nopriv_dln_add_choose', array( $this, 'ajax_add_choose' ) );
	}
	
	public function init() {
	
	}
	
	public function ajax_add_choose() {
		check_ajax_referer( 'dln-add-choose', '_ajax_nonce' );
		$pid = (int) $_POST['post_id'];
		if ( empty( $pid ) )
			die(0);
		$post = get_post( $pid );
		
		// Create draft choose
		$draft = array(
			'post_title' => '',
			'post_content' => '',
			'post_status' => 'draft',
			'post_type' => 'dln_choose',
			'post_parent' => $pid,
			'post_author' => get_current_user_id()
		);
		$draft_id = wp_insert_post( $draft );
		echo $draft_id;
		exit();
	}
	
}
$_dln_choose = DLN_Choose::get_instance();