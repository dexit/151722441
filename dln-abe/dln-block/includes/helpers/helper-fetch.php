<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Helper_Fetch {
	
	public static $instance;
	public $max_crawl = 100;
	public $height_limit;
	public $width_limit;
	public $count_limit;
	public $height_min;
	public $width_min;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		
		return self::$instance;
	}
	
	function __construct() {
		$this->set_height_limit( 1024 );
		$this->set_width_limit( 1024 );
		$this->set_height_min( 140 );
		$this->set_width_min( 140 );
		$this->set_count_limit( 10 );
	}
	
	public function set_height_limit( $height = '' ) {
		if ( ! $height )
			return false;
		
		$height             = intval( $height );
		$this->height_limit = $height;
		return $this->height_limit;
	}
	
	public function set_width_limit( $width = '' ) {
		if ( ! $width )
			return false;
	
		$width             = intval( $width );
		$this->width_limit = $width;
		return $this->width_limit;
	}
	
	public function set_height_min( $height = '' ) {
		if ( ! $height )
			return false;
	
		$height           = intval( $height );
		$this->height_min = $height;
		return $this->height_min;
	}
	
	public function set_width_min( $width = '' ) {
		if ( ! $width )
			return false;
	
		$width           = intval( $width );
		$this->width_min = $width;
		return $this->width_min;
	}
	
	public function set_count_limit( $count = '' ) {
		if ( ! $count )
			return false;
		
		$count             = intval( $count );
		$this->count_limit = $count;
		return $this->count_limit;
	}
	
	public function fetch_images_from_url( $url = '' ) {
		if ( ! $url )
			return null;
		$result = array();
		
		$html      = new DOMDocument( '1.0', 'utf-8' );
		@$html->loadHTMLFile( $url );
		$xpath     = new DOMXPath( $html );
		$node_list = $xpath->query( '//img' );
		
		$arr_src = array();
		$count   = 0;
		if ( ! empty( $node_list ) ) {
			foreach ( $node_list as $i => $node ) {
				if ( $i == $this->max_crawl )
					break;
				
				if ( $count == $this->count_limit )
					break;
				
				// Get src of img html element.
				if ( $src = $node->getAttribute('src') ) {
					$img_data = @getimagesize( $src );
					if ( ! empty( $img_data ) && ! empty( $img_data[0] ) && ! empty( $img_data[1] ) ) {
						$width = intval( $img_data[0] );
						$height = intval( $img_data[1] );
						if ( $height >= $this->height_min && $height <= $this->height_limit
								&& $width >= $this->width_min && $width <= $this->width_limit ) {
							$arr_src[] = $src;
							$count++;
						}
					}
				}
			}
			
		}
		return $arr_src;
	}
	
}