<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Source_Helper {
	
	public static $instance;
	public static $google_link_api = 'https://ajax.googleapis.com/ajax/services/';
	public static $rss;
	public static $ip;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() { 
		self::$ip = self::get_real_ip_addr();
	}
	
	public static function get_instance_rss_php() {
		// Create instance SimplePie
		if ( null == self::$rss ) {
			self::$rss = new rss_php();
		}
		
		return self::$rss;
	}
	
	public static function load_rss_link( $rss_url = '' ) {
		if ( ! $rss_url ) return;
		
		$rss    = self::get_instance_rss_php();
		$rss->load( $rss_url );
		$items  = $rss->getItems( true );
		
		$result = $arr_hashes = $arr_urls = array();
		if ( $items ) {
			foreach ( $items as $i => $item ) {
				$data = $item->children;
				$url  = isset( $data['link'] ) ? trim( $data['link']->valueData ) : '';
				$url  = esc_url( $url );
				$hash = DLN_Cron_Helper::generate_hash( $url );
				
				$obj              = new stdClass;
				$obj->title       = isset( $data['title'] ) ? trim( $data['title']->valueData ) : '';
				$obj->link        = $url;
				$content          = isset( $data['description'] ) ? wp_strip_all_tags( trim( $data['description']->valueData ) ) : '';
				$obj->content     = preg_replace( '!\s+!', ' ', $content );
				$publishedDate      = isset( $data['pubDate'] ) ? strtotime( trim( $data['pubDate']->valueData ) ) : '';
				$obj->publishedDate = ! empty( $publishedDate ) ? date( 'Y-m-d H:i:s', $publishedDate ) : date( 'Y-m-d H:i:s' );
				$obj->hash        = ! empty( $hash ) ? $hash : '';
				$obj->image       = isset( $data['image']->valueData )   ? esc_url( $data['image']->valueData ) : '';
				//$obj->categories  = isset( $data['category'] ) ? esc_url( $data['category']->valueData ) : '';
				// If exists enclosure then process image for it (Ex: news.zing.vn)
				if ( ! $obj->image && isset( $data['enclosure'] ) ) {
					$attrs        = $data['enclosure']->attributeNodes;
					if ( in_array( $attrs['type'], array( 'image/jpeg', 'image/png', 'image/gif' ) ) ) {
						$obj->image = isset( $attrs['url'] ) ? $attrs['url'] : '';
					}
				}
				
				if ( $hash ) {
					$arr_hashes[] = $hash;
				}
				$result[]         = $obj;
				$arr_urls[]       = $url;
			}
		}
		return array( 'post' => $result, 'hash' => $arr_hashes, 'urls' => $arr_urls );
	}
	
	public static function load_google_feed_rss( $rss_url = '', $amount = 50 ) {
		if ( ! $rss_url ) return;
		
		$rss_url = esc_url( $rss_url );
		$amount  = (int) $amount ? (int) $amount : 10;
		$arr_url = array(
			'v'      => '1.0',
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
				$obj->publishedDate  = date( 'Y-m-d H:i:s', strtotime( $entry->publishedDate ) );
				//$obj->contentSnippet = wp_strip_all_tags( trim( $entry->contentSnippet ) );
				$content             = preg_replace( '/\s+/', ' ', wp_strip_all_tags( trim( $entry->content ) ) );
				$obj->content        = $content;
				//$obj->categories     = $entry->categories;
				$obj->hash           = $hash;
				
				$result[]         = $obj;
				$arr_urls[]       = $url;
			}
		}
		
		return array( 'post' => $result, 'hash' => $arr_hashes, 'urls' => $arr_urls );
	}
	
	public static function load_google_news( $query = '', $comapre_url = '', $new_obj ) {
		if ( ! $query || ! $comapre_url ) return $new_obj;
		
		$arr_url = array(
			'v'    => '1.0',
			'ned'  => 'vi_vn',
			'userip' => self::$ip,
			'q'    => $query
		);
		$link    = self::$google_link_api . "search/news?" . http_build_query( $arr_url );
		$content = self::file_get_contents_curl( $link );
		$jobject = json_decode( $content );
		
		if ( empty( $new_obj->image ) && isset( $jobject->responseStatus ) && $jobject->responseStatus == '200' ) {
			foreach ( $jobject->responseData->results as $i => $result ) {
				if ( $result->unescapedUrl == $comapre_url ) {
					$new_obj->publishedDateNew = date( 'Y-m-d H:i:s', strtotime( $result->publishedDate ) );
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
				'rsz'  => '8',
				'q'    => $query
		);
		$link    = self::$google_link_api . "search/images?" . http_build_query( $arr_url );
		$content = self::file_get_contents_curl( $link );
		$jobject = json_decode( $content );

		if ( empty( $new_obj->image ) && isset( $jobject->responseStatus ) && $jobject->responseStatus == '200' ) {
			$parse_url = parse_url( $comapre_url );
			$host      = isset( $parse_url['host'] ) ? $parse_url['host'] : '';
			foreach ( $jobject->responseData->results as $i => $result ) {
				if ( $result->visibleUrl == $host ) {
					// get image from google images api
					$new_obj->image = $result->url;
					break;
				}
			}
		}
		return $new_obj;
	}
	
	private static function get_real_ip_addr()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
		{
			$ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
		{
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
			$ip=$_SERVER['REMOTE_ADDR'];
		}
		return $ip;
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
	
	private static function file_get_contents_curl( $url ) {
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
}

DLN_Source_Helper::get_instance();