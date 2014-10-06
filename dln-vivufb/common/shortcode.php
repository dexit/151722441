<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Common_Shortcode {
	
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
		add_shortcode( 'dln_source_submit', array( $this, 'dln_source_submit' ) );
	}
	
	public static function dln_source_submit() {
		return DLN_Common_Template::render_view( 'source-submit' );
	}
	
}

DLN_Common_Shortcode::get_instance();