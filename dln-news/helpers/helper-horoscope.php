<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Helper_HoroScope {
	
	public static $instance;
	public static $cards;
	public static $file_path = '';
	public static $host_url  = 'http://www.xemtuong.net/boi/boi_bai/index.php';
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		self::$file_path = DLN_NEW_PLUGIN_DIR . '/data/saved_cards.txt';
		self::get_list_cards();
	}
	
	public static function crawl_data_db() {
		include_once DLN_NEW_PLUGIN_DIR . '/libs/simple_html_dom.php';
		global $wpdb;
		
		// Get 3 card
		$sql  = $wpdb->prepare( "SELECT id, card_key FROM {$wpdb->dln_horo_card} WHERE crawl = %s LIMIT 0, 10", '0' );
		$data = $wpdb->get_results( $sql );
		if ( ! empty( $data ) && ( ! is_wp_error( $data ) ) && is_array( $data ) ) {
			foreach ( $data as $i => $item ) {
				if ( ! empty( $item->card_key ) ) {
					$title    = '';
					$content  = '';
					if ( strpos( $item->card_key, '-' ) != false ) {
						// For three card type
						$ketquas  = explode( '-', $item->card_key );
						$url      = self::$host_url;
						$postdata = http_build_query(
							array(
								'lan'     => '5',
								'ketqua1' => $ketquas[0],
								'ketqua2' => $ketquas[1],
								'ketqua3' => $ketquas[2],
							)
						);

						$opts = array('http' =>
							array(
								'method'  => 'POST',
								'header'  => 'Content-type: application/x-www-form-urlencoded',
								'content' => $postdata
							)
						);
						
						$context  = stream_context_create($opts);
						$result   = @file_get_contents( $url, false, $context );
						if ( $result ) {
							$html = str_get_html( $result );
							$tags = $html->find( 'font' );
							
							foreach ( $tags as $i => $tag ) {
								if ( $i == 3 ) {
									$text  = trim( preg_replace("/\s+/", ' ', strip_tags( html_entity_decode( $tag->outertext ) ) ) );
									$title = str_replace( 'Lá»�i Giáº£i Ä�oÃ¡n', '', $text );
								} else if ( $i == 5 ) {
									$content = trim( preg_replace("/\s+/", ' ', strip_tags( html_entity_decode( $tag->outertext ) ) ) );
									$content = str_replace( 'Bá»•n Máº¡ng:', '<strong>Bá»•n Máº¡ng:</strong>', $content );
									$content = str_replace( 'TÃ i Lá»™c:', '<br /><br /><strong>TÃ i Lá»™c:</strong>', $content );
									$content = str_replace( 'Gia Ä�áº¡o:', '<br /><br /><strong>Gia Ä�áº¡o:</strong>', $content );
									$content = str_replace( '    ', '', $content );
								}
								
							}
						}
					} else {
						// For one card type
						$url  = self::$host_url . '?lan=7&xem=' .$item->card_key;
						$html = @file_get_html( $url );
						if ( $html ) {
							$tags = $html->find( 'tr td font' );
							foreach ( $tags as $i => $tag ) {
								if ( $i == 3 ) {
									$title = trim( preg_replace("/\s+/", ' ', strip_tags( html_entity_decode( $tag->outertext ) ) ) );
								} else if ( $i == 4 ) {
									$content = trim( preg_replace("/\s+/", ' ', strip_tags( html_entity_decode( $tag->outertext ) ) ) );
									$content = str_replace( '. ', '.<br /><br />', $content );
									$content = str_replace( '    ', '', $content );
								}
							}
						}
					}
					if ( sanitize_title( $title ) == 'chua-co-loi-gian-doan-cho-que-nay-chung-toi-se-cap-nhat-trong-thoi-gian-som-nhat' ) {
						$title = $content = '';
						$wpdb->update( $wpdb->dln_horo_card, array( 'start_time' => current_time( 'mysql' ), 'crawl' => '1' ), array( 'id' => $item->id ) );
					}
					
					// Insert post
					$post_id = 0;
					if ( $title && $content ) {
						$post_id = wp_insert_post( array(
							'post_title'   => $title,
							'post_content' => $content,
						) );
						if ( $post_id ) {
							$wpdb->update( $wpdb->dln_horo_card, array( 'start_time' => current_time( 'mysql' ), 'post_id' => $post_id, 'crawl' => '1' ), array( 'id' => $item->id ) );
						}
					}
				}
			}
		}
	}
	
	public static function insert_cards_db() {
		global $wpdb;
		$arr_cards = array();
		
		if ( ! file_exists( self::$file_path ) ) {
			for( $i = 0; $i < count( self::$cards ); $i++ ) {
				for( $j = 0; $j < count( self::$cards ); $j++ ) {
					for( $k = 0; $k < count( self::$cards ); $k++ ) {
						$arr_cards[] = self::$cards[$i] . '-' . self::$cards[$j] . '-' . self::$cards[$k];
					}
				}
			}
			$arr_cards = array_merge( self::$cards, $arr_cards );
			
			// Put to file
			file_put_contents( self::$file_path, json_encode( $arr_cards ) );
		}
		
		$data = @file_get_contents( self::$file_path );
		if ( ! empty( $data ) ) {
			$data         = json_decode( $data );
			$extract_data = array_splice( $data, 0, 100 );
			if ( $data ) {
				file_put_contents( self::$file_path, json_encode( $data ) );
			}
			
			// Check has exists in db
			$where    = implode( "', '", $extract_data );
			$sql      = "SELECT card_key AS count FROM {$wpdb->dln_horo_card} WHERE card_key IN ( '{$where}' )";
			$excludes = $wpdb->get_results( $sql );
			
			if ( count( $extract_data ) == 0 ) {
				echo 'Zero';
				return false;
			}
			
			$count = count( $excludes );
			for( $i = 0; $i < $count; $i++ ) {
				foreach ( $extract_data as $j => $data ) {
					if ( $excludes[ $i ] == $data[ $j ] ) {
						unset( $extract_data[ $j ] );
					}
				}
			}
			
			$count = count( $extract_data );
			for( $i = 0; $i < $count; $i++ ) {
				$wpdb->insert( $wpdb->dln_horo_card, array( 'card_key' => $extract_data[ $i ] ) );
			}
		}
	}
	
	public static function get_list_cards() {
		self::$cards = array(
			'000', '010', '020', '030', // Type 7
			'100', '110', '120', '130', // Type 8
			'200', '210', '220', '230', // Type 9
			'300', '310', '320', '330', // Type 10
			'400', '410', '420', '430', // Type J
			'500', '510', '520', '530', // Type Q
			'600', '610', '620', '630', // Type K
			'700', '710', '720', '730', // Type A
		);
		
		return self::$cards;
	}
	
	public static function crawl_horoscope_daily() {
		$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
		$context = stream_context_create($opts);
		$content = file_get_contents( 'http://lichvansu.wap.vn/tu-vi-hang-ngay-12-cung-hoang-dao.html', false, $context );
		$dom     = new DOMDocument( '1.0', 'utf-8' );
		libxml_use_internal_errors(true);
		$dom->loadHTML( $content );
		
		$xpath = new DOMXPath( $dom );
		
		$elements = $xpath->query( "//img[@class='imageCrazy1k']" );
		
		if ( ! is_null( $elements ) ) {
			foreach ( $elements as $i => $element ) {
				echo $element->parentNode->getAttribute('href') . '<br />';
			}
		}
	}
	
}

DLN_Helper_HoroScope::get_instance();