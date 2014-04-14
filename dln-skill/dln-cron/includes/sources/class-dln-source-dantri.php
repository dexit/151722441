<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Source_Dantri extends DLN_Source {
	
	function __construct() {
		
	}
	
	public static function init() {
		self::get_links();
	}
	
	public static function get_links() {
		
		$nodes = self::get_nodes( 'http://dantri.com.vn/trangchu.rss' );
		var_dump($nodes);
		if ( $nodes ) {
			foreach ($nodes->channel->item as $item) {
				$link = $item->link->__toString();
				preg_match_all('/-(\d+).htm/', $link, $matches);
				var_dump($link, $matches);
			}
		}
		
	}
}