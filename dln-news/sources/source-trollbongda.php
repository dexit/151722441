<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Source_TrollBongDa {
	
	public static $instance;
	public static $sel_listing = array(
		'.photoListItem .thumbnail a',
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
	
	function __construct() {}
	
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
							
							$arr_urls[] = $crawl_url;
						}
					}
				}
			}
				
			// Exclude duplicate urls
			if ( ! empty( $arr_urls ) ) {
				foreach( $arr_urls as $i => $url ) {
					if ( ! in_array( $url, $arr_links ) ) {
						$arr_links[] = $url;
					}
				}
			}
		}
		
		return $arr_links;
	}
}

DLN_Source_TrollBongDa::get_instance();