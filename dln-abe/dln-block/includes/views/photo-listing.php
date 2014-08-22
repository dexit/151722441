<?php

if ( ! defined( 'WPINC' ) ) { die; }

$list_posts  = DLN_Helper_Photo::get_photo_listing_posts( 10 );
$photo_posts = $list_posts['posts'];
$photo_users = $list_posts['users'];

?>
<div id="dln_add_status" class="thumbnail thumbnail-album animation animating delay fadeInLeft dln-items">
	<!-- media -->
	<div class="media">
		<!--/ indicator -->
		<!-- toolbar overlay -->
		<div class="overlay show">
			<div class="toolbar dln-toolbar">
				<a id="dln_select_image" href="javascript:void(0);" class="btn btn-default" title="upload to collection"><i class="ico-picture"></i> </a>
			</div>
		</div>
		<!--/ toolbar overlay -->
	</div>
	<!--/ media -->
	<!-- caption -->
	<div class="caption">
		<textarea placeholder="What on your mind?" rows="3" class="form-control form-control-minimal dln-block-desc"></textarea>
	</div>
	<!--/ caption -->
	<div class="panel-footer">
		<div class="btn-group" id="dln_post_perm">
			<button type="button" class="btn btn-default" selected="selected" data-value="publish"><?php _e( 'Publish', DLN_ABE ) ?></button>
			<button type="button" class="btn btn-default" data-value="private"><?php _e( 'Private', DLN_ABE ) ?></button>
		</div>
		<div class="btn-group">
			<button type="button" class="btn btn-default">
				<i class="ico-smile"></i>
			</button>
		</div>
		<div class="pull-right">
			<button type="submit" class="btn btn-primary"><?php _e( 'Post', DLN_ABE ) ?></button>
		</div>
	</div>
</div>

<div class="row">
<?php if ( ! empty( $photo_posts ) ):?>
<?php 
	foreach ( $photo_posts as $i => $post ) {
		// Get user
		$user_avatar = $user_name = '';
		if ( $post->post_author ) {
			$user_avatar = bp_core_fetch_avatar( 
				array(
					'item_id' => $post->post_author,
					'type'    => 'thumb',
					'width'   => 32,
					'height'  => 32,
					'class'   => 'friend-avatar',
					'html'    => false
				)
			);
			
			if ( ! empty( $users ) ) {
				foreach ( $users as $i => $user ) {
					if ( $user->ID == $post->post_author ) {
						$user_name = $user->name;
					}
				}
			}
			
			$thumb_url = get_post_meta( $post->ID, 'dln_pic_url', true );
			$block_photo_html = DLN_Helper_Photo_Tmpl::render_photo_post( $user_avatar, $user_name, $post->post_date, $thumb_url, $thumb_url, $post->post_title );
			echo $block_photo_html;
		}
	}
?>
<?php endif ?>
</div>

<?php
$block_photo_html = DLN_Helper_Photo_Tmpl::convert_literal_string( DLN_Helper_Photo_Tmpl::render_photo_post() );
?>
<script type="text/javascript">
(function ($) {
	$.DLN_TemplatePhotoPost = '<?php echo $block_photo_html ?>';
})(jQuery);
</script>
