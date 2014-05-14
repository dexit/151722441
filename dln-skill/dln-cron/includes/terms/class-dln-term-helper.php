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
	
	public static function get_term_folder() {
		global $wpdb;
		
		$terms = get_terms( 'dln_folder', array(
			'orderby'    => 'count',
			'order'      => 'DESC',
			'hide_empty' => false
		) );
		
		if ( ! $terms )
			return '';
		
		// Process count source
		$arr_ids = array();
		foreach( $terms as $i => $term ) {
			if ( $term->term_id && ! in_array( $term->term_id, $arr_ids ) ) {
				$arr_ids[] = $term->term_id;
			}
		}
		$ids    = ( ! empty( $arr_ids ) ) ? implode( ',', $arr_ids ) : '';
		$sql    = $wpdb->prepare( "SELECT folder_id, COUNT(source_id) AS count_source FROM $wpdb->dln_source_folder WHERE folder_id IN ( %s ) GROUP BY folder_id", esc_sql( $ids ) );
		$result = $wpdb->get_results( $sql, ARRAY_A );
		if ( ! empty( $result ) ) {
			foreach( $terms as $i => $term ) {
				foreach ( $result as $j => $obj ) {
					if ( isset( $obj['folder_id'] ) && $obj['folder_id'] == $term->term_id ) {
						$terms[$i]->count_source = ( isset( $obj['count_source'] ) ) ? $obj['count_source'] : 0;
					}
				}
			}
		}
		
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
	
		$sql    = $wpdb->prepare( "SELECT * FROM {$wpdb->dln_source_folder} AS sfolder WHERE sfolder.source_id = %d", (int) esc_sql( $source_id ) );
		$return = $wpdb->get_row( $sql, ARRAY_A );
	
		return $return;
	}
	
	public static function select_folder_name( $source_id = '' ) {
		global $wpdb;
		if ( ! $source_id )
			return '';
		$sql = $wpdb->prepare( "SELECT term.name AS folder_name 
								FROM {$wpdb->dln_source_folder} AS sfolder 
								INNER JOIN {$wpdb->terms} AS term 
								ON term.term_id = sfolder.folder_id
								WHERE sfolder.source_id = %d", (int) esc_sql( $source_id ) );
		$return = $wpdb->get_results( $sql, ARRAY_A );
		return $return;
	}
	
}

DLN_Term_Helper::get_instance();