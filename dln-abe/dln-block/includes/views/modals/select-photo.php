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
	
	//var_dump( json_decode( @file_get_contents( 'https://api.instagram.com/v1/users/3/media/recent/?client_id=d3457498fa2e4097aa3610ec81e95ab8&max_id=564566764063559682_3' ) ) );die();
}
?>
<div class="page-header page-header-block">
	<div class="page-header-section">
		<h4 class="title semibold">Media gallery</h4>
	</div>
	<div class="page-header-section">
		<!-- Toolbar -->
		<div class="toolbar">
			<span class="toolbar-label semibold mr5"><?php _e( 'Photo : ', DLN_ABE ) ?></span>
			<div class="btn-group" id="dln_photo_source">
				<button class="btn btn-default" data-group="upload"><?php _e( 'Upload', DLN_ABE ) ?></button>
				<button class="btn btn-default" data-group="facebook"><?php _e( 'Facebook', DLN_ABE ) ?></button>
				<button class="btn btn-default" data-group="instagram"><?php _e( 'Instagram', DLN_ABE ) ?></button>
			</div>
		</div>
		<!--/ Toolbar -->
	</div>
</div>

<div id="dln_photo_wrapper" class="dln-wrapper">
<div class="row">
	<div class="col-md-3 col-xs-6">
		<!-- thumbnail -->
		<div class="thumbnail nm">
			<!-- media -->
			<div class="media">
				<!-- indicator -->
				<div class="indicator">
					<span class="spinner"></span>
				</div>
				<!--/ indicator -->
				<!-- toolbar overlay -->
				<div class="overlay">
					<div class="toolbar">
						<a href="#" class="btn btn-default magnific" title="view picture"><i class="ico-search"></i></a>
						<a href="#" class="btn btn-default magnific"><i class="ico-close2"></i></a>
					</div>
				</div>
				<!--/ toolbar overlay -->
				<img data-toggle="unveil"
					src="https://fbcdn-sphotos-a-a.akamaihd.net/hphotos-ak-xfa1/t1.0-9/s720x720/10378970_740123969367360_649301298345723939_n.jpg"
					data-src="https://fbcdn-sphotos-a-a.akamaihd.net/hphotos-ak-xfa1/t1.0-9/s720x720/10378970_740123969367360_649301298345723939_n.jpg" alt="Photo"
					width="100%" />
			</div>
			<!--/ media -->
		</div>
		<!--/ thumbnail -->
	</div>
	
</div>
</div>


<ul class="pager mt0">
	<li><a href="javascript:void(0);"><?php _e( 'Previous', DLN_ABE ) ?></a></li>
	<li><a href="javascript:void(0);"><?php _e( 'Next', DLN_ABE ) ?></a></li>
</ul>

<?php if ( ! $valid_fb ) : ?>
<button class="btn btn-default dln-connect-fb" href="#"><?php _e( 'Connect to Facebook', DLN_ABE ) ?></button>
<?php endif ?>

<button class="btn btn-default dln-connect-insta"href="#"><?php _e( 'Connect to Instagram', DLN_ABE ) ?></button>
