<?php
if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');

class DLN_Helper_Google {
	
	private static $instance;
	
	public function get_instance() {
		if( !self::$instance instanceof self ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	
	public function __construct() { }
	
	public function insert_google_map( $item ) {
		$itemId = $item['pk_i_id'];
		$aItem  = Item::newInstance()->findByPrimaryKey($itemId);
		
		$address = osc_sanitize_name( strip_tags( trim( Params::getParam('dln_address') ) ) );
		$lat     = strip_tags( trim( Params::getParam('dln_lat') ) );
		$long    = strip_tags( trim( Params::getParam('dln_long') ) );
		$city    = strip_tags( trim( Params::getParams('dln_city') ) );
		$country = strip_tags( trim( Params::getParams('dln_country') ) );
		
		ItemLocation::newInstance()->update(
			array(
				's_address'    => $address,
				'd_coord_lat'  => $lat,
				'd_coord_long' => $long
		), array( 'fk_i_item_id' => $itemId ) );
	}
	
	public function load_google_map() {
		DLN_Classified::get_view( 'field-google' );
	}
	
}