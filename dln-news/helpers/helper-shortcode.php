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
		add_shortcode( 'dln_horoscope_three_card', array( $this, 'dln_horoscope_three_card' ) );
	}
	
	public static function dln_source_listing() {
		return DLN_Helper_Template::render_view( 'source-listing' );
	}
	
	public static function dln_horoscope_three_card() {
		return DLN_Helper_Template::render_view( 'horoscope-three-card' );
	}
}

DLN_Helper_Shortcode::get_instance();