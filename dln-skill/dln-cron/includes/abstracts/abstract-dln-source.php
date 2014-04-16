<?php

if ( ! defined( 'WPINC' ) ) { die; }

abstract class DLN_Source {

	public static $xpath = '';
	public static $file = 'crawl.log.html';
	
	public static function write_log( $log = '' ) {
		if ( ! $log )
			return;
		$log = $log . "\n";
		$path = DLN_SKILL_PLUGIN_DIR . "/dln-cron/logs/" . self::$file;
		$file = fopen( $path, 'a+' );
		fwrite( $file, $log );
		fclose( $file );
	}
	
	public static function get_nodes( $rss_url = '' ) {
		if ( ! $rss_url )
			return;
		
		if ( ! self::check_url( $rss_url ) )
			return;
		
		if (!($x = simplexml_load_file( $rss_url )))
            return;

		return $x;
	}
	
	public static function check_exist_ids( $arr_ids, $source_type ) {
		global $wpdb;
		// Check id exists in db
		$str_ids = ( count( $arr_ids ) > 0 ) ? implode( $arr_ids, ',' ) : '';
		$sql     = "SELECT host_id FROM {$wpdb->prefix}dln_crawl_links WHERE site = '" . $source_type . "' AND host_id IN ({$str_ids})";
		$results = $wpdb->get_col( $sql );
		if ( $results ) {
			foreach ( $results as $i => $item ) {
				if ( $item ) {
					$idx = array_search( $item, $arr_ids );
					unset( $arr_ids[$idx] );
				}
			}
		}
		
		return $arr_ids;
	}
	
	public static function insert_links_to_db( $arr_objs, $arr_ids, $current_time ) {
		global $wpdb;
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
	
	private static function check_url( $html ){
		return $result = preg_replace(
			'%\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/)))%s',
			'<a href="$1">$1</a>',
			$html
		);
	}
	
}
