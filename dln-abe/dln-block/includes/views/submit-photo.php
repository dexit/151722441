<?php
?>
<div class="row">
	<div class="col-md-6">
	<div class="thumbnail thumbnail-album animation animating delay fadeInLeft">
		<!-- media -->
		<div class="media" style="min-height: 150px;">
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
	</div>
</div>

<div id="dln_modal_select_photo" class="modal fade dln-modal-resize">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h3 class="semibold modal-title text-primary">Rocket Launch</h3>
			</div>
			<div class="modal-body">
				<!-- Modal content here! -->
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
