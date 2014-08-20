<?php

if ( ! defined( 'WPINC' ) ) { die; }

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
			<button type="button" class="btn btn-default" selected="selected" data-group="publish"><?php _e( 'Publish', DLN_ABE ) ?></button>
			<button type="button" class="btn btn-default" data-group="private"><?php _e( 'Private', DLN_ABE ) ?></button>
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