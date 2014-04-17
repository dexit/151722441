<?php

if ( ! defined( 'WPINC' ) ) { die; }

abstract class DLN_Source {

	public static $xpath = '';
	public static $file  = 'crawl.log.html';
	public $source_type  = '';
	public $rss_url      = '';
	public $regex        = '';
	
	public function __construct() {
		$this->get_links();
		$this->get_hot_link();
	}
	
	public function get_links() {
		global $wpdb;
		
		$nodes    = self::get_nodes( $this->rss_url );
		if ( $nodes ) {
			$arr_ids = $arr_objs = array();
			foreach ($nodes->channel->item as $item) {
				$link     = $item->link->__toString();
				preg_match_all( $this->regex, $link, $matches );
				$id       = isset( $matches[1][0] ) ? $matches[1][0] : 0;
				if ( ! in_array( $id, $arr_ids ) ) {
					$arr_ids[] = $id;
					$obj_item                = array();
					$obj_item['link']        = trim( $link );
					$obj_item['host_id']     = trim( $id );
					$obj_item['site']        = $this->source_type;
					$obj_item['is_crawl']    = '0';
					$obj_item['time_create'] = date( 'Y-m-d H:i:s', time() );
					$arr_objs[]              = $obj_item;
				}
			}
				
			$current_time = date( 'Y-m-d H:i:s', time() );
			$arr_ids = self::check_exist_ids( $arr_ids, $this->source_type );
			self::insert_links_to_db( $arr_objs, $arr_ids, $current_time );
		}
	}
	
	public function get_hot_link() {
		
	}
	
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
