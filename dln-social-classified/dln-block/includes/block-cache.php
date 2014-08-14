<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Block_Cache {
	
	public static $instance;
	public static $cache_products;
	public static $cache_length = 2000;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() { }
	
	public static function clear_cache() {
		self::$cache_products = null;
	}
	
	public static function add_cache( $value ) {
		if ( empty( $value ) )
			return false;
		
		$value     = ( is_array( $value ) ) ? serialize( $value ) : $value;
		$value_md5 = md5( $value );
		
		if ( self::check_cache( $value_md5 ) ) {
			return false;
		} else {
			// Add cache
			if ( count( self::$cache_products >= self::$cache_length ) ) {
				array_shift( self::$cache_products );
			}
			self::$cache_products[] = $value_md5;
			return true;
		}
	}
	
	private static function check_cache( $value ) {
		if ( empty( $value ) )
			return false;
		
		$result = false;
		if ( ! empty( self::$cache_products ) ) {
			foreach ( self::$cache_products as $i => $cache ) {
				if ( $cache == $value ) {
					$result = true;
					break;
				}
			}
		}
		
		return $result;
	}
}

DLN_Block_Cache::get_instance();
