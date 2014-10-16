<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Source_TrollBongDa extends DLN_Source_Abstract {
	
	public static $instance;
	protected $sel_listing = array(
		'.itemContainer .catItemView .catItemImage a',
	);
	protected $arr_prevent = array(
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
			
			// Get links
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
							
							$obj = new stdClass;
							if ( ! empty( $image = $link->first_child() ) ) {
								if ( ! empty( $image->src ) ) {
									$src = $image->src;
									
									if ( substr( $link->href, 0, 4 ) === 'http' ) {
										$obj->image = $src;
									} else {
										$obj->image = $host . $src;
									}
								}
							}
							
							$obj->link  = $crawl_url;							
							$arr_urls[] = $obj;
						}
					}
				}
			}
	
			// Exclude duplicate urls
			if ( ! empty( $arr_urls ) ) {
				foreach( $arr_urls as $i => $obj ) {
					if ( ! in_array( $obj->link, $arr_links ) ) {
						$arr_links[] = $obj;
					}
				}
			}
		}
	
		return $arr_links;
	}
	
	public function get_link_step_two( $url = '' ) {
		if ( ! $url )
			return false;
		
		$arr_results = array();
		
		var_dump($this->html);die();
		if ( empty( $this->html ) ) {
			$opts    = array( 'http' => array( 'header' => "User-Agent:MyAgent/1.0\r\n" ) );
			$context = stream_context_create( $opts );
			
			$this->html = file_get_html( $url );
		}
		
		$links = $this->html->find( $this->sel_listing[0] );
		
		if ( ! empty( $links ) ) {
			$host = 'http://trollbongda.com';
			foreach ( $links as $i => $link ) {
				$image = $link->find( 'img' );
				if ( ! empty( $image ) ) {
					$src = ( substr( $link->href, 0, 4 ) === 'http' ) ? $image->src : $host . $image->src;
					$arr_results[] = array(
						'link'  => $host . $link->href,
						'image' => $image->src
					);
				}
			}
		}
		
		return $arr_results;
	}
}

DLN_Source_TrollBongDa::get_instance();