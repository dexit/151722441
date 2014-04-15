<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Source_Dantri extends DLN_Source {
	
	function __construct() {
		
	}
	
	public static function init() {
		self::get_links();
	}
	
	public static function get_links() {
		global $wpdb;
		
		$nodes = self::get_nodes( 'http://dantri.com.vn/trangchu.rss' );
		if ( $nodes ) {
			$arr_ids = $arr_objs = array();
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
				$arr_objs[] = $obj_item;
			}
			
			// Check id exists in db
			$arr_ids = ( count( $arr_ids ) > 0 ) ? implode( $arr_ids, ',' ) : '';
			$sql     = "SELECT id FROM {$wpdb->prefix}dln_crawl_links WHERE id IN ({$arr_ids})";
			$results = $wpdb->get_row( $sql );
			if ( $results ) {
				foreach ( $results as $i => $item ) {
					self::write_log( 'Duplicate <b>id</b> of crawl link in Database: ' . $item['id'] . '<br />' );
				}
			}
			
			// Insert link to db
			$wpdb->insert( 
				$wpdb->prefix . 'dln_crawl_links',
				array(
					'link' => ''
				)
			);
		}
	}
}