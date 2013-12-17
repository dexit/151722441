<?php
/**
 * @package   DLN_Like_Manager_Admin
 * @author    DinhLN <lenhatdinh@gmail.com>
 * @license   GPL-2.0+
 * @link      http://www.facebook.com/lenhatdinh
 * @copyright 2013 by DinhLN
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) { die; }

?>
<div class="wrap">
	<h2><?php echo esc_html( get_admin_page_title() . ' Settings' ); ?></h2>
	<form method="post" action="options.php">
		<?php settings_fields( 'dln-like-manager-settings-group' ); ?>
		<h3><?php _e( 'Facebook Settings', DLN_LIKE_SLUG ); ?></h3>
		<p><?php _e( 'To connect your site to Facebook, you need a Facebook Application. If you have already created one, please insert your API & Secret key below.', DLN_LIKE_SLUG ); ?></p>
		<p><?php printf( __( 'Already registered? Find your keys in your <a target="_blank" href="%2$s">%1$s Application List</a>', DLN_LIKE_SLUG ), 'Facebook', 'http://www.facebook.com/developers/apps.php' ); ?></li>
		<p><?php _e('Need to register?', DLN_LIKE_SLUG ); ?></p>
		<ol>
			<li><?php printf( __( 'Visit the <a target="_blank" href="%1$s">Facebook Application Setup</a> page', DLN_LIKE_SLUG ), 'http://www.facebook.com/developers/createapp.php' ); ?></li>
			<li><?php printf( __( 'Get the API information from the <a target="_blank" href="%1$s">Facebook Application List</a>', DLN_LIKE_SLUG ), 'http://www.facebook.com/developers/apps.php' ); ?></li>
			<li><?php _e( 'Select the application you created, then copy and paste the API key & Application Secret from there.', DLN_LIKE_SLUG ); ?></li>
		</ol>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e( 'API Key', DLN_LIKE_SLUG ); ?></th>
				<td><input type="text" name="dln_like_facebook_api_key" value="<?php echo get_option( 'dln_like_facebook_api_key' ); ?>" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e( 'Secret Key', DLN_LIKE_SLUG ); ?></th>
				<td><input type="text" name="dln_like_facebook_secret_key" value="<?php echo get_option( 'dln_like_facebook_secret_key' ); ?>" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e( 'Permission', DLN_LIKE_SLUG ); ?></th>
				<td><input type="text" name="dln_like_facebook_permission" value="<?php echo get_option( 'dln_like_facebook_permission' ); ?>" /></td>
			</tr>
		</table>
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e( 'Save Changes', DLN_LIKE_SLUG ) ?>" />
		</p>
	</form>
</div>