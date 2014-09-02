<?php
wp_enqueue_script( 'dln-modal-photo-select-js', DLN_ABE_PLUGIN_URL . '/assets/dln-abe/js/modals/photo-select.js', null, '1.0.0', true );
wp_enqueue_style( 'dln-modal-photo-select-css', DLN_ABE_PLUGIN_URL . '/assets/dln-abe/css/modals/photo-select.css', null, '1.0.0' );

wp_print_scripts( 'dln-modal-photo-select-js' );
wp_print_styles( 'dln-modal-photo-select-css' );

DLN_Upload_Loader::add_scripts();
wp_print_scripts( 'dln-upload-js' );

$user_id  = get_current_user_id();
$valid_fb = $valid_insta = true;

if ( ! empty( $user_id ) ) {
	// If user has logged in
	$fb_access_token = get_user_meta( $user_id, 'dln_facebook_access_token', true );
	
	if ( $fb_access_token ) {
		// Validate facebook access token
		$fb_app_id = FB_APP_ID;
		$url       = 'https://graph.facebook.com/v2.1/oauth/access_token_info?client_id=' . $fb_app_id . '&access_token=' . $fb_access_token;
		$obj       = @file_get_contents( $url );
		$obj       = ( ! empty( $obj ) ) ? json_decode( $obj ) : '';
		if ( ! empty( $obj->error ) ) {
			$valid_fb = true;
		} else {
			$valid_fb = false;
		}
	}
	
	// Get Instagram user access token
	$insta_access_token = get_user_meta( $user_id, 'dln_instagram_access_token', true );
	
	if ( $insta_access_token ) {
		$valid_insta = false;
	} else {
		$valid_insta = true;
	}
}
?>
<div class="page-header page-header-block">
	<div class="page-header-section">
		<h4 class="title semibold"><?php _e( 'Image list', DLN_ABE ) ?></h4>
	</div>
	<div class="page-header-section">
		<!-- Toolbar -->
		<div class="toolbar">
			<span class="toolbar-label semibold mr5"><?php _e( 'Source : ', DLN_ABE ) ?></span>
			<div class="btn-group" id="dln_btn_photos">
				<button class="btn btn-default" data-value="upload"><?php _e( 'Upload', DLN_ABE ) ?></button>
				<button class="btn btn-default" data-value="facebook" data-allow="<?php echo $valid_fb ?>"><?php _e( 'Facebook', DLN_ABE ) ?></button>
				<button class="btn btn-default" data-value="instagram" data-allow="<?php echo $valid_insta ?>"><?php _e( 'Instagram', DLN_ABE ) ?></button>
				<button class="btn btn-default" data-value="fetch"><?php _e( 'Fetch', DLN_ABE ) ?></button>
			</div>
		</div>
		<!--/ Toolbar -->
	</div>
</div>
<div id="dln_photo_wrapper" class="dln-wrapper">
	<div class="row dln-modal-content dln-upload">
		<div class="dln-item-wrapper">
			<?php echo balanceTags( do_shortcode( '[dln_upload theme="true"]' ) )?>
		</div>
	</div>
	
	<div class="row dln-modal-content dln-facebook">
		<div class="dln-item-wrapper">
			<!-- listing facebook photos -->
		</div>
	</div>
	
	<div class="row dln-modal-content dln-instagram">
		<div class="dln-item-wrapper">
			<!-- listing instagram photos -->
		</div>
	</div>
	
	<div class="row dln-modal-content dln-fetch">
		<div class="form-group">
			<div class="row">
				<div class="col-sm-12">
					<label class="control-label"><?php _e( 'URL', DLN_ABE ) ?> <span class="text-danger">*</span></label>
					<input type="text" value="http://" id="dln_url_fetch" required="" placeholder="<?php _e( 'http://', DLN_ABE ) ?>" class="form-control">
					<button type="button" id="dln_submit_url_fetch" class="btn btn-primary"><?php _e( 'Fetch', DLN_ABE ) ?></button>
				</div>
			</div>
		</div>
		<div class="dln-item-wrapper">
			<!-- fetch content -->
		</div>
	</div>
</div>
<ul class="pager mt0" id="dln_paging_group">
	<li><a data-action-type="before" href="javascript:void(0);"><?php _e( 'Previous', DLN_ABE ) ?></a></li>
	<li><a data-action-type="after" href="javascript:void(0);"><?php _e( 'Next', DLN_ABE ) ?></a></li>
</ul>

<input type="hidden" id="dln_index_pos" value="0" />
<input type="hidden" id="dln_image_data" value="" />

<?php
	$block_photo_html = DLN_Helper_Photo_Tmpl::convert_literal_string( DLN_Helper_Photo_Tmpl::render_photo_source() );
?>
<script type="text/javascript">
(function ($) {
	window.DLN_TemplatePhotoSource = '<?php echo $block_photo_html ?>';
})(jQuery);
</script>