<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Term_Helper {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	public static function generate_hash( $url = '' ) {
		if ( ! $url )
			return '';
		$arr_url = parse_url( $url );
		$hash    = md5( $arr_url['host'] . '|' . $arr_url['path'] );
		
		return $hash;
	}
	
	public static function get_term_folder() {
		$terms = get_terms( 'dln_folder', array(
			'orderby'    => 'count',
			'order'      => 'DESC',
			'hide_empty' => false
		) );
		
		if ( ! $terms )
			return '';
	
		return $terms;
	}
	
	public static function get_selected_folder( $term_id = '' ) {
		global $wpdb;
		if ( empty( $term_id ) ) 
			return;
		
		$source_folder = self::select_source_folder( $term_id );
		
		return isset( $source_folder['folder_id'] ) ? $source_folder['folder_id'] : ''; 
	}
	
	public static function select_source_folder( $source_id = '' ) {
		global $wpdb;
		if ( empty( $source_id ) )
			return false;
	
		$sql    = $wpdb->prepare( "SELECT * FROM {$wpdb->dln_source_folder} AS sfolder WHERE sfolder.source_id = %d", $source_id );
		$return = $wpdb->get_row( $sql, ARRAY_A );
	
		return $return;
	}
	
}

DLN_Term_Helper::get_instance();