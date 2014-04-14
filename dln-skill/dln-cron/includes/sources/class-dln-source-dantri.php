<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Source_Dantri extends DLN_Source {
	
<<<<<<< HEAD
=======
	function __construct() {
		
	}
	
>>>>>>> f603692674b54ff7b82ac4a52fca73e9000e830e
	public static function init() {
		
	}
	
<<<<<<< HEAD
=======
	public static function get_links() {
		if ( ! self::$xpath ) 
			self::load_rss_source( 'http://dantri.com.vn/trangchu.rss' );
		$nodes = self::get_nodes( '//channel/item/link' );
		foreach ( $nodes as $i => $node ) {
			var_dump( $node );
		}
	}
	
>>>>>>> f603692674b54ff7b82ac4a52fca73e9000e830e
}