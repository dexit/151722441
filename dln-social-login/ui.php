<?php

function dln_render_login_form_social_login( $args = NULL ) {

	if( $args == NULL )
		$display_label = true;
	elseif ( is_array( $args ) )
		extract( $args );

	if( !isset( $images_url ) )
		$images_url = SOCIAL_LOGIN_PLUGIN_URL . '/assets/img/';
	?>
	<div class="social_login_ui <?php if( strpos( $_SERVER['REQUEST_URI'], 'wp-signup.php' ) ) echo 'mu_signup'; ?>">
		<?php if( $display_label !== false ) : ?>
			<div style="margin-bottom: 3px;"><label><?php _e( 'Connect with', 'social_login' ); ?>:</label></div>
		<?php endif; ?>
		<div class="social_login_form" title="Social Connect">
			<a href="javascript:void(0);" title="Facebook" class="social_login_login_facebook"><img alt="Facebook" src="<?php echo $images_url . 'facebook_32.png' ?>" /></a>
		</div>

		<?php
	$social_login_provider = isset( $_COOKIE['social_login_current_provider']) ? $_COOKIE['social_login_current_provider'] : '';

?>
	<div id="social_login_facebook_auth">
		<input type="hidden" name="client_id" value="<?php echo get_option( 'social_login_facebook_api_key' ); ?>" />
		<input type="hidden" name="redirect_uri" value="<?php echo urlencode( SOCIAL_LOGIN_PLUGIN_URL . '/facebook/callback.php' ); ?>" />
	</div>
</div> <!-- End of social_login_ui div -->
<?php
}
add_action( 'login_form',          'dln_render_login_form_social_login' );
add_action( 'register_form',       'dln_render_login_form_social_login' );
add_action( 'after_signup_form',   'dln_render_login_form_social_login' );
add_action( 'social_login_form', 'dln_render_login_form_social_login' );


function dln_social_login_add_comment_meta( $comment_id ) {
	$social_login_comment_via_provider = isset( $_POST['social_login_comment_via_provider']) ? $_POST['social_login_comment_via_provider'] : '';
	if( $social_login_comment_via_provider != '' ) {
		update_comment_meta( $comment_id, 'social_login_comment_via_provider', $social_login_comment_via_provider );
	}
}
add_action( 'comment_post', 'dln_social_login_add_comment_meta' );


function dln_social_login_render_comment_meta( $link ) {
	global $comment;
	$images_url = SOCIAL_LOGIN_PLUGIN_URL . '/assets/img/';
	$social_login_comment_via_provider = get_comment_meta( $comment->comment_ID, 'social_login_comment_via_provider', true );
	if( $social_login_comment_via_provider && current_user_can( 'manage_options' )) {
		return $link . '&nbsp;<img class="social_login_comment_via_provider" alt="'.$social_login_comment_via_provider.'" src="' . $images_url . $social_login_comment_via_provider . '_16.png"  />';
	} else {
		return $link;
	}
}
add_action( 'get_comment_author_link', 'dln_social_login_render_comment_meta' );


function dln_render_comment_form_social_login() {
	if( comments_open() && !is_user_logged_in()) {
		dln_render_login_form_social_login();
	}
}
add_action( 'comment_form_top', 'dln_render_comment_form_social_login' );

function dln_render_login_page_uri(){
	?>
	<input type="hidden" id="social_login_login_form_uri" value="<?php echo site_url( 'wp-login.php', 'login_post' ); ?>" />
	<?php
}
add_action( 'wp_footer', 'dln_render_login_page_uri' );


function dln_social_login_shortcode_handler( $args ) {
	if( !is_user_logged_in()) {
		dln_render_login_form_social_login();
	}
}
add_shortcode( 'social_login', 'dln_social_login_shortcode_handler' );
