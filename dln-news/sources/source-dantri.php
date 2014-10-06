<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Source_DanTri {
	
	public static $instance;
	public static $sel_listing = '.wrapper .container .fl a';
	public static $arr_prevent = array(
		'/trang-2.htm'
	);
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() { 
		//self::get_links( 'http://dantri.com.vn/o-to-xe-may.htm' );
	}
	
	public static function get_links( $url = '' ) {
		if ( ! $url || ! self::$sel_listing )
			return false;
	
		$arr_url = DLN_Helper_Source::validate_url( $url );
		$host    = isset( $arr_url['host'] ) ? $arr_url['host'] : '';
		$url     = isset( $arr_url['full'] ) ? $arr_url['full'] : '';
	
		$arr_links = array();
		if ( $url ) {
			// Get urls raw
			$arr_urls = array();
				
			$html  = file_get_html( $url );
			$links = $html->find( self::$sel_listing );
				
			if ( is_array( $links ) ) {
				foreach( $links as $i => $link ) {
					if ( $link->href ) {
						if ( substr( $link->href, 0, 4 ) === 'http' ) {
							$crawl_url = $link->href;
						} else {
							$crawl_url = $host . $link->href;
						}
	
						// Exclude bad url
						foreach ( self::$arr_prevent as $i => $prevent ) {
							if ( strpos( $crawl_url, $prevent) === false ) {
								$arr_urls[] = $crawl_url;
							}
						}
					}
				}
			}
				
			// Exclude duplicate urls
			if ( ! empty( $arr_urls ) ) {
				foreach( $arr_urls as $i => $url ) {
					if ( ! in_array( $url, $arr_links ) ) {
						//var_dump(json_decode( file_get_contents( 'https://graph.facebook.com/v2.1/?ids=' . $url . '&access_token=225132297553705|8f00d29717ee8c6a49cd25da80c5aad8' ) ));
						$arr_links[] = $url;
					}
				}
			}
		}
		
		return $arr_links;
	}
	
}

DLN_Source_DanTri::get_instance();