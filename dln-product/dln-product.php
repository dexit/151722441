<?php
/*
Plugin Name: DLN Product
Plugin URI: http://www.facebook.com/lenhatdinh
Description: Like Management for fb, pinterest or youtube...
Version: 1.0.0
Author: Dinh Le Nhat
Author URI: http://www.facebook.com/lenhatdinh
License: GPL2
 */

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Product {
	
	public function __construct() {
		// Define constants
		define( 'DLN_PRO_VERSION', '1.0.0' );
		define( 'DLN_PRO', 'dln-product' );
		define( 'DLN_PRO_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
		define( 'DLN_PRO_PLUGIN_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );
		
		// Define nonce ID
		define( 'DLN_PRO_NONCE', 'dln_pro_nonce_check' );
		
		// Define Facebook App Settings
		define( 'FB_APP_ID', '225132297553705' );
		define( 'FB_SECRET', '8f00d29717ee8c6a49cd25da80c5aad8' );
		define( 'FB_REDIRECT_URI', site_url() . '?dln_endpoint_fb=true' );
		
		// Define Instagram Settings
		define( 'INSTA_APP_ID', 'd3457498fa2e4097aa3610ec81e95ab8' );
		define( 'INSTA_SECRET', '5fd6cdc8106743cb82d95a7130063c92' );
		define( 'INSTA_REDIRECT_URI', site_url() . '?dln_endpoint_insta=true' );
		
		define( 'DLN_MAX_IMAGE_SIZE', 1024 );
		define( 'DLN_MAIN_IMAGE_SIZE', 500 );
		define( 'DLN_DEFAULT_IMAGE', '' );
		
		add_action( 'init', array( __CLASS__, 'dln_endpoint_listener' ) );
		
		$this->requires();
		
		register_activation_hook( __FILE__, array( $this, 'install' ) );
	}
	
	public function requires() {
		include DLN_PRO_PLUGIN_DIR . '/common/shortcodes.php';
		include DLN_PRO_PLUGIN_DIR . '/common/template.php';
		
		//$this->required_components = apply_filters( 'dln_required_components', array( 'connections', 'cron' ) );
		$this->required_components = apply_filters( 'dln_required_components', array( 'block' ) );
		
		// Loop through required components
		foreach ( $this->required_components as $component ) {
			if ( file_exists( DLN_PRO_PLUGIN_DIR . '/includes/dln-' . $component . '/dln-' . $component . '-loader.php' ) )
				include( DLN_PRO_PLUGIN_DIR . '/includes/dln-' . $component . '/dln-' . $component . '-loader.php' );
		}
	}
	
	public static function install() {
		//DLN_Member_Loader::activate();
	}
	
	public static function dln_endpoint_listener() {
		if ( isset( $_GET['dln_endpoint_fb'] ) && $_GET['dln_endpoint_fb'] == 'true' ) {
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
		}
	}
	
}

$GLOBALS['dln_product'] = new DLN_Product();
