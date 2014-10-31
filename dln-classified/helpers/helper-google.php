<?php
if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');

class DLN_Helper_Google {
	
	private static $instance;
	
	public function new_instance() {
		if( !self::$instance instanceof self ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	
	public function __construct() { }
	
	public function insert_google_map( $item ) {
		$item_id  = $item['pk_i_id'];
		$arr_item = Item::newInstance()->findByPrimaryKey( $item_id );
		$address  = ( isset( $arr_item['s_address'] ) ) ? $arr_item['s_address'] : '';
		$city     = ( isset( $arr_item['s_city'] ) ) ? $arr_item['s_city'] : '';
		$region   = ( isset( $arr_item['s_region'] ) ) ? $arr_item['s_region'] : '';
		$country  = ( isset( $arr_item['s_country'] ) ) ? $arr_item['s_country'] : '';
		
		
		
	}
	
}