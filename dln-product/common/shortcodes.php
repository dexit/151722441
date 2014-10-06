<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Common_Shortcodes {
	
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
		add_shortcode( 'dln_product_submit', array( $this, 'dln_product_submit' ) );
	}
	
	public static function dln_product_submit() {
		return DLN_Common_Template::render_view( 'product-submit' );
	}
	
}

DLN_Common_Shortcodes::get_instance();