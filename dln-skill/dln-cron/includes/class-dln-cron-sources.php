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
		
		include_once( DLN_SKILL_PLUGIN_DIR . '/dln-cron/includes/libraries/rss_php/rss_php.php' );
		include_once( DLN_SKILL_PLUGIN_DIR . '/dln-cron/includes/sources/class-dln-source-helper.php' );
		
		// Get source link
		$sources = self::get_source_link( 10 );
		if ( ! empty( $sources ) ) {
			foreach ( $sources as $i => $source ) {
				if ( isset( $source['link'] ) && $source['link'] ) {
					self::process_crawl_data( $source['link'], $source['term_id'], $source['crawl'] );
				}
			}
		}
		die();
	}
	
	private static function process_crawl_data( $rss_link , $term_id, $crawl_count = 0 ) {
		if ( ! $rss_link || ! $term_id ) return;
		
		$data = DLN_Source_Helper::load_rss_link( $rss_link );
		
		// get links added in db
		$hashes     = $data['hash'];
		$posts      = $data['post']; 
		$arr_urls   = $data['urls'];
		
		$str_hashes = '';
		if ( ! empty( $hashes ) ) {
			$str_hashes = implode( ',', $hashes );
		}
		$arr_url      = parse_url( esc_url( $rss_link ) );
		$site         = isset( $arr_url['host'] ) ? $arr_url['host'] : '';
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
		
		// Assign facebook information for posts
		$links      = ! empty( $arr_urls ) ? implode( "','", $arr_urls ) : '';
		if ( $links ) {
			$fql        = urlencode( "SELECT url, normalized_url, total_count, share_count, like_count, comment_count, comments_fbid FROM link_stat WHERE url IN ('{$links}')" );
			$app_id     = FB_APP_ID;
			$app_secret = FB_SECRET;

			$jfb_object = json_decode( self::file_get_contents_curl( "https://graph.facebook.com/fql?q={$fql}&access_token={$app_id}|{$app_secret}" ), false, 512, JSON_BIGINT_AS_STRING );
			if ( ! empty( $jfb_object ) && isset( $jfb_object->data ) ) {
				foreach ( $posts as $i => $post ) {
					foreach( $jfb_object->data as $j => $fb_obj ) {
						if ( $post->link == $fb_obj->url ) {
							$posts[$i]->total_count   = $fb_obj->total_count;
							$posts[$i]->share_count   = $fb_obj->share_count;
							$posts[$i]->like_count    = $fb_obj->like_count;
							$posts[$i]->comment_count = $fb_obj->comment_count;
							$posts[$i]->comments_fbid = $fb_obj->comments_fbid;
						}
					}
				}
			}
		}
		if ( ! empty( $posts ) ) {
			foreach ( $posts as $i => $post ) {
				// Get published date use google news api
				if ( $post->title ) {
					//$post = DLN_Source_Helper::load_google_news( $post->title, $post->link, $post );
					// Get image use google images api
					//if ( empty( $post->image ) ) {
						//$post    = DLN_Source_Helper::load_google_images( $post->title, $post->link, $post );
						$post_id = self::insert_post_link( $post, $term_id );
						if ( $post_id ) {
							// Insert to dln_post_link
							$link         = esc_url( $post->link );
							$arr_url      = parse_url( $link );
							$site         = isset( $arr_url['host'] ) ? $arr_url['host'] : '';
							$hash         = DLN_Cron_Helper::generate_hash( $link );
							$data = array( 
								'post_id'     => $post_id,
								'site'        => $site,
								'link'        => $link,
								'hash'        => $hash,
								'time_create' => date( 'Y-m-d H:i:s' ),
								'total_count' => $post->total_count,
							);
							self::insert_dln_post_link( $data );
						}
					//}
				}
			}
			
			// Update crawl count source link
			$crawl_count = intval( $crawl_count ) + 1;
			$data = array( 
				'crawl' => $crawl_count
			);
			self::update_source_link( $data, $term_id );
		}
		var_dump($posts);
	}
	
	public static function update_source_link( $data, $term_id ) {
		if ( empty( $data ) ) return;
		
		global $wpdb;
		$result = $wpdb->update( $wpdb->dln_source_link, $data, array( 'term_id' => $term_id ) );
		
		return $result;
	}
	
	public static function insert_post_link( $data = array(), $term_id = '' ) {
		if ( empty( $data ) || empty( $term_id ) ) return;
		
		$terms = array_map( 'intval', array( $term_id ) );
		$post  = array(
			'post_title'     => $data->title,
			'post_name'      => sanitize_title( $data->title ),
			'post_content'   => $data->description,
			'post_type'      => 'dln_article',
			'post_status'    => 'pending',
			'comment_status' => 'open',
			'tax_input'      => array(
				'dln_source' => $terms
			)
		);
		$post_id = wp_insert_post( $post, true );
		
		if ( is_wp_error( $post_id ) ) {
			echo $post_id->get_error_message();
			die();
		}
		
		if ( empty( $post_id ) )
			return $post_id;
		
		// Update post meta
		if ( ! empty( $data->publishDate ) ) {
			update_post_meta( $post_id, 'dln_publish_date', $data->publishDate );
		}
		if ( ! empty( $data->category ) ) {
			update_post_meta( $post_id, 'dln_category', $data->category );
		}
		if ( ! empty( $data->share_count ) ) {
			update_post_meta( $post_id, 'dln_share_count', $data->share_count );
		}
		if ( ! empty( $data->like_count ) ) {
			update_post_meta( $post_id, 'dln_like_count', $data->like_count );
		}
		if ( ! empty( $data->comment_count ) ) {
			update_post_meta( $post_id, 'dln_comment_count', $data->comment_count );
		}
		if ( ! empty( $data->comments_fbid ) ) {
			update_post_meta( $post_id, 'dln_comments_fbid', $data->comments_fbid );
		}
		
		return $post_id;
	}
	
	public static function get_post_link_added( $site = '', $hashes = '' ) {
		if ( ! $site || ! $hashes ) return;
		
		global $wpdb;
		$sql    = $wpdb->prepare( "SELECT hash FROM {$wpdb->dln_post_link} WHERE site = %s AND hash IN ( %s )", $site, $hashes );
		$result = $wpdb->get_results( $sql, ARRAY_A );
		return $result;
	}
	
	public static function insert_dln_post_link( $data = array() ) {
		if ( ! is_array( $data ) ) return false;
		
		global $wpdb;
		$result_id = $wpdb->insert( $wpdb->dln_post_link, $data );
		
		return $result_id;
	}
	
	public static function get_source_link( $limit = 10 ) {
		global $wpdb;
		if ( ! $limit ) return;
		
		$sql    = $wpdb->prepare( "SELECT link, term_id, crawl FROM {$wpdb->dln_source_link} ORDER BY crawl, priority ASC LIMIT 0, %d", ( int ) esc_sql( $limit ) );
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
	
	public static function file_get_contents_curl( $url = '' ) {
		if ( ! $url ) return false;
		
		$agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, $agent);
		curl_setopt($ch, CURLOPT_URL,$url);
		$result=curl_exec($ch);
	
		return $result;
	}
	
}

DLN_Cron_Sources::get_instance();