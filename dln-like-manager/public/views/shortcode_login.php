<?php
/**
 * @package   DLN_Like_Manager
 * @author    DinhLN <lenhatdinh@gmail.com>
 * @license   GPL-2.0+
 * @link      http://www.facebook.com/lenhatdinh
 * @copyright 2013 by DinhLN
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) { die; }

?>
<div class="social_login_form" title="Social Connect">
	<a href="javascript:void(0);" title="Facebook" class="social_login_login_facebook"><img alt="Facebook" src="<?php echo DLN_LIKE_PLUGIN_URL . '/public/assets/images/facebook_32.png' ?>" /></a>
</div>
<div id="social_login_facebook_auth">
	<input type="hidden" name="client_id" value="<?php echo get_option( 'dln_like_facebook_api_key' ); ?>" />
	<input type="hidden" name="redirect_uri" value="<?php echo urlencode( DLN_LIKE_PLUGIN_URL . '/public/views/callback.php' ); ?>" />
</div>
<input type="hidden" id="social_login_login_form_uri" value="<?php echo site_url( 'wp-login.php', 'login_post' ); ?>" />