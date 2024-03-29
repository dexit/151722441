<?php
require_once(dirname(dirname(__FILE__)) . '/constants.php' );
require_once(dirname(__FILE__) . '/base_facebook.php' );
require_once(dirname(__FILE__) . '/facebook.php' );
require_once(dirname(dirname(__FILE__)) . '/utils.php' );

$client_id = get_option('social_login_facebook_api_key');
$secret_key = get_option('social_login_facebook_secret_key');

if(isset($_GET['code'])) {
  $code = $_GET['code'];
  $client_id = get_option('social_login_facebook_api_key');
  $secret_key = get_option('social_login_facebook_secret_key');
  parse_str(dln_curl_get_contents("https://graph.facebook.com/oauth/access_token?" .
    'client_id=' . $client_id . '&redirect_uri=' . urlencode(SOCIAL_LOGIN_PLUGIN_URL . '/facebook/callback.php') .
    '&client_secret=' .  $secret_key .
    '&code=' . urlencode($code)));
  
  $signature = social_login_generate_signature($access_token);  
?>
<html>
<head>
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
  $permission = get_option('social_login_facebook_api_key');
  $permission = ( $permission ) ? $permission : 'email';
  $redirect_uri = urlencode(SOCIAL_LOGIN_PLUGIN_URL . '/facebook/callback.php');
  wp_redirect('https://graph.facebook.com/oauth/authorize?client_id=' . $client_id . '&redirect_uri=' . $redirect_uri . '&scope=' . $permission);
}
?>
