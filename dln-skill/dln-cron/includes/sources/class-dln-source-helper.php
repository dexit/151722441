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
	
}

DLN_Source_Helper::get_instance();