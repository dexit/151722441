<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Post_Helper {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() { 
		include_once( DLN_SKILL_PLUGIN_DIR . '/dln-cron/includes/libraries/opengraph/OpenGraph.php' );
	}
	
	public static function get_post_link( $amount = 50 ) {
		if ( ! $amount ) return;
		
		global $wpdb;
		$sql    = $wpdb->prepare( "SELECT link, post_id, comment_fbid FROM {$wpdb->dln_post_link} WHERE is_fetch = %d AND crawl = %d LIMIT 0, 100", 0, 0 );
		$result = $wpdb->get_results( $sql, ARRAY_A );
		
		return $result;
	}
	
	public static function fetch_image_post( $post_id = '', $link = '', $comment_fbid = '' ) {
		if ( ! $post_id || ! $link ) return;
		
		$image = '';
		
		if ( $comment_fbid ) {
			$app_id     = FB_APP_ID;
			$app_secret = FB_SECRET;
			$url        = "https://graph.facebook.com/{$comment_fbid}?access_token={$app_id}|{$app_secret}";
			$obj        = json_decode( file_get_contents_curl( $url ) );
			
			if ( isset( $obj->image ) && $obj->image ) {
				$image = $obj->image->url;
			}
		}
		var_dump($image);die();
		if ( ! empty( $image ) ) {
			$graph = OpenGraph::fetch( $link );
			var_dump($graph);die();
		}
	}
	
}

DLN_Post_Helper::get_instance();