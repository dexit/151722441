<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Cron_Sources {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		//add_action( 'init', array( $this, 'crawl_process' ) );
		add_action( 'init', array( $this, 'crawl_source' ) );
	}
	
	public function crawl_source() {
		if ( ! isset( $_GET['dln_crawl_source'] ) ) return;
		
		include( DLN_SKILL_PLUGIN_DIR . '/dln-cron/includes/sources/class-dln-source-helper.php' );
		
		// Get source link
		$sources = self::get_source_link( 10 );
		if ( ! empty( $sources ) ) {
			foreach ( $sources as $i => $source ) {
				if ( isset( $source['link'] ) && $source['link'] ) {
					self::process_crawl_data( $source['link'] );
				}
			}
		}
	}
	
	private static function process_crawl_data( $link ) {
		$data = DLN_Source_Helper::load_google_feed_rss( $link );
		// get links added in db
		$hashes     = $data['hash'];
		$posts      = $data['post']; 
		$str_hashes = '';
		if ( ! empty( $hashes ) ) {
			$str_hashes = implode( ',', $hashes );
		}
		$arr_url = parse_url( esc_url( $link ) );
		$site    = isset( $arr_url['host'] ) ? $arr_url['host'] : '';
		$hashes_added = self::get_post_link_added( $site, $str_hashes );
		
		// Exclude links added
		if ( ! empty( $hashes_added ) ) {
			$arr_new_posts = array();
			foreach ( $posts as $i => $post ) {
				foreach ( $hashes_added as $j => $hash ) {
					if ( isset( $hash['hash'] ) && $post->hash == $hash['hash'] ) {
						unset( $posts[$i] );
					}
				}
			}
			$arr_new_posts = array_merge( $posts );
			$posts         = $arr_new_posts;
		}
		
		if ( ! empty( $posts ) ) {
			foreach ( $posts as $i => $post ) {
				// Get published date use google news api
				if ( $post->title ) {
					$data = DLN_Source_Helper::load_google_news( $post->title, $post->link, $post );
					// Get image use google images api
					//if ( empty( $post->image ) ) {
					//	$data = DLN_Source_Helper::load_google_images( $post->title, $post->link, $post );
						//var_dump( $data );
					//}
				}
			}
		}
	}
	
	public static function get_post_link_added( $site = '', $hashes = '' ) {
		global $wpdb;
		if ( ! $site || ! $hashes ) return;
		
		$sql    = $wpdb->prepare( "SELECT hash FROM {$wpdb->dln_post_link} WHERE site = %s AND hash IN ( %s )", $site, $hashes );
		$result = $wpdb->get_results( $sql, ARRAY_A );
		return $result;
	}
	
	public static function get_source_link( $limit = 10 ) {
		global $wpdb;
		if ( ! $limit ) return;
		
		$sql    = $wpdb->prepare( "SELECT link FROM {$wpdb->dln_source_link} ORDER BY crawl, priority ASC LIMIT 0, %d", ( int ) esc_sql( $limit ) );
		$result = $wpdb->get_results( $sql, ARRAY_A );
		
		return $result; 
	}	
	
	public function crawl_process() {
		if ( ! isset( $_GET['dln_crawl_news'] ) || ! isset( $_GET['dln_crawl_source'] ) )
			return;

		if ( ! ( $crawl_source = $_GET['dln_crawl_source'] ) ) 
			return;
		
		if ( ! class_exists( 'DLN_Source' ) ) 
			include( 'abstracts/abstract-dln-source.php' );
		
		$arr_sources = explode( ',', $crawl_source );
		foreach ( $arr_sources as $i => $source ) {
			$source_class = 'DLN_Source_' . str_replace( '-', '_', $source );
			$source_file  = DLN_SKILL_PLUGIN_DIR . '/dln-cron/includes/sources/class-dln-source-' . $source . '.php';
			
			if ( class_exists( $source_class ) )
				return $source_class;

			if ( ! file_exists( $source_file ) )
				return false;
			
			if ( ! class_exists( $source_class ) )
				include $source_file;
			
			// Init the source
			$source_class::get_instance();
		}
		
	}
	
}

DLN_Cron_Sources::get_instance();