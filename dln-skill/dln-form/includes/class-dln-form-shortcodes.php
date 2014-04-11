<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Form_Shortcodes {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	public function __construct() {
		add_action( 'wp', array( $this, 'shortcode_action_handler' ) );
		
		//add_shortcode( 'submit_profile_form', array( $this, 'submit_profile_form' ) );
		add_shortcode( 'submit_point', array( $this, 'submit_point' ) );
	}
	
	public function shortcode_action_handler() {
		global $post;
		
		if ( is_page() && strstr( $post->post_content, '[profile_dashboard' ) ) {
			$this->profile_dashboard_handler();
		}
	}
	
	public function profile_dashboard_handler() {
		
	}
	
	public function submit_point() {
		return $GLOBALS['dln_form']->forms->get_form( 'submit-point' );
	}
	
	public function submit_profile_form() {
		//return $GLOBALS['dln_form']->forms->get_form( 'submit-profile' );
	}
	
}
DLN_Form_Shortcodes::get_instance();