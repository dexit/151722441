<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Match_Like {
	
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
		add_action( 'wp_ajax_dln_add_like', array( $this, 'ajax_add_like' ) );
		add_action( 'wp_ajax_nopriv_dln_add_like', array( $this, 'ajax_add_like' ) );
	}
	
	public function init() {
	}
	
	public function ajax_add_like() {
		global $wpdb;
		check_ajax_referer( 'dln_add_like', '_ajax_nonce' );
		$post_id = isset( $_POST['post_id'] ) ? $_POST['post_id'] : '';
		$post_type = isset( $_POST['post_type'] ) ? $_POST['post_type'] : '';
		$user_id = isset( $_POST['user_id'] ) ? $_POST['user_id'] : '';
		
		if ( empty( $post_id ) || empty( $post_type ) || empty( $user_id ) )
			die(0);
		
		switch( $post_type ) {
			case 'comment':
				// Check exists in user_like table
				$result = $wpdb->get_var( $wpdb->prepare( "
					SELECT * 
					FROM {$wpdb->prefix}dln_user_like 
					WHERE user_id = %d AND post_type = %s AND post_id = %d", $user_id, $post_type, $post_id  
				) );
				if ( $result )
					die( 0 );
				else {
					$wpdb->query($wpdb->prepare("INSERT INTO ".$wpdb->prefix."wpv_voting (post_id, author_id, vote_count) VALUES (%d, %d, '')", $p_ID, $a_ID));
				}
				break;
		}
	}
	
}
$_dln_match_like = DLN_Match_Like::get_instance();