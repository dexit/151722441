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
		if ( $nodes ) {
			$arr_ids = array();
			foreach ($nodes->channel->item as $item) {
				$link     = $item->link->__toString();
				preg_match_all('/-(\d+).htm/', $link, $matches);
				$id       = isset( $matches[1][0] ) ? $matches[1][0] : 0;
				if ( ! in_array( $id, $arr_ids ) ) {
					$arr_ids[] = $id;
				}
				$obj_item       = new stdClass;
				$obj_item->link = $link;
				$obj_item->id   = $id;
			}
		}
		
	}
}