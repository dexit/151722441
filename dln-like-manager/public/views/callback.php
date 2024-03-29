<?php
/**
 * @package   DLN_Like_Manager
 * @author    DinhLN <lenhatdinh@gmail.com>
 * @license   GPL-2.0+
 * @link      http://www.facebook.com/lenhatdinh
 * @copyright 2013 by DinhLN
 */

// Require wp-load.php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) { die; }

$client_id  = get_option( 'dln_like_facebook_api_key' );
$secret_key = get_option( 'dln_like_facebook_secret_key' );

if( isset( $_GET['code'] ) ) {
	$code = $_GET['code'];
	$content = DLN_Like_Helpers::curl_get_contents( "https://graph.facebook.com/oauth/access_token?" .
			'client_id=' . $client_id . 
			'&redirect_uri=' . urlencode( DLN_LIKE_PLUGIN_URL . '/public/views/callback.php' ) .
			'&client_secret=' .  $secret_key .
			'&code=' . urlencode( $code ) );
	parse_str( $content );
	if ( strpos( 'error', $content ) !== false OR ! isset( $access_token ) ) {
		echo '<b>' . $content . '</b>';
		return;
	}
	$signature = DLN_Like_Helpers::generate_signature( $access_token );
	?>
	<html>
	<head>
	<script type="text/javascript" src="<?php echo urlencode( DLN_LIKE_PLUGIN_URL . '/public/assets/js/shortcode_login.js' ) ?>"></script>
	<script>
	function init() {
	  window.opener.wp_social_login({'action' : 'social_login', 'social_login_provider' : 'facebook',
	    'social_login_signature' : '<?php echo $signature ?>',
	    'social_login_access_token' : '<?php echo $access_token ?>'});
	    
	  window.close();
	}
	</script>
	</head>
	<body onload="init();">
	</body>
	</html>
	<?php
} else {
	$permission   = get_option( 'dln_like_facebook_api_key' );
	$permission   = ( $permission ) ? $permission : 'email';
	$redirect_uri = urlencode( DLN_LIKE_PLUGIN_URL . '/public/views/callback.php' );
	wp_redirect( 'https://graph.facebook.com/oauth/authorize?client_id=' . $client_id . 
				'&redirect_uri=' . $redirect_uri . 
				'&scope=' . $permission );
}
?>
