<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Helper_Photo {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {  }
	
	public static function get_likes_photo( $photo_id ) {
		if ( empty( $photo_id ) )
			return null;
		
		
	}
	
	public static function get_comments_photo( $photo_id ) {
		if ( empty( $photo_id ) )
			return null;
		
		
	}
	
}