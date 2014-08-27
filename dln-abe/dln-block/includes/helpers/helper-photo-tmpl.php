<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Helper_Photo_Tmpl {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {  }
	
	public static function render_photo_source() {
		ob_start();
		?>
<div class="col-md-3 col-xs-6 dln-photo-items">
	<!-- thumbnail -->
	<div class="thumbnail nm dln-items">
		<!-- media -->
		<div class="media" data-id="[photo_id]" data-type="[photo_type]">
			<!-- indicator -->
			<div class="indicator">
				<span class="spinner"></span>
			</div>
			<!--/ indicator -->
			<!-- toolbar overlay -->
			<div class="overlay">
				<div class="toolbar">
					<a href="#" class="btn btn-default dln-select-photo"><i class="ico-close2"></i></a>
				</div>
			</div>
			<!--/ toolbar overlay -->
			<img data-toggle="unveil" src="[photo_src]" data-src="[photo_src]" />
		</div>
		<!--/ media -->
		
		<input type="hidden" class="dln-json-meta-data" value="[photo_image_data]" />
	</div>
	<!--/ thumbnail -->
</div>
		<?php
		$block_photo_html = ob_get_clean();
		
		return $block_photo_html;
	}
	
	/*public static function render_photo_item( $is_string = false ) {
		ob_start();
		?>
<div class="thumbnail thumbnail-album animation animating delay fadeInLeft dln-items">
	<!-- media -->
	<div class="media">
		<!-- indicator -->
		<div class="indicator">
			<span class="spinner"></span>
		</div>
		<!-- toolbar overlay -->
		<div class="overlay">
			<div class="toolbar">
				<a href="#" class="btn btn-default dln-select-photo"><i class="ico-heart"></i></a>
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
		<?php
		$block_html = ob_get_clean();
		
		return $block_html;
	}*/
	
	/*public static function render_photo_submit() {
		ob_start();
		?>
<div id="dln_add_status" class="thumbnail thumbnail-album animation animating delay fadeInLeft dln-items">
	<!-- media -->
	<div class="media">
		<!--/ indicator -->
		<!-- toolbar overlay -->
		<div class="overlay show">
			<div class="toolbar dln-toolbar">
				<a id="dln_select_image" href="javascript:void(0);" class="btn btn-default" title="upload to collection"><i class="ico-picture"></i></a>
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
			<button type="button" class="btn btn-default" data-value="publish"><?php _e( 'Publish', DLN_ABE ) ?></button>
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
		<?php
		$block_html = ob_get_clean();
		
		return $block_html;
	}*/

	public static function render_product_images( $position = '[data_position]' ) {
	?>
	<div class="thumbnail thumbnail-album dln-items dln-image-items" data-position="<?php echo esc_attr( $position )?>" >
		<!-- media -->
		<div class="media">
			<!--/ indicator -->
			<!-- toolbar overlay -->
			<div class="overlay show dln-select-image">
				<div class="toolbar dln-toolbar">
					<a href="javascript:void(0);" class="btn btn-default" title="upload to collection">
						<i class="ico-picture"></i>
					</a>
				</div>
			</div>
			<!--/ toolbar overlay -->
		</div>
		<!--/ media -->
	</div>
	<?php
	}
	
	public static function render_photo_post( $user_thumb = '[data_user_thumb]', $username = '[data_user_name]', $post_id = '[data_post_id]', $time_post = '[data_time]', 
		$img_thumb = '[data_thumb_img]', $full_img = '[data_full_img]', $img_alt = '[data_thumb_alt]', $message = '[data_message]' ) {
		ob_start();
		?>
<div class="panel dln-post" id="dln_post_<?php echo $post_id ?>">
	<ul class="list-table">
		<li class="text-left" style="width: 60px;">
			<img class="img-circle" src="<?php echo $user_thumb ?>" alt="" width="40px" height="40px">
		</li>
		<li class="text-left">
			<p class="ellipsis nm">
				<span class="semibold"><?php echo $username ?></span>
			</p>
			<p class="text-muted nm"><?php echo $time_post ?></p>
		</li>
		<li class="text-right" style="width: 60px;">
			<div class="btn-group">
				<button type="button" class="btn btn-link dropdown-toggle text-default" data-toggle="dropdown">
					<i class="ico-menu2"></i>
				</button>
				<ul class="dropdown-menu dropdown-menu-right">
					<li>
						<a href="javascript:void(0);" class="dln-report-btn"><?php _e( 'Report', DLN_ABE ) ?></a></li>
					<li class="divider"></li>
					<li>
						<a href="javascript:void(0);" class="dln-delete-post-btn text-danger"><?php _e( 'Delete post', DLN_ABE ) ?></a>
					</li>
				</ul>
			</div>
		</li>
	</ul>
	<div class="panel-body">
		<?php echo esc_html( $message ) ?>
	</div>
	<div class="thumbnail thumbnail-album">
		<!-- media -->
		<div class="media">
			<!-- indicator -->
			<div class="indicator">
				<span class="spinner"></span>
			</div>
			<!--/ indicator -->
			<img data-toggle="unveil" src="<?php echo $img_thumb ?>" data-src="<?php echo $full_img ?>" alt="<?php echo $img_alt ?>" width="100%">
		</div>
		<!--/ media -->
	</div>
	<div class="panel-toolbar-wrapper">
		<div class="panel-toolbar">
			<a href="javascript:void(0);" class="semibold text-default"><?php _e( 'Follow', DLN_ABE )?></a>
			<span class="text-muted mr5 ml5">&#8226;</span> <a
				href="javascript:void(0);" class="semibold text-default"><?php _e( 'Comment', DLN_ABE )?></a>
			<span class="text-muted mr5 ml5">&#8226;</span> <a
				href="javascript:void(0);" class="semibold text-default"><?php _e( 'Share', DLN_ABE )?></a>
		</div>
	</div>
	<!-- <div class="panel-footer dln-comment-block">
		<div class="pull-right">
			<textarea placeholder="<?php _e( 'Write your comment!', DLN_ABE ) ?>" rows="2" class="form-control"></textarea>
		</div>
		<button type="submit" class="btn btn-primary dln-submit-photo-btn"><?php _e( 'Post', DLN_ABE ) ?></button>
	</div> -->
</div>
		<?php
		$block_html = ob_get_clean();
		
		return $block_html;
	}
	
	public static function convert_literal_string( $block_html ) {
		return addslashes( preg_replace( "/[\r\n]+/",' ',( preg_replace( '/\s\s+/', ' ', $block_html ) ) ) );
	}

}