<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Block_Cache {
	
	public static $instance;
	public static $cache_products;
	public static $cache_length = 1000;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() { }
	
	public static function clear_cache() {
		set_transient( 'dln_cache_status' , null );
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
			$cache_products = get_transient( 'dln_cache_status' );
			$cache_products = ( ! empty( $cache_products ) ) ? unserialize( $cache_products ) : null;
			if ( count( $cache_products ) >= self::$cache_length ) {
				array_shift( $cache_products );
			}
			$cache_products[] = $value_md5;
			if ( ! empty( $cache_products ) ) {
				set_transient( 'dln_cache_status' , serialize( $cache_products ) );
			}
			return true;
		}
	}
	
	private static function check_cache( $value ) {
		if ( empty( $value ) )
			return false;
		
		$result         = false;
		$cache_products = get_transient( 'dln_cache_status' );
		$cache_products = ( ! empty( $cache_products ) ) ? unserialize( $cache_products ) : null;
		if ( ! empty( $cache_products ) ) {
			foreach ( $cache_products as $i => $cache ) {
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
