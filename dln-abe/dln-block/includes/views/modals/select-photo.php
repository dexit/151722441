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
			<div class="btn-group" id="dln_btn_photos">
				<button class="btn btn-default" data-value="upload"><?php _e( 'Upload', DLN_ABE ) ?></button>
				<button class="btn btn-default" data-value="facebook"><?php _e( 'Facebook', DLN_ABE ) ?></button>
				<button class="btn btn-default" data-value="instagram"><?php _e( 'Instagram', DLN_ABE ) ?></button>
			</div>
		</div>
		<!--/ Toolbar -->
	</div>
</div>
<div id="dln_photo_wrapper" class="dln-wrapper">
	<div class="row">
		<!-- listing photos -->
	</div>
</div>
<ul class="pager mt0" id="dln_paging_group">
	<li><a data-action-type="before" href="javascript:void(0);"><?php _e( 'Previous', DLN_ABE ) ?></a></li>
	<li><a data-action-type="after" href="javascript:void(0);"><?php _e( 'Next', DLN_ABE ) ?></a></li>
</ul>

<?php if ( ! $valid_fb ) : ?>
<button class="btn btn-default dln-connect-fb" href="#"><?php _e( 'Connect to Facebook', DLN_ABE ) ?></button>
<?php endif ?>

<button class="btn btn-default dln-connect-insta"href="#"><?php _e( 'Connect to Instagram', DLN_ABE ) ?></button>

<?php
	$block_photo_html = DLN_Helper_Photo::renderPhotoSource();
?>

<script type="text/javascript">
(function ($) {
	$.DLN_TemplatePhotoSource = '<?php echo $block_photo_html ?>';
})(jQuery);
</script>