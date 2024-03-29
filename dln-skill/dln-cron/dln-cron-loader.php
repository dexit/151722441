<?php

if ( ! defined( 'WPINC' ) ) { die; }

function file_get_contents_curl( $url = '' ) {
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

class DLN_Cron_Loader {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		date_default_timezone_set( "Asia/Ho_Chi_Minh" );
		define( 'DLN_COMPANY_SLUG', 'dln_cron' );
		
		global $wpdb;
		//$wpdb->dln_crawl_links      = $wpdb->prefix . 'dln_crawl_links';
		//$wpdb->dln_crawl_links_meta = $wpdb->prefix . 'dln_crawl_links_meta';
		$wpdb->dln_source_link      = $wpdb->prefix . 'dln_source_link';
		$wpdb->dln_source_folder    = $wpdb->prefix . 'dln_source_folder';
		$wpdb->dln_post_link        = $wpdb->prefix . 'dln_post_link';
		$wpdb->dln_source_post      = $wpdb->prefix . 'dln_source_post';
		
		if ( is_admin() )
			include( 'includes/admin/class-dln-cron-admin.php' );
		
		include( 'includes/class-dln-cron-helper.php' );
		include( 'includes/class-dln-cron-sources.php' );
		include( 'includes/class-dln-cron-shortcodes.php' );
		include( 'includes/class-dln-cron-terms.php' );
		
		add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
	}
	
	public function register_assets() {
		//wp_register_script( 'dln-form-field-text-search', DLN_SKILL_PLUGIN_URL . '/dln-form/assets/js/fields/text-search.js', array( 'jquery' ), DLN_SKILL_VERSION, true );
		//wp_register_script( 'dln-bootstrap-js', DLN_SKILL_PLUGIN_URL . '/assets/3rd-party/bootstrap3/js/bootstrap.min.js', array( 'jquery' ), '3.1.1', true );
		//wp_register_style( 'dln-bootstrap-css', DLN_SKILL_PLUGIN_URL . '/assets/3rd-party/bootstrap3/css/bootstrap.min.css', null, '3.1.1' );
		//wp_register_style( 'dln-ui-element-css', DLN_SKILL_PLUGIN_URL . '/assets/theme-skill/css/uielement.min.css', array( 'dln-bootstrap-css' ), DLN_SKILL_VERSION );
	}
	
	public static function activate() {
		require_once( 'includes/class-dln-install-db.php' );
	}
	
}
$GLOBALS['dln_cron'] = DLN_Cron_Loader::get_instance();