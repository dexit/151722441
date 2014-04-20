<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Source_TCCL extends DLN_Source {
	
	public static $instance;
	public $source_type = 'tccl';
	public $rss_url     = 'http://tccl.info/feed/';
	public $html_url    = 'http://tccl.info/';
	public $regex       = '/\/([a-z0-9]+)\//';
	public $type_crawl  = 'html';
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		parent::__construct();
	}
	
	public static function check_exist_ids( $arr_ids, $source_type) {
		// process md5 id
		foreach( $arr_ids as $i => $id ) {
			$arr_ids[$i] = md5( $id );
		}
		parent::check_exist_ids($arr_ids, $source_type);
	}
	
	public static function insert_links_to_db( $arr_objs, $arr_ids, $current_time ) {
		// process md5 id
		foreach ( $arr_objs as $i => $obj ) {
			if ( isset( $obj['host_id'] ) ) {
				$obj['host_id'] = md5( $obj['host_id'] );
				$arr_objs[$i] = $obj;
			}
		}
		parent::insert_links_to_db( $arr_objs, $arr_ids, $current_time );
	}
	
}