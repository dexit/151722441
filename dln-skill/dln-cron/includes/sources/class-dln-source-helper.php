<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Source_Helper {
	
	public static $instance;
	public static $google_link_api = 'https://ajax.googleapis.com/ajax/services/';
	
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
		$arr_url = array(
			'output' => 'json',
			'num'    => $amount,
			'q'      => $rss_url
		);
		
		$link    = self::$google_link_api . "feed/load?v=1.0&" . http_build_query( $arr_url );
		$content = file_get_contents( $link );
		$jobject = json_decode( $content );
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
	
	public static function load_google_news( $query = '' ) {
		if ( ! $query ) return false;
		
		$arr_url = array(
			'ned'  => 'vi_vn',
			'q'    => 'Cưa đầu đạn, một người chết với mảnh đạn găm đầy cơ thể'
		);
		$link    = self::$google_link_api . "search/news?v=1.0&" . http_build_query( $arr_url );
		$content = file_get_contents( $link );
		$jobject = json_decode( $content );
		var_dump($jobject);die();
	}
	
}

DLN_Source_Helper::get_instance();