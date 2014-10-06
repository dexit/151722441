<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Source_VNExpress {
	
	public static $instance;
	public static $sel_listing = array(
		'#box_news_top .box_hot_news a',
		'#box_news_top .box_sub_hot_news a',
		'#container #col_1 .block_mid_new a'
	);
	
	public static $arr_prevent = array(
		'#',
		'javascript:void(0)',
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
			$links    = array();
			
			$html  = file_get_html( $url );
			if ( is_array( self::$sel_listing ) ) {
				foreach ( self::$sel_listing as $i => $selector ) {
					$links = array_merge( $links, $html->find( $selector ) );
				}
			} else {
				$links = $html->find( self::$sel_listing );
			}
			
			if ( is_array( $links ) ) {
				foreach( $links as $i => $link ) {
					
					if ( $link->href ) {
						
						// Exclude bad url
						if ( ! in_array( $link->href, self::$arr_prevent ) ) {
							if ( substr( $link->href, 0, 4 ) === 'http' ) {
								$crawl_url = $link->href;
							} else {
								$crawl_url = $host . $link->href;
							}
							
							$crawl_url  = str_replace( '#box_comment', '', $crawl_url ); 
							$arr_urls[] = $crawl_url;
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

DLN_Source_VNExpress::get_instance();