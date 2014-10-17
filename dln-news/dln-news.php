<?php
/*
Plugin Name: DLN News
Plugin URI: http://www.facebook.com/lenhatdinh
Description: Like Management for fb, pinterest or youtube...
Version: 1.0.0
Author: Dinh Le Nhat
Author URI: http://www.facebook.com/lenhatdinh
License: GPL2
 */

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_News {
	
	public function __construct() {
		// Define constants
		define( 'DLN_NEW_VERSION', '1.0.0' );
		define( 'DLN_NEW', 'dln-product' );
		define( 'DLN_NEW_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
		define( 'DLN_NEW_PLUGIN_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );
		
		// Define nonce ID
		define( 'DLN_NEW_NONCE', 'dln_new_nonce_check' );
		
		// Define Facebook App Settings
		define( 'FB_APP_ID', '225132297553705' );
		define( 'FB_SECRET', '8f00d29717ee8c6a49cd25da80c5aad8' );
		define( 'FB_REDIRECT_URI', site_url() . '?dln_endpoint_fb=true' );
		
		define( 'DLN_MAX_IMAGE_SIZE', 1024 );
		define( 'DLN_MAIN_IMAGE_SIZE', 500 );
		define( 'DLN_DEFAULT_IMAGE', '' );
		
		global $wpdb;
		$wpdb->dln_news_source = $wpdb->prefix . 'dln_news_source';
		$wpdb->dln_news_link   = $wpdb->prefix . 'dln_news_link';
		$wpdb->dln_news_top_comments = $wpdb->prefix . 'dln_news_top_comments';
		 
		$wpdb->dln_horo_card   = $wpdb->prefix . 'dln_horo_card';
		$wpdb->dln_horo_twelve = $wpdb->prefix . 'dln_horo_twelve';
		
		$this->requires();
		
		register_activation_hook( __FILE__, array( $this, 'install' ) );
		
		add_action( 'init', array( $this, 'listener_form' ) );
	}
	
	public function requires() {
		include DLN_NEW_PLUGIN_DIR . '/helpers/helper-ajax.php';
		include DLN_NEW_PLUGIN_DIR . '/helpers/helper-horoscope.php';
		include DLN_NEW_PLUGIN_DIR . '/helpers/helper-shortcode.php';
		include DLN_NEW_PLUGIN_DIR . '/helpers/helper-template.php';
		include DLN_NEW_PLUGIN_DIR . '/helpers/helper-source.php';
		
		if ( is_admin() ) {
			include( DLN_NEW_PLUGIN_DIR . '/admin/news-post-type.php' );
		}
		
		//$this->required_components = apply_filters( 'dln_required_components', array( 'connections', 'cron' ) );
		$this->required_components = apply_filters( 'dln_required_components', array( 'block' ) );
		
		// Loop through required components
		foreach ( $this->required_components as $component ) {
			if ( file_exists( DLN_NEW_PLUGIN_DIR . '/includes/dln-' . $component . '/dln-' . $component . '-loader.php' ) )
				include( DLN_NEW_PLUGIN_DIR . '/includes/dln-' . $component . '/dln-' . $component . '-loader.php' );
		}
	}
	
	public static function install() {
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
		self::create_table_source();
		self::create_table_link();
		self::create_table_top_comments();
		
		self::create_table_horoscope();
		self::create_table_horo_twelve();
	}
	
	private static function create_table_source() {
		global $wpdb;
	
		if ( ! empty( $wpdb->charset ) )
			$db_charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		if ( ! empty( $wpdb->collate ) )
			$db_charset_collate .= " COLLATE $wpdb->collate";
	
		$sql = "CREATE TABLE {$wpdb->dln_news_source} (
		id int(11) NOT NULL AUTO_INCREMENT,
		term_id int(11) NOT NULL,
		link nvarchar(500) NOT NULL,
		type nvarchar(50) NOT NULL,
		source_type nvarchar(50) NOT NULL,
		tags nvarchar(255) NOT NULL,
		state tinyint(1) DEFAULT 0,
		PRIMARY KEY  (id)
		) CHARSET=utf8, ENGINE=MyIsam $db_charset_collate;";
	
		dbDelta( $sql );
	}
	
	private static function create_table_link() {
		global $wpdb;
		
		if ( ! empty( $wpdb->charset ) )
			$db_charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		if ( ! empty( $wpdb->collate ) )
			$db_charset_collate .= " COLLATE $wpdb->collate";
		
		$sql = "CREATE TABLE {$wpdb->dln_news_link} (
		id int(11) NOT NULL AUTO_INCREMENT,
		post_id int(11) NOT NULL,
		md5 nvarchar(255) NOT NULL,
		url nvarchar(500) NOT NULL,
		title nvarchar(255) NOT NULL,
		image nvarchar(500) NOT NULL,
		start_time datetime NOT NULL,
		update_time datetime NOT NULL,
		likes int(11) NOT NULL,
		share int(11) NOT NULL,
		comment_count int(11) NOT NULL,
		bound_rate float(11) NOT NULL,
		comments int(11) NOT NULL,
		state tinyint(1) DEFAULT 0,
		PRIMARY KEY  (id)
		) CHARSET=utf8, ENGINE=InnoDB $db_charset_collate;
		
		ALTER TABLE {$wpdb->dln_news_link} ADD INDEX ( md5 );";
		
		dbDelta( $sql );
	}
	
	private static function create_table_top_comments() {
		global $wpdb;
		
		if ( ! empty( $wpdb->charset ) )
			$db_charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		if ( ! empty( $wpdb->collate ) )
			$db_charset_collate .= " COLLATE $wpdb->collate";
		
		$sql = "CREAT TABLE {$wpdb->dln_news_top_comments} (
			id int(11) NOT NULL AUTO_INCREMENT;
			post_id int(11) NOT NULL,
			comment_id nvarchar(25) NOT NULL,
			user_id nvarchar(25) NOT NULL,
			user_name nvarchar(255) NOT NULL,
			message TEXT,
			likes int(11) NOT NULL,
			create_time datetime NOT NULL,
			PRIMARY KEY  (id)
		) CHARSET=utf8, ENGINE=InnoDB {$db_charset_collate};
		
		ALTER TABLE {$wpdb->dln_news_top_comments} ADD INDEX ( comment_id );";
		
		dbDelta( $sql );
	}
	
	private static function create_table_horoscope() {
		global $wpdb;
	
		if ( ! empty( $wpdb->charset ) )
			$db_charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		if ( ! empty( $wpdb->collate ) )
			$db_charset_collate .= " COLLATE $wpdb->collate";
	
		$sql = "CREATE TABLE {$wpdb->dln_horo_card} (
		id int(11) NOT NULL AUTO_INCREMENT,
		post_id int(11) NOT NULL,
		card_key nvarchar(255) NOT NULL,
		start_time datetime NOT NULL,
		crawl tinyint(1) DEFAULT 0,
		PRIMARY KEY  (id)
		) CHARSET=utf8, ENGINE=InnoDB $db_charset_collate;
	
		ALTER TABLE {$wpdb->dln_horo_card} ADD INDEX ( card_key );";
		
		dbDelta( $sql );
	}
	
	private static function create_table_horo_twelve() {
		global $wpdb;
		
		if ( ! empty( $wpdb->charset ) )
			$db_charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		if ( ! empty( $wpdb->collate ) )
			$db_charset_collate .= " COLLATE $wpdb->collate";
		
		$sql = "CREATE TABLE {$wpdb->dln_horo_twelve} (
		id int(11) NOT NULL AUTO_INCREMENT,
		post_id int(11) NOT NULL,
		uni_query nvarchar(255) NOT NULL,
		type_time nvarchar(10) NOT NULL,
		type_group nvarchar(10) NOT NULL,
		link nvarchar(255) NOT NULL,
		update_time datetime NOT NULL,
		crawl tinyint(1) DEFAULT 0,
		PRIMARY KEY  (id)
		) CHARSET=utf8, ENGINE=InnoDB $db_charset_collate;
		
		INSERT INTO {$wpdb->dln_horo_twelve} ( `link`, `type_time`, `type_group` ) VALUES ( 'http://lichvansu.wap.vn/tu-vi-hang-ngay-12-cung-hoang-dao-bach-duong.html', 'ngay', 'bach-duong' );
		INSERT INTO {$wpdb->dln_horo_twelve} ( `link`, `type_time`, `type_group` ) VALUES ( 'http://lichvansu.wap.vn/tu-vi-hang-ngay-12-cung-hoang-dao-kim-nguu.html', 'ngay', 'kim-nguu' );
		INSERT INTO {$wpdb->dln_horo_twelve} ( `link`, `type_time`, `type_group` ) VALUES ( 'http://lichvansu.wap.vn/tu-vi-hang-ngay-12-cung-hoang-dao-song-tu.html', 'ngay', 'song-tu' );
		INSERT INTO {$wpdb->dln_horo_twelve} ( `link`, `type_time`, `type_group` ) VALUES ( 'http://lichvansu.wap.vn/tu-vi-hang-ngay-12-cung-hoang-dao-cu-giai.html', 'ngay', 'cu-giai' );
		INSERT INTO {$wpdb->dln_horo_twelve} ( `link`, `type_time`, `type_group` ) VALUES ( 'http://lichvansu.wap.vn/tu-vi-hang-ngay-12-cung-hoang-dao-su-tu.html', 'ngay', 'su-tu' );
		INSERT INTO {$wpdb->dln_horo_twelve} ( `link`, `type_time`, `type_group` ) VALUES ( 'http://lichvansu.wap.vn/tu-vi-hang-ngay-12-cung-hoang-dao-xu-nu.html', 'ngay', 'xu-nu' );
		INSERT INTO {$wpdb->dln_horo_twelve} ( `link`, `type_time`, `type_group` ) VALUES ( 'http://lichvansu.wap.vn/tu-vi-hang-ngay-12-cung-hoang-dao-thien-binh.html', 'ngay', 'thien-binh' );
		INSERT INTO {$wpdb->dln_horo_twelve} ( `link`, `type_time`, `type_group` ) VALUES ( 'http://lichvansu.wap.vn/tu-vi-hang-ngay-12-cung-hoang-dao-ho-cap.html', 'ngay', 'ho-cap' );
		INSERT INTO {$wpdb->dln_horo_twelve} ( `link`, `type_time`, `type_group` ) VALUES ( 'http://lichvansu.wap.vn/tu-vi-hang-ngay-12-cung-hoang-dao-nhan-ma.html', 'ngay', 'nhan-ma' );
		INSERT INTO {$wpdb->dln_horo_twelve} ( `link`, `type_time`, `type_group` ) VALUES ( 'http://lichvansu.wap.vn/tu-vi-hang-ngay-12-cung-hoang-dao-ma-ket.html', 'ngay', 'ma-ket' );
		INSERT INTO {$wpdb->dln_horo_twelve} ( `link`, `type_time`, `type_group` ) VALUES ( 'http://lichvansu.wap.vn/tu-vi-hang-ngay-12-cung-hoang-dao-bao-binh.html', 'ngay', 'bao-binh' );
		INSERT INTO {$wpdb->dln_horo_twelve} ( `link`, `type_time`, `type_group` ) VALUES ( 'http://lichvansu.wap.vn/tu-vi-hang-ngay-12-cung-hoang-dao-song-ngu.html', 'ngay', 'song-ngu' );
		
		INSERT INTO {$wpdb->dln_horo_twelve} ( `link`, `type_time`, `type_group` ) VALUES ( 'http://lichvansu.wap.vn/tu-vi-hang-tuan-12-cung-hoang-dao-bach-duong.html', 'tuan', 'bach-duong' );
		INSERT INTO {$wpdb->dln_horo_twelve} ( `link`, `type_time`, `type_group` ) VALUES ( 'http://lichvansu.wap.vn/tu-vi-hang-tuan-12-cung-hoang-dao-kim-nguu.html', 'tuan', 'kim-nguu' );
		INSERT INTO {$wpdb->dln_horo_twelve} ( `link`, `type_time`, `type_group` ) VALUES ( 'http://lichvansu.wap.vn/tu-vi-hang-tuan-12-cung-hoang-dao-song-tu.html', 'tuan', 'song-tu' );
		INSERT INTO {$wpdb->dln_horo_twelve} ( `link`, `type_time`, `type_group` ) VALUES ( 'http://lichvansu.wap.vn/tu-vi-hang-tuan-12-cung-hoang-dao-cu-giai.html', 'tuan', 'cu-giai' );
		INSERT INTO {$wpdb->dln_horo_twelve} ( `link`, `type_time`, `type_group` ) VALUES ( 'http://lichvansu.wap.vn/tu-vi-hang-tuan-12-cung-hoang-dao-su-tu.html', 'tuan', 'su-tu' );
		INSERT INTO {$wpdb->dln_horo_twelve} ( `link`, `type_time`, `type_group` ) VALUES ( 'http://lichvansu.wap.vn/tu-vi-hang-tuan-12-cung-hoang-dao-xu-nu.html', 'tuan', 'xu-nu' );
		INSERT INTO {$wpdb->dln_horo_twelve} ( `link`, `type_time`, `type_group` ) VALUES ( 'http://lichvansu.wap.vn/tu-vi-hang-tuan-12-cung-hoang-dao-thien-binh.html', 'tuan', 'thien-binh' );
		INSERT INTO {$wpdb->dln_horo_twelve} ( `link`, `type_time`, `type_group` ) VALUES ( 'http://lichvansu.wap.vn/tu-vi-hang-tuan-12-cung-hoang-dao-ho-cap.html', 'tuan', 'ho-cap' );
		INSERT INTO {$wpdb->dln_horo_twelve} ( `link`, `type_time`, `type_group` ) VALUES ( 'http://lichvansu.wap.vn/tu-vi-hang-tuan-12-cung-hoang-dao-nhan-ma.html', 'tuan', 'nhan-ma' );
		INSERT INTO {$wpdb->dln_horo_twelve} ( `link`, `type_time`, `type_group` ) VALUES ( 'http://lichvansu.wap.vn/tu-vi-hang-tuan-12-cung-hoang-dao-ma-ket.html', 'tuan', 'ma-ket' );
		INSERT INTO {$wpdb->dln_horo_twelve} ( `link`, `type_time`, `type_group` ) VALUES ( 'http://lichvansu.wap.vn/tu-vi-hang-tuan-12-cung-hoang-dao-bao-binh.html', 'tuan', 'bao-binh' );
		INSERT INTO {$wpdb->dln_horo_twelve} ( `link`, `type_time`, `type_group` ) VALUES ( 'http://lichvansu.wap.vn/tu-vi-hang-tuan-12-cung-hoang-dao-song-ngu.html', 'tuan', 'song-ngu' );
		
		INSERT INTO {$wpdb->dln_horo_twelve} ( `link`, `type_time`, `type_group` ) VALUES ( 'http://lichvansu.wap.vn/tu-vi-hang-thang-12-cung-hoang-dao-bach-duong.html', 'thang', 'bach-duong' );
		INSERT INTO {$wpdb->dln_horo_twelve} ( `link`, `type_time`, `type_group` ) VALUES ( 'http://lichvansu.wap.vn/tu-vi-hang-thang-12-cung-hoang-dao-kim-nguu.html', 'thang', 'kim-nguu' );
		INSERT INTO {$wpdb->dln_horo_twelve} ( `link`, `type_time`, `type_group` ) VALUES ( 'http://lichvansu.wap.vn/tu-vi-hang-thang-12-cung-hoang-dao-song-tu.html', 'thang', 'song-tu' );
		INSERT INTO {$wpdb->dln_horo_twelve} ( `link`, `type_time`, `type_group` ) VALUES ( 'http://lichvansu.wap.vn/tu-vi-hang-thang-12-cung-hoang-dao-cu-giai.html', 'thang', 'cu-giai' );
		INSERT INTO {$wpdb->dln_horo_twelve} ( `link`, `type_time`, `type_group` ) VALUES ( 'http://lichvansu.wap.vn/tu-vi-hang-thang-12-cung-hoang-dao-su-tu.html', 'thang', 'su-tu' );
		INSERT INTO {$wpdb->dln_horo_twelve} ( `link`, `type_time`, `type_group` ) VALUES ( 'http://lichvansu.wap.vn/tu-vi-hang-thang-12-cung-hoang-dao-xu-nu.html', 'thang', 'xu-nu' );
		INSERT INTO {$wpdb->dln_horo_twelve} ( `link`, `type_time`, `type_group` ) VALUES ( 'http://lichvansu.wap.vn/tu-vi-hang-thang-12-cung-hoang-dao-thien-binh.html', 'thang', 'thien-binh' );
		INSERT INTO {$wpdb->dln_horo_twelve} ( `link`, `type_time`, `type_group` ) VALUES ( 'http://lichvansu.wap.vn/tu-vi-hang-thang-12-cung-hoang-dao-ho-cap.html', 'thang', 'ho-cap' );
		INSERT INTO {$wpdb->dln_horo_twelve} ( `link`, `type_time`, `type_group` ) VALUES ( 'http://lichvansu.wap.vn/tu-vi-hang-thang-12-cung-hoang-dao-nhan-ma.html', 'thang', 'nhan-ma' );
		INSERT INTO {$wpdb->dln_horo_twelve} ( `link`, `type_time`, `type_group` ) VALUES ( 'http://lichvansu.wap.vn/tu-vi-hang-thang-12-cung-hoang-dao-ma-ket.html', 'thang', 'ma-ket' );
		INSERT INTO {$wpdb->dln_horo_twelve} ( `link`, `type_time`, `type_group` ) VALUES ( 'http://lichvansu.wap.vn/tu-vi-hang-thang-12-cung-hoang-dao-bao-binh.html', 'thang', 'bao-binh' );
		INSERT INTO {$wpdb->dln_horo_twelve} ( `link`, `type_time`, `type_group` ) VALUES ( 'http://lichvansu.wap.vn/tu-vi-hang-thang-12-cung-hoang-dao-song-ngu.html', 'thang', 'song-ngu' );
		
		";
		
		dbDelta( $sql );
	}
	
	public static function dln_endpoint_listener() {
		/*if ( isset( $_GET['dln_endpoint_fb'] ) && $_GET['dln_endpoint_fb'] == 'true' ) {
			if ( ! empty( $_GET['state'] ) && ! empty( $_GET['code'] ) ) {
				// Process state
				$state        = $_GET['state'];
				$code         = $_GET['code'];
				$app_id       = FB_APP_ID;
				$app_secret   = FB_SECRET;
				$redirect_uri = urlencode( FB_REDIRECT_URI );
				
				if ( ! empty( $redirect_uri ) ) {
					$url      = "https://graph.facebook.com/oauth/access_token?client_id={$app_id}&redirect_uri={$redirect_uri}&client_secret={$app_secret}&code={$code}";
					$obj_data = @file_get_contents( $url );
					
					if ( $obj_data ) {
						$params   = null;
						parse_str( $obj_data, $params );
						
						if ( ! empty( $params['access_token'] ) ) {
							// Get facebook user account
							$obj_data = @file_get_contents( 'https://graph.facebook.com/v2.0/me?access_token=' . $params['access_token'] );
							if ( ! empty( $obj_data ) ) {
								$obj_data = json_decode( $obj_data );
								$user_id = get_current_user_id();
								if ( $user_id ) {
									update_user_meta( $user_id, 'dln_facebook_user_id', $obj_data->id );
									update_user_meta( $user_id, 'dln_facebook_user_name', $obj_data->name );
									update_user_meta( $user_id, 'dln_facebook_access_token', $params['access_token'] );
								}
							}
							?>
							<script type="text/javascript">
								document.location = "<?php echo esc_attr( $state ) ?>";
							</script>
							<?php
							exit();
						}
					}
				}
			}
		} else if ( isset( $_GET['dln_endpoint_insta'] ) && $_GET['dln_endpoint_insta'] == 'true' ) {
			if ( ! empty( $_GET['code'] ) ) {
				$code     = $_GET['code'];
				$api_data = array(
					'client_id'     => INSTA_APP_ID,
					'client_secret' => INSTA_SECRET,
					'grant_type'    => 'authorization_code',
					'redirect_uri'  => INSTA_REDIRECT_URI,
					'code'          => $code
				);
				$api_host = 'https://api.instagram.com/oauth/access_token';
				
				$ch = curl_init( $api_host );
				curl_setopt( $ch, CURLOPT_POST, true );
				curl_setopt( $ch, CURLOPT_POSTFIELDS, $api_data );
				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
				curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
				$result = curl_exec( $ch );
				curl_close( $ch );
				$arr = json_decode( $result, true );
				
				$user_id = get_current_user_id();
				if ( $user_id ) {
					if ( ! empty( $arr['access_token'] ) ) {
						update_user_meta( $user_id, 'dln_instagram_access_token', $arr['access_token'] );
					}
					if ( ! empty( $arr['user']['id'] ) ) {
						update_user_meta( $user_id, 'dln_instagram_user_id', $arr['user']['id'] );
					}
					if ( ! empty( $arr['user']['username'] ) ) {
						update_user_meta( $user_id, 'dln_instagram_user_name', $arr['user']['username'] );
					}
					
					?>
					<script language="javascript" type="text/javascript">
						document.location = "<?php echo esc_attr( site_url() ) ?>";
					</script>
					<?php
					exit();
				}
			}
		}*/
	}
	
	public static function listener_form() {
		global $wpdb;
		
		if ( isset( $_GET['dln_crawl'] ) && $_GET['dln_crawl'] == '2' ) {
			DLN_Helper_HoroScope::insert_cards_db(); die();
		}
		
		if ( isset( $_GET['dln_crawl'] ) && $_GET['dln_crawl'] == '3' ) {
			DLN_Helper_HoroScope::crawl_data_db(); die();
		}
		
		if ( isset( $_GET['dln_crawl'] ) && $_GET['dln_crawl'] == '4' ) {
			DLN_Helper_HoroScope::crawl_horoscope_daily(); die();
		}
		
		if ( isset( $_GET['dln_crawl'] ) && $_GET['dln_crawl'] == 'add_source' ) {
			DLN_Helper_Source::add_source_default();
		}
		
		if ( isset( $_GET['dln_crawl'] ) && $_GET['dln_crawl'] == '1' ) {
			include_once DLN_NEW_PLUGIN_DIR . '/libs/simple_html_dom.php';
			//$sources = DLN_Helper_Source::select_lastest( 3 );
			
			$sukien = new stdClass();
			$thethao = new stdClass();
			$xeco = new stdClass();
			$xeco1 = new stdClass();
			//$xeco2 = new stdClass();
			//$xeco3 = new stdClass();
			
			$sukien->type = 'haivl';
			$thethao->type = 'haivl';
			$xeco->type = 'haivl';
			$xeco1->type = 'haivl';
			//$xeco2->type = 'haivl';
			//$xeco3->type = 'haivl';
			
			$sukien->link = 'http://haivl.com/';
			$thethao->link = 'http://haivl.com/new/2';
			$xeco->link = 'http://haivl.com/new/3';
			$xeco1->link = 'http://haivl.com/new/4';
			//$xeco2->link = 'http://haivl.com/new/5';
			//$xeco3->link = 'http://haivl.com/new/6';
			
			$sources[] = $sukien;
			$sources[] = $thethao;
			$sources[] = $xeco;
			$sources[] = $xeco1;
			//$sources[] = $xeco2;
			//$sources[] = $xeco3;
			
			
			if ( $sources ) {
				$arr_links  = array();
				$arr_images = array();
				
				// Get links from source
				foreach ( $sources as $i => $source ) {
					if ( $source->type ) {
						$source_class    = DLN_Helper_Source::load_source_class( $source->type );
						$source_instance = $source_class::get_instance();
						
						if ( $source_instance && ! empty( $source->link ) ) {
							$links = $source_instance->get_links( $source->link );
							
							if ( $links ) {
								$arr_links = array_merge( $arr_links, $links );
							}
						}
					}
				}
				
				if ( $arr_links ) {
					$arr_fb_links = self::get_fb_link_info( $arr_links );
					var_dump($arr_fb_links);die();
					if ( ! empty( $arr_fb_links ) ) {
						$arr_md5 = array();
						foreach ( $arr_fb_links as $i => $link ) {
							if ( $link ) {
								$arr_md5[] = $link->md5;
							}
						}
						
						if ( ! empty( $arr_md5 ) ) {
							// Get md5 exists in db
							$where     = implode( "','", $arr_md5 );
							$sql       = "SELECT md5, post_id FROM {$wpdb->dln_news_link} WHERE md5 IN ( '{$where}' )";
							$arr_links = $wpdb->get_results( $sql );
							
							if ( ! empty( $arr_links ) && ! is_wp_error( $arr_links ) ) {
								foreach ( $arr_links as $i => $data ) {
									
									if ( ! empty( $data->md5 ) ) {
										foreach ( $arr_fb_links as $i => $link ) {
									
											if ( $link->md5 == $data->md5 ) {													
												$wpdb->update(
													$wpdb->dln_news_link,
													array(
														'url'         => $link->url,
														'update_time' => current_time( 'mysql' ),
														'likes'       => $link->likes,
														'share'       => $link->share
													),
													array( 'md5' => $data->md5 )
												);
												
												unset( $arr_fb_links[ $i ] );
											}
										}
									}
								}
							}
						}
						
						// Insert to db
						if ( count( $arr_fb_links ) ) {
							foreach ( $arr_fb_links as $i => $link ) {
								
								if ( $link ) {
									// Insert post
									$post_id = wp_insert_post(
										array(
											'post_type'    => 'dln_source',
											'post_title'   => $link->title,
											'post_content' => $link->desc,
											'post_status'  => 'publish',
											'post_author'  => 1
										)
									);
									
									if ( $post_id ) {
										if ( $link->thumbs ) {
											update_post_meta( $post_id, '_dln_thumbs', $link->thumbs );
										}
										$wpdb->insert(
											$wpdb->dln_news_link,
											array(
												'post_id'    => $post_id,
												'md5'        => $link->md5,
												'url'        => $link->url,
												'title'      => $link->title,
												'image'      => $link->thumbs,
												'start_time' => current_time( 'mysql' ),
												'likes'      => $link->likes,
												'share'      => $link->share,
												'bound_rate' => $link->bound_rate,
												'comments'   => $link->comment_count
											)
										);
										
										// Get comments exists in database
										/*$cm_ids = array();
										if ( $link->comments ) {
											foreach ( $link->comments as $i => $comment ) {
												$cm_ids[] = $comment->comment_id;
											}
										}*/
										
									}
								}
							}
						}
						
						
					}
				}
			}
		}
	}
	
	public static function get_fb_link_info( $arr_links ) {
		if ( ! $arr_links )
			return false;
		
		$batch_fbids  = array();
		$count        = 0;
		$access_token = FB_APP_ID . '|' . FB_SECRET;

		// Get facebook id for links
		if ( is_array( $arr_links ) ) {
			foreach ( $arr_links as $i => $obj ) {
				if ( ! empty( $obj->link ) )
					$link = $obj->link;
				else 
					$link = $obj;
				
				$count++;
				if ( $link ) {
					$batch_fbids[] = '{"method":"GET","relative_url":"?ids=' . $link . '"}';
					
					if ( $count == 50 ) {
						$batch_request[]  = '[' . implode( ',', $batch_fbids ) . ']';
						$count            = 0;
						$batch_fbids      = null;
					}
				}
			}
			
			if ( ! empty( $batch_fbids ) ) {
				$batch_request[]  = '[' . implode( ',', $batch_fbids ) . ']';
				$batch_fbids      = null;
			}
			
			if ( ! empty( $batch_request ) ) {
				foreach ( $batch_request as $i => $request ) {
					$request_urls[] = 'https://graph.facebook.com/v2.1/?batch=' . $request . '&access_token=' . $access_token . '&method=post';
				}
			}
		}
		
		$arr_link_infor = array();
		$arr_fbids      = array();
		
		foreach ( $request_urls as $i => $url ) {
			$objs = json_decode( @file_get_contents( $url ) );
			
			if ( ! empty( $objs ) ) {
				foreach ( $objs as $i => $obj ) {
				
					if ( $obj->body ) {
						$body = json_decode( $obj->body );
							
						foreach ( $arr_links as $i => $obj ) {
							if ( ! empty( $obj->link ) )
								$link = $obj->link;
							else
								$link = $obj;
							
							if ( ! empty( $body->$link ) ) {
								$obj_link = new stdClass;
								$obj_link->md5   = md5( $link );
								$obj_link->url   = $link;
								$obj_link->fbid  = isset( $body->$link->og_object->id ) ? $body->$link->og_object->id : '';
								$obj_link->title = isset( $body->$link->og_object->title ) ? $body->$link->og_object->title : '';
								$obj_link->desc  = isset( $body->$link->og_object->description ) ? $body->$link->og_object->description : '';
								$obj_link->share = isset( $body->$link->share->share_count ) ? $body->$link->share->share_count : 0;
								$obj_link->likes = 0;
								
								$obj_link->thumbs = ( ! empty( $obj->image ) ) ? $obj->image : ''; 
				
								$arr_fbids[]      = isset( $body->$link->og_object->id ) ? $body->$link->og_object->id : '';
								$arr_link_infor[] = $obj_link;
							}
						}
					}
				}
			}
		}
		//$fb_likes  = self::get_fb_likes( $arr_fbids, $access_token );
		$fb_thumbs   = self::get_fb_thumbs( $arr_fbids, $access_token );
		
		foreach ( $arr_link_infor as $i => $link_infor ) {
			if ( ! empty( $fb_thumbs['thumbs'][ $i ] ) ) {
				//$arr_link_infor[ $i ]->likes  = ( ! empty( $fb_likes[ $i ] ) ) ? $fb_likes[ $i ] : 0;
				if ( empty( $arr_link_infor[ $i ]->thumbs ) ) {
					$arr_link_infor[ $i ]->thumbs       = ( ! empty( $fb_thumbs['thumbs'][ $i ] ) ) ? $fb_thumbs['thumbs'][ $i ] : '';
				}
				$arr_link_infor[ $i ]->created_time = $fb_thumbs['created'][ $i ];
				$arr_link_infor[ $i ]->bound_rate   = $arr_link_infor[ $i ]->share / ( current_time( 'timestamp' ) - $fb_thumbs['created'][ $i ] );
			}
		}
	
		// Unset share count is zero
		if ( count( $arr_link_infor ) ) {
			foreach ( $arr_link_infor as $i => $link_infor ) {
				if ( $link_infor->likes == 0 && $link_infor->share == 0 ) {
					unset( $arr_link_infor[$i] );
				}
			}
		}
		
		$arr_link_infor = self::get_fb_top_comments( $arr_link_infor, $access_token );
		
		var_dump($arr_link_infor);die();
		return $arr_link_infor;
	}
	
	public static function get_fb_top_comments( $arr_link_infor = array(), $access_token = '' ) {
		if ( empty( $arr_link_infor ) || ! $access_token )
			return false;
		
		$batch_fbids = array();
		$count       = 0;
		
		foreach ( $arr_link_infor as $i => $item ) {
			$count++;
			
			$fbid = $item->fbid;
			if ( $fbid ) {
				$batch_fbids[] = '{"method":"GET","relative_url":"' . $fbid . '/comments?summary=true"}';
					
				if ( $count == 50 ) {
					$batch_request[]  = '[' . implode( ',', $batch_fbids ) . ']';
					$count          = 0;
					$batch_fbids    = null;
				}
			}
		}
		
		if ( ! empty( $batch_fbids ) ) {
			$batch_request[]  = '[' . implode( ',', $batch_fbids ) . ']';
			$batch_fbids      = null;
		}
			
		if ( ! empty( $batch_request ) ) {
			foreach ( $batch_request as $i => $request ) {
				$request_urls[] = 'https://graph.facebook.com/v2.1/?batch=' . $request . '&access_token=' . $access_token . '&method=post';
			}
		}
		
		foreach ( $request_urls as $i => $url ) {
			$objs = json_decode( @file_get_contents( $url ) );
				
			if ( ! empty( $objs ) ) {
				foreach ( $objs as $i => $obj ) {
						
					if ( $obj->body ) {
						$arr_comments = array();
						$search_id    = null;
						
						$body = json_decode( $obj->body );
						$data = $body->data;
						
						if ( $data ) {
							foreach ( $data as $i => $item ) {
								$user_comment = new stdClass;
								$user_comment->comment_id = $item->id;
								$user_comment->user_id    = $item->from->id;
								$user_comment->user_name  = $item->from->name;
								$user_comment->message    = $item->message;
								$user_comment->likes      = $item->like_count;
								$arr_comments[] = $user_comment;
								$search_id      = $item->id;
							}
						}
						
						usort( $arr_comments, array( 'DLN_News', 'cmp' ) );
						
						if ( $arr_comments ) {
							foreach ( $arr_link_infor as $i => $link_infor ) {
								if ( strpos( $search_id, $link_infor->fbid ) !== false ) {
									$arr_link_infor[ $i ]->comment_count = $body->summary->total_count;
									$arr_link_infor[ $i ]->comments = array_slice( $arr_comments, 0, 5, true );
								}
							}
						}
					}
				}
			}
		}
		
		return $arr_link_infor;
	}
	
	public static function get_fb_likes( $arr_fbids = array(), $access_token = '' ) {
		if ( empty( $arr_fbids ) || ! $access_token )
			return false;
		
		$batch_fbids  = array();
		$count        = 0;
		
		foreach ( $arr_fbids as $i => $fbid ) {
			$count++;
			if ( $fbid ) {
				$batch_fbids[] = '{"method":"GET","relative_url":"' . $fbid . '/likes?summary=true"}';
					
				if ( $count == 50 ) {
					$batch_request[]  = '[' . implode( ',', $batch_fbids ) . ']';
					$count          = 0;
					$batch_fbids    = null;
				}
			}
		}
		
		if ( ! empty( $batch_fbids ) ) {
			$batch_request[]  = '[' . implode( ',', $batch_fbids ) . ']';
			$batch_fbids      = null;
		}
			
		if ( ! empty( $batch_request ) ) {
			foreach ( $batch_request as $i => $request ) {
				$request_urls[] = 'https://graph.facebook.com/v2.1/?batch=' . $request . '&access_token=' . $access_token . '&method=post';
			}
		}
		
		$arr_fb_likes = array();
		foreach ( $request_urls as $i => $url ) {
			$objs = json_decode( @file_get_contents( $url ) );
			
			if ( ! empty( $objs ) ) {
				foreach ( $objs as $i => $obj ) {
					
					if ( $obj->body ) {
						$body = json_decode( $obj->body );
						
						$arr_fb_likes[] = isset( $body->summary->total_count ) ? $body->summary->total_count : 0;
					}
				}
			}
		}
		
		return $arr_fb_likes;
	}
	
	public static function get_fb_thumbs( $arr_fbids = array(), $access_token = '' ) {
		if ( empty( $arr_fbids ) || ! $access_token )
			return false;
	
		$batch_fbids  = array();
		$count        = 0;
	
		foreach ( $arr_fbids as $i => $fbid ) {
			$count++;
			if ( $fbid ) {
				$batch_fbids[] = '{"method":"GET","relative_url":"' . $fbid . '"}';
					
				if ( $count == 50 ) {
					$batch_request[]  = '[' . implode( ',', $batch_fbids ) . ']';
					$count          = 0;
					$batch_fbids    = null;
				}
			}
		}
	
		if ( ! empty( $batch_fbids ) ) {
			$batch_request[]  = '[' . implode( ',', $batch_fbids ) . ']';
			$batch_fbids      = null;
		}
			
		if ( ! empty( $batch_request ) ) {
			foreach ( $batch_request as $i => $request ) {
				$request_urls[] = 'https://graph.facebook.com/v2.1/?batch=' . $request . '&access_token=' . $access_token . '&method=post';
			}
		}
	
		$arr_fb_thumbs  = array();
		$arr_fb_created = array();
		foreach ( $request_urls as $i => $url ) {
			$objs = json_decode( @file_get_contents( $url ) );
			
			if ( ! empty( $objs ) ) {
				foreach ( $objs as $i => $obj ) {
						
					if ( $obj->body ) {
						$body = json_decode( $obj->body );
						
						// Get thumbnail
						if ( isset( $body->data->full_image ) ) {
							$arr_fb_thumbs[] = $body->data->full_image;
						} else {
							$arr_fb_thumbs[] = ( isset( $body->image[0]->url ) && isset( $body->image[0]->height ) ) ? $body->image[0]->url : '';
						}
						
						// Get create time
						$arr_fb_created[] = strtotime( $body->created_time );
					}
				}
			}
		}
	
		return array( 'thumbs' => $arr_fb_thumbs, 'created' => $arr_fb_created );
	}

	public static function cmp( $a, $b ) {
		return strnatcmp( $b->likes, $a->likes );
	}
	
}

$GLOBALS['dln_news'] = new DLN_News();
