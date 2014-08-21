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
	</div>
	<!--/ thumbnail -->
</div>
		<?php
		$block_photo_html = ob_get_clean();
		
		return $block_photo_html;
	}
	
	public static function render_photo_item( $is_string = false ) {
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
	}
	
	public static function render_photo_submit() {
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
	}
	
	public static function convert_literal_string( $block_html ) {
		return addslashes( preg_replace( "/[\r\n]+/",' ',( preg_replace( '/\s\s+/', ' ', $block_html ) ) ) );
	}

}