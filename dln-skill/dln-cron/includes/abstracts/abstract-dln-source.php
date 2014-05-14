<?php

if ( ! defined( 'WPINC' ) ) { die; }

abstract class DLN_Source {

	public static $file_log = 'crawl.log.html';
	public static $fb_log   = 'crawl-fb.log.html';
	public static $xpath    = '';
	public $source_type     = '';
	public $rss_url         = '';
	public $html_url        = '';
	public $regex           = '';
	public $type_crawl      = 'rss';
	
	public function __construct() {
		switch( $this->type_crawl ) {
			case 'rss':
				$this->get_links();
				$this->get_hot_link();
				break;
			case 'html':
				if ( $this->html_url ) {
					$dom  = new DOMDocument( '1.0', 'utf-8' );
					$html = self::file_get_contents_curl( $this->html_url );
					@$dom->loadHTML( $html );
					$xpath = new DOMXPath( $dom );
					$nodes = $xpath->query( '//div[@id="isofeatured"]/a' );
					var_dump($nodes, count( $nodes ));
					foreach( $nodes as $i => $node ) {
						var_dump($node->getAttribute('href'));
					}
				}
				break;
		}
		
	}
	
	public function get_links() {
		global $wpdb;
		
		$nodes    = self::get_nodes( $this->rss_url );
		if ( $nodes ) {
			$arr_ids = $arr_objs = array();
			
			foreach ( $nodes->getElementsByTagName( 'item' ) as $item) {
				$link     = $item->getElementsByTagName( 'link' )->item(0)->nodeValue;
				preg_match_all( $this->regex, $link, $matches );
				$id       = isset( $matches[1][0] ) ? $matches[1][0] : 0;
				if ( ! in_array( $id, $arr_ids ) ) {
					$arr_ids[] = $id;
					$obj_item                = array();
					$obj_item['link']        = trim( $link );
					$obj_item['host_id']     = trim( $id );
					$obj_item['site']        = $this->source_type;
					$obj_item['time_create'] = date( 'Y-m-d H:i:s', time() );
					$arr_objs[]              = $obj_item;
				}
			}
			
			$current_time = date( 'Y-m-d H:i:s', time() );
			$arr_ids = self::check_exist_ids( $arr_ids, $this->source_type );
			self::insert_links_to_db( $arr_objs, $arr_ids, $current_time );
		}
	}
	
	public function get_hot_link() {
		global $wpdb;
		
		// Get last 24h
		$last_time = time() - ( 24 * 60 * 60 );
		$last_time = date( 'Y-m-d H:i:s', $last_time );
		
		$sql = $wpdb->prepare(
			"SELECT *
			FROM {$wpdb->dln_crawl_links}
			WHERE time_create >= %s
			ORDER BY crawl ASC 
			LIMIT 50", $last_time
		);
		
		$items = $wpdb->get_results( $sql , ARRAY_A );
		
		$links = $ids = array();
		if ( ! empty( $items ) ) {
			foreach( $items as $i => $item ) {
				if ( isset( $item['link'] ) && ! in_array( $item['link'], $links ) ) {
					$links[] = $item['link'];
					$ids[]   = $item['host_id'];
				}
			}
		}
		$links      = implode( "','" , $links );
		$fql        = urlencode( "SELECT url, normalized_url, total_count, share_count, like_count, comment_count FROM link_stat WHERE url IN ('{$links}')" );
		$app_id     = FB_APP_ID;
		$app_secret = FB_SECRET;
		$content    = json_decode( file_get_contents( "https://graph.facebook.com/fql?q={$fql}&access_token={$app_id}|{$app_secret}" ) );
		if ( ! empty( $items ) && isset( $content->data ) ) {
			$arr_data = $content->data;
			if ( is_array( $arr_data ) ) {
				foreach ( $arr_data as $i => $data ) {
					foreach( $items as $j => $item ) {
						if (  $data->url == $item['link'] ) {
							$id            = $item['id'];
							$current_time  = date( 'Y-m-d H:i:s', time() );
							$item['crawl'] = $item['crawl'] + 1;
							unset( $item['id'] );
							$item['total_count'] = $data->total_count;
							$item['time_update'] = $current_time;
							
							$int = $wpdb->update( $wpdb->dln_crawl_links, $item, array( 'id' => $id ) );
							
							if ( $int ) {
								self::write_log( 'Completed update <b>id</b> of crawl link in Database: ' . $item['host_id'] . ' at time ' . $current_time . '<br />', 'fb_log' );
							} else {
								self::write_log( 'Error insert <b>id</b> of crawl link in Database: ' . $item['host_id'] . ' at time ' . $current_time . '<br />', 'fb_log' );
							}
						}
					}
				}
			}
		} else {
			self::write_log( 'Error at article id: ' . implode( ', ', $ids ), 'fb_log' );
		}
	}
	
	public static function write_log( $log = '', $type = 'crawl' ) {
		if ( ! $log )
			return;
		$log = $log . "\n";
		switch( $type ) {
			case 'fb_log':
				$path = DLN_SKILL_PLUGIN_DIR . "/dln-cron/logs/" . self::$fb_log;
				break;
			case 'crawl':
			default:
				$path = DLN_SKILL_PLUGIN_DIR . "/dln-cron/logs/" . self::$file_log;
				break;
		}
		
		$file = fopen( $path, 'a+' );
		fwrite( $file, $log );
		fclose( $file );
	}
	
	public static function get_nodes( $rss_url = '' ) {
		if ( ! $rss_url )
			return;
		
		if ( ! self::check_url( $rss_url ) )
			return;
		
		$dom = new DOMDocument( '1.0', 'utf-8' );
		$xml = self::file_get_contents_curl( $rss_url );
		$dom->loadXML( $xml );

		return $dom;
	}
	
	public static function check_exist_ids( $arr_ids, $source_type ) {
		global $wpdb;
		// Check id exists in db
		$str_ids = ( count( $arr_ids ) > 0 ) ? implode( $arr_ids, "','" ) : "";
		$sql     = "SELECT host_id FROM {$wpdb->dln_crawl_links} WHERE site = '" . $source_type . "' AND host_id IN ('{$str_ids}')";
		$results = $wpdb->get_col( $sql );
		if ( $results ) {
			foreach ( $results as $i => $item ) {
				if ( $item ) {
					$idx = array_search( $item, $arr_ids );
					unset( $arr_ids[$idx] );
				}
			}
		}
		
		return $arr_ids;
	}
	
	public static function insert_links_to_db( $arr_objs, $arr_ids, $current_time ) {
		global $wpdb;
		// Insert link to db
		if( count( $arr_objs ) && count( $arr_ids ) ) {
			foreach ( $arr_objs as $i => $obj ) {
				if ( in_array( $obj['host_id'], $arr_ids ) ) {
					$int = $wpdb->insert(
						$wpdb->dln_crawl_links,
						$obj
					);
					if ( $int ) {
						self::write_log( 'Completed insert <b>id</b> of crawl link in Database: ' . $obj['host_id'] . ' - ' . $obj['link'] . ' at time ' . $current_time . '<br />' );
					} else {
						self::write_log( 'Error insert <b>id</b> of crawl link in Database: ' . $obj['host_id'] . ' at time ' . $current_time . '<br />' );
					}
				}
			}
		}
	}
	
	public static function file_get_contents_curl( $url ) {
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
	
	private static function check_url( $html ){
		return $result = preg_replace(
			'%\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/)))%s',
			'<a href="$1">$1</a>',
			$html
		);
	}
	
}
