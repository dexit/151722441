<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Source_Dantri extends DLN_Source {
	
	public static $source_type = 'dan-tri';
	
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
					$obj_item                = array();
					$obj_item['link']        = trim( $link );
					$obj_item['host_id']     = trim( $id );
					$obj_item['site']        = self::$source_type;
					$obj_item['is_crawl']    = '0';
					$obj_item['time_create'] = date( 'Y-m-d H:i:s', time() );
					$arr_objs[]              = $obj_item;
				}
			}
			
			// Check id exists in db
			$current_time = date( 'Y-m-d H:i:s', time() );
			$str_ids = ( count( $arr_ids ) > 0 ) ? implode( $arr_ids, ',' ) : '';
			$sql     = "SELECT host_id FROM {$wpdb->prefix}dln_crawl_links WHERE site = '" . self::$source_type . "' AND host_id IN ({$str_ids})";
			$results = $wpdb->get_col( $sql );
			if ( $results ) {
				foreach ( $results as $i => $item ) {
					if ( $item ) {
						$idx = array_search( $item, $arr_ids );
						unset( $arr_ids[$idx] );
					}
				}
			}
			
			// Insert link to db
			if( count( $arr_objs ) && count( $arr_ids ) ) {
				foreach ( $arr_objs as $i => $obj ) {
					if ( in_array( $obj['host_id'], $arr_ids ) ) {
						$int = $wpdb->insert(
							$wpdb->prefix . 'dln_crawl_links',
							$obj
						);
						if ( $int ) {
							self::write_log( 'Completed insert <b>id</b> of crawl link in Database: ' . $obj['host_id'] . ' - ' . $obj['link'] . '  at time ' . $current_time . '<br />' );
						} else {
							self::write_log( 'Error insert <b>id</b> of crawl link in Database: ' . $obj['host_id'] . ' at time ' . $current_time . '<br />' );
						}
					}
				}
			}
		}
	}
}