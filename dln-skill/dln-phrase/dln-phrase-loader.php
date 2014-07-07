<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Phrase_Loader {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		define( 'DLN_PHRASE', 'dln_phrase' );
		global $wpdb;
		$wpdb->dln_user_phrase = $wpdb->prefix . 'dln_user_phrase';
	}
	
	public static function activate() {
		require_once( 'includes/class-dln-install-phrase.php' );
	}
	
}

$GLOBALS['dln_phrase'] = DLN_Phrase_Loader::get_instance();