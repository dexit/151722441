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

<!-- image post -->
<div class="panel">
	<!-- User info -->
	<ul class="list-table pa15">
		<li class="text-left" style="width: 60px;"><img class="img-circle"
			src="../image/avatar/avatar9.jpg" alt="" width="50px" height="50px">
		</li>
		<li class="text-left">
			<p class="ellipsis nm">
				<span class="semibold">Tamara Moon</span>
			</p>
			<p class="text-muted nm">2 Minutes ago</p>
		</li>
		<li class="text-right" style="width: 60px;">
			<div class="btn-group">
				<button type="button"
					class="btn btn-link dropdown-toggle text-default"
					data-toggle="dropdown">
					<i class="ico-menu2"></i>
				</button>
				<ul class="dropdown-menu dropdown-menu-right">
					<li><a href="javascript:void(0);" class="text-danger"><?php _e( 'Report', DLN_ABE ) ?></a></li>
					<li class="divider"></li>
					<li><a href="javascript:void(0);">Delete post</a>
					</li>
				</ul>
			</div>
		</li>
	</ul>
	<!--/ User info -->
	<!-- Thumbnail -->
	<div class="thumbnail thumbnail-album">
		<!-- media -->
		<div class="media">
			<!-- indicator -->
			<div class="indicator">
				<span class="spinner"></span>
			</div>
			<!--/ indicator -->
			<img data-toggle="unveil"
				src="../image/background/400x250/placeholder.jpg"
				data-src="../image/background/400x250/background11.jpg" alt="Cover"
				width="100%">
		</div>
		<!--/ media -->
	</div>
	<!--/ Thumbnail -->
	<!-- Toolbar -->
	<div class="panel-toolbar-wrapper">
		<div class="panel-toolbar">
			<a href="javascript:void(0);" class="semibold text-default"><?php _e( 'Like', DLN_ABE )?></a>
			<span class="text-muted mr5 ml5">&#8226;</span> <a
				href="javascript:void(0);" class="semibold text-default"><?php _e( 'Follow', DLN_ABE )?></a>
			<span class="text-muted mr5 ml5">&#8226;</span> <a
				href="javascript:void(0);" class="semibold text-default"><?php _e( 'Share', DLN_ABE )?></a>
		</div>
	</div>
	<!--/ Toolbar -->
	<!-- Comment box -->
	<div class="panel-footer dln-comment-block">
		<div class="pull-right">
			<textarea placeholder="Write your comment" rows="2" class="form-control"></textarea>
		</div>
		<button type="submit" class="btn btn-primary dln-submit-photo-btn"><?php _e( 'Post', DLN_ABE ) ?></button>
	</div>
	<!--/ Comment box -->
</div>
<!--/ image post -->
