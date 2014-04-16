<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Source_VietnamNet extends DLN_Source {
	
	public static $source_type = 'viet-nam-net';
	
	function __construct() {
		
	}
	
	public static function init() {
		self::get_links();
	}
	
	public static function get_links() {
		global $wpdb;
		
		$nodes = self::get_nodes( 'http://vietnamnet.vn/rss/home.rss' );
		if ( $nodes ) {
			$arr_ids = $arr_objs = array();
			foreach ($nodes->channel->item as $item) {
				$link     = $item->link->__toString();
				preg_match_all('/(\d+)\/([^A-Za-z0-9-]+).html/', $link, $matches);
				var_dump($matches);
				$id       = isset( $matches[1][0] ) ? $matches[1][0] : 0;
				if ( ! in_array( $id, $arr_ids ) ) {
					$arr_ids[] = $id;
					$obj_item                = array();
					$obj_item['link']        = trim( $link );
					$obj_item['host_id']     = trim( $id );
					$obj_item['site']        = self::$source_type;
					$obj_item['is_crawl']    = '0';
					$obj_item['time_create'] = date( 'Y-m-d H:i:s', time() );
					$arr_objs[]              = $obj_item;
				}
			}
			
			//$current_time = date( 'Y-m-d H:i:s', time() );
			//$arr_ids = self::check_exist_ids( $arr_ids, self::$source_type );
			//self::insert_links_to_db( $arr_objs, $arr_ids, $current_time );
		}
	}
}