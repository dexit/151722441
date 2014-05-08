<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Source_Helper {
	
	public static $instance;
	public static $google_link_api = 'https://ajax.googleapis.com/ajax/services/';
	public static $feed;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() { }
	
	public static function get_instance_feed( $rss_url ) {
		if ( ! $rss_url ) return false;
		
		// Create instance SimplePie
		if ( null == self::$feed ) {
			self::$feed = new SimplePie();
			/*$upload_dir = wp_upload_dir();
			$dir        = $upload_dir['basedir'] . '/dln_cache';
			if( ! is_dir( $dir ) ) {
				mkdir( $dir );
			}
			self::$feed->set_cache_location( $dir );*/
			self::$feed->enable_cache(false);
		}
		
		// Set feed url
		self::$feed->set_feed_url( $rss_url );
		
		// Run SimplePie.
		self::$feed->init();
		// This makes sure that the content is sent to the browser as text/html and the UTF-8 character set (since we didn't change it).
		self::$feed->handle_content_type();
		
		return self::$feed;
	}
	
	public static function load_rss_link( $rss_url = '' ) {
		if ( ! $rss_url ) return;
		
		$feed = self::get_instance_feed( $rss_url );
		var_dump( $rss_url, $feed->get_item(0) );
	}
	
	public static function load_google_feed_rss( $rss_url = '', $amount = 10 ) {
		if ( ! $rss_url ) return;
		
		$rss_url = esc_url( $rss_url );
		$amount  = (int) $amount ? (int) $amount : 10;
		$arr_url = array(
			'v'    => '1.0',
			'output' => 'json',
			'num'    => $amount,
			'q'      => $rss_url
		);
		
		$link    = self::$google_link_api . "feed/load?" . http_build_query( $arr_url );
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
				$obj->contentSnippet = wp_strip_all_tags( $entry->contentSnippet );
				$obj->content        = wp_strip_all_tags( $entry->content );
				$obj->categories     = $entry->categories;
				$obj->hash           = $hash;
				
				$result[]   = $obj;
			}
		}
		
		return array( 'post' => $result, 'hash' => $arr_hashes);
	}
	
	public static function load_google_news( $query = '', $comapre_url = '', $new_obj ) {
		if ( ! $query || ! $comapre_url ) return $new_obj;
		
		$arr_url = array(
			'v'    => '1.0',
			'ned'  => 'vi_vn',
			'q'    => $query
		);
		$link    = self::$google_link_api . "search/news?" . http_build_query( $arr_url );
		$content = file_get_contents( $link );
		$jobject = json_decode( $content );
		var_dump($jobject);
		if ( isset( $jobject->responseStatus ) && $jobject->responseStatus == '200' ) {
			foreach ( $jobject->responseData->results as $i => $result ) {
				if ( $result->unescapedUrl == $comapre_url ) {
					$new_obj->publishedDateNew = $result->publishedDate;
					// get image from google news api
					if ( isset( $result->image ) ) {
						$new_obj->image = $result->image;
					} else {
						$result->image = '';
					}
					break;
				}
			}
		}
		return $new_obj;
	}
	
	public static function load_google_images( $query = '', $comapre_url = '', $new_obj ) {
		if ( ! $query || ! $comapre_url ) return $new_obj;
		
		$arr_url = array(
				'v'    => '1.0',
				'ned'  => 'vi_vn',
				'q'    => $query
		);
		$link    = self::$google_link_api . "search/images?" . http_build_query( $arr_url );
		$content = file_get_contents( $link );
		$jobject = json_decode( $content );
		var_dump($jobject);
		/*if ( isset( $jobject->responseStatus ) && $jobject->responseStatus == '200' ) {
			foreach ( $jobject->responseData->results as $i => $result ) {
				if ( $result->unescapedUrl == $comapre_url ) {
					$new_obj->publishedDateNew = $result->publishedDate;
					// get image from google news api
					if ( isset( $result->image ) ) {
						$new_obj->image = $result->image;
					}
					break;
				}
			}
		}*/
		return $new_obj;
	}
	
	private static function get_nodes( $rss_url = '' ) {
		if ( ! $rss_url )
			return;
	
		if ( ! self::check_url( $rss_url ) )
			return;
	
		$dom = new DOMDocument( '1.0', 'utf-8' );
		$xml = self::file_get_contents_curl( $rss_url );
		$dom->loadXML( $xml );
	
		return $dom;
	}
	
	/*public static function file_get_contents_curl( $url ) {
		$agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, $agent);
		curl_setopt($ch, CURLOPT_URL,$url);
		$result=curl_exec($ch);
	
		return $result;
	}
	
	private static function check_url( $html ){
		return $result = preg_replace(
			'%\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/)))%s',
			'<a href="$1">$1</a>',
			$html
		);
	}*/
}

DLN_Source_Helper::get_instance();