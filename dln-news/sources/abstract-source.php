<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Source_Abstract {
	
	public static $instance;
	
	protected $sel_listing = null;
	
	protected $arr_prevent = null;
	
	protected $html = null;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {}
	
	public function get_links( $url = '' ) {
		if ( ! $url || ! $this->sel_listing )
			return false;
	
		$arr_url = DLN_Helper_Source::validate_url( $url );
		$host    = isset( $arr_url['host'] ) ? $arr_url['host'] : '';
		$url     = isset( $arr_url['full'] ) ? $arr_url['full'] : '';
	
		$arr_links = array();
		if ( $url ) {
			// Get urls raw
			$arr_urls = array();
			$links    = array();
			
			$opts    = array( 'http'=>array( 'header' => "User-Agent:MyAgent/1.0\r\n" ) );
			$context = stream_context_create( $opts );
			
			$this->html = file_get_html( $url, false, $context );
			if ( is_array( $this->sel_listing ) ) {
				foreach ( $this->sel_listing as $i => $selector ) {
					$links = array_merge( $links, $this->html->find( $selector ) );
				}
			} else {
				$links = $this->html->find( $this->sel_listing );
			}
			
			if ( is_array( $links ) ) {
				foreach( $links as $i => $link ) {
					
					if ( $link->href ) {
						
						// Exclude bad url
						if ( ! in_array( $link->href, $this->arr_prevent ) ) {
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

DLN_Source_Abstract::get_instance();