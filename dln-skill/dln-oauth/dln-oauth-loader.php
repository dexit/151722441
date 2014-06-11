<?php 

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_OAuth_Loader{
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		
		return self::$instance;
	}
	
	function __construct() {
		add_filter( 'query_vars', array( $this, 'add_query_vars' ), 0 );
		add_action( 'parse_request', array( $this, 'sniff_request' ), 0 );
		add_action( 'init', array( $this, 'add_endpoint' ), 0 );
	}
	
	public function add_endpoint() {
		add_rewrite_rule( '^oauth/?([a-z]+)?/?', 'index.php?__oauth=1&provider=$matches[1]', 'top' );
		flush_rewrite_rules();
	}
	
	public function add_query_vars( $vars ) {
		$vars[] = '__oauth';
		$vars[] = 'provider';
		return $vars;
	}
	
	public function sniff_request() {
		global $wp;
		
		if ( isset( $wp->query_vars['__oauth'] ) ) {
			$this->handle_request();
		}
	}
	
	protected function handle_request() {
		global $wp;
		
		$provider = $wp->query_vars['provider'];
		if ( ! $provider ) {
			$this->send_response( 'Please tell us what is you need?' );
		}
		
		if ( file_exists( DLN_SKILL_PLUGIN_DIR . "/dln-oauth/includes/class-dln-oauth-{$provider}.php" ) ) {
			include( DLN_SKILL_PLUGIN_DIR . "/dln-oauth/includes/class-dln-oauth-{$provider}.php" );
		}
	}
	
	protected function send_response($msg, $pugs = ''){
		$response['message'] = $msg;
		if($pugs)
			$response['pugs'] = $pugs;
		header('content-type: application/json; charset=utf-8');
		echo json_encode($response)."\n";
		exit;
	}
	
}

$GLOBALS['dln_oauth'] = DLN_OAuth_Loader::get_instance();
