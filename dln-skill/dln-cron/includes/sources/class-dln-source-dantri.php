<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Source_Dantri extends DLN_Source {
	
	function __construct() {
		
	}
	
	public static function init() {
		
	}
	
	public static function get_links() {
		if ( ! self::$xpath ) 
			self::load_rss_source( 'http://dantri.com.vn/trangchu.rss' );
		$nodes = self::get_nodes( '//channel/item/link' );
		foreach ( $nodes as $i => $node ) {
			var_dump( $node );
		}
	}
	
}