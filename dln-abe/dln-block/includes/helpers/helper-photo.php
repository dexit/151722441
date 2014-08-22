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
	
	public static function get_photo_listing_posts( $limit = 10 ) {
		$photo_posts = get_posts(
			array(
				'numberposts' => 10,
				'post_type'   => 'dln_photo',
				'post_status' => 'publish',
				'orderby'     => 'post_date',
				'order'       => 'DESC'
			)
		);
		
		$arr_user_id = array();
		if ( ! is_wp_error( $photo_posts ) ) {
			foreach ( $photo_posts as $i => $photo ) {
				if ( ! empty( $photo->post_author ) ) {
					$arr_user_id[] = $photo->post_author;
				}
			}
		}
		$users = ( ! empty( $arr_user_id ) ) ? get_users( array( 'include' => $arr_user_id ) ) : null;
		
		return array( 'posts' => $photo_posts, 'users' => $users );
	}
}