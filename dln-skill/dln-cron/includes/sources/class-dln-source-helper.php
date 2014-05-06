<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Source_Helper {
	
	public static $instance;
	public static $google_feed_api = 'https://ajax.googleapis.com/ajax/services/feed';
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	public static function load_google_feed_rss( $rss_url = '', $amount = 50 ) {
		if ( ! $rss_url ) return;
		
		$rss_url = esc_url( $rss_url );
		$amount  = (int) $amount ? (int) $amount : 10;
		$link    = self::$google_feed_api . "/load?v=1.0&output=json&num={$amount}&q={$rss_url}";
		$jobject = json_decode( file_get_contents( $link ) );
		$result  = $arr_hashes = array();
		if ( isset( $jobject->responseStatus ) && $jobject->responseStatus == '200' ) {
			foreach( $jobject->responseData->feed->entries as $i => $entry ) {
				$url          = esc_url( $entry->link );
				$hash         = DLN_Cron_Helper::generate_hash( $url );
				$arr_hashes[] = $hash;
				$obj                 = new stdClass;
				$obj->title          = $entry->title;
				$obj->link           = $url;
				$obj->publishedDate  = $entry->publishedDate;
				$obj->contentSnippet = $entry->contentSnippet;
				$obj->content        = $entry->content;
				$obj->categories     = $entry->categories;
				$obj->hash           = $hash;
				
				$result[]   = $obj;
			}
		}
		return array( 'post' => $result, 'hash' => $arr_hashes);
	}
	
}

DLN_Source_Helper::get_instance();