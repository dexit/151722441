<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Helper_Source {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		
	}
	
	public static function add_source( $term_id = '0', $link = '', $type = '' ) {
		if ( ! $link || ! $type )
			return false;
		
		global $wpdb;
		
		$current_time = date( 'Y-m-d H:i:s' );
		$arr_data     = array(
			'term_id' => (int) $term_id,
			'link'    => $link,
			'type'   => $type
		);
		
		$source = self::select_source( $term_id );
		
		if ( $source ) {
			// Update
			$arr_data = array_merge(
				$arr_data,
				array( 'update_time' => $current_time, 'state' => '1' )
			);
			$result = $wpdb->update(
				$wpdb->dln_news_source,
				$arr_data,
				array( 'term_id' => $term_id )
			);
		} else {
			// Insert
			$arr_data = array_merge(
				$arr_data,
				array( 'start_time' => $current_time )
			);
			$result = $wpdb->insert( $wpdb->dln_news_source, $arr_data );
		}
		
		if ( is_wp_error( $result ) ) {
			return false;
		} else {
			return $result;
		}
	}
	
	public static function select_source( $term_id = '0' ) {
		if ( ! $term_id )
			return false;

		global $wpdb;
		$sql    = $wpdb->prepare( "SELECT id, link, type FROM {$wpdb->dln_news_source} WHERE term_id = %s", esc_sql( $term_id ) );
		$result = $wpdb->get_row( $sql );
		
		if ( is_wp_error( $result ) ) {
			return false;
		} else {
			return $result;
		}
	}
	
	public static function select_lastest( $limit = 1 ) {
		if ( ! $limit )
			return false;
		
		global $wpdb;
		
		$sql    = $wpdb->prepare( "SELECT id, link, type FROM {$wpdb->dln_news_source} WHERE state = 0 LIMIT 0, %d", (int) $limit );
		$result = $wpdb->get_results( $sql );
		
		if ( is_wp_error( $result ) ) {
			return false;
		} else {
			if ( is_array( $result ) && ! empty( $result ) ) {
				$ids = array();
				
				foreach ( $result as $i => $item ) {
					$ids[] = $item->id;
				}
				
				if ( $ids ) {
					$sql        = $wpdb->query( "UPDATE {$wpdb->dln_news_source} SET state = %s WHERE id IN (%s)", '1', implode( ',', $ids ) );
					$sql_result = $wpdb->query( $query );
				}
			} else {
				$sql_result = $wpdb->update( $wpdb->dln_news_source, array( 'state' => '0' ) );
			}
			
			if ( is_wp_error( $sql_result ) ) {
				var_dump( $sql_result->get_error_message() );
			}
			
			return $result;
		}
	}
	
	public static function validate_url( $url = '' ) {
		if ( ! $url )
			return false;
	
		$arr_data = array();
	
		extract( parse_url( $url ) );
	
		if ( empty( $scheme ) || empty( $host ) )
			return false;
	
		$host_url = $scheme . '://' . $host;
		$full_url = ( ! empty( $path ) ) ? $host_url . $path : $host_url;
		$full_url = ( ! empty( $query ) ) ? $full_url . $query : $full_url;
	
		return array( 'host' => $host_url, 'full' => $full_url );
	}

	public static function load_source_class( $source_name = '' ) {
		if ( ! $source_name )
			return false;
	
		// Now try to load the form_name
		$source_class = 'DLN_Source_' . str_replace( '-', '_', $source_name );
		$source_file  = DLN_NEW_PLUGIN_DIR . '/sources/source-' . $source_name . '.php';
	
		if ( class_exists( $source_class ) )
			return $source_class;
	
		if ( ! file_exists( $source_file ) )
			return false;
	
		if ( ! class_exists( $source_class ) )
			include $source_file;
	
		return $source_class;
	}
}

DLN_Helper_Source::get_instance();