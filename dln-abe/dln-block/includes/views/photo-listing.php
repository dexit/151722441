<?php

if ( ! defined( 'WPINC' ) ) { die; }

$list_posts  = DLN_Helper_Photo::get_photo_listing_posts( 10 );
$photo_posts = $list_posts['posts'];
$photo_users = $list_posts['users'];

?>

<div class="row">
	<div class="col-md-12">
		<div class="col-md-2">
			<div
				class="widget panel">
				<!-- panel body -->
				<div class="panel-body">
					<h5 class="mb0">
						Latest Tweet <i class="ico-twitter text-info pull-right"></i>
					</h5>
					<hr>
					<button type="button" class="btn btn-primary btn-sm btn-outline mb5">Primary</button>
					<button type="button" class="btn btn-primary btn-sm btn-outline mb5">Primary</button>
					<button type="button" class="btn btn-primary btn-sm btn-outline mb5">Primary</button>
					<button type="button" class="btn btn-primary btn-sm btn-outline mb5">Primary</button>
					<button type="button" class="btn btn-primary btn-sm btn-outline mb5">Primary</button>
					<button type="button" class="btn btn-primary btn-sm btn-outline mb5">Primary</button>
					<button type="button" class="btn btn-primary btn-sm btn-outline mb5">Primary</button>
					<button type="button" class="btn btn-primary btn-sm btn-outline mb5">Primary</button>
					<button type="button" class="btn btn-primary btn-sm btn-outline mb5">Primary</button>
				</div>
				<!--/ panel body -->
			</div>
		</div>
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
				
				if ( ! empty( $photo_users ) ) {
					foreach ( $photo_users as $i => $user ) {
						if ( $user->ID == $post->post_author ) {

							$user_name = $user->name;
						}
					}
				}
				
				$thumb_url = get_post_meta( $post->ID, 'dln_pic_url', true );
				$time_ago  = human_time_diff( get_post_time( 'U', false, $post->ID ), current_time( 'timestamp' ), 'cách đây' );
				$block_photo_html = DLN_Helper_Photo_Tmpl::render_photo_post( $user_avatar, $user_name, $post->ID, $time_ago, $thumb_url, $thumb_url, $post->post_title, $post->post_content );
				echo '<div class="col-md-2">';
				echo $block_photo_html;
				echo '</div>';
			}
		}
	?>
	<?php endif ?>
	</div>
</div>

<?php
$block_photo_html = DLN_Helper_Photo_Tmpl::convert_literal_string( DLN_Helper_Photo_Tmpl::render_photo_post() );
?>
<script type="text/javascript">
(function ($) {
	$.DLN_TemplatePhotoPost = '<?php echo $block_photo_html ?>';
})(jQuery);
</script>
