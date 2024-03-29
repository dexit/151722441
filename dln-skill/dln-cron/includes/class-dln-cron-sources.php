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
		add_action( 'init', array( $this, 'crawl_post' ) );
	}
	
	public function crawl_post() {
		if ( ! isset( $_GET['dln_crawl_post'] ) ) return;
		
		include_once( DLN_SKILL_PLUGIN_DIR . '/dln-cron/includes/posts/class-dln-post-helper.php' );
		
		$sources = DLN_Post_Helper::get_post_link( 100 );
		
		if ( ! empty( $sources ) ) {
			foreach ( $sources as $i => $source ) {
				if ( isset( $source['link'] ) && ! empty( $source['link'] ) ) {
					DLN_Post_Helper::fetch_image_post( $source['post_id'], $source['link'], $source['comment_fbid'] );
				}
			}
		}
	}
	
	public function crawl_source() {
		if ( ! isset( $_GET['dln_crawl_source'] ) ) return;
		
		include_once( DLN_SKILL_PLUGIN_DIR . '/dln-cron/includes/libraries/rss_php/rss_php.php' );
		include_once( DLN_SKILL_PLUGIN_DIR . '/dln-cron/includes/sources/class-dln-source-helper.php' );
		
		// Get source link
		$sources = self::get_source_link( 10 );
		
		if ( empty( $sources ) ) {
			self::reset_crawl_count();
			$sources = self::get_source_link( 10 );
		}
		
		if ( ! empty( $sources ) ) {
			// Process folder ids
			$term_ids = array();
			foreach ( $sources as $i => $source ) {
				if ( isset( $source['term_id'] ) ) {
					$term_ids[] = $source['term_id'];
				}
			}
			$folders = self::get_folders_by_source_id( $term_ids );
			foreach ( $sources as $i => $source ) {
				if ( isset( $source['link'] ) && $source['link'] ) {
					self::process_crawl_data( $source['link'], $source['term_id'], $folders );
				}
			}
		}
		die();
	}
	
	private static function process_crawl_data( $rss_link , $term_id, $folders ) {
		if ( ! $rss_link || ! $term_id ) return;
		
		$data = DLN_Source_Helper::load_rss_link( $rss_link );
		//$data = DLN_Source_Helper::load_google_feed_rss( $rss_link );
		
		// get links added in db
		$hashes     = $data['hash'];
		$posts      = $data['post']; 
		$arr_urls   = $data['urls'];
		
		$arr_url      = parse_url( esc_url( $rss_link ) );
		$site         = isset( $arr_url['host'] ) ? $arr_url['host'] : '';
		$hashes_added = self::get_post_link_added( $site, $hashes );
		
		// Exclude links added
		$post_added_ids = array();
		if ( ! empty( $hashes_added ) ) {
			$arr_new_posts = array();
			foreach ( $posts as $i => $post ) {
				foreach ( $hashes_added as $j => $hash ) {
					if ( isset( $hash['hash'] ) && $post->hash == $hash['hash'] ) {
						unset( $posts[$i] );
						$post_added_ids[] = $hash['post_id'];
					}
				}
			}
			$arr_new_posts = array_merge( $posts );
			$posts         = $arr_new_posts;
		}
		
		// Add relation for post and source
		self::add_relate_post_source( $post_added_ids, $term_id );
		
		// Re-validate url
		foreach ( $posts as $i => $post ) {
			if ( ! self::is_valid_url( $post->link ) ) {
				unset( $posts[$i] );
			}
		}
		
		// Assign facebook information for posts
		$links      = ! empty( $arr_urls ) ? implode( "','", $arr_urls ) : '';
		if ( $links ) {
			$fql        = urlencode( "SELECT url, normalized_url, total_count, share_count, like_count, comment_count, comments_fbid FROM link_stat WHERE url IN ('{$links}')" );
			$app_id     = FB_APP_ID;
			$app_secret = FB_SECRET;

			$jfb_object = json_decode( file_get_contents_curl( "https://graph.facebook.com/fql?q={$fql}&access_token={$app_id}|{$app_secret}" ), false, 512, JSON_BIGINT_AS_STRING );
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
			$arr_post_ids = array();
			foreach ( $posts as $i => $post ) {
				// Get published date use google news api
				if ( $post->title ) {
					//$post = DLN_Source_Helper::load_google_news( $post->title, $post->link, $post );
					// Get image use google images api
					//if ( empty( $post->image ) ) {
						//$post    = DLN_Source_Helper::load_google_images( $post->title, $post->link, $post );
						$post_id = self::insert_post_link( $post, $term_id, $folders );
						if ( $post_id ) {
							// Insert to dln_post_link
							$link         = esc_url( $post->link );
							$arr_url      = parse_url( $link );
							$site         = isset( $arr_url['host'] ) ? $arr_url['host'] : '';
							$hash         = DLN_Cron_Helper::generate_hash( $link );
							$data = array(
								'post_id'      => $post_id,
								'site'         => $site,
								'link'         => $link,
								'hash'         => $hash,
								'time_create'  => date( 'Y-m-d H:i:s' ),
								'total_count'  => $post->total_count,
								'comment_fbid' => $post->comments_fbid,
							);
							self::insert_dln_post_link( $data );
							$arr_post_ids[] = $post_id;
						}
					//}
				}
			}
			self::add_relate_post_source( $arr_post_ids, $term_id );
		}
		
		// Update crawl count source link
		$crawl_count = 1;
		$data = array(
			'crawl' => $crawl_count
		);
		self::update_source_link( $data, $term_id );
		
		var_dump( $posts, date( 'Y-m-d H:i:s' ) );
	}
	
	private static function is_valid_url( $url = '' ) {
		if ( ! $url ) return false;
		
		return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
	}
	
	public static function update_source_link( $data, $term_id ) {
		if ( empty( $data ) ) return;
		
		global $wpdb;
		$result = $wpdb->update( $wpdb->dln_source_link, $data, array( 'term_id' => $term_id ) );
		
		return $result;
	}
	
	public static function insert_post_link( $data = array(), $term_id = '', $folders ) {
		if ( empty( $data ) || empty( $term_id ) ) return;
		
		$terms = array_map( 'intval', array( $term_id ) );
		// Process folder term 
		$arr_folders = array();
		if ( ! empty( $folders ) ) {
			foreach ( $folders as $i => $folder ) {
				if ( isset( $folder['source_id'] ) && $folder['source_id'] == $term_id ) {
					$arr_folders[] = intval( $folder['folder_id'] );
				}
			}
		}
		$post  = array(
			'post_title'     => $data->title,
			'post_name'      => sanitize_title( $data->title ),
			'post_content'   => $data->content,
			'post_type'      => 'dln_article',
			'post_status'    => 'pending',
			'comment_status' => 'open',
			'tax_input'      => array(
				'dln_source' => $terms,
				'dln_folder' => $arr_folders
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
		if ( ! empty( $data->publishedDate ) ) {
			update_post_meta( $post_id, 'dln_publish_date', $data->publishedDate );
		}
		if ( ! empty( $data->image ) ) {
			update_post_meta( $post_id, 'dln_image', $data->image );
		}
		//if ( ! empty( $data->categories ) ) {
		//	update_post_meta( $post_id, 'dln_category', implode( ',', $data->categories ) );
		//}
		if ( ! empty( $data->share_count ) ) {
			update_post_meta( $post_id, 'dln_share_count', $data->share_count );
		}
		if ( ! empty( $data->like_count ) ) {
			update_post_meta( $post_id, 'dln_like_count', $data->like_count );
		}
		if ( ! empty( $data->comment_count ) ) {
			update_post_meta( $post_id, 'dln_comment_count', $data->comment_count );
		}
		if ( ! empty( $data->link ) ) {
			update_post_meta( $post_id, 'dln_link', $data->link );
		}
		if ( ! empty( $data->total_count ) ) {
			update_post_meta( $post_id, 'dln_total_count', $data->total_count );
		}
		
		return $post_id;
	}
	
	private static function get_post_link_added( $site = '', $hashes = '' ) {
		if ( ! $site || ! $hashes ) return;
		
		$str_hashes = '';
		if ( ! empty( $hashes ) ) {
			$str_hashes = implode( "','", $hashes );
		}
		
		global $wpdb;
		$sql    = $wpdb->prepare( "SELECT post_id, hash FROM {$wpdb->dln_post_link} WHERE site = %s AND hash IN ( '{$str_hashes}' )", $site );
		
		$result = $wpdb->get_results( $sql, ARRAY_A );
		return $result;
	}
	
	private static function add_relate_post_source( $arr_post_ids = array(), $term_id = '' ) {
		if ( ! is_array( $arr_post_ids ) || ! $term_id ) return false;
		
		$str_post_ids = '';
		if ( ! empty( $arr_post_ids ) ) {
			$str_post_ids = implode( "','", $arr_post_ids );
		}
		
		global $wpdb;
		$sql    = $wpdb->prepare( "SELECT post_id FROM {$wpdb->dln_source_post} WHERE source_id = %d AND post_id IN ( '{$str_post_ids}' )", $term_id );
		$posts  = $wpdb->get_results( $sql, ARRAY_A );
		
		if ( ! empty( $posts ) ) {
			foreach ( $arr_post_ids as $i => $post_id ) {
				foreach ( $posts as $j => $post ) {
					if ( isset( $post['post_id'] ) && $post_id == $post['post_id'] ) {
						unset( $arr_post_ids[$i] );
					}
				}
			}
		}
		
		if ( ! empty( $arr_post_ids ) ) {
			foreach( $arr_post_ids as $i => $post_id ) {
				$data = array(
					'source_id' => $term_id,
					'post_id'   => $post_id
				);
				$wpdb->insert( $wpdb->dln_source_post, $data );
			}
		}
		
	}
	
	public static function insert_dln_post_link( $data = array() ) {
		if ( ! is_array( $data ) ) return false;
		
		global $wpdb;
		$result_id = $wpdb->insert( $wpdb->dln_post_link, $data );
		
		return $result_id;
	}
	
	private static function get_folders_by_source_id( $term_ids = array() ) {
		if ( empty( $term_ids ) ) return false;
		
		global $wpdb;
		$str_term_ids = implode( "','", $term_ids );
		$sql    = $wpdb->prepare( "SELECT source_id, folder_id FROM {$wpdb->dln_source_folder} WHERE source_id IN ('{$str_term_ids}') AND 1 = %d", 1 );
		$result = $wpdb->get_results( $sql, ARRAY_A );
		
		return $result;
	}
	
	private static function get_source_link( $limit = 10 ) {
		global $wpdb;
		if ( ! $limit ) return;
		
		$sql    = $wpdb->prepare( "SELECT link, term_id FROM {$wpdb->dln_source_link} WHERE enable = %d AND crawl = %d ORDER BY crawl, priority ASC LIMIT 0, %d", 1, 0,  ( int ) esc_sql( $limit ) );
		$result = $wpdb->get_results( $sql, ARRAY_A );
		
		return $result; 
	}
	
	private static function reset_crawl_count() {
		global $wpdb;
		
		$sql = $wpdb->prepare( "UPDATE {$wpdb->dln_source_link} SET crawl = %d WHERE 1 = 1", 0 );
		$wpdb->query( $sql );
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