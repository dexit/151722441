<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Helper_Shortcode {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		//badd_action( 'init', array( $this, 'load_posted_form' ) );
		add_shortcode( 'dln_source_listing', array( $this, 'dln_source_listing' ) );
	}
	
	public static function dln_source_listing() {
		return DLN_Helper_Template::render_view( 'source-listing' );
	}
	
}

DLN_Helper_Shortcode::get_instance();