<?php

function dln_social_login_admin_menu() {
	add_options_page( 'Social Login', 'Social Login', 'manage_options', 'social-login-id', 'dln_render_social_login_settings' );
	add_action( 'admin_init', 'dln_register_social_login_settings' );
}
add_action( 'admin_menu', 'dln_social_login_admin_menu' );

function dln_register_social_login_settings() {
	register_setting( 'social-login-settings-group', 'social_login_facebook_api_key' );
	register_setting( 'social-login-settings-group', 'social_login_facebook_secret_key' );
	register_setting( 'social-login-settings-group', 'social_login_facebook_permission' );
}

function dln_render_social_login_settings() {
	?>
	<div class="wrap">
		<h2><?php _e('Social Login Settings', 'social_login'); ?></h2>

		<form method="post" action="options.php">
			<?php settings_fields( 'social-login-settings-group' ); ?>
			<h3><?php _e('Facebook Settings', 'social_connect'); ?></h3>
			<p><?php _e('To connect your site to Facebook, you need a Facebook Application. If you have already created one, please insert your API & Secret key below.', 'social_connect'); ?></p>
			<p><?php printf(__('Already registered? Find your keys in your <a target="_blank" href="%2$s">%1$s Application List</a>', 'social_connect'), 'Facebook', 'http://www.facebook.com/developers/apps.php'); ?></li>
			<p><?php _e('Need to register?', 'social_connect'); ?></p>
			<ol>
				<li><?php printf(__('Visit the <a target="_blank" href="%1$s">Facebook Application Setup</a> page', 'social_connect'), 'http://www.facebook.com/developers/createapp.php'); ?></li>
				<li><?php printf(__('Get the API information from the <a target="_blank" href="%1$s">Facebook Application List</a>', 'social_connect'), 'http://www.facebook.com/developers/apps.php'); ?></li>
				<li><?php _e('Select the application you created, then copy and paste the API key & Application Secret from there.', 'social_connect'); ?></li>
			</ol>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('API Key', 'social_login'); ?></th>
					<td><input type="text" name="social_login_facebook_api_key" value="<?php echo get_option('social_login_facebook_api_key' ); ?>" /></td>
				</tr>

				<tr valign="top">
					<th scope="row"><?php _e('Secret Key', 'social_login'); ?></th>
					<td><input type="text" name="social_login_facebook_secret_key" value="<?php echo get_option('social_login_facebook_secret_key' ); ?>" /></td>
				</tr>
				
				<tr valign="top">
					<th scope="row"><?php _e('Permission', 'social_login'); ?></th>
					<td><input type="text" name="social_login_facebook_permission" value="<?php echo get_option('social_login_facebook_permission' ); ?>" /></td>
				</tr>
			</table>

			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Save Changes' ) ?>" />
			</p>

		</form>
	</div>
	<?php
}