<?php
wp_enqueue_script( 'dln-modal-select-photo-js', DLN_ABE_PLUGIN_URL . '/assets/dln-abe/js/modals/select-photo.js', null, '1.0.0', true );
wp_enqueue_style( 'dln-modal-select-photo-css', DLN_ABE_PLUGIN_URL . '/assets/dln-abe/css/modals/select-photo.css', null, '1.0.0' );

wp_print_scripts( 'dln-modal-select-photo-js' );
wp_print_styles( 'dln-modal-select-photo-css' );

$user_id  = get_current_user_id();
$valid_fb = false;

if ( ! empty( $user_id ) ) {
	// If user has logged in
	$fb_access_token = get_user_meta( $user_id, 'dln_facebook_access_token', true );
	
	if ( $fb_access_token ) {
		// Validate facebook access token
		$fb_app_id = FB_APP_ID;
		$url       = 'https://graph.facebook.com/v2.0/oauth/access_token_info?client_id=' . $fb_app_id . '&access_token=' . $fb_access_token;
		$obj       = @file_get_contents( $url );
		$obj       = ( ! empty( $obj ) ) ? json_decode( $obj ) : '';
		if ( ! empty( $obj->error ) ) {
			$valid_fb = false;
		} else {
			$valid_fb = true;
		}
	}
	
	// Get Instagram user access token
	$insta_access_token = get_user_meta( $user_id, 'dln_instagram_access_token', true );
	
	if ( $insta_access_token ) {
		
	}
	
	var_dump( json_decode( @file_get_contents( 'https://api.instagram.com/v1/users/3/media/recent/?client_id=d3457498fa2e4097aa3610ec81e95ab8&max_id=564566764063559682_3' ) ) );die();
}
?>
<?php if ( ! $valid_fb ) : ?>
<button class="btn btn-default dln-connect-fb" href="#"><?php _e( 'Connect to Facebook', DLN_ABE ) ?></button>
<?php endif ?>

<button class="btn btn-default dln-connect-insta"href="#"><?php _e( 'Connect to Instagram', DLN_ABE ) ?></button>
