<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Helper_HoroScope_Ajax{
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		add_action( 'wp_ajax_dln_get_three_card',              array( $this, 'dln_get_three_card' ) );
		add_action( 'wp_ajax_nopriv_dln_get_three_card',       array( $this, 'dln_get_three_card' ) );
	}
	
	public static function dln_get_three_card() {
		if ( ! isset( $_POST[DLN_NEW_NONCE] ) || ! wp_verify_nonce( $_POST[DLN_NEW_NONCE], DLN_NEW_NONCE ) ) {
			echo '123';
			
			die();
		}
		exit('0');
	}
	
}

DLN_Helper_HoroScope_Ajax::get_instance();